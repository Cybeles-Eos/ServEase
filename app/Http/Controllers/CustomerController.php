<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingInfo;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use File;
use Carbon\Carbon;

class CustomerController extends Controller
{
    private int $bookingDurationHours = 16; // Auto-complete 16 hours after booking start time
    private int $bookingDurationMinutes = 1;

    public function dashboard(Request $request)
    {
        $customer = auth()->user()->customer;

        if (! $customer) {
            abort(403, 'Customer account not found.');
        }

        $customerId = $customer->id;
        $selectedStatus = $request->get('status');

        /*
        |--------------------------------------------------------------------------
        | Auto status update
        |--------------------------------------------------------------------------
        */
        $bookingsToCheck = BookingInfo::with('bookingRequest')
            ->where('customer_id', $customerId)
            ->whereIn('status', ['ACCEPTED', 'ONGOING'])
            ->get();

        foreach ($bookingsToCheck as $bookingInfo) {
            $this->updateToOngoingIfDue($bookingInfo);
            $this->updateToCompletedIfDue($bookingInfo);
        }

        /*
        |--------------------------------------------------------------------------
        | Left side dynamic counts
        |--------------------------------------------------------------------------
        */
        $totalBookings = BookingInfo::query()
            ->where('customer_id', $customerId)
            ->count();

        $cancelledBookings = \App\Models\BookingRequest::query()
            ->whereHas('bookingInfo', function ($query) use ($customerId) {
                $query->where('customer_id', $customerId);
            })
            ->where('status', 'CANCELLED')
            ->where(function ($query) {
                $query->where('cancelled_by', 'customer')
                    ->orWhereNull('cancelled_by');
            })
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Active booking
        |--------------------------------------------------------------------------
        */
        $ongoingBookings = BookingInfo::with([
                'service.provider.user',
                'bookingRequest',
            ])
            ->where('customer_id', $customerId)
            ->where('status', 'ONGOING')
            ->latest()
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Booking list with status filter
        |--------------------------------------------------------------------------
        */
        $allBookingsQuery = BookingInfo::with([
                'service.provider.user',
                'bookingRequest',
            ])
            ->where('customer_id', $customerId)
            ->where('status', '!=', 'ONGOING');

        if (! empty($selectedStatus)) {
            $allBookingsQuery->where('status', $selectedStatus);
        }

        $allBookings = $allBookingsQuery
            ->latest()
            ->get();

        $bookingListCount = $allBookings->count();

        return view('admin.cusdashboard', compact(
            'ongoingBookings',
            'allBookings',
            'totalBookings',
            'cancelledBookings',
            'bookingListCount',
            'selectedStatus'
        ));
    }
    private function updateToOngoingIfDue($bookingInfo)
    {
        if (
            $bookingInfo->status !== 'ACCEPTED' ||
            empty($bookingInfo->date) ||
            empty($bookingInfo->time)
        ) {
            return;
        }

        try {
            $bookingDate = \Carbon\Carbon::parse($bookingInfo->date)->toDateString();
            $bookingTime = \Carbon\Carbon::parse($bookingInfo->time)->format('H:i:s');

            $scheduleDateTime = \Carbon\Carbon::parse(
                $bookingDate . ' ' . $bookingTime,
                config('app.timezone')
            );

            $now = \Carbon\Carbon::now(config('app.timezone'));

            if ($now->greaterThanOrEqualTo($scheduleDateTime)) {
                $bookingInfo->update([
                    'status' => 'ONGOING',
                ]);

                if ($bookingInfo->bookingRequest) {
                    $bookingInfo->bookingRequest->update([
                        'status' => 'ONGOING',
                    ]);
                }
            }
        } catch (\Exception $e) {
            \Log::error('Customer dashboard updateToOngoingIfDue failed', [
                'booking_info_id' => $bookingInfo->id ?? null,
                'date' => $bookingInfo->date ?? null,
                'time' => $bookingInfo->time ?? null,
                'error' => $e->getMessage(),
            ]);
        }
    }
    private function updateToCompletedIfDue($bookingInfo)
    {
        if (
            $bookingInfo->status !== 'ONGOING' ||
            empty($bookingInfo->date) ||
            empty($bookingInfo->time)
        ) {
            return;
        }

        try {
            $bookingDate = \Carbon\Carbon::parse($bookingInfo->date)->toDateString();
            $bookingTime = \Carbon\Carbon::parse($bookingInfo->time)->format('H:i:s');

            $scheduleDateTime = \Carbon\Carbon::parse(
                $bookingDate . ' ' . $bookingTime,
                config('app.timezone')
            );

            // $completedDateTime = $scheduleDateTime
            //     ->copy()
            //     ->addHours($this->bookingDurationHours);
            $completedDateTime = $scheduleDateTime
                ->copy()
                ->addMinutes($this->bookingDurationMinutes);

            $now = \Carbon\Carbon::now(config('app.timezone'));

            if ($now->greaterThanOrEqualTo($completedDateTime)) {
                $bookingInfo->update([
                    'status' => 'COMPLETED',
                ]);

                if ($bookingInfo->bookingRequest) {
                    $bookingInfo->bookingRequest->update([
                        'status' => 'COMPLETED',
                    ]);
                }
            }
        } catch (\Exception $e) {
            \Log::error('Customer dashboard updateToCompletedIfDue failed', [
                'booking_info_id' => $bookingInfo->id ?? null,
                'date' => $bookingInfo->date ?? null,
                'time' => $bookingInfo->time ?? null,
                'duration_hours' => $this->bookingDurationHours,
                'error' => $e->getMessage(),
            ]);
        }
    }

