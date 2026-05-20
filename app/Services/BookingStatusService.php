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

    /*
    |--------------------------------------------------------------------------
    | Testing mode
    |--------------------------------------------------------------------------
    | true  = complete after 1 minute
    | false = complete after 16 hours
    */
    private bool $useMinuteTesting = true;

    public function updateAllDueBookings(): array
    {
        $updatedToOngoing = 0;
        $updatedToCompleted = 0;

        $bookingRequests = BookingRequest::with('bookingInfo')
            ->whereIn('status', ['ACCEPTED', 'ONGOING'])
            ->whereHas('bookingInfo', function ($query) {
                $query->whereNotNull('date')
                    ->whereNotNull('time');
            })
            ->get();

        foreach ($bookingRequests as $bookingRequest) {
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
            'updated_to_ongoing' => $updatedToOngoing,
            'updated_to_completed' => $updatedToCompleted,
        ]);

        return [
            'ongoing' => $updatedToOngoing,
            'completed' => $updatedToCompleted,
        ];
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

            DB::transaction(function () use ($bookingRequest) {
                $bookingRequest->update([
                    'status' => 'COMPLETED',
                ]);

                $bookingRequest->bookingInfo->update([
                    'status' => 'COMPLETED',
                ]);
            });

            Log::info('Booking updated to COMPLETED', [
                'booking_request_id' => $bookingRequest->id,
                'booking_info_id' => $bookingRequest->bookingInfo->id,
            ]);

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
}