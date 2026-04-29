<?php

namespace App\Services;

use App\Models\BookingInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingStatusService
{
    private int $bookingDurationHours = 16; // Auto-complete 16 hours after booking start time

    public function updateAllDueBookings(): void
    {
        $bookings = BookingInfo::with('bookingRequest')
            ->whereIn('status', ['ACCEPTED', 'ONGOING'])
            ->whereNotNull('date')
            ->whereNotNull('time')
            ->get();

        foreach ($bookings as $bookingInfo) {
            $this->updateToOngoingIfDue($bookingInfo);
            $this->updateToCompletedIfDue($bookingInfo);
        }
    }

    private function updateToOngoingIfDue($bookingInfo): void
    {
        if ($bookingInfo->status !== 'ACCEPTED') {
            return;
        }

        try {
            $scheduleDateTime = $this->getScheduleDateTime($bookingInfo);
            $now = Carbon::now(config('app.timezone'));

            if ($now->greaterThanOrEqualTo($scheduleDateTime)) {
                DB::transaction(function () use ($bookingInfo) {
                    $bookingInfo->update([
                        'status' => 'ONGOING',
                    ]);

                    if ($bookingInfo->bookingRequest) {
                        $bookingInfo->bookingRequest->update([
                            'status' => 'ONGOING',
                        ]);
                    }
                });
            }
        } catch (\Exception $e) {
            Log::error('Global updateToOngoingIfDue failed', [
                'booking_info_id' => $bookingInfo->id ?? null,
                'date' => $bookingInfo->date ?? null,
                'time' => $bookingInfo->time ?? null,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function updateToCompletedIfDue($bookingInfo): void
    {
        if ($bookingInfo->status !== 'ONGOING') {
            return;
        }

        try {
            $scheduleDateTime = $this->getScheduleDateTime($bookingInfo);

            $completedDateTime = $scheduleDateTime
                ->copy()
                ->addHours($this->bookingDurationHours);

            $now = Carbon::now(config('app.timezone'));

            if ($now->greaterThanOrEqualTo($completedDateTime)) {
                DB::transaction(function () use ($bookingInfo) {
                    $bookingInfo->update([
                        'status' => 'COMPLETED',
                    ]);

                    if ($bookingInfo->bookingRequest) {
                        $bookingInfo->bookingRequest->update([
                            'status' => 'COMPLETED',
                        ]);
                    }
                });
            }
        } catch (\Exception $e) {
            Log::error('Global updateToCompletedIfDue failed', [
                'booking_info_id' => $bookingInfo->id ?? null,
                'date' => $bookingInfo->date ?? null,
                'time' => $bookingInfo->time ?? null,
                'duration_hours' => $this->bookingDurationHours,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function getScheduleDateTime($bookingInfo): Carbon
    {
        $bookingDate = Carbon::parse($bookingInfo->date)->toDateString();
        $bookingTime = Carbon::parse($bookingInfo->time)->format('H:i:s');

        return Carbon::parse(
            $bookingDate . ' ' . $bookingTime,
            config('app.timezone')
        );
    }
}