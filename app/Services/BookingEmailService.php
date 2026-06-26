<?php

namespace App\Services;

use App\Models\BookingRequest;
use App\Models\PlatformSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Throwable;

class BookingEmailService
{
    public function __construct(private EmailService $emailService)
    {
    }

    public function sendNewBookingToProvider(BookingRequest $bookingRequest): void
    {
        $this->sendBookingEmail($bookingRequest, 'new_booking_provider');
    }

    public function sendAcceptedToCustomer(BookingRequest $bookingRequest): void
    {
        $this->sendBookingEmail($bookingRequest, 'accepted_customer');
    }

    public function sendDeclinedToCustomer(BookingRequest $bookingRequest): void
    {
        $this->sendBookingEmail($bookingRequest, 'declined_customer');
    }

    public function sendProviderCancelledToCustomer(BookingRequest $bookingRequest): void
    {
        $this->sendBookingEmail($bookingRequest, 'provider_cancelled_customer');
    }

    public function sendCustomerCancelledToProvider(BookingRequest $bookingRequest): void
    {
        $this->sendBookingEmail($bookingRequest, 'customer_cancelled_provider');
    }

    private function sendBookingEmail(BookingRequest $bookingRequest, string $type): void
    {
        $bookingRequest->loadMissing([
            'bookingInfo.service.serviceCategory',
            'bookingInfo.customer.user',
            'provider.user',
        ]);

        $payload = $this->payloadFor($bookingRequest, $type);

        if (!$payload) {
            Log::warning('Booking email skipped because recipient data is missing.', [
                'booking_request_id' => $bookingRequest->id,
                'type' => $type,
            ]);

            return;
        }

        try {
            $this->emailService->sendEmail([
                'view' => 'email.booking-notification',
                'type' => $type,
                'subject' => $payload['subject'],
                'user' => $payload['recipient'],
                'user_data' => $payload,
                'seo_meta' => $this->seoMeta($payload['subject']),
            ]);
        } catch (Throwable $exception) {
            Log::error('Booking email delivery failed.', [
                'booking_request_id' => $bookingRequest->id,
                'type' => $type,
                'email' => $payload['recipient']['email'] ?? null,
                'exception' => $exception::class,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    private function payloadFor(BookingRequest $bookingRequest, string $type): ?array
    {
        $bookingInfo = $bookingRequest->bookingInfo;
        $provider = $bookingRequest->provider;
        $providerUser = $provider?->user;
        $service = $bookingInfo?->service;
        $platform = PlatformSetting::current();
        $customerName = $this->customerName($bookingRequest);
        $providerName = $this->providerName($bookingRequest);

        $details = [
            'booking_reference' => '#' . str_pad((string) $bookingRequest->id, 5, '0', STR_PAD_LEFT),
            'status' => $bookingRequest->status,
            'requested_at' => $bookingRequest->created_at?->format('M d, Y g:i A') ?? 'Not available',
            'schedule_date' => $this->formatDate($bookingInfo?->date),
            'schedule_time' => $this->formatTime($bookingInfo?->time),
            'service_title' => $service?->title ?: 'Service',
            'service_category' => $service?->serviceCategory?->name ?: ($service?->category ?? 'Service'),
            'service_price' => $this->priceLabel($service),
            'customer_name' => $customerName,
            'customer_email' => $bookingInfo?->email ?: 'Not provided',
            'customer_phone' => $bookingInfo?->number ?: 'Not provided',
            'customer_address' => $bookingInfo?->address ?: 'Not provided',
            'booking_notes' => $bookingInfo?->notes ?: 'No notes provided',
            'provider_name' => $providerName,
            'provider_email' => $providerUser?->email ?: 'Not provided',
            'provider_phone' => $provider?->phone_number ?: 'Not provided',
        ];

        $base = [
            'platform_name' => $platform->platform_name ?: 'Servease',
            'support_email' => $platform->platform_email ?: config('mail.from.address'),
            'details' => $details,
        ];

        return match ($type) {
            'new_booking_provider' => $providerUser?->email ? array_merge($base, [
                'recipient' => [
                    'name' => $providerName,
                    'email' => $providerUser->email,
                ],
                'subject' => 'New booking request for ' . $details['service_title'],
                'headline' => 'New booking request',
                'intro' => $customerName . ' requested your service. Review the booking details and respond from your provider dashboard.',
                'status_label' => 'Pending response',
                'status_color' => '#FFBE42',
                'cta_label' => 'Open provider bookings',
                'cta_url' => route('provider.bookings'),
                'footer_note' => 'Please accept only if you are available for the selected schedule.',
            ]) : null,

            'accepted_customer' => $bookingInfo?->email ? array_merge($base, [
                'recipient' => [
                    'name' => $customerName,
                    'email' => $bookingInfo->email,
                ],
                'subject' => 'Your booking has been accepted',
                'headline' => 'Booking accepted',
                'intro' => $providerName . ' accepted your booking request. Your service is now scheduled with the details below.',
                'status_label' => 'Accepted',
                'status_color' => '#22C55E',
                'cta_label' => 'View my bookings',
                'cta_url' => route('customer.dashboard'),
                'footer_note' => 'Keep your contact details available so the provider can reach you if needed.',
            ]) : null,

            'declined_customer' => $bookingInfo?->email ? array_merge($base, [
                'recipient' => [
                    'name' => $customerName,
                    'email' => $bookingInfo->email,
                ],
                'subject' => 'Your booking request was declined',
                'headline' => 'Booking request declined',
                'intro' => $providerName . ' declined your booking request. You can choose another provider or send a new request from the services page.',
                'status_label' => 'Declined',
                'status_color' => '#EF4444',
                'cta_label' => 'Browse services',
                'cta_url' => route('services.index'),
                'footer_note' => 'No service appointment has been scheduled for this request.',
            ]) : null,

            'provider_cancelled_customer' => $bookingInfo?->email ? array_merge($base, [
                'recipient' => [
                    'name' => $customerName,
                    'email' => $bookingInfo->email,
                ],
                'subject' => 'Your booking was cancelled by the provider',
                'headline' => 'Booking cancelled',
                'intro' => $providerName . ' cancelled this booking. The details are included below for your records.',
                'status_label' => 'Cancelled by provider',
                'status_color' => '#EF4444',
                'cta_label' => 'View my bookings',
                'cta_url' => route('customer.dashboard'),
                'footer_note' => 'You may book another service provider if you still need this service.',
            ]) : null,

            'customer_cancelled_provider' => $providerUser?->email ? array_merge($base, [
                'recipient' => [
                    'name' => $providerName,
                    'email' => $providerUser->email,
                ],
                'subject' => 'A customer cancelled a booking',
                'headline' => 'Booking cancelled by customer',
                'intro' => $customerName . ' cancelled this booking. The request details are included below for your records.',
                'status_label' => 'Cancelled by customer',
                'status_color' => '#EF4444',
                'cta_label' => 'Open provider bookings',
                'cta_url' => route('provider.bookings'),
                'footer_note' => 'This booking no longer requires provider action.',
            ]) : null,

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

    private function customerName(BookingRequest $bookingRequest): string
    {
        $bookingInfo = $bookingRequest->bookingInfo;
        $name = trim(($bookingInfo?->fname ?? '') . ' ' . ($bookingInfo?->lname ?? ''));

        return $name !== '' ? $name : 'Customer';
    }

    private function providerName(BookingRequest $bookingRequest): string
    {
        $provider = $bookingRequest->provider;
        $name = trim(($provider?->first_name ?? '') . ' ' . ($provider?->last_name ?? ''));

        return $name !== '' ? $name : 'Provider';
    }

    private function formatDate(mixed $value): string
    {
        if (!$value) {
            return 'Not scheduled';
        }

        return Carbon::parse($value)->format('M d, Y');
    }

    private function formatTime(mixed $value): string
    {
        if (!$value) {
            return 'Not scheduled';
        }

        return Carbon::parse($value)->format('g:i A');
    }

    private function priceLabel(mixed $service): string
    {
        if (!$service) {
            return 'Not available';
        }

        $price = 'PHP ' . number_format((float) ($service->price ?? 0), 2);

        if (($service->pricing_type ?? 'fixed') === 'per_hour') {
            return $price . ' / hour';
        }

        return $price;
    }
}
