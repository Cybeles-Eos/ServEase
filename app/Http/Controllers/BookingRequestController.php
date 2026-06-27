<?php

namespace App\Http\Controllers;

use App\Models\BookingRequest;
use App\Models\CustomerRequestApplication;
use App\Services\BookingEmailService;
use App\Services\BookingStatusService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingRequestController extends Controller
{
    //    1        2       3        4       5         6
    // PENDING ACCEPTED ONGOING DECLINED CANCELLED COMPLETED
    public function providerRequests()
    {
        $user = auth()->user();

        app(BookingStatusService::class)->updateAllDueBookings();

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

    public function accept($id)
    {
        $provider = auth()->user()->provider ?? null;
        $bookingStatusService = app(BookingStatusService::class);

        if (!$provider) {
            return redirect()->back()->with('flash_message', [
                'title' => 'Unauthorized',
                'message' => 'Provider account not found.',
                'type' => 'error'
            ]);
        }

        $bookingRequest = BookingRequest::with('bookingInfo')
            ->where('id', $id)
            ->where('provider_id', $provider->id)
            ->firstOrFail();

        $bookingStatusService->expirePendingIfDue($bookingRequest);
        $bookingRequest->refresh();

        if ($bookingRequest->status !== 'PENDING') {
            return redirect()->back()->with('flash_message', [
                'title' => 'Invalid Action',
                'message' => 'Only pending bookings can be accepted.',
                'type' => 'warning'
            ]);
        }

        $bookingRequest->update([
            'status' => 'ACCEPTED',
            'responded_at' => now(),
            'customer_seen_at' => null,
        ]);

        if ($bookingRequest->bookingInfo) {
            $bookingRequest->bookingInfo->update([
                'status' => 'ACCEPTED',
            ]);
        }

        app(BookingEmailService::class)->sendAcceptedToCustomer($bookingRequest);

        return redirect()->back()->with('flash_message', [
            'title' => 'Booking Accepted',
            'message' => null,
            'type' => 'success'
        ]);
    }

    public function decline($id)
    {
        $provider = auth()->user()->provider ?? null;
        $bookingStatusService = app(BookingStatusService::class);

        if (!$provider) {
            return redirect()->back()->with('flash_message', [
                'title' => 'Unauthorized',
                'message' => 'Provider account not found.',
                'type' => 'error'
            ]);
        }

        $bookingRequest = BookingRequest::with('bookingInfo')
            ->where('id', $id)
            ->where('provider_id', $provider->id)
            ->firstOrFail();

        $bookingStatusService->expirePendingIfDue($bookingRequest);
        $bookingRequest->refresh();

        if ($bookingRequest->status !== 'PENDING') {
            return redirect()->back()->with('flash_message', [
                'title' => 'Invalid Action',
                'message' => 'Only pending bookings can be declined.',
                'type' => 'warning'
            ]);
        }

        $bookingRequest->update([
            'status' => 'DECLINED',
            'responded_at' => now(),
            'customer_seen_at' => null,
        ]);

        if ($bookingRequest->bookingInfo) {
            $bookingRequest->bookingInfo->update([
                'status' => 'DECLINED',
            ]);
        }

        app(BookingEmailService::class)->sendDeclinedToCustomer($bookingRequest);

        return redirect()->back()->with('flash_message', [
            'title' => 'Booking Declined',
            'message' => 'Booking request declined successfully.',
            'type' => 'success'
        ]);
    }

    public function cancel($id)
    {
        $provider = auth()->user()->provider ?? null;
        $bookingStatusService = app(BookingStatusService::class);

        if (!$provider) {
            return redirect()->back()->with('flash_message', [
                'title' => 'Unauthorized',
                'message' => 'Provider account not found.',
                'type' => 'error'
            ]);
        }

        $bookingRequest = BookingRequest::with('bookingInfo')
            ->where('id', $id)
            ->where('provider_id', $provider->id)
            ->firstOrFail();

        $bookingStatusService->expirePendingIfDue($bookingRequest);
        $bookingRequest->refresh();

        if (! in_array($bookingRequest->status, ['ACCEPTED', 'ONGOING'])) {
            return redirect()->back()->with('flash_message', [
                'title' => 'Invalid Action',
                'message' => 'Only accepted or ongoing bookings can be cancelled.',
                'type' => 'warning'
            ]);
        }

        $bookingRequest->update([
            'status' => 'CANCELLED',
            'responded_at' => now(),
            'customer_seen_at' => null,
            'cancelled_by' => 'provider',
        ]);

        if ($bookingRequest->bookingInfo) {
            $bookingRequest->bookingInfo->update([
                'status' => 'CANCELLED',
            ]);
        }

        app(BookingEmailService::class)->sendProviderCancelledToCustomer($bookingRequest);

        return redirect()->back()->with('flash_message', [
            'title' => 'Booking Cancel',
            'message' => 'Booking cancellation may have effect your account',
            'type' => 'warning'
        ]);
    }

    public function markComplete(Request $request, $id)
    {
        $provider = auth()->user()->provider ?? null;

        if (!$provider) {
            return redirect()->back()->with('flash_message', [
                'title' => 'Unauthorized',
                'message' => 'Provider account not found.',
                'type' => 'error'
            ]);
        }

        $bookingRequest = BookingRequest::with('bookingInfo.service')
            ->where('id', $id)
            ->where('provider_id', $provider->id)
            ->firstOrFail();

        if ($bookingRequest->status !== 'ONGOING') {
            return redirect()->back()->with('flash_message', [
                'title' => 'Invalid Action',
                'message' => 'Only ongoing bookings can be marked as completed.',
                'type' => 'warning'
            ]);
        }

        $service = $bookingRequest->bookingInfo?->service;
        $isPerHour = ($service?->pricing_type ?? 'fixed') === 'per_hour';
        $completionBilling = [
            'completed_hours' => null,
            'completed_minutes' => null,
            'completed_total' => null,
        ];

        if ($isPerHour) {
            $validated = $request->validate([
                'completed_hours' => ['required', 'integer', 'min:0', 'max:9999'],
                'completed_minutes' => ['required', 'integer', 'min:0', 'max:59'],
            ]);

            $hours = (int) $validated['completed_hours'];
            $minutes = (int) $validated['completed_minutes'];
            $totalMinutes = ($hours * 60) + $minutes;

            if ($totalMinutes < 1) {
                return redirect()->back()->with('flash_message', [
                    'title' => 'Invalid Hours',
                    'message' => 'Completed time must be at least 1 minute.',
                    'type' => 'warning'
                ]);
            }

            $hourlyRate = (float) ($service->price ?? 0);
            $completionBilling = [
                'completed_hours' => $hours,
                'completed_minutes' => $minutes,
                'completed_total' => round(($totalMinutes / 60) * $hourlyRate, 2),
            ];
        }

        DB::transaction(function () use ($bookingRequest, $completionBilling) {
            $bookingRequest->update([
                'status' => 'COMPLETED',
                'responded_at' => now(),
                'customer_seen_at' => null,
                'cancelled_by' => null,
                ...$completionBilling,
            ]);

            if ($bookingRequest->bookingInfo) {
                $bookingRequest->bookingInfo->update([
                    'status' => 'COMPLETED',
                ]);
            }
        });

        return redirect()->back()->with('flash_message', [
            'title' => 'Booking Completed',
            'message' => 'The booking has been marked as completed.',
            'type' => 'success'
        ]);
    }

    public function markProviderNotificationsRead(Request $request)
    {
        $user = auth()->user();

        if (! $user || $user->role !== 'provider' || ! $user->provider) {
            abort(403);
        }

        if ($request->filled('notification_id')) {
            if ($request->input('notification_type') === 'customer_request') {
                CustomerRequestApplication::query()
                    ->where('id', $request->input('notification_id'))
                    ->where('provider_id', $user->provider->id)
                    ->whereNull('provider_seen_at')
                    ->update([
                        'provider_seen_at' => now(),
                    ]);

                return response()->json([
                    'success' => true,
                ]);
            }

            if ($request->input('notification_type') === 'rating') {
                \App\Models\ServiceRating::query()
                    ->where('id', $request->input('notification_id'))
                    ->where('provider_id', $user->provider->id)
                    ->whereNull('provider_seen_at')
                    ->update([
                        'provider_seen_at' => now(),
                    ]);
            } else {
                \App\Models\BookingRequest::query()
                    ->where('id', $request->input('notification_id'))
                    ->where('provider_id', $user->provider->id)
                    ->whereNull('provider_seen_at')
                    ->update([
                        'provider_seen_at' => now(),
                    ]);
            }

            return response()->json([
                'success' => true,
            ]);
        }

        \App\Models\BookingRequest::query()
            ->where('provider_id', $user->provider->id)
            ->whereNull('provider_seen_at')
            ->update([
                'provider_seen_at' => now(),
            ]);

        \App\Models\ServiceRating::query()
            ->where('provider_id', $user->provider->id)
            ->whereNull('provider_seen_at')
            ->update([
                'provider_seen_at' => now(),
            ]);

        CustomerRequestApplication::query()
            ->where('provider_id', $user->provider->id)
            ->whereIn('status', ['accepted', 'rejected', 'cancelled'])
            ->whereNull('provider_seen_at')
            ->update([
                'provider_seen_at' => now(),
            ]);

        return response()->json([
            'success' => true,
        ]);
    }

    public function customerCancel($id)
    {
        $customer = auth()->user()->customer ?? null;
        $bookingStatusService = app(BookingStatusService::class);

        if (! $customer) {
            return redirect()->back()->with('flash_message', [
                'title' => 'Unauthorized',
                'message' => 'Customer account not found.',
                'type' => 'error'
            ]);
        }

        $bookingRequest = BookingRequest::with('bookingInfo')
            ->where('id', $id)
            ->whereHas('bookingInfo', function ($query) use ($customer) {
                $query->where('customer_id', $customer->id);
            })
            ->firstOrFail();

        $bookingStatusService->expirePendingIfDue($bookingRequest);
        $bookingRequest->refresh();

        if (! in_array($bookingRequest->status, ['PENDING', 'ACCEPTED', 'ONGOING'])) {
            return redirect()->back()->with('flash_message', [
                'title' => 'Invalid Action',
                'message' => 'Only pending, accepted, or ongoing bookings can be cancelled.',
                'type' => 'warning'
            ]);
        }

        $bookingRequest->update([
            'status' => 'CANCELLED',
            'cancelled_by' => 'customer',
            'responded_at' => now(),
            'provider_seen_at' => null,
        ]);

        if ($bookingRequest->bookingInfo) {
            $bookingRequest->bookingInfo->update([
                'status' => 'CANCELLED',
            ]);
        }

        app(BookingEmailService::class)->sendCustomerCancelledToProvider($bookingRequest);

        return redirect()->back()->with('flash_message', [
            'title' => 'Booking Cancelled',
            'message' => 'Your booking has been cancelled.',
            'type' => 'warning'
        ]);
    }
    public function markCustomerNotificationsRead(Request $request)
    {
        $customer = auth()->user()->customer ?? null;

        if (! $customer) {
            abort(403);
        }

        if ($request->filled('notification_id')) {
            if ($request->input('notification_type') === 'customer_request') {
                CustomerRequestApplication::query()
                    ->where('id', $request->input('notification_id'))
                    ->whereHas('customerRequest', function ($query) use ($customer) {
                        $query->where('customer_id', $customer->id);
                    })
                    ->whereNull('customer_seen_at')
                    ->update([
                        'customer_seen_at' => now(),
                    ]);

                return response()->json([
                    'success' => true,
                ]);
            }

            BookingRequest::query()
                ->where('id', $request->input('notification_id'))
                ->whereHas('bookingInfo', function ($query) use ($customer) {
                    $query->where('customer_id', $customer->id);
                })
                ->whereIn('status', ['ACCEPTED', 'ONGOING', 'COMPLETED', 'DECLINED', 'CANCELLED', 'expired'])
                ->whereNull('customer_seen_at')
                ->update([
                    'customer_seen_at' => now(),
                ]);

            return response()->json([
                'success' => true,
            ]);
        }

        BookingRequest::query()
            ->whereHas('bookingInfo', function ($query) use ($customer) {
                $query->where('customer_id', $customer->id);
            })
            ->whereIn('status', ['ACCEPTED', 'ONGOING', 'COMPLETED', 'DECLINED', 'CANCELLED', 'expired'])
            ->whereNull('customer_seen_at')
            ->update([
                'customer_seen_at' => now(),
            ]);

        CustomerRequestApplication::query()
            ->whereHas('customerRequest', function ($query) use ($customer) {
                $query->where('customer_id', $customer->id);
            })
            ->whereNull('customer_seen_at')
            ->update([
                'customer_seen_at' => now(),
            ]);

        return response()->json([
            'success' => true,
        ]);
    }
}
