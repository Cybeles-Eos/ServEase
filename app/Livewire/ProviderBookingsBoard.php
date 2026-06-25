<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BookingRequest;
use App\Services\BookingStatusService;
use Livewire\WithPagination;

class ProviderBookingsBoard extends Component
{
    use WithPagination;

    public string $historyStatus = 'COMPLETED';

    public function updatedHistoryStatus(): void
    {
        $this->resetPage('history_page');
    }

    public function customerAvatarData($request): array
    {
        $bookingInfo = $request->bookingInfo;
        $customer = $bookingInfo?->customer;

        $firstName = trim((string) ($customer->first_name ?? $bookingInfo?->fname ?? ''));
        $lastName = trim((string) ($customer->last_name ?? $bookingInfo?->lname ?? ''));
        $displayName = trim($firstName . ' ' . $lastName);

        if ($displayName === '') {
            $displayName = trim((string) ($bookingInfo?->name ?? 'Customer'));
        }

        if ($firstName === '' && $lastName === '' && $displayName !== '') {
            $nameParts = preg_split('/\s+/', $displayName);
            $firstName = $nameParts[0] ?? '';
            $lastName = count($nameParts) > 1 ? end($nameParts) : '';
        }

        $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
        $profileImage = $customer?->profile_image;
        $normalizedProfileImage = trim((string) $profileImage, '/');
        $hasProfileImage = $normalizedProfileImage !== ''
            && !in_array($normalizedProfileImage, ['images/user.png', 'public/images/user.png'], true);

        return [
            'name' => $displayName,
            'initials' => $initials !== '' ? $initials : 'C',
            'profile_image' => $profileImage,
            'has_profile_image' => $hasProfileImage,
        ];
    }

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
        $historyRequests = null;

        if ($providerId) {
            $bookRequests = BookingRequest::with([
                    'bookingInfo',
                    'bookingInfo.customer',
                    'bookingInfo.service',
                    'rating',
                ])
                ->where('provider_id', $providerId)
                ->latest()
                ->get();

            $historyRequests = BookingRequest::with([
                    'bookingInfo',
                    'bookingInfo.customer',
                    'bookingInfo.service',
                    'rating',
                ])
                ->where('provider_id', $providerId)
                ->where('status', $this->historyStatus)
                ->latest()
                ->paginate(3, ['*'], 'history_page');
        }

        return view('livewire.provider-bookings-board', [
            'bookRequests' => $bookRequests,
            'historyRequests' => $historyRequests,
            'providerId' => $providerId,
        ]);
    }
}
