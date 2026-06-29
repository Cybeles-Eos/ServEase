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
use App\Exceptions\OtpDeliveryException;
use App\Models\EmailOtp;    

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

                if ($provider->application_status === 'resubmission_requested') {
                    return redirect()->route('provider.resubmit');
                }

                if ($provider->application_status === 'declined') {
                    return redirect()->route('provider.declined');
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
        $birthdateAgeRule = function ($attribute, $value, $fail) {
            try {
                $age = \Carbon\Carbon::parse($value)->age;
            } catch (\Throwable $exception) {
                return;
            }

            if ($age < 18) {
                $fail('You must be at least 18 years old.');
            }

            if ($age > 150) {
                $fail('Age cannot be greater than 150 years old.');
            }
        };

        $validated = $request->validate([
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone_number' => ['required', 'regex:/^09[0-9]{9}$/', 'unique:tbl_customers,phone_number'],
            'gender' => ['required', 'in:male,female,prefer_not_to_say'],
            'birthdate' => ['required', 'date', $birthdateAgeRule],
            'street_address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'barangay' => ['required', 'string', 'max:255'],
            'zipcode' => ['required', 'regex:/^[0-9]{4}$/'],
            // 'password' => ['required', 'min:8', 'confirmed'],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).+$/',
            ],
            'privacy_accepted' => ['accepted'],
            'g-recaptcha-response' => ['required'],
        ], [
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'phone_number.regex' => 'Phone number must start with 09 and must be exactly 11 digits.',
            'phone_number.unique' => 'This phone number is already registered.',
            'gender.required' => 'Please select your gender.',
            'gender.in' => 'Please select a valid gender.',
            'birthdate.required' => 'Please select your birthdate.',
            'birthdate.date' => 'Please select a valid birthdate.',
            'zipcode.regex' => 'ZIP code must be exactly 4 digits.',
            'privacy_accepted.accepted' => 'Please agree to the Privacy Policy before creating your account.',
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.regex' => 'Password must include uppercase, lowercase, number, and special character.',
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

        $name = $validated['fname'] . ' ' . $validated['lname'];

        if (! $otpService->isEnabled()) {
            DB::transaction(function () use ($validated, $name) {
                $user = User::create([
                    'name' => $name,
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'role' => 'customer',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]);

                $user->customer()->create([
                    'first_name' => $validated['fname'],
                    'last_name' => $validated['lname'],
                    'phone_number' => $validated['phone_number'],
                    'gender' => $validated['gender'],
                    'birth_date' => $validated['birthdate'],
                    'street_address' => $validated['street_address'],
                    'city' => $validated['city'],
                    'barangay' => $validated['barangay'],
                    'zipcode' => $validated['zipcode'],
                ]);

                AdminNotificationService::newCustomer($user);
            });

            session()->forget([
                'pending_customer_registration',
                'pending_provider_registration',
                'otp_email',
                'otp_name',
                'otp_user_id',
            ]);

            return redirect()->route('login')->with('flash_message', [
                'title' => 'Account Created',
                'message' => 'Your customer account has been created successfully. You can now login.',
                'type' => 'success',
            ]);
        }

        if ($otpService->hasReachedDailyLimit()) {
            return redirect()
                ->route('signup')
                ->withInput($request->except('password', 'password_confirmation', 'g-recaptcha-response'))
                ->with('flash_message', $otpService->limitFlashMessage());
        }

        if ($otpService->hasReachedResendLimit($request, $validated['email'])) {
            return redirect()
                ->route('signup')
                ->withInput($request->except('password', 'password_confirmation', 'g-recaptcha-response'))
                ->withErrors(['email' => $otpService->resendLimitMessage($request, $validated['email'])]);
        }

        session([
            'pending_customer_registration' => [
                'fname'          => $validated['fname'],
                'lname'          => $validated['lname'],
                'name'           => $name,
                'email'          => $validated['email'],
                'phone_number'   => $validated['phone_number'],
                'gender'         => $validated['gender'],
                'birthdate'      => $validated['birthdate'],
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
        } catch (OtpDeliveryException $exception) {
            session()->forget([
                'pending_customer_registration',
                'otp_email',
                'otp_name',
            ]);

            return redirect()
                ->route('signup')
                ->withInput($request->except('password', 'password_confirmation', 'g-recaptcha-response'))
                ->withErrors(['email' => $exception->getMessage()]);
        }

        return redirect()->route('otp.verify.page')->with('flash_message', [
            'title' => 'Verify Your Email',
            'message' => 'We sent a 6-digit OTP to your email. Please verify your email to complete your registration.',
            'type' => 'success',
        ]);
    }

    public function signupProvider(Request $request)
    {
        $otpService = app(OtpService::class);
        $birthdateAgeRule = function ($attribute, $value, $fail) {
            try {
                $age = \Carbon\Carbon::parse($value)->age;
            } catch (\Throwable $exception) {
                return;
            }

            if ($age < 18) {
                $fail('You must be at least 18 years old.');
            }

            if ($age > 150) {
                $fail('Age cannot be greater than 150 years old.');
            }
        };

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
            'birthdate' => ['required', 'date', $birthdateAgeRule],
            'profession' => ['required', 'string', 'max:255'],
            'experience' => ['required', 'integer', 'min:1', 'max:100'],
            'resume' => ['required', 'file', 'mimes:pdf', 'max:5120'],
            'barangay_clearance' => ['required', 'file', 'mimes:pdf', 'max:5120'],
            // 'password' => ['required', 'min:8', 'confirmed'],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).+$/',
            ],
            'privacy_accepted' => ['accepted'],
            'g-recaptcha-response' => ['required'],
        ], [
            'number.regex' => 'The phone number must start with 09 and must be exactly 11 digits.',
            'zipcode.regex' => 'The ZIP Code must be 4 digits.',
            'gender.required' => 'Please select your gender.',
            'gender.in' => 'Please select a valid gender.',
            'birthdate.required' => 'Please select your birthdate.',
            'birthdate.date' => 'Please select a valid birthdate.',
            'privacy_accepted.accepted' => 'Please agree to the Privacy Policy before submitting your application.',
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.regex' => 'Password must include uppercase, lowercase, number, and special character.',
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

        $name = $validated['fname'] . ' ' . $validated['lname'];

        if (! $otpService->isEnabled()) {
            $resumePath = null;
            $barangayClearancePath = null;

            if ($request->hasFile('resume')) {
                $resumePath = $request->file('resume')->store('provider-resumes', 'public');
            }

            if ($request->hasFile('barangay_clearance')) {
                $barangayClearancePath = $request->file('barangay_clearance')->store('provider-barangay-clearances', 'public');
            }

            DB::transaction(function () use ($validated, $name, $resumePath, $barangayClearancePath) {
                $user = User::create([
                    'name' => $name,
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'role' => 'provider',
                    'is_active' => 0,
                    'email_verified_at' => now(),
                ]);

                $user->provider()->create([
                    'first_name' => $validated['fname'],
                    'last_name' => $validated['lname'],
                    'phone_number' => $validated['number'],
                    'gender' => $validated['gender'],
                    'birth_date' => $validated['birthdate'],
                    'home_address' => $validated['address'],
                    'city' => $validated['city'],
                    'barangay' => $validated['barangay'],
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

                AdminNotificationService::newProviderApplication($user);
            });

            session()->forget([
                'pending_customer_registration',
                'pending_provider_registration',
                'otp_email',
                'otp_name',
                'otp_user_id',
            ]);

            return redirect()->route('login')->with('flash_message', [
                'title' => 'Application Submitted',
                'message' => 'Your provider application has been submitted successfully. Please wait while admin reviews your application.',
                'type' => 'success',
            ]);
        }

        if ($otpService->hasReachedDailyLimit()) {
            return redirect()
                ->route('provider-signup')
                ->withInput($request->except('password', 'password_confirmation', 'g-recaptcha-response', 'resume', 'barangay_clearance'))
                ->with('flash_message', $otpService->limitFlashMessage());
        }

        if ($otpService->hasReachedResendLimit($request, $validated['email'])) {
            return redirect()
                ->route('provider-signup')
                ->withInput($request->except('password', 'password_confirmation', 'g-recaptcha-response', 'resume', 'barangay_clearance'))
                ->withErrors(['email' => $otpService->resendLimitMessage($request, $validated['email'])]);
        }

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
                'birthdate' => $validated['birthdate'],
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
        } catch (OtpDeliveryException $exception) {
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
                ->withErrors(['email' => $exception->getMessage()]);
        }

        return redirect()->route('otp.verify.page')->with('flash_message', [
            'title' => 'Verify Your Email',
            'message' => 'We sent a 6-digit OTP to your email. Please verify your email to submit your provider application.',
            'type' => 'success',
        ]);
    }

    public function showForgotPassword()
    {
        return view('admin.auth.forgot-password');
    }

    public function sendForgotPasswordOtp(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'g-recaptcha-response' => ['required'],
        ], [
            'email.exists' => 'No account found with this email address.',
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

        $user = User::where('email', $validated['email'])->firstOrFail();
        $otpService = app(OtpService::class);

        if ($otpService->hasReachedDailyLimit()) {
            return back()
                ->withInput()
                ->with('flash_message', $otpService->limitFlashMessage());
        }

        if ($otpService->hasReachedResendLimit($request, $user->email)) {
            return back()
                ->withInput()
                ->withErrors([
                    'email' => $otpService->resendLimitMessage($request, $user->email),
                ]);
        }

        $otpService->reserveResendAttempt($request, $user->email);

        try {
            $otpService->sendForgotPasswordOtp($user);
        } catch (DailyOtpLimitReachedException $exception) {
            $otpService->releaseResendAttempt($request, $user->email);

            return back()
                ->withInput()
                ->with('flash_message', $otpService->limitFlashMessage());
        } catch (OtpDeliveryException $exception) {
            $otpService->releaseResendAttempt($request, $user->email);

            return back()
                ->withInput()
                ->withErrors([
                    'email' => $exception->getMessage(),
                ]);
        }

        session([
            'forgot_password_email' => $user->email,
            'forgot_password_user_id' => $user->id,
            'forgot_password_name' => $user->name,
        ]);

        return redirect()->route('password.otp.page')->with('flash_message', [
            'title' => 'OTP Sent',
            'message' => 'We sent a 6-digit password reset OTP to your email.',
            'type' => 'success',
        ]);
    }

    public function showForgotPasswordOtp(Request $request)
    {
        if (! session('forgot_password_email')) {
            return redirect()->route('password.forgot')
                ->withErrors(['email' => 'Session expired. Please enter your email again.']);
        }

        $resendLimit = app(OtpService::class)->resendLimitStatus($request, session('forgot_password_email'));

        return view('auth.forgot-password-otp', compact('resendLimit'));
    }

    public function verifyForgotPasswordOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'string', 'min:6', 'max:6'],
        ]);

        $email = session('forgot_password_email');

        if (! $email) {
            return redirect()->route('password.forgot')
                ->withErrors(['email' => 'Session expired. Please enter your email again.']);
        }

        $record = EmailOtp::where('email', $email)
            ->where('otp', $request->otp)
            ->whereNull('verified_at')
            ->latest()
            ->first();

        if (! $record) {
            return back()->withErrors([
                'otp' => 'Invalid OTP code.',
            ]);
        }

        if (now()->greaterThan($record->expires_at)) {
            return back()->withErrors([
                'otp' => 'OTP code has expired. Please request a new one.',
            ]);
        }

        $record->update([
            'verified_at' => now(),
        ]);

        session([
            'forgot_password_verified' => true,
        ]);

        return redirect()->route('password.reset.page');
    }

    public function showResetPassword()
    {
        if (! session('forgot_password_verified') || ! session('forgot_password_user_id')) {
            return redirect()->route('password.forgot')
                ->withErrors(['email' => 'Please verify your OTP first.']);
        }

        return view('auth.reset-password');
    }

    public function updateForgotPassword(Request $request)
    {
        if (! session('forgot_password_verified') || ! session('forgot_password_user_id')) {
            return redirect()->route('password.forgot')
                ->withErrors(['email' => 'Please verify your OTP first.']);
        }

        $validated = $request->validate([
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).+$/',
            ],
        ], [
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.regex' => 'Password must include uppercase, lowercase, number, and special character.',
        ]);

        $user = User::find(session('forgot_password_user_id'));

        if (! $user) {
            session()->forget([
                'forgot_password_email',
                'forgot_password_user_id',
                'forgot_password_name',
                'forgot_password_verified',
            ]);

            return redirect()->route('password.forgot')
                ->withErrors(['email' => 'Account not found. Please try again.']);
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        session()->forget([
            'forgot_password_email',
            'forgot_password_user_id',
            'forgot_password_name',
            'forgot_password_verified',
        ]);

        return redirect()->route('login')->with('flash_message', [
            'title' => 'Password Updated',
            'message' => 'Your password has been updated successfully. You can now login.',
            'type' => 'success',
        ]);
    }

    public function resendForgotPasswordOtp(Request $request)
    {
        $email = session('forgot_password_email');
        $userId = session('forgot_password_user_id');
        $otpService = app(OtpService::class);

        if (! $email || ! $userId) {
            return redirect()->route('password.forgot')
                ->withErrors(['email' => 'Session expired. Please enter your email again.']);
        }

        $user = User::find($userId);

        if (! $user) {
            return redirect()->route('password.forgot')
                ->withErrors(['email' => 'Account not found. Please try again.']);
        }

        if ($otpService->hasReachedDailyLimit()) {
            return back()->withErrors(['otp' => $otpService->limitFlashMessage()['message']]);
        }

        if ($otpService->hasReachedResendLimit($request, $email)) {
            return back()->withErrors(['otp' => $otpService->resendLimitMessage($request, $email)]);
        }

        $otpService->reserveResendAttempt($request, $email);

        try {
            $otpService->sendForgotPasswordOtp($user);
        } catch (DailyOtpLimitReachedException $exception) {
            $otpService->releaseResendAttempt($request, $email);

            return back()->withErrors(['otp' => $otpService->limitFlashMessage()['message']]);
        } catch (OtpDeliveryException $exception) {
            $otpService->releaseResendAttempt($request, $email);

            return back()->withErrors(['otp' => $exception->getMessage()]);
        }

        return back()->with('success', 'A new password reset OTP has been sent to your email.');
    }
}
