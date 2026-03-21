<?php

namespace App\Http\Controllers;

use App\Models\BookingInfo;
use App\Models\BookingRequest;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingInfoController extends Controller
{
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            // 'service_id' => ['required', 'exists:tbl_services,id'],
            'fname' => ['required', 'max:255'],
            'lname' => ['required', 'max:255'],
            'address' => ['nullable'],
            'email' => ['required', 'email', 'max:255'],
            'number' => ['required', 'max:50'],
            'date' => ['nullable', 'date'],
            'time' => ['nullable'],
        ]);

        if ($validation->fails()) {
            return back()->with('flash_message', [
                'title' => 'Something Went Wrong.',
                'message' => $validation->messages(),
                'type' => 'error'
            ]);
        }

        $customer = auth()->user()->customer ?? null;
        $serviceOwner = \App\Models\Service::where('id', $request->service_id)->firstOrFail();

        if (!$customer) {
            return redirect()->back()->with('flash_message', [
                'title' => 'Account Not Found!',
                'message' => 'Please Login Your Account To Continue.',
                'type' => 'error'
            ]);
        }

        $bookingInfo = BookingInfo::create([
            'service_id' => $request->service_id,
            'customer_id' => $customer->id,
            'fname' => $request->fname,
            'lname' => $request->lname,
            'address' => $request->address,
            'email' => $request->email,
            'number' => $request->number,
            'date' => $request->date,
            'time' => $request->time,
            'status' => 'pending',
        ]);

        BookingRequest::create([
            'booking_info_id' => $bookingInfo->id,
            'provider_id' => $serviceOwner->provider_id,
            'status' => 'pending',
            'responded_at' => null,
        ]);

        return redirect()->route('services.index')->with('flash_message', [
            'title' => 'Book Requested',
            'message' => 'Booking request sent successfully.',
            'type' => 'success'
        ]);
    }

    // public function show($id)
    // {
    //     $bookingInfo = BookingInfo::with(['service.provider', 'customer', 'bookingRequest'])->findOrFail($id);

    //     return view('booking-info.show', compact('bookingInfo'));
    // }

    // public function customerBookings()
    // {
    //     $customer = auth()->user()->customer ?? null;

    //     if (!$customer) {
    //         abort(403);
    //     }

    //     $bookingInfos = BookingInfo::with(['service.provider', 'bookingRequest'])
    //         ->where('customer_id', $customer->id)
    //         ->latest()
    //         ->get();

    //     return view('booking-info.customer-bookings', compact('bookingInfos'));
    // }
}