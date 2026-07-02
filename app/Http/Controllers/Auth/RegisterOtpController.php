<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmailOtp;
use App\Models\User;
use App\Services\OtpService;
use App\Services\AdminNotificationService;
use App\Exceptions\DailyOtpLimitReachedException;
use App\Exceptions\OtpDeliveryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class RegisterOtpController extends Controller
{
    public function showVerifyForm(Request $request)
    {
        if (!session('otp_email')) {
            return redirect()->route('login')
                ->withErrors(['otp' => 'Session expired. Please register again.']);
        }

        $resendLimit = app(OtpService::class)->resendLimitStatus($request);

        return view('auth.verify-email-otp', compact('resendLimit'));
    }

    // public function verifyOtp(Request $request)
    // {
    //     $request->validate([
    //         'otp' => 'required|string|min:6|max:6',
    //     ]);

    //     $email = session('otp_email');

    //     if (!$email) {
    //         return redirect()->route('login')
    //             ->withErrors(['otp' => 'Session expired. Please register again.']);
    //     }

    //     $record = EmailOtp::where('email', $email)
    //         ->where('otp', $request->otp)
    //         ->whereNull('verified_at')
    //         ->latest()
    //         ->first();

    //     if (!$record) {
    //         return back()->withErrors([
    //             'otp' => 'Invalid OTP code.',
    //         ]);
    //     }

    //     if (now()->greaterThan($record->expires_at)) {
    //         return back()->withErrors([
    //             'otp' => 'OTP code has expired. Please request a new one.',
    //         ]);
    //     }

    //     $record->update([
    //         'verified_at' => now(),
    //     ]);

    //     $user = User::where('email', $email)->first();

    //     if ($user) {
    //         $user->update([
    //             'email_verified_at' => now(),
    //         ]);
    //     }

    //     session()->forget([
    //         'otp_email',
    //         'otp_user_id',
    //     ]);

    //     return redirect()->route('login')
    //         ->with('success', 'Email verified successfully. You can now log in.');
    // }
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|min:6|max:6',
        ]);

        $email = session('otp_email');

        if (!$email) {
            return redirect()->route('signup')
                ->withErrors(['otp' => 'Session expired. Please register again.']);
        }

        $record = EmailOtp::where('email', $email)
            ->where('otp', $request->otp)
            ->whereNull('verified_at')
            ->latest()
            ->first();

        if (!$record) {
            return back()->withErrors([
                'otp' => 'Invalid OTP code.',
            ]);
        }

        if (now()->greaterThan($record->expires_at)) {
            return back()->withErrors([
                'otp' => 'OTP code has expired. Please request a new one.',
            ]);
        }

        $pendingCustomer = session('pending_customer_registration');

        if ($pendingCustomer) {
            if (User::where('email', $pendingCustomer['email'])->exists()) {
                return redirect()->route('signup')
                    ->withErrors([
                        'email' => 'This email address is already registered. Please login instead.',
                    ]);
            }

            if (DB::table('tbl_customers')->where('phone_number', $pendingCustomer['phone_number'])->exists()) {
                return redirect()->route('signup')
                    ->withErrors([
                        'phone_number' => 'This phone number is already registered.',
                    ]);
            }

            DB::transaction(function () use ($pendingCustomer, $record) {
                $finalValidIdPath = $pendingCustomer['valid_id_path'] ?? null;

                if (!empty($pendingCustomer['valid_id_path']) && Storage::disk('public')->exists($pendingCustomer['valid_id_path'])) {
                    $finalValidIdPath = str_replace('pending-customer-valid-ids/', 'customer-valid-ids/', $pendingCustomer['valid_id_path']);
                    Storage::disk('public')->move($pendingCustomer['valid_id_path'], $finalValidIdPath);
                }

                $user = User::create([
                    'name'              => $pendingCustomer['name'],
                    'email'             => $pendingCustomer['email'],
                    'password'          => $pendingCustomer['password'],
                    'role'              => 'customer',
                    'email_verified_at' => now(),
                ]);

                $user->customer()->create([
                    'first_name'     => $pendingCustomer['fname'],
                    'last_name'      => $pendingCustomer['lname'],
                    'phone_number'   => $pendingCustomer['phone_number'],
                    'house_number'   => $pendingCustomer['house_number'],
                    'gender'         => $pendingCustomer['gender'],
                    'birth_date'     => $pendingCustomer['birthdate'],
                    'street_address' => $pendingCustomer['street_address'],
                    'city'           => $pendingCustomer['city'],
                    'barangay'       => $pendingCustomer['barangay'],
                    'zipcode'        => $pendingCustomer['zipcode'],
                    'valid_id_path'  => $finalValidIdPath,
                ]);

                $record->update([
                    'user_id'     => $user->id,
                    'verified_at' => now(),
                ]);

                AdminNotificationService::newCustomer($user);
            });

            session()->forget([
                'pending_customer_registration',
                'otp_email',
                'otp_name',
                'otp_user_id',
            ]);

            return redirect()->route('login')->with('flash_message', [
                'title' => 'Email Verified',
                'message' => 'Your customer account has been created successfully. You can now login.',
                'type' => 'success',
            ]);
        }

        $pendingProvider = session('pending_provider_registration');

        if ($pendingProvider) {
            if (User::where('email', $pendingProvider['email'])->exists()) {
                return redirect()->route('provider-signup')
                    ->withErrors([
                        'email' => 'This email address is already registered. Please login instead.',
                    ]);
            }

            $finalResumePath = $pendingProvider['resume_path'];
            $finalBarangayClearancePath = $pendingProvider['barangay_clearance_path'];
            $finalNbiClearancePath = $pendingProvider['nbi_clearance_path'] ?? null;
            $finalTesdaCertificatePath = $pendingProvider['tesda_certificate_path'] ?? null;
            $finalRecommendationLetterPath = $pendingProvider['recommendation_letter_path'] ?? null;

            if (!empty($pendingProvider['resume_path']) && Storage::disk('public')->exists($pendingProvider['resume_path'])) {
                $finalResumePath = str_replace('pending-provider-resumes/', 'provider-resumes/', $pendingProvider['resume_path']);
                Storage::disk('public')->move($pendingProvider['resume_path'], $finalResumePath);
            }

            if (!empty($pendingProvider['barangay_clearance_path']) && Storage::disk('public')->exists($pendingProvider['barangay_clearance_path'])) {
                $finalBarangayClearancePath = str_replace('pending-provider-barangay-clearances/', 'provider-barangay-clearances/', $pendingProvider['barangay_clearance_path']);
                Storage::disk('public')->move($pendingProvider['barangay_clearance_path'], $finalBarangayClearancePath);
            }

            if (!empty($pendingProvider['nbi_clearance_path']) && Storage::disk('public')->exists($pendingProvider['nbi_clearance_path'])) {
                $finalNbiClearancePath = str_replace('pending-provider-nbi-clearances/', 'provider-nbi-clearances/', $pendingProvider['nbi_clearance_path']);
                Storage::disk('public')->move($pendingProvider['nbi_clearance_path'], $finalNbiClearancePath);
            }

            if (!empty($pendingProvider['tesda_certificate_path']) && Storage::disk('public')->exists($pendingProvider['tesda_certificate_path'])) {
                $finalTesdaCertificatePath = str_replace('pending-provider-tesda-certificates/', 'provider-tesda-certificates/', $pendingProvider['tesda_certificate_path']);
                Storage::disk('public')->move($pendingProvider['tesda_certificate_path'], $finalTesdaCertificatePath);
            }

            if (!empty($pendingProvider['recommendation_letter_path']) && Storage::disk('public')->exists($pendingProvider['recommendation_letter_path'])) {
                $finalRecommendationLetterPath = str_replace('pending-provider-recommendation-letters/', 'provider-recommendation-letters/', $pendingProvider['recommendation_letter_path']);
                Storage::disk('public')->move($pendingProvider['recommendation_letter_path'], $finalRecommendationLetterPath);
            }

            DB::transaction(function () use (
                $pendingProvider,
                $record,
                $finalResumePath,
                $finalBarangayClearancePath,
                $finalNbiClearancePath,
                $finalTesdaCertificatePath,
                $finalRecommendationLetterPath
            ) {
                $user = User::create([
                    'name'              => $pendingProvider['name'],
                    'email'             => $pendingProvider['email'],
                    'password'          => $pendingProvider['password'],
                    'role'              => 'provider',
                    'is_active'         => 0,
                    'email_verified_at' => now(),
                ]);

                $user->provider()->create([
                    'first_name' => $pendingProvider['fname'],
                    'last_name' => $pendingProvider['lname'],
                    'phone_number' => $pendingProvider['number'],
                    'gender' => $pendingProvider['gender'],
                    'birth_date' => $pendingProvider['birthdate'],
                    'home_address' => $pendingProvider['address'],
                    'city' => $pendingProvider['city'],
                    'barangay' => $pendingProvider['barangay'],
                    'zipcode' => $pendingProvider['zipcode'],
                    'profession' => $pendingProvider['profession'],
                    'year_exp' => $pendingProvider['experience'],

                    'resume_path' => $finalResumePath,
                    'barangay_clearance_path' => $finalBarangayClearancePath,
                    'nbi_clearance_path' => $finalNbiClearancePath,
                    'tesda_certificate_path' => $finalTesdaCertificatePath,
                    'recommendation_letter_path' => $finalRecommendationLetterPath,

                    'application_status' => 'pending',
                    'application_reviewed_at' => null,
                    'application_reviewed_by' => null,
                    'application_remarks' => null,
                ]);

                $record->update([
                    'user_id'     => $user->id,
                    'verified_at' => now(),
                ]);

                AdminNotificationService::newProviderApplication($user);
            });

            session()->forget([
                'pending_provider_registration',
                'otp_email',
                'otp_name',
                'otp_user_id',
            ]);

            return redirect()->route('login')->with('flash_message', [
                'title' => 'Email Verified',
                'message' => 'Your provider application has been submitted successfully. Please wait while admin reviews your application.',
                'type' => 'success',
            ]);
        }

        $record->update([
            'verified_at' => now(),
        ]);

        $user = User::where('email', $email)->first();

        if ($user) {
            $user->update([
                'email_verified_at' => now(),
            ]);
        }

        session()->forget([
            'otp_email',
            'otp_name',
            'otp_user_id',
        ]);

        return redirect()->route('login')->with('flash_message', [
            'title' => 'Email Verified',
            'message' => 'Email verified successfully. You can now login.',
            'type' => 'success',
        ]);
    }

    // public function resendOtp()
    // {
    //     $email = session('otp_email');

    //     if (!$email) {
    //         return redirect()->route('login')
    //             ->withErrors(['otp' => 'Session expired. Please register again.']);
    //     }

    //     $user = User::where('email', $email)->first();

    //     if (!$user) {
    //         return redirect()->route('login')
    //             ->withErrors(['otp' => 'User not found. Please register again.']);
    //     }

    //     app(OtpService::class)->sendRegistrationOtp($user);

    //     return back()->with('success', 'A new OTP has been sent to your email.');
    // }
    public function resendOtp(Request $request)
    {
        $email = session('otp_email');
        $name = session('otp_name');
        $otpService = app(OtpService::class);

        if (! $otpService->isEnabled()) {
            return back()->withErrors(['otp' => 'OTP verification is currently turned off. Please submit the signup form again.']);
        }

        if (!$email) {
            return redirect()->route('signup')
                ->withErrors(['otp' => 'Session expired. Please register again.']);
        }

        if ($otpService->hasReachedDailyLimit()) {
            return back()->withErrors(['otp' => $otpService->limitFlashMessage()['message']]);
        }

        if ($otpService->hasReachedResendLimit($request, $email)) {
            return back()->withErrors(['otp' => $otpService->resendLimitMessage($request, $email)]);
        }

        $pendingCustomer = session('pending_customer_registration');

        if ($pendingCustomer) {
            $otpService->reserveResendAttempt($request, $pendingCustomer['email']);

            try {
                $otpService->sendOtpToEmail(
                    email: $pendingCustomer['email'],
                    name: $pendingCustomer['name']
                );
            } catch (DailyOtpLimitReachedException $exception) {
                $otpService->releaseResendAttempt($request, $pendingCustomer['email']);
                return back()->withErrors(['otp' => $otpService->limitFlashMessage()['message']]);
            } catch (OtpDeliveryException $exception) {
                $otpService->releaseResendAttempt($request, $pendingCustomer['email']);
                return back()->withErrors(['otp' => $exception->getMessage()]);
            } catch (Throwable $exception) {
                $otpService->releaseResendAttempt($request, $pendingCustomer['email']);
                throw $exception;
            }

            return back()->with('success', 'A new OTP has been sent to your email.');
        }

        $pendingProvider = session('pending_provider_registration');

        if ($pendingProvider) {
            $otpService->reserveResendAttempt($request, $pendingProvider['email']);

            try {
                $otpService->sendOtpToEmail(
                    email: $pendingProvider['email'],
                    name: $pendingProvider['name']
                );
            } catch (DailyOtpLimitReachedException $exception) {
                $otpService->releaseResendAttempt($request, $pendingProvider['email']);
                return back()->withErrors(['otp' => $otpService->limitFlashMessage()['message']]);
            } catch (OtpDeliveryException $exception) {
                $otpService->releaseResendAttempt($request, $pendingProvider['email']);
                return back()->withErrors(['otp' => $exception->getMessage()]);
            } catch (Throwable $exception) {
                $otpService->releaseResendAttempt($request, $pendingProvider['email']);
                throw $exception;
            }

            return back()->with('success', 'A new OTP has been sent to your email.');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('signup')
                ->withErrors(['otp' => 'User not found. Please register again.']);
        }

        try {
            $otpService->reserveResendAttempt($request, $user->email);
            $otpService->sendRegistrationOtp($user);
        } catch (DailyOtpLimitReachedException $exception) {
            $otpService->releaseResendAttempt($request, $user->email);
            return back()->withErrors(['otp' => $otpService->limitFlashMessage()['message']]);
        } catch (OtpDeliveryException $exception) {
            $otpService->releaseResendAttempt($request, $user->email);
            return back()->withErrors(['otp' => $exception->getMessage()]);
        } catch (Throwable $exception) {
            $otpService->releaseResendAttempt($request, $user->email);
            throw $exception;
        }

        return back()->with('success', 'A new OTP has been sent to your email.');
    }
}
