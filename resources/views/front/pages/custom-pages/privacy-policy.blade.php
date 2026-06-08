@extends('front.layouts.base')

@section('title', 'Privacy Policy - Servease')

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
                <h1>Privacy Policy</h1>
                <span>This policy explains how {{ $platformName }} handles customer, provider, booking, and service review information for local service requests in {{ $serviceArea }}.</span>
            </div>
        </section>

        <section class="legal-page__content m-padding">
            <div class="m-width legal-page__content-inner">
                <h2>Information we collect</h2>
                <p>We collect account details, contact information, booking requests, uploaded provider verification documents, service listings, messages related to support, and customer ratings or comments submitted through the platform.</p>

                <h2>How we use information</h2>
                <p>We use this information to create accounts, verify providers, show available services, process booking requests, notify customers and providers, improve service quality, and respond to support or administrative concerns.</p>

                <h2>Information sharing</h2>
                <p>Customer booking details are shared with the selected provider so the service can be completed. Provider profile and service information may be shown publicly. We do not sell personal information.</p>

                <h2>Provider documents</h2>
                <p>Documents uploaded during provider registration are used for review and approval. Access is limited to authorized administrators who need the information for verification and platform safety.</p>

                <h2>Reviews and ratings</h2>
                <p>Ratings and comments may appear on service pages when visible. Reviews help customers compare providers and help the platform monitor service quality.</p>

                <h2>Security and retention</h2>
                <p>We keep information only as long as needed for account management, bookings, records, legal requirements, and platform operations. Reasonable safeguards are used to protect stored data.</p>

                <h2>Contact</h2>
                <p>For privacy questions or account data concerns, contact us at <a href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a>.</p>
            </div>
        </section>
    </main>
@endsection
