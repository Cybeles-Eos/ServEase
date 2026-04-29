<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BookingInfo;
use App\Models\BookingRequest;
use Carbon\Carbon;

class AutoCloseBookings extends Command
{

    // php artisan schedule:work


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:auto-close';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically close bookings not marked done after 9 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $bookings = BookingInfo::where('status', 'ONGOING')->get();

        // $updated = 0;

        // foreach ($bookings as $booking) {
        //     if (empty($booking->date) || empty($booking->time)) {
        //         continue;
        //     }

        //     try {
        //         $bookingDate = Carbon::parse($booking->date)->toDateString();
        //         $bookingTime = Carbon::parse($booking->time)->format('H:i:s');

        //         $scheduleDateTime = Carbon::parse(
        //             $bookingDate . ' ' . $bookingTime,
        //             config('app.timezone')
        //         );

        //         $closeDateTime = $scheduleDateTime->copy()->addMinute();  //addHours(9);
        //         $now = Carbon::now(config('app.timezone'));

        //         if ($now->greaterThanOrEqualTo($closeDateTime)) {
        //             $booking->update([
        //                 'status' => 'CLOSED',
        //                 'updated_at' => now(),
        //             ]);

        //             BookingRequest::where('booking_info_id', $booking->id)
        //                 ->where('status', 'ONGOING')
        //                 ->update([
        //                     'status' => 'CLOSED',
        //                     'updated_at' => now(),
        //                 ]);

        //             $updated++;
        //         }
        //     } catch (\Exception $e) {
        //         \Log::error('AutoCloseBookings failed', [
        //             'booking_id' => $booking->id,
        //             'date' => $booking->date ?? null,
        //             'time' => $booking->time ?? null,
        //             'error' => $e->getMessage(),
        //         ]);
        //     }
        // }

        // $this->info("{$updated} booking(s) auto-closed.");

        // return Command::SUCCESS;
    }
}
