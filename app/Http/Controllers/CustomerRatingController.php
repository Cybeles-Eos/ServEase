<?php

namespace App\Http\Controllers;

use App\Models\BookingRequest;
use App\Models\CustomerRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerRatingController extends Controller
{
    public function store(Request $request, $bookingRequestId)
    {
        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $user = auth()->user();

        if (!$user || !$user->provider) {
            abort(403, 'Only providers can rate customers.');
        }

        $provider = $user->provider;

        $bookingRequest = BookingRequest::with([
                'bookingInfo',
                'bookingInfo.service',
            ])
            ->findOrFail($bookingRequestId);

        if ($bookingRequest->status !== 'COMPLETED') {
            return redirect()->back()->with('flash_message', [
                'title' => 'Rating Not Allowed',
                'message' => 'You can only rate customers on completed bookings.',
                'type' => 'error',
            ]);
        }

        if (!$bookingRequest->bookingInfo || !$bookingRequest->bookingInfo->service) {
            return redirect()->back()->with('flash_message', [
                'title' => 'Rating Failed',
                'message' => 'Booking service information is missing.',
                'type' => 'error',
            ]);
        }

        if ((int) $bookingRequest->provider_id !== (int) $provider->id) {
            abort(403, 'You can only rate customers from your own bookings.');
        }

        $alreadyRated = CustomerRating::where('booking_request_id', $bookingRequest->id)->exists();

        if ($alreadyRated) {
            return redirect()->back()->with('flash_message', [
                'title' => 'Already Rated',
                'message' => 'You already rated this customer.',
                'type' => 'info',
            ]);
        }

        DB::transaction(function () use ($request, $bookingRequest, $provider) {
            $bookingInfo = $bookingRequest->bookingInfo;
            $service = $bookingInfo->service;

            CustomerRating::create([
                'booking_request_id' => $bookingRequest->id,
                'booking_info_id' => $bookingInfo->id,
                'provider_id' => $provider->id,
                'customer_id' => $bookingInfo->customer_id,
                'service_id' => $service->id,
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);
        });

        return redirect()->back()->with('flash_message', [
            'title' => 'Rating Submitted',
            'message' => 'Thank you for rating this customer.',
            'type' => 'success',
        ]);
    }
}
