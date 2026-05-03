<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
// use App\Services\BookingStatusService;
use App\Models\BookingInfo;
use Carbon\Carbon;

class AuthManagerController extends Controller
{
    private int $bookingDurationHours = 16; // Production
    private int $bookingDurationMinutes = 1; // Testing only
    private bool $useMinuteTesting = true; // Set false after testing
    /**
     * Show login page
     */
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    // public function showDashboard()
    // {

    //     return view('admin.dashboard');
    // }
    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            //app(BookingStatusService::class)->updateAllDueBookings(); //Update Status

            $this->updateAllBookingStatuses();

            $user = Auth::user();

            if (!$user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                throw ValidationException::withMessages([
                    'email' => ['This account has been disabled.'],
                ]);
            }

            if ($user->isAdmin()) {
                return redirect('/admin/dashboard');
            }

            if ($user->isProvider()) {
                return redirect('/provider/dashboard');
            }

            return redirect('customer/dashboard'); // customer
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    /**
     * Logout authenticated user
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function showSignup()
    {
        return view('admin.auth.register');
    }

    public function showProvReg()
    {
        return view('admin.auth.provider-register');
    }

    public function signup(Request $request)
    {
        // Customer Creation Account
        $validated = $request->validate([
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = User::create([ 
            'name' => $validated['fname'] . ' ' . $validated['lname'],      // temporary, soon this data will be removed or act as username
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'customer', 
        ]);
        $user->customer()->create([
            'first_name' => $validated['fname'],
            'last_name' => $validated['lname'],
        ]);

        return redirect('/login');
    }

    public function signupProvider(Request $request)
    {
        $validated = $request->validate([
            'fname'      => ['required', 'string', 'max:255'],
            'lname'      => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'unique:users,email'],
            'number'     => ['required', 'string'], // phone_num
            'address'    => ['required', 'string'], // home_address
            'province'   => ['required', 'string'],
            'zipcode'    => ['required', 'string'], // zip
            'profession' => ['required', 'string'],
            'experience' => ['required', 'integer'], // year_exp
            'password'   => ['required', 'min:8', 'confirmed'],
        ]);
        
        // Create the Base User Account
        $user = User::create([
            'name'     => $validated['fname'] . ' ' . $validated['lname'],      // temporary, soon this data will be removed or act as username
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'provider', // Set role to provider
        ]);

        // Create the Provider Profile
        $user->provider()->create([
            'first_name' => $validated['fname'],
            'last_name' => $validated['lname'],
            'phone_num'    => $validated['number'],
            'home_address' => $validated['address'],
            'province'     => $validated['province'],
            'zipcode'          => $validated['zipcode'],
            'profession'   => $validated['profession'],
            'year_exp'     => $validated['experience'],
        ]);

        return redirect('/login')->with('success', 'Provider account created successfully!');
    }



    // For Status
    private function updateAllBookingStatuses()
    {
        // Check all bookings, not only one customer/provider
        $bookingsToCheck = BookingInfo::with('bookingRequest')
            ->whereIn('status', ['ACCEPTED', 'ONGOING'])
            ->whereNotNull('date')
            ->whereNotNull('time')
            ->get();

        foreach ($bookingsToCheck as $bookingInfo) {
            $this->updateToOngoingIfDue($bookingInfo);
            $this->updateToCompletedIfDue($bookingInfo);
        }
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
            $bookingDate = Carbon::parse($bookingInfo->date)->toDateString();
            $bookingTime = Carbon::parse($bookingInfo->time)->format('H:i:s');

            $scheduleDateTime = Carbon::parse(
                $bookingDate . ' ' . $bookingTime,
                config('app.timezone')
            );

            $now = Carbon::now(config('app.timezone'));

            \Log::info('Login auto ongoing check', [
                'booking_info_id' => $bookingInfo->id,
                'booking_request_id' => $bookingInfo->bookingRequest->id ?? null,
                'booking_info_status' => $bookingInfo->status,
                'booking_request_status' => $bookingInfo->bookingRequest->status ?? null,
                'schedule' => $scheduleDateTime->toDateTimeString(),
                'now' => $now->toDateTimeString(),
            ]);

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
            \Log::error('Login updateToOngoingIfDue failed', [
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
            $bookingDate = Carbon::parse($bookingInfo->date)->toDateString();
            $bookingTime = Carbon::parse($bookingInfo->time)->format('H:i:s');

            $scheduleDateTime = Carbon::parse(
                $bookingDate . ' ' . $bookingTime,
                config('app.timezone')
            );

            if ($this->useMinuteTesting) {
                $completedDateTime = $scheduleDateTime
                    ->copy()
                    ->addMinutes($this->bookingDurationMinutes);
            } else {
                $completedDateTime = $scheduleDateTime
                    ->copy()
                    ->addHours($this->bookingDurationHours);
            }

            $now = Carbon::now(config('app.timezone'));

            \Log::info('Login auto completed check', [
                'booking_info_id' => $bookingInfo->id,
                'booking_request_id' => $bookingInfo->bookingRequest->id ?? null,
                'booking_info_status' => $bookingInfo->status,
                'booking_request_status' => $bookingInfo->bookingRequest->status ?? null,
                'duration_hours' => $this->bookingDurationHours,
                'duration_minutes' => $this->bookingDurationMinutes,
                'use_minute_testing' => $this->useMinuteTesting,
                'schedule' => $scheduleDateTime->toDateTimeString(),
                'completed_at' => $completedDateTime->toDateTimeString(),
                'now' => $now->toDateTimeString(),
            ]);

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
            \Log::error('Login updateToCompletedIfDue failed', [
                'booking_info_id' => $bookingInfo->id ?? null,
                'date' => $bookingInfo->date ?? null,
                'time' => $bookingInfo->time ?? null,
                'duration_hours' => $this->bookingDurationHours,
                'duration_minutes' => $this->bookingDurationMinutes,
                'error' => $e->getMessage(),
            ]);
        }
    }

}
