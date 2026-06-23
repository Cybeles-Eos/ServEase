<?php

namespace App\Services;

use App\Exceptions\EmailDeliveryException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

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

        if (config('services.brevo.api_key')) {
            $this->sendViaBrevoApi($params, $data, $seo_meta);

            return;
        }

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

    private function sendViaBrevoApi(array $params, array $data, array $seo_meta): void
    {
        $html = view($params['view'], [
            'data'     => $data,
            'seo_meta' => $seo_meta,
        ])->render();

        $payload = [
            'sender' => [
                'email' => config('mail.from.address'),
                'name'  => config('mail.from.name'),
            ],
            'to' => [[
                'email' => $data['user']['email'],
                'name'  => $data['user']['name'],
            ]],
            'subject' => $data['subject'],
            'htmlContent' => $html,
        ];

        try {
            $response = Http::timeout(config('services.brevo.timeout', 15))
                ->withHeaders([
                    'accept' => 'application/json',
                    'api-key' => config('services.brevo.api_key'),
                    'content-type' => 'application/json',
                ])
                ->post(config('services.brevo.endpoint'), $payload);
        } catch (Throwable $exception) {
            Log::error('Brevo API email request failed.', [
                'exception' => $exception::class,
                'message' => $exception->getMessage(),
                'email' => $data['user']['email'],
            ]);

            throw new EmailDeliveryException(
                'Brevo API email request failed.',
                previous: $exception
            );
        }

        if ($response->successful()) {
            return;
        }

        Log::error('Brevo API email delivery failed.', [
            'status' => $response->status(),
            'body' => $response->body(),
            'email' => $data['user']['email'],
        ]);

        throw new EmailDeliveryException('Brevo API email delivery failed.');
    }
}
