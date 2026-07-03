<?php

namespace App\Http\Controllers;

use App\Models\BookingRequest;
use App\Models\CustomerReport;
use App\Services\AdminNotificationService;
use Illuminate\Http\Request;

class CustomerReportController extends Controller
{
    public function store(Request $request, BookingRequest $bookingRequest)
    {
        $validated = $request->validate([
            'reason' => ['required', 'string', 'max:120'],
            'details' => ['nullable', 'string', 'max:1200'],
        ]);

        $provider = auth()->user()->provider ?? null;

        if (!$provider) {
            abort(403);
        }

        $bookingRequest->load(['bookingInfo.service', 'customerReport']);

        if ($bookingRequest->status !== 'COMPLETED') {
            return redirect()->back()->with('flash_message', [
                'title' => 'Report Not Allowed',
                'message' => 'You can only report customers on completed bookings.',
                'type' => 'error',
            ]);
        }

        if ((int) $bookingRequest->provider_id !== (int) $provider->id) {
            abort(403);
        }

        if (!$bookingRequest->bookingInfo) {
            abort(403);
        }

        if ($bookingRequest->customerReport) {
            return redirect()->back()->with('flash_message', [
                'title' => 'Already Reported',
                'message' => 'You already reported this customer for this booking.',
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

        $report = CustomerReport::create([
            'booking_request_id' => $bookingRequest->id,
            'booking_info_id' => $bookingInfo->id,
            'provider_id' => $provider->id,
            'customer_id' => $bookingInfo->customer_id,
            'service_id' => $service->id,
            'reason' => $validated['reason'],
            'details' => $validated['details'] ?? null,
            'status' => 'OPEN',
        ]);

        AdminNotificationService::newCustomerReport($report->load(['service', 'customer', 'provider']));

        return redirect()->back()->with('flash_message', [
            'title' => 'Report Submitted',
            'message' => 'Your report has been sent to the admin for review.',
            'type' => 'success',
        ]);
    }
}
