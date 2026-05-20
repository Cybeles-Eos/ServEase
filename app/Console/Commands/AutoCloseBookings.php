<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BookingStatusService;

class AutoCloseBookings extends Command
{
    protected $signature = 'bookings:auto-close';

    protected $description = 'Automatically update accepted bookings to ongoing and ongoing bookings to completed';

    public function handle(BookingStatusService $bookingStatusService)
    {
        $result = $bookingStatusService->updateAllDueBookings();

        $this->info($result['ongoing'] . ' booking(s) moved to ONGOING.');
        $this->info($result['completed'] . ' booking(s) moved to COMPLETED.');

        return Command::SUCCESS;
    }
}