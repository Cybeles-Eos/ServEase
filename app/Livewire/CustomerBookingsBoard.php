<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BookingInfo;
use App\Services\BookingStatusService;

class CustomerBookingsBoard extends Component
{
    public string $selectedStatus = '';

    public function mount()
    {
        $this->selectedStatus = request('status', '');
    }

    public function refreshBookings(BookingStatusService $bookingStatusService)
    {
        $bookingStatusService->updateAllDueBookings();
    }

    public function updatedSelectedStatus()
    {
        // Livewire automatically re-renders after this changes.
    }

    public function render()
    {
        $customerId = auth()->user()->customer->id ?? null;

        $query = BookingInfo::with([
            'service',
            'service.provider',
            'service.provider.user',
            'bookingRequest',
        ])
            ->where('customer_id', $customerId)
            ->latest();

        if (!empty($this->selectedStatus)) {
            $query->where('status', $this->selectedStatus);
        }

        $allBookings = $query->get();

        $ongoingBookings = BookingInfo::with([
            'service',
            'service.provider',
            'service.provider.user',
            'bookingRequest',
        ])
            ->where('customer_id', $customerId)
            ->where('status', 'ONGOING')
            ->latest()
            ->first();

        $bookingListCount = $allBookings->count();

        return view('livewire.customer-bookings-board', [
            'allBookings' => $allBookings,
            'ongoingBookings' => $ongoingBookings,
            'bookingListCount' => $bookingListCount,
        ]);
    }
}