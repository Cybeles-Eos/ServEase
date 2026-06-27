<?php

namespace App\Services;

use App\Models\CustomerRequest;
use App\Models\PlatformSetting;
use Illuminate\Support\Facades\Log;
use Throwable;

class CustomerRequestEmailService
{
    public function __construct(private EmailService $emailService)
    {
    }

    public function sendAcceptedProvider(CustomerRequest $customerRequest): void
    {
        $customerRequest->loadMissing([
            'customer.user',
            'acceptedProvider.user',
            'acceptedApplication',
        ]);

        $provider = $customerRequest->acceptedProvider;
        $providerUser = $provider?->user;

        if (!$providerUser?->email) {
            Log::warning('Customer request email skipped because provider email is missing.', [
                'customer_request_id' => $customerRequest->id,
            ]);

            return;
        }

        $providerName = trim(($provider->first_name ?? '') . ' ' . ($provider->last_name ?? '')) ?: 'Provider';
        $subject = 'Your application was accepted for ' . $customerRequest->title;
        $platform = PlatformSetting::current();

        try {
            $this->emailService->sendEmail([
                'view' => 'email.customer-request-accepted',
                'type' => 'customer_request_accepted_provider',
                'subject' => $subject,
                'user' => [
                    'name' => $providerName,
                    'email' => $providerUser->email,
                ],
                'user_data' => [
                    'headline' => 'Customer request accepted',
                    'request' => [
                        'reference' => '#CR-' . str_pad((string) $customerRequest->id, 5, '0', STR_PAD_LEFT),
                        'title' => $customerRequest->title,
                        'service_type' => $customerRequest->service_type ?: 'Custom service',
                        'description' => $customerRequest->description,
                        'fixed_price' => $customerRequest->fixed_price_label,
                        'image_url' => $customerRequest->image_path ? asset($customerRequest->image_path) : null,
                        'accepted_at' => $customerRequest->accepted_at?->format('M d, Y g:i A'),
                        'notes' => $customerRequest->acceptedApplication?->notes ?: 'No notes provided',
                    ],
                    'customer' => [
                        'name' => $customerRequest->contact_name ?: 'Customer',
                        'email' => $customerRequest->contact_email ?: 'Not provided',
                        'phone' => $customerRequest->contact_phone ?: 'Not provided',
                        'address' => $customerRequest->contact_address ?: 'Not provided',
                    ],
                    'cta_label' => 'Open customer request work',
                    'cta_url' => route('provider.customer-requests.work'),
                ],
                'seo_meta' => [
                    'title' => $subject,
                    'name' => $platform->platform_name ?: 'Servease',
                ],
            ]);
        } catch (Throwable $exception) {
            Log::error('Customer request accepted email failed.', [
                'customer_request_id' => $customerRequest->id,
                'provider_email' => $providerUser->email,
                'exception' => $exception::class,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