    // Index Settings
    public function setting()
    {
        $user = User::with('customer')->find(auth()->id());
        return view('admin.cussetting', compact('user'));
    }

    public function updateSetting(Request $request)
    {
        $request->validate([
            'first_name'   => 'nullable|string|max:255',
            'last_name'    => 'nullable|string|max:255',
            'profile_image'=> 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'phone_number' => 'nullable|string|max:20',
            'street_address' => 'nullable|string|max:255',
            'city'         => 'nullable|string|max:255',
            'barangay'     => 'nullable|string|max:255',
            'zipcode'      => 'nullable|string|max:20',
            // 'email'        => 'nullable|email|max:255'
        ]);

        $user = auth()->user();
        $customer = $user->customer;

        /*
        |--------------------------------------------------------------------------
        | Handle Image Removal
        |--------------------------------------------------------------------------
        */
        if ($request->remove_profile_image == "1") {

            if ($customer->profile_image && file_exists(public_path($customer->profile_image))) {
                unlink(public_path($customer->profile_image));
            }

            $customer->profile_image = null;
        }

        /*
        |--------------------------------------------------------------------------
        | Handle New Upload
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('profile_image')) {
            $profileImagePath = $this->uploadFile(
                $request->file('profile_image'),
                'profile',
                'customer_profiles'
            );

            $customer->profile_image = $profileImagePath;
        }

        /*
        |--------------------------------------------------------------------------
        | Update Customer Table
        |--------------------------------------------------------------------------
        */
        $customer->first_name  = $request->first_name;
        $customer->last_name   = $request->last_name;
        $customer->phone_number= $request->phone_number;
        $customer->street_address     = $request->street_address;
        $customer->city        = $request->city;
        $customer->barangay     = $request->barangay;
        $customer->zipcode     = $request->zipcode;
        $customer->save();

        /*
        |--------------------------------------------------------------------------
        | Update Users Table
        |--------------------------------------------------------------------------
        */
        $user->name  = trim($request->first_name . ' ' . $request->last_name);
        // $user->email = $request->email;
        $user->save();

        return redirect()->route('customer.setting')->with('flash_message', [
            'title' => '',
            'message' => 'Profile updated successfully.',
            'type' => 'success'
        ]);
    }

    // Helper function to handle file uploads
    public function uploadFile($file, $type = null, $path)
    {
        $extension = $file->getClientOriginalExtension();
        $file_name = substr(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), 0, 30) . '-' . time() . ($type ? '-' . $type : '') . '.' . $extension;
        $file_name = preg_replace("/[^a-z0-9\_\-\.]/i", '', $file_name);
        $file_path = 'public/uploads/' . $path;
        $directory = public_path() . $file_path;

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0777, true);
        }

        $file->move($directory, $file_name);
        return $file_path . '/' . $file_name;
    }
}
