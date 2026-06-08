<?php

namespace App\Http\Controllers;

use App\Models\BookingRequest;
use App\Models\ServiceReport;
use App\Services\AdminNotificationService;
use Illuminate\Http\Request;

class ServiceReportController extends Controller
{
    public function store(Request $request, BookingRequest $bookingRequest)
    {
        $validated = $request->validate([
            'reason' => ['required', 'string', 'max:120'],
            'details' => ['nullable', 'string', 'max:1200'],
        ]);

        $customer = auth()->user()->customer ?? null;

        if (!$customer) {
            abort(403);
        }

        $bookingRequest->load(['bookingInfo.service', 'report']);

        if ($bookingRequest->status !== 'COMPLETED') {
            return redirect()->back()->with('flash_message', [
                'title' => 'Report Not Allowed',
                'message' => 'You can only report completed bookings.',
                'type' => 'error',
            ]);
        }

        if (!$bookingRequest->bookingInfo || (int) $bookingRequest->bookingInfo->customer_id !== (int) $customer->id) {
            abort(403);
        }

        if ($bookingRequest->report) {
            return redirect()->back()->with('flash_message', [
                'title' => 'Already Reported',
                'message' => 'You already reported this completed booking.',
                'type' => 'info',
            ]);
        }

        $bookingInfo = $bookingRequest->bookingInfo;
        $service = $bookingInfo->service;

        if (!$service) {
            return redirect()->back()->with('flash_message', [
                'title' => 'Report Failed',
                'message' => 'The booked service could not be found.',
                'type' => 'error',
            ]);
        }

        $report = ServiceReport::create([
            'booking_request_id' => $bookingRequest->id,
            'booking_info_id' => $bookingInfo->id,
            'customer_id' => $customer->id,
            'provider_id' => $bookingRequest->provider_id,
            'service_id' => $service->id,
            'reason' => $validated['reason'],
            'details' => $validated['details'] ?? null,
            'status' => 'OPEN',
        ]);

        AdminNotificationService::newReport($report->load(['service', 'customer', 'provider']));

        return redirect()->back()->with('flash_message', [
            'title' => 'Report Submitted',
            'message' => 'Your report has been sent to the admin for review.',
            'type' => 'success',
        ]);
    }
}
