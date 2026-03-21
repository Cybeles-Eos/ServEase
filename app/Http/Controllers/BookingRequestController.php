<?php

namespace App\Http\Controllers;

use App\Models\BookingRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingRequestController extends Controller
{
    public function providerRequests()
    {
        $user = auth()->user();

        //$bookRequests = BookingRequest::where('provider_id', $user->provider->id)->get();
        $bookRequests = BookingRequest::with([
                'bookingInfo.service.provider',
                'bookingInfo.customer'
            ])
            ->whereHas('bookingInfo.service', function ($query) use ($user) {
                $query->where('provider_id', $user->provider->id ?? 0);
            })
            ->latest()
            ->get();

        return view('admin.provbookings', compact('bookRequests'));
    }

    // public function accept($id)
    // {
    //     $bookingRequest = BookingRequest::with('bookingInfo.service.provider')->findOrFail($id);

    //     $providerId = auth()->user()->provider->id ?? null;

    //     if (!$providerId || $bookingRequest->bookingInfo->service->provider_id != $providerId) {
    //         abort(403);
    //     }

    //     $bookingRequest->update([
    //         'status' => 'accepted',
    //         'responded_at' => Carbon::now(),
    //     ]);

    //     $bookingRequest->bookingInfo->update([
    //         'status' => 'ongoing',
    //     ]);

    //     return redirect()->back()->with('success', 'Booking request accepted.');
    // }

    // public function decline($id)
    // {
    //     $bookingRequest = BookingRequest::with('bookingInfo.service.provider')->findOrFail($id);

    //     $providerId = auth()->user()->provider->id ?? null;

    //     if (!$providerId || $bookingRequest->bookingInfo->service->provider_id != $providerId) {
    //         abort(403);
    //     }

    //     $bookingRequest->update([
    //         'status' => 'declined',
    //         'responded_at' => Carbon::now(),
    //     ]);

    //     $bookingRequest->bookingInfo->update([
    //         'status' => 'declined',
    //     ]);

    //     return redirect()->back()->with('success', 'Booking request declined.');
    // }

    // public function pending()
    // {
    //     $user = auth()->user();

    //     $bookingRequests = BookingRequest::with([
    //             'bookingInfo.service.provider',
    //             'bookingInfo.customer'
    //         ])
    //         ->where('status', 'pending')
    //         ->whereHas('bookingInfo.service', function ($query) use ($user) {
    //             $query->where('provider_id', $user->provider->id ?? 0);
    //         })
    //         ->latest()
    //         ->get();

    //     return view('booking-request.pending', compact('bookingRequests'));
    // }

    // public function accepted()
    // {
    //     $user = auth()->user();

    //     $bookingRequests = BookingRequest::with([
    //             'bookingInfo.service.provider',
    //             'bookingInfo.customer'
    //         ])
    //         ->where('status', 'accepted')
    //         ->whereHas('bookingInfo.service', function ($query) use ($user) {
    //             $query->where('provider_id', $user->provider->id ?? 0);
    //         })
    //         ->latest()
    //         ->get();

    //     return view('booking-request.accepted', compact('bookingRequests'));
    // }
}