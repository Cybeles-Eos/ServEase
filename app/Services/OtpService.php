<?php

namespace App\Services;

use App\Models\EmailOtp;

class OtpService
{
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
        $otp = rand(100000, 999999);

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
    }
}