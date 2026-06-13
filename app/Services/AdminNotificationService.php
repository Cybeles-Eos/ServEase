<?php

namespace App\Services;

use App\Models\AdminNotification;
use App\Models\BookingInfo;
use App\Models\Provider;
use App\Models\ProviderDeletedRecord;
use App\Models\Service;
use App\Models\ServiceRating;
use App\Models\ServiceReport;
use App\Models\User;

class AdminNotificationService
{
    public static function notify(string $type, string $title, string $message, ?string $link = null): void
    {
        AdminNotification::create([
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'link' => $link,
        ]);
    }

    public static function newCustomer(User $user): void
    {
        self::notify(
            'new_customer',
            'New Customer Account',
            "{$user->name} registered as a customer.",
            route('admin.users.show', $user)
        );
    }

    public static function newProviderApplication(User $user): void
    {
        $provider = $user->provider;

        if (! $provider) {
            return;
        }

        self::notify(
            'new_provider_application',
            'New Provider Application',
            "{$user->name} submitted a provider application for review.",
            route('admin.applicants.show', $provider)
        );
    }

    public static function providerDeletedRecords(ProviderDeletedRecord $record): void
    {
        self::notify(
            'provider_records_deleted',
            'Provider Records Deleted',
            "{$record->provider_name} ({$record->provider_email}) deleted their declined provider application records on " . $record->deleted_at->format('M d, Y h:i A') . ".",
            route('admin.dashboard')
        );
    }

    public static function adminCreatedUser(User $user, string $role): void
    {
        self::notify(
            'admin_user_created',
            'User Account Created',
            "A new {$role} account was created for {$user->name}.",
            route('admin.users.show', $user)
        );
    }

    public static function newService(Service $service): void
    {
        $provider = $service->provider;
        $providerName = $provider
            ? trim(($provider->first_name ?? '') . ' ' . ($provider->last_name ?? ''))
            : 'A provider';

        $link = $provider?->user_id
            ? route('admin.users.show', $provider->user_id)
            : route('admin.dashboard');

        self::notify(
            'new_service',
            'New Service Listed',
            "{$providerName} listed \"{$service->title}\".",
            $link
        );
    }

    public static function newBooking(BookingInfo $bookingInfo): void
    {
        $service = $bookingInfo->service;
        $customerName = trim(($bookingInfo->fname ?? '') . ' ' . ($bookingInfo->lname ?? ''));

        self::notify(
            'new_booking',
            'New Booking Request',
            ($customerName ?: 'A customer') . ' booked "' . ($service?->title ?? 'a service') . '".',
            route('admin.dashboard')
        );
    }

    public static function newRating(ServiceRating $rating): void
    {
        $service = $rating->service;
        $customer = $rating->customer;

        $customerName = $customer
            ? trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? ''))
            : 'A customer';

        self::notify(
            'new_rating',
            'New Service Rating',
            "{$customerName} rated \"" . ($service?->title ?? 'a service') . "\" with {$rating->rating} star(s).",
            route('admin.dashboard')
        );
    }

    public static function newReport(ServiceReport $report): void
    {
        $service = $report->service;
        $customer = $report->customer;
        $provider = $report->provider;

        $customerName = $customer
            ? trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? ''))
            : 'A customer';

        $providerName = $provider
            ? trim(($provider->first_name ?? '') . ' ' . ($provider->last_name ?? ''))
            : 'a provider';

        self::notify(
            'new_report',
            'New Provider Report',
            "{$customerName} reported {$providerName} for \"" . ($service?->title ?? 'a service') . "\".",
            route('admin.reports')
        );
    }
}
