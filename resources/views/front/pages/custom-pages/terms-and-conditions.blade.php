@extends('front.layouts.base')

@section('title', 'Terms and Conditions - Servease')

@section('content')
    @php
        $platform = getPlatformSettings();
        $platformName = $platform->platform_name ?: 'ServEase';
        $serviceArea = $platform->service_area ?: 'Barangay Batasan Hills, Quezon City';
        $supportEmail = $platform->platform_email ?: 'support@servease.com';
    @endphp

    <main class="main-page legal-page">
        <section class="legal-page__hero m-padding">
            <div class="m-width-legal">
                <p>{{ $platformName }}</p>
                <h1>Terms and Conditions</h1>
                <span>These terms apply when customers book local services and providers offer services through {{ $platformName }} in {{ $serviceArea }}.</span>
            </div>
        </section>

        <section class="legal-page__content m-padding">
            <div class="m-width legal-page__content-inner">
                <h2>Use of the platform</h2>
                <p>You agree to provide accurate account, contact, booking, and service information. Accounts must not be used for fraud, harassment, spam, fake bookings, or activities that can harm customers, providers, or the platform.</p>

                <h2>Customer bookings</h2>
                <p>Customers are responsible for submitting clear service details, availability, location, and contact information. A booking is not final until it is accepted by a provider or confirmed through the platform workflow.</p>

                <h2>Provider responsibilities</h2>
                <p>Providers must submit truthful registration details, keep service information updated, respond to bookings professionally, and perform accepted services with reasonable care and skill.</p>

                <h2>Service information and pricing</h2>
                <p>Service titles, descriptions, categories, prices, and availability are provided by providers or administrators. Customers should review the service details before sending a booking request.</p>

                <h2>Cancellations and completion</h2>
                <p>Customers and providers should cancel only when necessary and should update booking status honestly. Completed bookings may be used for customer ratings and platform records.</p>

                <h2>Ratings and comments</h2>
                <p>Customer reviews must be based on actual service experience. We may hide or review ratings that are abusive, misleading, unrelated, or otherwise harmful to platform trust.</p>

                <h2>Changes to these terms</h2>
                <p>We may update these terms as platform features, policies, or legal requirements change. Continued use of {{ $platformName }} means you accept the latest version.</p>

                <h2>Contact</h2>
                <p>For questions about these terms, contact us at <a href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a>.</p>
            </div>
        </section>
    </main>
@endsection
