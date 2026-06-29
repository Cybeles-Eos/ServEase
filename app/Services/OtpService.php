<?php

namespace App\Services;

use App\Exceptions\DailyOtpLimitReachedException;
use App\Exceptions\EmailDeliveryException;
use App\Exceptions\OtpDeliveryException;
use App\Models\DailyOtpUsage;
use App\Models\EmailOtp;
use App\Models\OtpResendAttempt;
use App\Models\PlatformSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Str;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Throwable;

class OtpService
{
    private const DAILY_LIMIT = 300;
    private const TEST_SENT_TODAY = null; // Set to 300 to test the limit popup, then set back to null for live.
    private const RESEND_LIMIT = 5;
    private const RESEND_WINDOW_HOURS = 6;

    public function sendRegistrationOtp($user): void
    {
        $this->sendOtpToEmail(
            email: $user->email,
            name: $user->name,
            userId: $user->id
        );
    }

    public function sendOtpToEmail(string $email, string $name, ?int $userId = null): void
    {
        $this->reserveDailySend();

        $otp = rand(100000, 999999);

        try {
            EmailOtp::where('email', $email)
                ->whereNull('verified_at')
                ->delete();

            EmailOtp::create([
                'user_id'    => $userId,
                'email'      => $email,
                'otp'        => $otp,
                'expires_at' => now()->addMinutes(10),
            ]);

            app(EmailService::class)->sendEmail([
                'view'        => 'email.otp',
                'type'        => 'registration_otp',
                'user'        => [
                    'name'  => $name,
                    'email' => $email,
                ],
                'user_data'   => null,
                'otp'         => $otp,
                'expires_in'  => 10,
                'subject'     => 'Your Servease verification code',
                'attachments' => [],
                'seo_meta'    => [
                    'title' => 'Servease Email Verification',
                    'name'  => 'Servease',
                ],
            ]);
        } catch (TransportExceptionInterface|EmailDeliveryException $exception) {
            $this->releaseDailySend();

            Log::error('OTP email delivery failed.', [
                'email' => $email,
                'exception' => $exception::class,
                'message' => $exception->getMessage(),
            ]);

            throw new OtpDeliveryException(
                'We could not send the OTP email right now. Please try again later or contact support.',
                previous: $exception
            );
        } catch (Throwable $exception) {
            $this->releaseDailySend();

            throw $exception;
        }
    }

    public function hasReachedDailyLimit(): bool
    {
        if (! $this->isEnabled()) {
            return false;
        }

        return $this->sentToday() >= self::DAILY_LIMIT;
    }

    public function isEnabled(): bool
    {
        return (bool) PlatformSetting::current()->otp_enabled;
    }

    public function sentToday(): int
    {
        if (self::TEST_SENT_TODAY !== null) {
            return (int) self::TEST_SENT_TODAY;
        }

        return (int) DailyOtpUsage::query()
            ->where('date', $this->today())
            ->value('used');
    }

    public function limitFlashMessage(): array
    {
        return [
            'title' => 'Please Try Again Tomorrow',
            'message' => 'Account creation has reached the email verification limit for today. Please come back tomorrow to create your account or resend an OTP.',
            'type' => 'warning',
        ];
    }

    public function resendLimitStatus(Request $request, ?string $email = null): array
    {
        $email = strtolower(trim((string) ($email ?: session('otp_email'))));

        if ($email === '') {
            return $this->emptyResendStatus();
        }

        $attempt = OtpResendAttempt::query()
            ->where('email', $email)
            ->where('device_key', $this->deviceKey($request))
            ->first();

        if (! $attempt || $this->resendWindowExpired($attempt)) {
            return $this->emptyResendStatus();
        }

        $lockedUntil = $attempt->locked_until && now()->lessThan($attempt->locked_until)
            ? $attempt->locked_until
            : null;

        return [
            'limit' => self::RESEND_LIMIT,
            'remaining' => max(0, self::RESEND_LIMIT - (int) $attempt->attempts),
            'used' => min(self::RESEND_LIMIT, (int) $attempt->attempts),
            'locked' => (bool) $lockedUntil,
            'locked_until' => $lockedUntil,
            'locked_until_label' => $lockedUntil ? $lockedUntil->format('M d, Y g:i A') : null,
            'window_hours' => self::RESEND_WINDOW_HOURS,
        ];
    }

    public function hasReachedResendLimit(Request $request, ?string $email = null): bool
    {
        return $this->resendLimitStatus($request, $email)['locked'];
    }

    public function resendLimitMessage(Request $request, ?string $email = null): string
    {
        $status = $this->resendLimitStatus($request, $email);

        if (! $status['locked']) {
            return '';
        }

        return 'You have reached the OTP resend limit for this device. Please try again after '
            . $status['locked_until_label'] . '.';
    }

    public function reserveResendAttempt(Request $request, string $email): array
    {
        $email = strtolower(trim($email));
        $deviceKey = $this->deviceKey($request);

        return DB::transaction(function () use ($email, $deviceKey) {
            $attempt = OtpResendAttempt::query()
                ->where('email', $email)
                ->where('device_key', $deviceKey)
                ->lockForUpdate()
                ->first();

            if (! $attempt || $this->resendWindowExpired($attempt)) {
                $attempt = OtpResendAttempt::updateOrCreate(
                    [
                        'email' => $email,
                        'device_key' => $deviceKey,
                    ],
                    [
                        'attempts' => 0,
                        'window_started_at' => now(),
                        'locked_until' => null,
                    ]
                );
            }

            if ($attempt->locked_until && now()->lessThan($attempt->locked_until)) {
                return $this->resendLimitStatusFromAttempt($attempt);
            }

            $attempt->attempts = (int) $attempt->attempts + 1;

            if ($attempt->attempts >= self::RESEND_LIMIT) {
                $attempt->locked_until = ($attempt->window_started_at ?: now())
                    ->copy()
                    ->addHours(self::RESEND_WINDOW_HOURS);
            }

            $attempt->save();

            return $this->resendLimitStatusFromAttempt($attempt);
        });
    }

