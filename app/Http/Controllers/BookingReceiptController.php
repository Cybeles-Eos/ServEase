<?php

namespace App\Http\Controllers;

use App\Models\BookingRequest;

class BookingReceiptController extends Controller
{
    public function show($id)
    {
        $bookingRequest = BookingRequest::with([
                'bookingInfo',
                'bookingInfo.customer',
                'bookingInfo.service',
                'bookingInfo.service.serviceCategory',
                'bookingInfo.service.provider',
                'bookingInfo.service.provider.user',
            ])
            ->findOrFail($id);

        $user = auth()->user();

        $isCustomerOwner =
            $user?->customer &&
            $bookingRequest->bookingInfo?->customer_id === $user->customer->id;

        $isProviderOwner =
            $user?->provider &&
            $bookingRequest->provider_id === $user->provider->id;

        if (!$isCustomerOwner && !$isProviderOwner) {
            abort(403);
        }

        if ($bookingRequest->status !== 'COMPLETED') {
            return redirect()->back()->with('error', 'Receipt is only available for completed bookings.');
        }

        return view('admin.receipts.booking-receipt', [
            'bookingRequest' => $bookingRequest,
            'bookingInfo' => $bookingRequest->bookingInfo,
        ]);
    }
}
