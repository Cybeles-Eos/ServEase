@extends('front.layouts.base')

{{-- Metas --}}
@section('title', 'Contact - Servease services')

@section('content')
    @php
        $platform = getPlatformSettings();
        $platformName = $platform->platform_name ?: 'ServEase';
        $supportEmail = $platform->platform_email ?: 'support@servease.com';
        $phoneNumber = $platform->phone_number ?: '09XXXXXXXXX';
        $officeAddress = $platform->office_address ?: 'Burgos Barangay Hall Rodriguez, Rizal';
        $supportHours = preg_replace('/-{2,}/', '-', preg_replace('/[^\x20-\x7E]/', '-', (string) $platform->support_hours)) ?: 'Mon-Sat, 8:00 AM - 5:00 PM';
    @endphp

    <main class="main-page page--contact">
        <section class="section--hero">
            <div class="m-width m-padding">
                <p>{{ $platformName }}</p>
                <h1>Contact</h1>
                <span>Reach our support team for account, booking, provider application, and local service concerns.</span>
            </div>
        </section>

        <section class="section--contact-info m-padding">
            <div class="m-width">
                <div>
                    <h2>Email</h2>
                    <a href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a>
                </div>
                <div>
                    <h2>Phone</h2>
                    <p>{{ $phoneNumber }}</p>
                </div>
                <div>
                    <h2>Office Address</h2>
                    <p>{{ $officeAddress }}</p>
                </div>
                <div>
                    <h2>Support Hours</h2>
                    <p>{{ $supportHours }}</p>
                </div>
            </div>
        </section>
    </main>
@endsection
