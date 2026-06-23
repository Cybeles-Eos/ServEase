<?php

namespace App\Services;

use App\Exceptions\DailyOtpLimitReachedException;
use App\Exceptions\OtpDeliveryException;
use App\Models\DailyOtpUsage;
use App\Models\EmailOtp;
use App\Models\PlatformSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Throwable;

class OtpService
{
    private const DAILY_LIMIT = 300;
    private const TEST_SENT_TODAY = null; // Set to 300 to test the limit popup, then set back to null for live.

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
        } catch (TransportExceptionInterface $exception) {
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
}
