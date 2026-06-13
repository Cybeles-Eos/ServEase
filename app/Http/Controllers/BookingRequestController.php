<?php

namespace App\Http\Controllers;

use App\Models\BookingRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingRequestController extends Controller
{
    //    1        2       3        4       5         6
    // PENDING ACCEPTED ONGOING DECLINED CANCELLED COMPLETED
    private int $bookingDurationHours = 16; // Auto Close when 16hours reach
    private int $bookingDurationMinutes = 1;

    public function providerRequests()
    {
        $user = auth()->user();

        $bookRequests = BookingRequest::with([
                'bookingInfo.service.provider',
                'bookingInfo.customer'
            ])
            ->whereHas('bookingInfo.service', function ($query) use ($user) {
                $query->where('provider_id', $user->provider->id ?? 0);
            })
            ->latest()
            ->get();

        foreach ($bookRequests as $bookingRequest) {
            $this->updateToOngoingIfDue($bookingRequest);
            $this->updateToCompletedIfDue($bookingRequest);
        }

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

    private function updateToCompletedIfDue($bookingRequest)
    {
        $bookingInfo = $bookingRequest->bookingInfo;

        if (!$bookingInfo) {
            return;
        }

        /*
        * Only ONGOING bookings should become COMPLETED.
        * Example:
        * Booking time: 1:12 PM
        * Duration: 8 hours
        * Completed time: 9:12 PM
        */
        if ($bookingRequest->status !== 'ONGOING' || $bookingInfo->status !== 'ONGOING') {
            return;
        }

        if (empty($bookingInfo->date) || empty($bookingInfo->time)) {
            return;
        }

        try {
            $bookingDate = Carbon::parse($bookingInfo->date)->toDateString();
            $bookingTime = Carbon::parse($bookingInfo->time)->format('H:i:s');

            $scheduleDateTime = Carbon::parse(
                $bookingDate . ' ' . $bookingTime,
                config('app.timezone')
            );

            // $completedDateTime = $scheduleDateTime
            //     ->copy()
            //     ->addHours($this->bookingDurationHours);
            $completedDateTime = $scheduleDateTime
                ->copy()
                ->addMinutes($this->bookingDurationMinutes);

            $now = Carbon::now(config('app.timezone'));

            \Log::info('Booking completion time check', [
                'booking_request_id' => $bookingRequest->id,
                'booking_info_id' => $bookingInfo->id,
                'request_status' => $bookingRequest->status,
                'booking_info_status' => $bookingInfo->status,
                'duration_hours' => $this->bookingDurationHours,
                'schedule' => $scheduleDateTime->toDateTimeString(),
                'completed_at' => $completedDateTime->toDateTimeString(),
                'now' => $now->toDateTimeString(),
                'timezone' => config('app.timezone'),
            ]);

            if ($now->greaterThanOrEqualTo($completedDateTime)) {
                $bookingRequest->update([
                    'status' => 'COMPLETED',
                ]);

                $bookingInfo->update([
                    'status' => 'COMPLETED',
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Booking updateToCompletedIfDue failed', [
                'booking_request_id' => $bookingRequest->id,
                'booking_info_id' => $bookingInfo->id ?? null,
                'date' => $bookingInfo->date ?? null,
                'time' => $bookingInfo->time ?? null,
                'duration_hours' => $this->bookingDurationHours,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function updateToOngoingIfDue($bookingRequest)
    {
        if (
            $bookingRequest->status !== 'ACCEPTED' ||
            !$bookingRequest->bookingInfo ||
            empty($bookingRequest->bookingInfo->date) ||
            empty($bookingRequest->bookingInfo->time)
        ) {
            return;
        }

        try {
            $bookingDate = Carbon::parse($bookingRequest->bookingInfo->date)->toDateString();
            $bookingTime = Carbon::parse($bookingRequest->bookingInfo->time)->format('H:i:s');

            $scheduleDateTime = Carbon::parse(
                $bookingDate . ' ' . $bookingTime,
                config('app.timezone')
            );

            $now = Carbon::now(config('app.timezone'));

            \Log::info('Booking time check', [
                'booking_request_id' => $bookingRequest->id,
                'request_status' => $bookingRequest->status,
                'booking_date' => $bookingDate,
                'booking_time' => $bookingTime,
                'schedule' => $scheduleDateTime->toDateTimeString(),
                'now' => $now->toDateTimeString(),
                'timezone' => config('app.timezone'),
            ]);

            if ($now->greaterThanOrEqualTo($scheduleDateTime)) {
                $bookingRequest->update([
                    'status' => 'ONGOING',
                ]);

                $bookingRequest->bookingInfo->update([
                    'status' => 'ONGOING',
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Booking updateToOngoingIfDue failed', [
                'booking_request_id' => $bookingRequest->id,
                'date' => $bookingRequest->bookingInfo->date ?? null,
                'time' => $bookingRequest->bookingInfo->time ?? null,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function accept($id)
    {
        $provider = auth()->user()->provider ?? null;

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

        return redirect()->back()->with('flash_message', [
            'title' => 'Booking Accepted',
            'message' => null,
            'type' => 'success'
        ]);
    }

    public function decline($id)
    {
        $provider = auth()->user()->provider ?? null;

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

        return redirect()->back()->with('flash_message', [
            'title' => 'Booking Declined',
            'message' => 'Booking request declined successfully.',
            'type' => 'success'
        ]);
    }

    public function cancel($id)
    {
        $provider = auth()->user()->provider ?? null;

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

        return redirect()->back()->with('flash_message', [
            'title' => 'Booking Cancel',
            'message' => 'Booking cancellation may have effect your account',
            'type' => 'warning'
        ]);
    }

    public function markComplete($id)
    {
        $provider = auth()->user()->provider ?? null;

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

        if ($bookingRequest->status !== 'ONGOING') {
            return redirect()->back()->with('flash_message', [
                'title' => 'Invalid Action',
                'message' => 'Only ongoing bookings can be marked as completed.',
                'type' => 'warning'
            ]);
        }

        $bookingRequest->update([
            'status' => 'COMPLETED',
            'responded_at' => now(),
            'customer_seen_at' => null,
            'cancelled_by' => 'provider',
        ]);

        if ($bookingRequest->bookingInfo) {
            $bookingRequest->bookingInfo->update([
                'status' => 'COMPLETED',
            ]);
        }

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

        return response()->json([
            'success' => true,
        ]);
    }

    public function customerCancel($id)
    {
        $customer = auth()->user()->customer ?? null;

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

        if (! in_array($bookingRequest->status, ['PENDING', 'ACCEPTED'])) {
            return redirect()->back()->with('flash_message', [
                'title' => 'Invalid Action',
                'message' => 'Only pending or accepted bookings can be cancelled.',
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
            BookingRequest::query()
                ->where('id', $request->input('notification_id'))
                ->whereHas('bookingInfo', function ($query) use ($customer) {
                    $query->where('customer_id', $customer->id);
                })
                ->whereIn('status', ['ACCEPTED', 'ONGOING', 'COMPLETED', 'DECLINED', 'CANCELLED'])
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
            ->whereIn('status', ['ACCEPTED', 'ONGOING', 'COMPLETED', 'DECLINED', 'CANCELLED'])
            ->whereNull('customer_seen_at')
            ->update([
                'customer_seen_at' => now(),
            ]);

        return response()->json([
            'success' => true,
        ]);
    }
}
