<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function sendEmail(array $params): void
    {
        $data = [
            'type'        => $params['type'] ?? null,
            'subject'     => $params['subject'] ?? 'Servease Email Notification',
            'user'        => [
                'name'  => $params['user']['name'] ?? '',
                'email' => $params['user']['email'] ?? '',
            ],
            'user_data'   => $params['user_data'] ?? null,
            'attachments' => $params['attachments'] ?? [],
            'otp'         => $params['otp'] ?? null,
            'expires_in'  => $params['expires_in'] ?? 10,
        ];

        $seo_meta = $params['seo_meta'] ?? [
            'title' => 'Servease Email Verification',
            'name'  => 'Servease',
        ];

        Mail::send($params['view'], [
            'data'     => $data,
            'seo_meta' => $seo_meta,
        ], function ($message) use ($data) {
            $message->from(
                config('mail.from.address'),
                config('mail.from.name')
            );

            $message->to(
                $data['user']['email'],
                $data['user']['name']
            );

            $message->subject($data['subject']);
        });
    }
}