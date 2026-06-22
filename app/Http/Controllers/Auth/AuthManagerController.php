<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Services\BookingStatusService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Services\AdminNotificationService;
use App\Services\OtpService;
use App\Exceptions\DailyOtpLimitReachedException;

class AuthManagerController extends Controller
{
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
                    return redirect()->route(
                        !empty($provider->resubmission_required_documents)
                            ? 'provider.resubmit'
                            : 'provider.declined'
                    );
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

            app(BookingStatusService::class)->updateAllDueBookings();

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
        $otpService = app(OtpService::class);

        $validated = $request->validate([
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone_number' => ['required', 'regex:/^09[0-9]{9}$/', 'unique:tbl_customers,phone_number'],
            'gender' => ['required', 'in:male,female,prefer_not_to_say'],
            'street_address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'barangay' => ['required', 'string', 'max:255'],
            'zipcode' => ['required', 'regex:/^[0-9]{4}$/'],
            'password' => ['required', 'min:8', 'confirmed'],
            'privacy_accepted' => ['accepted'],
            'g-recaptcha-response' => ['required'],
        ], [
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'phone_number.regex' => 'Phone number must start with 09 and must be exactly 11 digits.',
            'phone_number.unique' => 'This phone number is already registered.',
            'gender.required' => 'Please select your gender.',
            'gender.in' => 'Please select a valid gender.',
            'zipcode.regex' => 'ZIP code must be exactly 4 digits.',
            'privacy_accepted.accepted' => 'Please agree to the Privacy Policy before creating your account.',
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

        if ($otpService->hasReachedDailyLimit()) {
            return redirect()
                ->route('signup')
                ->withInput($request->except('password', 'password_confirmation', 'g-recaptcha-response'))
                ->with('flash_message', $otpService->limitFlashMessage());
        }

        $name = $validated['fname'] . ' ' . $validated['lname'];

        session([
            'pending_customer_registration' => [
                'fname'          => $validated['fname'],
                'lname'          => $validated['lname'],
                'name'           => $name,
                'email'          => $validated['email'],
                'phone_number'   => $validated['phone_number'],
                'gender'         => $validated['gender'],
                'street_address' => $validated['street_address'],
                'city'           => $validated['city'],
                'barangay'       => $validated['barangay'],
                'zipcode'        => $validated['zipcode'],
                'password'       => Hash::make($validated['password']),
            ],
            'otp_email' => $validated['email'],
            'otp_name'  => $name,
        ]);

        try {
            $otpService->sendOtpToEmail(
                email: $validated['email'],
                name: $name
            );
        } catch (DailyOtpLimitReachedException $exception) {
            session()->forget([
                'pending_customer_registration',
                'otp_email',
                'otp_name',
            ]);

            return redirect()
                ->route('signup')
                ->withInput($request->except('password', 'password_confirmation', 'g-recaptcha-response'))
                ->with('flash_message', $otpService->limitFlashMessage());
        }

        return redirect()->route('otp.verify.page')->with('flash_message', [
            'title' => 'Verify Your Email',
            'message' => 'We sent a 6-digit OTP to your email. Please verify your email to complete your registration.',
            'type' => 'success',
        ]);
    }

    // public function signupProvider(Request $request)
    // {
    //     $validated = $request->validate([
    //         'fname' => ['required', 'string', 'max:255'],
    //         'lname' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'email', 'max:255', 'unique:users,email'],
    //         'number' => ['required', 'regex:/^09[0-9]{9}$/'],
    //         'address' => ['required', 'string', 'max:255'],
    //         'city' => ['required', 'string', 'max:255'],
    //         'barangay' => ['required', 'string', 'max:255'],
    //         'zipcode' => ['required', 'regex:/^\d{4}$/'],
    //         'profession' => ['required', 'string', 'max:255'],
    //         'experience' => ['required', 'integer', 'min:1', 'max:100'],
    //         'resume' => ['required', 'file', 'mimes:pdf', 'max:5120'],
    //         'barangay_clearance' => ['required', 'file', 'mimes:pdf', 'max:5120'],
    //         'password' => ['required', 'min:8', 'confirmed'],
    //         'g-recaptcha-response' => ['required'],
    //     ], [
    //         'number.regex' => 'The phone number must start with 09 and must be exactly 11 digits.',
    //         'zipcode.regex' => 'The ZIP Code must be 4 digits.',
    //         'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
    //     ]);

    //     $recaptcha = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
    //         'secret' => config('services.recaptcha.secret_key'),
    //         'response' => $request->input('g-recaptcha-response'),
    //         'remoteip' => $request->ip(),
    //     ]);

    //     if (! $recaptcha->json('success')) {
    //         throw ValidationException::withMessages([
    //             'g-recaptcha-response' => ['reCAPTCHA verification failed. Please try again.'],
    //         ]);
    //     }

    //     $createdUser = null;

    //     DB::transaction(function () use ($request, $validated, &$createdUser) {
    //         $resumePath = null;
    //         $barangayClearancePath = null;

    //         if ($request->hasFile('resume')) {
    //             $resumePath = $request->file('resume')->store('provider-resumes', 'public');
    //         }

    //         if ($request->hasFile('barangay_clearance')) {
    //             $barangayClearancePath = $request->file('barangay_clearance')->store('provider-barangay-clearances', 'public');
    //         }

    //         $user = User::create([
    //             'name' => $validated['fname'] . ' ' . $validated['lname'],
    //             'email' => $validated['email'],
    //             'password' => Hash::make($validated['password']),
    //             'role' => 'provider',

    //             /*
    //             |--------------------------------------------------------------------------
    //             | Important
    //             |--------------------------------------------------------------------------
    //             | Provider cannot login until admin accepts the application.
    //             */
    //             'is_active' => 0, // Set to active to allow login, but provider application status will be checked on login to block access until accepted by admin
    //         ]);

    //         $user->provider()->create([
    //             'first_name' => $validated['fname'],
    //             'last_name' => $validated['lname'],
    //             'phone_number' => $validated['number'],
    //             'home_address' => $validated['address'],
    //             'city' => $validated['city'],
    //             'barangay' => $validated['barangay'],
    //             'zipcode' => $validated['zipcode'],
    //             'profession' => $validated['profession'],
    //             'year_exp' => $validated['experience'],

    //             'resume_path' => $resumePath,
    //             'barangay_clearance_path' => $barangayClearancePath,

    //             'application_status' => 'pending',
    //             'application_reviewed_at' => null,
    //             'application_reviewed_by' => null,
    //             'application_remarks' => null,
    //         ]);

    //         $createdUser = $user;
    //     });

    //     if ($createdUser) {
    //         AdminNotificationService::newProviderApplication($createdUser);

    //         app(OtpService::class)->sendRegistrationOtp($createdUser);

    //         session([
    //             'otp_email' => $createdUser->email,
    //             'otp_user_id' => $createdUser->id,
    //         ]);

    //         return redirect()->route('otp.verify.page')->with('flash_message', [
    //             'title' => 'Verify Your Email',
    //             'message' => 'Your provider application was submitted. We sent a 6-digit OTP to your email. Please verify your email while your application waits for admin review.',
    //             'type' => 'success',
    //         ]);
    //     }

    //     return redirect()
    //         ->route('provider-signup')
    //         ->with('provider_application_submitted', true);
    // }
    public function signupProvider(Request $request)
    {
        $otpService = app(OtpService::class);

        $validated = $request->validate([
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'number' => ['required', 'regex:/^09[0-9]{9}$/'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'barangay' => ['required', 'string', 'max:255'],
            'zipcode' => ['required', 'regex:/^\d{4}$/'],
            'gender' => ['required', 'in:male,female,prefer_not_to_say'],
            'profession' => ['required', 'string', 'max:255'],
            'experience' => ['required', 'integer', 'min:1', 'max:100'],
            'resume' => ['required', 'file', 'mimes:pdf', 'max:5120'],
            'barangay_clearance' => ['required', 'file', 'mimes:pdf', 'max:5120'],
            'password' => ['required', 'min:8', 'confirmed'],
            'privacy_accepted' => ['accepted'],
            'g-recaptcha-response' => ['required'],
        ], [
            'number.regex' => 'The phone number must start with 09 and must be exactly 11 digits.',
            'zipcode.regex' => 'The ZIP Code must be 4 digits.',
            'gender.required' => 'Please select your gender.',
            'gender.in' => 'Please select a valid gender.',
            'privacy_accepted.accepted' => 'Please agree to the Privacy Policy before submitting your application.',
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

        if ($otpService->hasReachedDailyLimit()) {
            return redirect()
                ->route('provider-signup')
                ->withInput($request->except('password', 'password_confirmation', 'g-recaptcha-response', 'resume', 'barangay_clearance'))
                ->with('flash_message', $otpService->limitFlashMessage());
        }

        $name = $validated['fname'] . ' ' . $validated['lname'];

        $resumePath = null;
        $barangayClearancePath = null;

        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('pending-provider-resumes', 'public');
        }

        if ($request->hasFile('barangay_clearance')) {
            $barangayClearancePath = $request->file('barangay_clearance')->store('pending-provider-barangay-clearances', 'public');
        }

        session([
            'pending_provider_registration' => [
                'fname' => $validated['fname'],
                'lname' => $validated['lname'],
                'name' => $name,
                'email' => $validated['email'],
                'number' => $validated['number'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'barangay' => $validated['barangay'],
                'zipcode' => $validated['zipcode'],
                'gender' => $validated['gender'],
                'profession' => $validated['profession'],
                'experience' => $validated['experience'],
                'resume_path' => $resumePath,
                'barangay_clearance_path' => $barangayClearancePath,
                'password' => Hash::make($validated['password']),
            ],
            'otp_email' => $validated['email'],
            'otp_name' => $name,
        ]);

        try {
            $otpService->sendOtpToEmail(
                email: $validated['email'],
                name: $name
            );
        } catch (DailyOtpLimitReachedException $exception) {
            foreach ([$resumePath, $barangayClearancePath] as $pendingPath) {
                if (!empty($pendingPath) && Storage::disk('public')->exists($pendingPath)) {
                    Storage::disk('public')->delete($pendingPath);
                }
            }

            session()->forget([
                'pending_provider_registration',
                'otp_email',
                'otp_name',
            ]);

            return redirect()
                ->route('provider-signup')
                ->withInput($request->except('password', 'password_confirmation', 'g-recaptcha-response', 'resume', 'barangay_clearance'))
                ->with('flash_message', $otpService->limitFlashMessage());
        }

        return redirect()->route('otp.verify.page')->with('flash_message', [
            'title' => 'Verify Your Email',
            'message' => 'We sent a 6-digit OTP to your email. Please verify your email to submit your provider application.',
            'type' => 'success',
        ]);
    }

}
