<?php

namespace App\Services;

use App\Models\PlatformSetting;
use App\Models\Provider;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProviderApplicationEmailService
{
    public function __construct(private EmailService $emailService)
    {
    }

    public function sendAccepted(Provider $provider): void
    {
        $this->sendProviderApplicationEmail($provider, 'accepted');
    }

    public function sendDeclined(Provider $provider): void
    {
        $this->sendProviderApplicationEmail($provider, 'declined');
    }

    public function sendResubmissionRequested(Provider $provider): void
    {
        $this->sendProviderApplicationEmail($provider, 'resubmission_requested');
    }

    private function sendProviderApplicationEmail(Provider $provider, string $type): void
    {
        $provider->loadMissing('user');

        $payload = $this->payloadFor($provider, $type);

        if (!$payload) {
            Log::warning('Provider application email skipped because recipient data is missing.', [
                'provider_id' => $provider->id,
                'type' => $type,
            ]);

            return;
        }

        try {
            $this->emailService->sendEmail([
                'view' => 'email.provider-application-notification',
                'type' => $type,
                'subject' => $payload['subject'],
                'user' => $payload['recipient'],
                'user_data' => $payload,
                'seo_meta' => $this->seoMeta($payload['subject']),
            ]);
        } catch (Throwable $exception) {
            Log::error('Provider application email delivery failed.', [
                'provider_id' => $provider->id,
                'type' => $type,
                'email' => $payload['recipient']['email'] ?? null,
                'exception' => $exception::class,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    private function payloadFor(Provider $provider, string $type): ?array
    {
        $user = $provider->user;

        if (!$user?->email) {
            return null;
        }

        $platform = PlatformSetting::current();
        $providerName = trim(($provider->first_name ?? '') . ' ' . ($provider->last_name ?? '')) ?: ($user->name ?: 'Provider');
        $loginUrl = route('login');
        $requiredDocuments = collect($provider->resubmission_required_documents ?? [])
            ->map(fn ($document) => match ($document) {
                'resume' => 'Resume / CV',
                'barangay_clearance' => 'Barangay Clearance',
                default => ucwords(str_replace('_', ' ', $document)),
            })
            ->values()
            ->all();

        $base = [
            'platform_name' => $platform->platform_name ?: 'Servease',
            'support_email' => $platform->platform_email ?: config('mail.from.address'),
            'recipient' => [
                'name' => $providerName,
                'email' => $user->email,
            ],
            'provider' => [
                'name' => $providerName,
                'email' => $user->email,
                'profession' => $provider->profession ?: 'Service provider',
                'remarks' => $provider->application_remarks,
                'required_documents' => $requiredDocuments,
            ],
            'cta_label' => 'Login to Servease',
            'cta_url' => $loginUrl,
        ];

        return match ($type) {
            'accepted' => array_merge($base, [
                'subject' => 'Your Servease provider application was accepted',
                'headline' => 'Provider application accepted',
                'intro' => 'Your provider application has been approved. You can now login and use your provider dashboard.',
                'status_label' => 'Accepted',
                'status_color' => '#22C55E',
                'footer_note' => 'After logging in, you can manage your services, bookings, and provider profile.',
            ]),

            'declined' => array_merge($base, [
                'subject' => 'Your Servease provider application was declined',
                'headline' => 'Provider application declined',
                'intro' => 'Your provider application was not approved after admin review. Login to review the application status and remarks.',
                'status_label' => 'Declined',
                'status_color' => '#EF4444',
                'footer_note' => 'No provider dashboard access is available for this declined application.',
            ]),

            'resubmission_requested' => array_merge($base, [
                'subject' => 'Servease needs provider application documents resubmitted',
                'headline' => 'Document resubmission requested',
                'intro' => 'Admin needs updated document information before your provider application can be approved. Login to upload the requested document.',
                'status_label' => 'Resubmission requested',
                'status_color' => '#F97316',
                'footer_note' => 'After logging in, you will be redirected to the resubmission page.',
            ]),

            default => null,
        };
    }

    private function seoMeta(string $title): array
    {
        $platform = PlatformSetting::current();

        return [
            'title' => $title,
            'name' => $platform->platform_name ?: 'Servease',
        ];
    }
}
