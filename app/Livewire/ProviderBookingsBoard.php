<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BookingRequest;
use App\Services\BookingStatusService;

class ProviderBookingsBoard extends Component
{
    public function refreshBookings(BookingStatusService $bookingStatusService)
    {
        /*
        |--------------------------------------------------------------------------
        | Optional but useful:
        |--------------------------------------------------------------------------
        | This makes sure every Livewire poll also checks due booking statuses.
        | Your schedule:work still remains the main background updater.
        */
        $bookingStatusService->updateAllDueBookings();
    }

    public function render()
    {
        $providerId = auth()->user()->provider->id ?? null;

        $bookRequests = collect();

        if ($providerId) {
            $bookRequests = BookingRequest::with([
                    'bookingInfo',
                    'bookingInfo.customer',
                    'bookingInfo.service',
                ])
                ->where('provider_id', $providerId)
                ->latest()
                ->get();
        }

        return view('livewire.provider-bookings-board', [
            'bookRequests' => $bookRequests,
            'providerId' => $providerId,
        ]);
    }
}