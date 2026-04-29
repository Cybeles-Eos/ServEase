<?php

namespace App\Services;

use App\Models\BookingRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingStatusService
{
    private int $bookingDurationHours = 16; // Auto-complete 16 hours after booking start time

    public function updateAllDueBookings(): void
    {
        $bookingRequests = BookingRequest::with('bookingInfo')
            ->whereIn('status', ['ACCEPTED', 'ONGOING'])
            ->whereHas('bookingInfo', function ($query) {
                $query->whereNotNull('date')
                    ->whereNotNull('time');
            })
            ->get();

        Log::info('Global booking status check started', [
            'total_checked' => $bookingRequests->count(),
        ]);

        foreach ($bookingRequests as $bookingRequest) {
            $this->updateToOngoingIfDue($bookingRequest);
            $this->updateToCompletedIfDue($bookingRequest);
        }
    }

    private function updateToOngoingIfDue(BookingRequest $bookingRequest): void
    {
        if ($bookingRequest->status !== 'ACCEPTED') {
            return;
        }

        if (!$bookingRequest->bookingInfo) {
            return;
        }

        try {
            $scheduleDateTime = $this->getScheduleDateTime($bookingRequest);
            $now = Carbon::now(config('app.timezone'));

            Log::info('Global ongoing check', [
                'booking_request_id' => $bookingRequest->id,
                'booking_info_id' => $bookingRequest->bookingInfo->id,
                'request_status' => $bookingRequest->status,
                'info_status' => $bookingRequest->bookingInfo->status,
                'schedule' => $scheduleDateTime->toDateTimeString(),
                'now' => $now->toDateTimeString(),
            ]);

            if ($now->greaterThanOrEqualTo($scheduleDateTime)) {
                DB::transaction(function () use ($bookingRequest) {
                    $bookingRequest->update([
                        'status' => 'ONGOING',
                    ]);

                    $bookingRequest->bookingInfo->update([
                        'status' => 'ONGOING',
                    ]);
                });

                Log::info('Global booking updated to ONGOING', [
                    'booking_request_id' => $bookingRequest->id,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Global updateToOngoingIfDue failed', [
                'booking_request_id' => $bookingRequest->id ?? null,
                'date' => $bookingRequest->bookingInfo->date ?? null,
                'time' => $bookingRequest->bookingInfo->time ?? null,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function updateToCompletedIfDue(BookingRequest $bookingRequest): void
    {
        if ($bookingRequest->status !== 'ONGOING') {
            return;
        }

        if (!$bookingRequest->bookingInfo) {
            return;
        }

        try {
            $scheduleDateTime = $this->getScheduleDateTime($bookingRequest);

            $completedDateTime = $scheduleDateTime
                ->copy()
                ->addHours($this->bookingDurationHours);

            $now = Carbon::now(config('app.timezone'));

            Log::info('Global completed check', [
                'booking_request_id' => $bookingRequest->id,
                'booking_info_id' => $bookingRequest->bookingInfo->id,
                'duration_hours' => $this->bookingDurationHours,
                'request_status' => $bookingRequest->status,
                'info_status' => $bookingRequest->bookingInfo->status,
                'schedule' => $scheduleDateTime->toDateTimeString(),
                'completed_at' => $completedDateTime->toDateTimeString(),
                'now' => $now->toDateTimeString(),
            ]);

            if ($now->greaterThanOrEqualTo($completedDateTime)) {
                DB::transaction(function () use ($bookingRequest) {
                    $bookingRequest->update([
                        'status' => 'COMPLETED',
                    ]);

                    $bookingRequest->bookingInfo->update([
                        'status' => 'COMPLETED',
                    ]);
                });

                Log::info('Global booking updated to COMPLETED', [
                    'booking_request_id' => $bookingRequest->id,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Global updateToCompletedIfDue failed', [
                'booking_request_id' => $bookingRequest->id ?? null,
                'date' => $bookingRequest->bookingInfo->date ?? null,
                'time' => $bookingRequest->bookingInfo->time ?? null,
                'duration_hours' => $this->bookingDurationHours,
                'error' => $e->getMessage(),
            ]);
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