    public function releaseResendAttempt(Request $request, string $email): void
    {
        $email = strtolower(trim($email));
        $deviceKey = $this->deviceKey($request);

        DB::transaction(function () use ($email, $deviceKey) {
            $attempt = OtpResendAttempt::query()
                ->where('email', $email)
                ->where('device_key', $deviceKey)
                ->lockForUpdate()
                ->first();

            if (! $attempt || $attempt->attempts <= 0) {
                return;
            }

            $attempt->attempts = (int) $attempt->attempts - 1;
            $attempt->locked_until = null;
            $attempt->save();
        });
    }

    private function reserveDailySend(): void
    {
        if ($this->hasReachedDailyLimit()) {
            throw new DailyOtpLimitReachedException('Daily OTP limit reached.');
        }

        DB::transaction(function () {
            $usage = DailyOtpUsage::query()
                ->where('date', $this->today())
                ->lockForUpdate()
                ->first();

            if (!$usage) {
                $usage = DailyOtpUsage::create([
                    'date' => $this->today(),
                    'used' => 0,
                ]);
            }

            if ($usage->used >= self::DAILY_LIMIT) {
                throw new DailyOtpLimitReachedException('Daily OTP limit reached.');
            }

            $usage->increment('used');
        });
    }

    private function releaseDailySend(): void
    {
        if (self::TEST_SENT_TODAY !== null) {
            return;
        }

        DB::transaction(function () {
            $usage = DailyOtpUsage::query()
                ->where('date', $this->today())
                ->lockForUpdate()
                ->first();

            if ($usage && $usage->used > 0) {
                $usage->decrement('used');
            }
        });
    }

    private function today(): string
    {
        return now('Asia/Manila')->toDateString();
    }

    private function emptyResendStatus(): array
    {
        return [
            'limit' => self::RESEND_LIMIT,
            'remaining' => self::RESEND_LIMIT,
            'used' => 0,
            'locked' => false,
            'locked_until' => null,
            'locked_until_label' => null,
            'window_hours' => self::RESEND_WINDOW_HOURS,
        ];
    }

    private function resendLimitStatusFromAttempt(OtpResendAttempt $attempt): array
    {
        $lockedUntil = $attempt->locked_until && now()->lessThan($attempt->locked_until)
            ? $attempt->locked_until
            : null;

        return [
            'limit' => self::RESEND_LIMIT,
            'remaining' => max(0, self::RESEND_LIMIT - (int) $attempt->attempts),
            'used' => min(self::RESEND_LIMIT, (int) $attempt->attempts),
            'locked' => (bool) $lockedUntil,
            'locked_until' => $lockedUntil,
            'locked_until_label' => $lockedUntil ? $lockedUntil->format('M d, Y g:i A') : null,
            'window_hours' => self::RESEND_WINDOW_HOURS,
        ];
    }

    private function resendWindowExpired(OtpResendAttempt $attempt): bool
    {
        if (! $attempt->window_started_at) {
            return true;
        }

        return now()->greaterThanOrEqualTo(
            $attempt->window_started_at->copy()->addHours(self::RESEND_WINDOW_HOURS)
        );
    }

    private function deviceKey(Request $request): string
    {
        if (! $request->session()->has('otp_resend_device_id')) {
            $request->session()->put('otp_resend_device_id', (string) Str::uuid());
        }

        return hash('sha256', implode('|', [
            $request->session()->get('otp_resend_device_id'),
            (string) $request->userAgent(),
        ]));
    }

    public function sendForgotPasswordOtp(User $user): void
    {
        $this->reserveDailySend();

        $otp = rand(100000, 999999);

        try {
            EmailOtp::where('email', $user->email)
                ->whereNull('verified_at')
                ->delete();

            EmailOtp::create([
                'user_id'    => $user->id,
                'email'      => $user->email,
                'otp'        => $otp,
                'expires_at' => now()->addMinutes(10),
            ]);

            app(EmailService::class)->sendEmail([
                'view'        => 'email.forgot-password-otp',
                'type'        => 'forgot_password_otp',
                'user'        => [
                    'name'  => $user->name,
                    'email' => $user->email,
                ],
                'user_data'   => null,
                'otp'         => $otp,
                'expires_in'  => 10,
                'subject'     => 'Your Servease password reset code',
                'attachments' => [],
                'seo_meta'    => [
                    'title' => 'Servease Password Reset',
                    'name'  => 'Servease',
                ],
            ]);
        } catch (TransportExceptionInterface|EmailDeliveryException $exception) {
            $this->releaseDailySend();

            Log::error('Forgot password OTP email delivery failed.', [
                'email' => $user->email,
                'exception' => $exception::class,
                'message' => $exception->getMessage(),
            ]);

            throw new OtpDeliveryException(
                'We could not send the password reset OTP right now. Please try again later or contact support.',
                previous: $exception
            );
        } catch (Throwable $exception) {
            $this->releaseDailySend();

            throw $exception;
        }
    }
}
