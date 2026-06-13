<?php

namespace App\Http\Controllers;

use App\Models\BookingInfo;
use App\Models\BookingRequest;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\AdminNotificationService;

class BookingInfoController extends Controller
{
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'fname' => ['required', 'max:255'],
            'lname' => ['required', 'max:255'],
            'address' => ['nullable'],
            'email' => ['required', 'email', 'max:255'],
            'number' => ['required', 'max:50'],
            'date' => ['nullable', 'date'],
            'time' => ['nullable'],
            'notes' => ['nullable', 'string', 'max:200'],
            'service_id' => ['required', 'exists:tbl_services,id'],
        ]);

        if ($validation->fails()) {
            return back()->with('flash_message', [
                'title' => 'Something Went Wrong.',
                'message' => $validation->messages(),
                'type' => 'error'
            ]);
        }

        $customer = auth()->user()->customer ?? null;
        $serviceOwner = \App\Models\Service::with('provider')->where('id', $request->service_id)->firstOrFail();

        if (!$customer) {
            return redirect()->back()->with('flash_message', [
                'title' => 'Account Not Found!',
                'message' => 'Please Login Your Account To Continue.',
                'type' => 'error'
            ]);
        }

        $existingBooking = BookingInfo::where('customer_id', $customer->id)
            ->where('service_id', $request->service_id)
            ->whereHas('bookingRequest', function ($query) {
                $query->whereIn('status', ['PENDING', 'ACCEPTED', 'ONGOING']);
            })
            ->exists();

        if ($existingBooking) {
            return redirect()->back()->with('flash_message', [
                'title' => 'Already Booked',
                'message' => 'You already have a booking for this service.',
                'type' => 'warning',
            ]);
        }

        if ($request->filled('date') && $request->filled('time') && !$serviceOwner->provider?->isAvailableAt($request->date, $request->time)) {
            return redirect()->back()->withInput()->with('flash_message', [
                'title' => 'Provider Unavailable',
                'message' => 'This provider is not available at the selected time. Please choose a time within their working hours.',
                'type' => 'error',
            ]);
        }

        if ($request->filled('date') && $request->filled('time')) {
            $scheduleConflict = BookingRequest::where('provider_id', $serviceOwner->provider_id)
                ->whereIn('status', ['PENDING', 'ACCEPTED', 'ONGOING'])
                ->whereHas('bookingInfo', function ($query) use ($request) {
                    $query->whereDate('date', $request->date);
                })
                ->exists();

            if ($scheduleConflict) {
                return redirect()->back()->withInput()->with('flash_message', [
                    'title' => 'Schedule Unavailable',
                    'message' => 'This schedule is already booked. Please choose another date.',
                    'type' => 'error',
                ]);
            }
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
            'notes' => $request->notes,
            'status' => 'PENDING',
        ]);

        BookingRequest::create([
            'booking_info_id' => $bookingInfo->id,
            'provider_id' => $serviceOwner->provider_id,
            'status' => 'PENDING',
            'responded_at' => null,
        ]);

        AdminNotificationService::newBooking($bookingInfo->load('service'));

        return redirect()->route('services.index')->with('flash_message', [
            'title' => 'Book Requested',
            'message' => 'Booking request sent successfully.',
            'type' => 'success'
        ]);
    }


}
