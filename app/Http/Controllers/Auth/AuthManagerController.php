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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

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

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'g-recaptcha-response' => ['required'],
        ], [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
        ]);

        $recaptcha = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (! $recaptcha->json('success')) {
            throw ValidationException::withMessages([
                'g-recaptcha-response' => ['reCAPTCHA verification failed. Please try again.'],
            ]);
        }

        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password'],
        ];

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            /*
            |--------------------------------------------------------------------------
            | Provider application check
            |--------------------------------------------------------------------------
            | New providers are created with is_active = 0 and application_status = pending.
            | So we must check provider application status before the general disabled check.
            */
            if ($user->role === 'provider') {
                $provider = $user->provider;

                if (!$provider) {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    throw ValidationException::withMessages([
                        'email' => ['Provider profile was not found. Please contact admin.'],
                    ]);
                }

                if ($provider->application_status === 'pending') {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    throw ValidationException::withMessages([
                        'email' => ['Your provider application is still under review.'],
                    ]);
                }

                if ($provider->application_status === 'declined') {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    throw ValidationException::withMessages([
                        'email' => ['Your provider application has been declined.'],
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Accepted provider but manually disabled by admin
                |--------------------------------------------------------------------------
                */
                if ($provider->application_status === 'accepted' && !$user->is_active) {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    throw ValidationException::withMessages([
                        'email' => ['This account has been disabled.'],
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | General disabled account check
            |--------------------------------------------------------------------------
            | This applies to admin/customer, and also protects any non-provider account.
            */
            if (!$user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                throw ValidationException::withMessages([
                    'email' => ['This account has been disabled.'],
                ]);
            }

            $this->updateAllBookingStatuses();

            if ($user->isAdmin()) {
                return redirect('/admin/dashboard');
            }

            if ($user->isProvider()) {
                return redirect('/provider/dashboard');
            }

            return redirect('customer/dashboard');
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
            'g-recaptcha-response' => ['required'],
        ], [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
        ]);

        $recaptcha = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (! $recaptcha->json('success')) {
            throw ValidationException::withMessages([
                'g-recaptcha-response' => ['reCAPTCHA verification failed. Please try again.'],
            ]);
        }

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
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'number' => ['required', 'regex:/^09[0-9]{9}$/'],
            'address' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'zipcode' => ['required', 'digits:5'],
            'profession' => ['required', 'string', 'max:255'],
            'experience' => ['required', 'integer', 'min:0'],
            'resume' => ['required', 'file', 'mimes:pdf', 'max:5120'],
            'barangay_clearance' => ['required', 'file', 'mimes:pdf', 'max:5120'],
            'password' => ['required', 'min:8', 'confirmed'],
            'g-recaptcha-response' => ['required'],
        ], [
            'number.regex' => 'The phone number must start with 09 and must be exactly 11 digits.',
            'zipcode.digits' => 'The ZIP code must be exactly 5 digits.',
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
        ]);

        $recaptcha = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (! $recaptcha->json('success')) {
            throw ValidationException::withMessages([
                'g-recaptcha-response' => ['reCAPTCHA verification failed. Please try again.'],
            ]);
        }

        DB::transaction(function () use ($request, $validated) {
            $resumePath = null;
            $barangayClearancePath = null;

            if ($request->hasFile('resume')) {
                $resumePath = $request->file('resume')->store('provider-resumes', 'public');
            }

            if ($request->hasFile('barangay_clearance')) {
                $barangayClearancePath = $request->file('barangay_clearance')->store('provider-barangay-clearances', 'public');
            }

            $user = User::create([
                'name' => $validated['fname'] . ' ' . $validated['lname'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'provider',

                /*
                |--------------------------------------------------------------------------
                | Important
                |--------------------------------------------------------------------------
                | Provider cannot login until admin accepts the application.
                */
                'is_active' => 0, // Set to active to allow login, but provider application status will be checked on login to block access until accepted by admin
            ]);

            $user->provider()->create([
                'first_name' => $validated['fname'],
                'last_name' => $validated['lname'],
                'phone_number' => $validated['number'],
                'personal_email' => $validated['email'],
                'home_address' => $validated['address'],
                'province' => $validated['province'],
                'zipcode' => $validated['zipcode'],
                'profession' => $validated['profession'],
                'year_exp' => $validated['experience'],

                'resume_path' => $resumePath,
                'barangay_clearance_path' => $barangayClearancePath,

                'application_status' => 'pending',
                'application_reviewed_at' => null,
                'application_reviewed_by' => null,
                'application_remarks' => null,
            ]);
        });

        return redirect()
            ->route('provider-signup')
            ->with('provider_application_submitted', true);
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
