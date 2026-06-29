<?php

namespace App\Services;

use App\Models\BookingRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingStatusService
{
    private int $bookingDurationHours = 16;
    private int $bookingDurationMinutes = 1;
    private int $pendingResponseHours = 4;

    /*
    |--------------------------------------------------------------------------
    | Testing mode
    |--------------------------------------------------------------------------
    | true  = complete after 1 minute
    | false = complete after 16 hours
    */
    private bool $useMinuteTesting = false;

    public function updateAllDueBookings(): array
    {
        $expired = 0;
        $updatedToOngoing = 0;
        $updatedToCompleted = 0;

        $bookingRequests = BookingRequest::with('bookingInfo.service')
            ->whereIn('status', ['PENDING', 'ACCEPTED', 'ONGOING'])
            ->whereHas('bookingInfo', function ($query) {
                $query->whereNotNull('date')
                    ->whereNotNull('time');
            })
            ->get();

        foreach ($bookingRequests as $bookingRequest) {
            if ($this->expirePendingIfDue($bookingRequest)) {
                $expired++;

                continue;
            }

            if ($this->updateToOngoingIfDue($bookingRequest)) {
                $updatedToOngoing++;

                /*
                |--------------------------------------------------------------------------
                | Refresh model after status changed
                |--------------------------------------------------------------------------
                */
                $bookingRequest->refresh();
                $bookingRequest->load('bookingInfo');
            }

            if ($this->updateToCompletedIfDue($bookingRequest)) {
                $updatedToCompleted++;
            }
        }

        Log::info('Global booking status check finished', [
            'total_checked' => $bookingRequests->count(),
            'expired' => $expired,
            'updated_to_ongoing' => $updatedToOngoing,
            'updated_to_completed' => $updatedToCompleted,
        ]);

        return [
            'expired' => $expired,
            'ongoing' => $updatedToOngoing,
            'completed' => $updatedToCompleted,
        ];
    }

    public function expirePendingIfDue(BookingRequest $bookingRequest): bool
    {
        if ($bookingRequest->status !== 'PENDING') {
            return false;
        }

        if (!$bookingRequest->bookingInfo) {
            return false;
        }

        if (!$bookingRequest->bookingInfo->date || !$bookingRequest->bookingInfo->time) {
            return false;
        }

        try {
            $expiresAt = $this->getPendingExpiresAt($bookingRequest);
            $now = Carbon::now(config('app.timezone'));

            if ($now->lessThan($expiresAt)) {
                return false;
            }

            DB::transaction(function () use ($bookingRequest) {
                $bookingRequest->update([
                    'status' => 'expired',
                    'responded_at' => now(),
                    'customer_seen_at' => null,
                    'provider_seen_at' => null,
                    'cancelled_by' => null,
                ]);

                $bookingRequest->bookingInfo->update([
                    'status' => 'expired',
                ]);
            });

            Log::info('Booking request expired', [
                'booking_request_id' => $bookingRequest->id,
                'booking_info_id' => $bookingRequest->bookingInfo->id,
                'expires_at' => $expiresAt->toDateTimeString(),
            ]);

            AuditLogService::record(
                'Bookings',
                'expired',
                'Booking #' . $bookingRequest->id . ' expired because the provider did not respond before the scheduled cutoff.',
                $bookingRequest,
                'Booking #' . $bookingRequest->id,
                ['status' => 'expired', 'expires_at' => $expiresAt->toDateTimeString()]
            );

            return true;
        } catch (\Exception $e) {
            Log::error('expirePendingIfDue failed', [
                'booking_request_id' => $bookingRequest->id ?? null,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    private function updateToOngoingIfDue(BookingRequest $bookingRequest): bool
    {
        if ($bookingRequest->status !== 'ACCEPTED') {
            return false;
        }

        if (!$bookingRequest->bookingInfo) {
            return false;
        }

        try {
            $scheduleDateTime = $this->getScheduleDateTime($bookingRequest);
            $now = Carbon::now(config('app.timezone'));

            if ($now->lessThan($scheduleDateTime)) {
                return false;
            }

            DB::transaction(function () use ($bookingRequest) {
                $bookingRequest->update([
                    'status' => 'ONGOING',
                ]);

                $bookingRequest->bookingInfo->update([
                    'status' => 'ONGOING',
                ]);
            });

            Log::info('Booking updated to ONGOING', [
                'booking_request_id' => $bookingRequest->id,
                'booking_info_id' => $bookingRequest->bookingInfo->id,
            ]);

            AuditLogService::record(
                'Bookings',
                'started',
                'Booking #' . $bookingRequest->id . ' automatically moved to ongoing.',
                $bookingRequest,
                'Booking #' . $bookingRequest->id,
                ['status' => 'ONGOING']
            );

            return true;
        } catch (\Exception $e) {
            Log::error('updateToOngoingIfDue failed', [
                'booking_request_id' => $bookingRequest->id ?? null,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    private function updateToCompletedIfDue(BookingRequest $bookingRequest): bool
    {
        if ($bookingRequest->status !== 'ONGOING') {
            return false;
        }

        if (!$bookingRequest->bookingInfo) {
            return false;
        }

        try {
            /*
            |--------------------------------------------------------------------------
            | Important:
            |--------------------------------------------------------------------------
            | Use updated_at as the ONGOING start time.
            | When status changes to ONGOING, Laravel updates updated_at.
            | Then testing mode completes it 1 minute after becoming ONGOING.
            */
            $ongoingStartedAt = Carbon::parse($bookingRequest->updated_at, config('app.timezone'));

            if ($this->useMinuteTesting) {
                $completedDateTime = $ongoingStartedAt->copy()->addMinutes($this->bookingDurationMinutes);
            } else {
                $completedDateTime = $ongoingStartedAt->copy()->addHours($this->bookingDurationHours);
            }

            $now = Carbon::now(config('app.timezone'));

            Log::info('Completed check', [
                'booking_request_id' => $bookingRequest->id,
                'booking_info_id' => $bookingRequest->bookingInfo->id,
                'status' => $bookingRequest->status,
                'ongoing_started_at' => $ongoingStartedAt->toDateTimeString(),
                'completed_at' => $completedDateTime->toDateTimeString(),
                'now' => $now->toDateTimeString(),
                'use_minute_testing' => $this->useMinuteTesting,
            ]);

            if ($now->lessThan($completedDateTime)) {
                return false;
            }

            $completionBilling = [
                'completed_hours' => null,
                'completed_minutes' => null,
                'completed_total' => null,
            ];
            $service = $bookingRequest->bookingInfo?->service;

            if (($service?->pricing_type ?? 'fixed') === 'per_hour') {
                $hours = $this->useMinuteTesting ? 0 : $this->bookingDurationHours;
                $minutes = $this->useMinuteTesting ? $this->bookingDurationMinutes : 0;
                $totalMinutes = ($hours * 60) + $minutes;

                $completionBilling = [
                    'completed_hours' => $hours,
                    'completed_minutes' => $minutes,
                    'completed_total' => round(($totalMinutes / 60) * (float) ($service->price ?? 0), 2),
                ];
            }

            DB::transaction(function () use ($bookingRequest, $completionBilling) {
                $bookingRequest->update([
                    'status' => 'COMPLETED',
                    'responded_at' => now(),
                    'cancelled_by' => null,
                    ...$completionBilling,
                ]);

                $bookingRequest->bookingInfo->update([
                    'status' => 'COMPLETED',
                ]);
            });

            Log::info('Booking updated to COMPLETED', [
                'booking_request_id' => $bookingRequest->id,
                'booking_info_id' => $bookingRequest->bookingInfo->id,
            ]);

            AuditLogService::record(
                'Bookings',
                'completed',
                'Booking #' . $bookingRequest->id . ' automatically moved to completed.',
                $bookingRequest,
                'Booking #' . $bookingRequest->id,
                ['status' => 'COMPLETED'] + $completionBilling
            );

            return true;
        } catch (\Exception $e) {
            Log::error('updateToCompletedIfDue failed', [
                'booking_request_id' => $bookingRequest->id ?? null,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    private function getScheduleDateTime(BookingRequest $bookingRequest): Carbon
    {
        $bookingInfo = $bookingRequest->bookingInfo;

        $bookingDate = Carbon::parse($bookingInfo->date)->toDateString();
        $bookingTime = Carbon::parse($bookingInfo->time)->format('H:i:s');

        return Carbon::parse(
            $bookingDate . ' ' . $bookingTime,
            config('app.timezone')
        );
    }

    private function getPendingExpiresAt(BookingRequest $bookingRequest): Carbon
    {
        return $this->getScheduleDateTime($bookingRequest)
            ->addHours($this->pendingResponseHours);
    }
}
