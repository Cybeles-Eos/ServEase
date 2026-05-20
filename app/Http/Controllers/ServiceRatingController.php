<?php

namespace App\Http\Controllers;

use App\Models\BookingRequest;
use App\Models\ServiceRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceRatingController extends Controller
{
    public function store(Request $request, $bookingRequestId)
    {
        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $user = auth()->user();

        if (!$user || !$user->customer) {
            abort(403, 'Only customers can rate services.');
        }

        $customer = $user->customer;

        $bookingRequest = BookingRequest::with([
                'bookingInfo',
                'bookingInfo.service',
            ])
            ->findOrFail($bookingRequestId);

        if ($bookingRequest->status !== 'COMPLETED') {
            return redirect()->back()->with('flash_message', [
                'title' => 'Rating Not Allowed',
                'message' => 'You can only rate completed bookings.',
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

        if ((int) $bookingRequest->bookingInfo->customer_id !== (int) $customer->id) {
            abort(403, 'You can only rate your own booking.');
        }

        $alreadyRated = ServiceRating::where('booking_request_id', $bookingRequest->id)->exists();

        if ($alreadyRated) {
            return redirect()->back()->with('flash_message', [
                'title' => 'Already Rated',
                'message' => 'You already rated this booking.',
                'type' => 'info',
            ]);
        }

        DB::transaction(function () use ($request, $bookingRequest, $customer) {
            $bookingInfo = $bookingRequest->bookingInfo;
            $service = $bookingInfo->service;

            ServiceRating::create([
                'booking_request_id' => $bookingRequest->id,
                'booking_info_id' => $bookingInfo->id,
                'customer_id' => $customer->id,
                'provider_id' => $bookingRequest->provider_id,
                'service_id' => $service->id,
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);
        });

        return redirect()->back()->with('flash_message', [
            'title' => 'Rating Submitted',
            'message' => 'Thank you for rating this service.',
            'type' => 'success',
        ]);
    }
}