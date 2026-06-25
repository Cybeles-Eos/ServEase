<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Booking Receipt</title>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- Meta's --}}
    <meta property="og:title" content="ServEase | Hire Verified Local Services in Brgy. Batasan Hills" />
    <meta property="og:description" content="ServEase helps you find and hire verified local service providers in Barangay Batasan Hills. You post requests, review services, and connect with trusted workers in one secure platform." />
    <meta property="og:image" content="{{ asset('images/meta-cover.png') }}" />
    <meta property="og:url" content="/" />
    <meta property="og:type" content="website" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="ServEase | Hire Verified Local Services in Brgy. Batasan Hills" />
    <meta name="twitter:description" content="You find trusted local services faster with ServEase. Hire verified workers, post service needs, and manage bookings securely within your barangay." />
    <meta name="twitter:image" content="{{ asset('images/meta-cover.png') }}" />

    {{-- Icons --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/icons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/icons/web-app-manifest-512x512.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/icons/web-app-manifest-192x192.png') }}">
    <link rel="manifest" href="{{ asset('images/icons/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('images/icons/favicon.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <style>
        @page {
            size: 76mm auto;
            margin: 0;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 76mm;
            background: #fff;
            font-family: Arial, sans-serif;
        }

        #wrap {
            padding: 10px 8mm 15px 8mm;
            width: 100%;
            box-sizing: border-box;
            text-align: center;
        }

        p {
            margin: 3px 0;
        }

        .big {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .med {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .sm {
            font-size: 11px;
            text-transform: uppercase;
        }

        .row {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            font-size: 11px;
            text-transform: uppercase;
            margin: 2px 0;
            text-align: left;
        }

        .row span:last-child {
            text-align: right;
            word-break: break-word;
        }

        .dash {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        .text-left {
            text-align: left;
        }
    </style>
</head>

<body onload="window.print(); window.onafterprint = function(){ window.close(); }">
    <div id="wrap">
        @php
            $service = $bookingInfo->service ?? null;
            $provider = $service->provider ?? null;
            $customer = $bookingInfo->customer ?? null;

            $servicePrice = (float) ($service->price ?? 0);
            $servicePriceLabel = $service?->price_label ?? ('₱' . number_format($servicePrice, 2));
            $servicePricingTypeLabel = $service?->pricing_type_label ?? 'Fixed Rate';
            $bookingTotalLabel = $bookingRequest->billing_total_label ?? $servicePriceLabel;
            $completedDurationLabel = $bookingRequest->completed_duration_label;
            $bookingDate = !empty($bookingInfo->date)
                ? \Carbon\Carbon::parse($bookingInfo->date)->format('m/d/Y')
                : 'N/A';

            $bookingTime = !empty($bookingInfo->time)
                ? \Carbon\Carbon::parse($bookingInfo->time)->format('h:i a')
                : 'N/A';

            $completedAt = $bookingRequest->updated_at
                ? \Carbon\Carbon::parse($bookingRequest->updated_at)->format('m/d/Y h:i:s a')
                : now()->format('m/d/Y h:i:s a');
        @endphp

        <p class="big">ServEase</p>
        <p class="sm">Booking Services</p>
        <p class="sm">Service Booking Receipt</p>

        <div class="dash"></div>

        <p class="big">COMPLETED</p>
        <p class="med">BOOKING RECEIPT</p>
        <p class="sm">Booking No: #{{ $bookingRequest->id }}</p>

        <div class="dash"></div>

        <p class="sm">{{ $completedAt }}</p>

        <div class="dash"></div>

        <div class="row">
            <span>Customer:</span>
            <span>{{ trim(($bookingInfo->fname ?? '') . ' ' . ($bookingInfo->lname ?? '')) ?: 'N/A' }}</span>
        </div>

        <div class="row">
            <span>Contact:</span>
            <span>{{ $bookingInfo->number ?? 'N/A' }}</span>
        </div>

        <div class="row">
            <span>Email:</span>
            <span>{{ $bookingInfo->email ?? 'N/A' }}</span>
        </div>

        <div class="row">
            <span>Provider:</span>
            <span>{{ trim(($provider->first_name ?? '') . ' ' . ($provider->last_name ?? '')) ?: 'N/A' }}</span>
        </div>

        <div class="row">
            <span>Provider No:</span>
            <span>{{ $provider->phone_number ?? 'N/A' }}</span>
        </div>

        <div class="dash"></div>

        <div class="row">
            <span>Service:</span>
            <span>{{ $service->title ?? 'N/A' }}</span>
        </div>

        <div class="row">
            <span>Category:</span>
            <span>{{ $service->serviceCategory->name ?? 'N/A' }}</span>
        </div>

        <div class="row">
            <span>Date:</span>
            <span>{{ $bookingDate }}</span>
        </div>

        <div class="row">
            <span>Time:</span>
            <span>{{ $bookingTime }}</span>
        </div>

        <div class="row">
            <span>Status:</span>
            <span>{{ $bookingRequest->status }}</span>
        </div>

        <div class="dash"></div>

        <p class="sm text-left">Address:</p>
        <p class="sm text-left">{{ $bookingInfo->address ?? 'N/A' }}</p>

        <div class="dash"></div>

        <div class="row">
            <span>{{ $servicePricingTypeLabel }}:</span>
            <span>{{ $servicePriceLabel }}</span>
        </div>

        @if(($service->pricing_type ?? 'fixed') === 'per_hour' && $completedDurationLabel)
            <div class="row">
                <span>Completed Time:</span>
                <span>{{ $completedDurationLabel }}</span>
            </div>
        @endif

        <div class="dash"></div>

        <div class="row" style="font-weight: bold;">
            <span>GRAND TOTAL:</span>
            <span>{{ $bookingTotalLabel }}</span>
        </div>

        <div class="dash"></div>

        <p class="sm">Thank you! Please keep this receipt.</p>

        <p style="font-size:6px; text-transform:uppercase; text-align:center; margin-top:7px;">
            Developed by Monte Carlo Technologies
        </p>

        <p style="font-size:6px; text-transform:uppercase; text-align:center;">
            Copyright © {{ date('Y') }} ServEase. All rights reserved.
        </p>

        <p class="sm">Printed: {{ now()->format('m/d/Y h:i a') }}</p>
    </div>
</body>
</html>
