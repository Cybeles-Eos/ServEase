<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BookingInfo;
use App\Services\BookingStatusService;

class CustomerBookingsBoard extends Component
{
    public string $selectedStatus = '';

    public function providerAvatarData($provider): array
    {
        $firstName = trim((string) ($provider?->first_name ?? ''));
        $lastName = trim((string) ($provider?->last_name ?? ''));
        $displayName = trim($firstName . ' ' . $lastName);

        if ($displayName === '') {
            $displayName = 'Provider';
        }

        $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
        $profileImage = $provider?->profile_image;
        $normalizedProfileImage = trim((string) $profileImage, '/');
        $hasProfileImage = $normalizedProfileImage !== ''
            && !in_array($normalizedProfileImage, ['images/user.png', 'public/images/user.png'], true);

        return [
            'name' => $displayName,
            'initials' => $initials !== '' ? $initials : 'P',
            'profile_image' => $profileImage,
            'has_profile_image' => $hasProfileImage,
        ];
    }

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

        $relations = [
            'service',
            'service.ratings',
            'service.provider',
            'service.provider.user',
            'service.provider.ratings',
            'bookingRequest',
            'bookingRequest.rating',
            'bookingRequest.report',
        ];

        $query = BookingInfo::with($relations)
            ->where('customer_id', $customerId)
            ->latest();

        if (!empty($this->selectedStatus)) {
            $query->where('status', $this->selectedStatus);
        }

        $allBookings = $query->get();

        $ongoingBookings = BookingInfo::with($relations)
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
