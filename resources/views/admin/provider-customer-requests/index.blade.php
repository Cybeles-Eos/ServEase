@extends('admin.layouts.auth')

@section('title', 'Provider Customer Requests - Servease')

@push('extrastylesheets')
<style>
    .provider-customer-request-page {
        display: grid;
        gap: 18px;
        padding: 15px 15px;
    }

    .provider-request-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
    }

    .provider-request-head h3 {
        margin: 0;
        color: #171515;
        font-size: 20px;
        font-weight: 800;
    }

    .provider-request-head p {
        margin: 6px 0 0;
        color: #667085;
        font-size: 13px;
        line-height: 1.45;
    }

    .provider-request-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
    }

    .provider-request-stat,
    .provider-request-card,
    .provider-request-empty {
        border: 1px solid #E4E7EC;
        border-radius: 8px;
        background: #fff;
    }

    .provider-request-stat {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        min-height: 96px;
        padding: 16px;
    }

    .provider-request-stat span {
        display: block;
        color: #667085;
        font-size: 12px;
        font-weight: 600;
    }

    .provider-request-stat strong {
        display: block;
        margin-top: 7px;
        color: #171515;
        font-size: 24px;
        line-height: 1;
        font-weight: 800;
    }

    .provider-request-stat__icon {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        flex: 0 0 auto;
        background: #FFF3D5;
        color: #B45309;
    }

    .provider-request-list {
        display: grid;
        gap: 14px;
    }

    .provider-request-card {
        overflow: hidden;
    }

    .provider-request-card-main {
        display: grid;
        grid-template-columns: 190px minmax(0, 1fr);
    }

    .provider-request-card img {
        width: 100%;
        height: 100%;
        min-height: 185px;
        object-fit: cover;
        background: #F2F4F7;
    }

    .provider-request-card__body {
        display: grid;
        gap: 10px;
        padding: 16px;
        min-width: 0;
    }

    .provider-request-card__top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .provider-request-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
    }

    .provider-request-badge {
        display: inline-flex;
        align-items: center;
        min-height: 24px;
        padding: 0 9px;
        border-radius: 999px;
        background: #F3F4F6;
        color: #4B5563;
        font-size: 11px;
        font-weight: 800;
        text-transform: capitalize;
    }

    .provider-request-badge--accepted {
        background: #ECFDF5;
        color: #15803D;
    }

    .provider-request-badge--completed {
        background: #EFF6FF;
        color: #1D4ED8;
    }

    .provider-request-card h3 {
        margin: 0;
        color: #171515;
        font-size: 18px;
        line-height: 1.25;
        font-weight: 800;
    }

    .provider-request-card p {
        margin: 0;
        color: #667085;
        font-size: 13px;
        line-height: 1.45;
    }

    .provider-request-price {
        color: #171515;
        font-size: 14px;
        font-weight: 800;
        white-space: nowrap;
    }

    .provider-request-meta {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 8px;
    }

    .provider-request-meta div {
        border-radius: 6px;
        background: #F7F8FA;
        padding: 9px 10px;
        min-width: 0;
    }

    .provider-request-meta span {
        display: block;
        color: #667085;
        font-size: 10px;
        line-height: 1.2;
        font-weight: 600;
    }

    .provider-request-meta strong {
        display: block;
        margin-top: 4px;
        color: #171515;
        font-size: 12px;
        line-height: 1.25;
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .provider-request-contact {
        border-top: 1px solid #EEF0F3;
        padding-top: 10px;
    }

    .provider-request-empty {
        padding: 28px;
        text-align: center;
    }

    .provider-request-empty span {
        color: #667085;
        font-size: 13px;
    }

    .provider-request-empty strong {
        display: block;
        margin-top: 6px;
        color: #171515;
        font-size: 18px;
    }

    @media (max-width: 1200px) {
        .provider-request-stats,
        .provider-request-meta {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .provider-request-head,
        .provider-request-card__top {
            flex-direction: column;
            align-items: flex-start;
        }

        .provider-request-stats,
        .provider-request-card-main,
        .provider-request-meta {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
    @include('admin.layouts.header')

    <main class="main-dash-uix dash-sp provider-customer-request-page">
        <div class="provider-request-head">
            <div>
                <h3>Customer Request Work</h3>
                <p>Track custom requests you applied to, accepted work, and completed request income.</p>
            </div>
        </div>

        <section class="provider-request-stats">
            <div class="provider-request-stat">
                <div>
                    <span>Total Applications</span>
                    <strong>{{ number_format($appliedRequestCount) }}</strong>
                </div>
                <div class="provider-request-stat__icon">
                    <i class="fas fa-paper-plane"></i>
                </div>
            </div>
            <div class="provider-request-stat">
                <div>
                    <span>Pending Applications</span>
                    <strong>{{ number_format($pendingApplicationCount) }}</strong>
                </div>
                <div class="provider-request-stat__icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            <div class="provider-request-stat">
                <div>
                    <span>Completed Requests</span>
                    <strong>{{ number_format($completedRequestCount) }}</strong>
                </div>
                <div class="provider-request-stat__icon">
                    <i class="fas fa-check"></i>
                </div>
            </div>
            <div class="provider-request-stat">
                <div>
                    <span>Completed Income</span>
                    <strong>PHP {{ number_format($completedRequestIncome, 2) }}</strong>
                </div>
                <div class="provider-request-stat__icon">
                    <i class="fas fa-coins"></i>
                </div>
            </div>
        </section>

        <section class="provider-request-list">
            @forelse($applications as $application)
                @php
                    $request = $application->customerRequest;
                    $isAcceptedProvider = $request?->accepted_provider_id === auth()->user()->provider?->id;
                    $requestReference = $request ? '#CR-' . str_pad((string) $request->id, 5, '0', STR_PAD_LEFT) : 'Request';
                    $badgeClass = match ($request?->status) {
                        'accepted' => 'provider-request-badge--accepted',
                        'completed' => 'provider-request-badge--completed',
                        default => '',
                    };
                @endphp

                <article class="provider-request-card">
                    <div class="provider-request-card-main">
                        <img src="{{ $request?->image_path ? asset($request->image_path) : asset('images/serv-bg.png') }}" alt="{{ $request?->title ?? 'Customer request' }}">
                        <div class="provider-request-card__body">
                            <div class="provider-request-card__top">
                                <div class="provider-request-badges">
                                    <span class="provider-request-badge {{ $badgeClass }}">{{ $request?->status ?? 'Request' }}</span>
                                    <span class="provider-request-badge">Application {{ ucfirst($application->status) }}</span>
                                </div>
                                <span class="provider-request-price">{{ $request?->fixed_price_label ?? 'PHP 0.00' }}</span>
                            </div>

                            <div>
                                <h3>{{ $request?->title ?? 'Customer request' }}</h3>
                                <p>{{ $request?->description }}</p>
                            </div>

                            <div class="provider-request-meta">
                                <div>
                                    <span>Reference</span>
                                    <strong>{{ $requestReference }}</strong>
                                </div>
                                <div>
                                    <span>Service Type</span>
                                    <strong>{{ $request?->service_type ?: 'Custom service' }}</strong>
                                </div>
                                <div>
                                    <span>Applied</span>
                                    <strong>{{ $application->applied_at?->format('M d, Y') ?? $application->created_at?->format('M d, Y') }}</strong>
                                </div>
                                <div>
                                    <span>Completed</span>
                                    <strong>{{ $request?->completed_at?->format('M d, Y') ?? 'Not completed' }}</strong>
                                </div>
                            </div>

                            @if($application->notes)
                                <p>Your notes: {{ $application->notes }}</p>
                            @endif

                            @if($isAcceptedProvider)
                                <div class="provider-request-contact">
                                    <p>Customer: <strong>{{ $request->contact_name ?: 'Customer' }}</strong></p>
                                    <p>{{ $request->contact_phone ?: 'No phone' }} {{ $request->contact_email ? ' - ' . $request->contact_email : '' }}</p>
                                    <p>{{ $request->contact_address ?: 'No address' }}</p>
                                    @if($request->status === 'completed')
                                        <p>Completed by: {{ $request->completion_source ?: 'manual' }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <div class="provider-request-empty">
                    <span>No customer request applications yet.</span>
                    <strong>Apply from the Customer Request marketplace.</strong>
                </div>
            @endforelse
        </section>
    </main>
@endsection
