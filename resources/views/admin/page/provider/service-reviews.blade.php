@extends('admin.layouts.auth')

@section('title', 'Service Reviews - Servease')

@push('extrastylesheets')
<style>

    /* Back Button */
    .service-review-admin__back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        width: fit-content;
        padding: 9px 14px;
        border: 1px solid #E5E7EB;
        background: #fff;
        color: #374151;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none !important;
        transition: 0.2s ease;
    }
    .service-review-admin__back:hover {
        background: #FFF7E6;
        border-color: #FFBE42;
        color: #202020;
    }
    .service-review-admin__back svg {
        width: 14px;
        height: 14px;
    }


    .service-review-admin {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }
    .service-review-admin__banner {
        position: relative;
        min-height: 230px;
        border-radius: 18px;
        overflow: hidden;
        background: #111827;
        color: #fff;
        display: flex;
        align-items: flex-end;
        padding: 24px;
    }
    .service-review-admin__banner img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: .45;
    }
    .service-review-admin__banner-content {
        position: relative;
        z-index: 1;
        max-width: 760px;
    }
    .service-review-admin__banner-content small {
        display: inline-flex;
        padding: 5px 9px;
        border-radius: 999px;
        background: #FFBE42;
        color: #202020;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 8px;
    }
    .service-review-admin__banner-content h1 {
        margin: 0 0 8px;
        font-size: 28px;
        font-weight: 800;
    }
    .service-review-admin__banner-content p {
        margin: 0;
        max-width: 680px;
        color: rgba(255,255,255,.88);
        line-height: 1.55;
    }
    .service-review-admin__stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
    }
    .service-review-admin__stat-card {
        background: #fff;
        border: 1px solid #E5E7EB;
        border-radius: 14px;
        padding: 16px;
    }
    .service-review-admin__stat-card p {
        margin: 0 0 8px;
        font-size: 12px;
        color: #6B7280;
    }
    .service-review-admin__stat-card h3 {
        margin: 0;
        font-size: 22px;
        font-weight: 800;
        color: #202020;
    }
    .service-review-admin__details,
    .service-review-admin__comments {
        background: #fff;
        border: 1px solid #E5E7EB;
        border-radius: 14px;
        padding: 18px;
    }
    .service-review-admin__details h3,
    .service-review-admin__comments h3 {
        margin: 0 0 12px;
        font-size: 18px;
        font-weight: 800;
    }
    .service-review-admin__details-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px 18px;
    }
    .service-review-admin__details-grid p {
        margin: 0;
        font-size: 13px;
        color: #6B7280;
    }
    .service-review-admin__details-grid strong {
        display: block;
        color: #202020;
        margin-bottom: 2px;
    }
    .service-review-admin__comment-card {
        display: flex;
        gap: 12px;
        padding: 14px 0;
        border-top: 1px solid #F1F1F1;
    }
    .service-review-admin__avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #FFBE42;
        color: #fff;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex: 0 0 44px;
    }
    .service-review-admin__avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .service-review-admin__comment-body {
        flex: 1;
    }
    .service-review-admin__comment-top {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        align-items: flex-start;
    }
    .service-review-admin__comment-top h4 {
        margin: 0;
        font-size: 14px;
        font-weight: 800;
    }
    .service-review-admin__comment-top p {
        margin: 2px 0 0;
        font-size: 12px;
        color: #6B7280;
    }
    .service-review-admin__stars {
        margin-top: 6px;
        color: #D1D5DB;
        letter-spacing: 1px;
    }
    .service-review-admin__stars .active {
        color: #FFBE42;
    }
    .service-review-admin__comment {
        margin: 8px 0 0;
        font-size: 13px;
        color: #374151;
        line-height: 1.5;
    }
    .service-review-admin__empty {
        padding: 24px;
        text-align: center;
        color: #6B7280;
        font-size: 14px;
    }
    .service-review-admin__pagination {
        margin-top: 16px;
    }
    @media (max-width: 900px) {
        .service-review-admin__stats,
        .service-review-admin__details-grid {
            grid-template-columns: 1fr;
        }

        .service-review-admin__comment-top {
            flex-direction: column;
        }
    }

    .review-switch-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .review-switch-label {
        font-size: 12px;
        font-weight: 700;
    }

    .review-switch-label.is-visible {
        color: #166534;
    }

    .review-switch-label.is-hidden {
        color: #991B1B;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 48px;
        height: 24px;
        flex: 0 0 48px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
        position: absolute;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        inset: 0;
        background-color: #ccc;
        transition: .3s;
        border-radius: 24px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        top: 3px;
        background-color: white;
        transition: .3s;
        border-radius: 50%;
    }

    .switch input:checked + .slider {
        background-color: #FFBE42;
    }

    .switch input:checked + .slider:before {
        transform: translateX(24px);
    }

.review-toggle-box {
    display: inline-flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    min-width: 64px;
}

.review-toggle-label {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 52px;
    padding: 3px 8px;
    border-radius: 999px;
    font-size: 10px;
    font-weight: 800;
    line-height: 1;
}

.review-toggle-label.is-visible {
    background: #DCFCE7;
    color: #166534;
}

.review-toggle-label.is-hidden {
    background: #FEE2E2;
    color: #991B1B;
}

.review-switch {
    position: relative;
    display: inline-block;
    width: 40px;
    height: 20px;
    cursor: pointer;
}

.review-switch input {
    opacity: 0;
    width: 0;
    height: 0;
    position: absolute;
}

.review-slider {
    position: absolute;
    inset: 0;
    background-color: #D1D5DB;
    border-radius: 999px;
    transition: 0.25s ease;
}

.review-slider::before {
    content: "";
    position: absolute;
    width: 16px;
    height: 16px;
    left: 2px;
    top: 2px;
    background-color: #fff;
    border-radius: 50%;
    transition: 0.25s ease;
    box-shadow: 0 1px 3px rgba(0,0,0,0.18);
}

.review-switch input:checked + .review-slider {
    background-color: #FFBE42;
}

.review-switch input:checked + .review-slider::before {
    transform: translateX(20px);
}

/* Tooltip */
.review-switch::after {
    content: attr(data-tooltip);
    position: absolute;
    right: 50%;
    bottom: calc(100% + 9px);
    transform: translateX(50%) translateY(4px);
    width: 210px;
    padding: 8px 10px;
    border-radius: 8px;
    background: #202020;
    color: #fff;
    font-size: 11px;
    font-weight: 500;
    line-height: 1.35;
    text-align: center;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: 0.2s ease;
    z-index: 20;
}

.review-switch::before {
    content: "";
    position: absolute;
    right: 50%;
    bottom: calc(100% + 3px);
    transform: translateX(50%) translateY(4px);
    border-width: 6px 6px 0 6px;
    border-style: solid;
    border-color: #202020 transparent transparent transparent;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: 0.2s ease;
    z-index: 21;
}

.review-switch:hover::after,
.review-switch:hover::before {
    opacity: 1;
    visibility: visible;
    transform: translateX(50%) translateY(0);
}
.provider-review-breadcrumb {
    display: flex;
    align-items: center;
    gap: 9px;
    flex-wrap: wrap;
    margin-bottom: 4px;
    font-size: 13px;
}

.provider-review-breadcrumb a {
    color: #6b728064;
    text-decoration: none;
    font-weight: 500;
    transition: 0.2s ease;
}

.provider-review-breadcrumb a:hover {
    color: #FDB932;
}

.provider-review-breadcrumb span {
    color: #202020;
    font-weight: 500;
}

.provider-review-breadcrumb svg {
    flex: 0 0 auto;
}
</style>
@endpush

@section('content')
@include('admin.layouts.header')

<main class="main-dash-uix dash-sp provider--service">
    <div class="service-review-admin">
        <div class="provider-review-breadcrumb">
            <a href="{{ route('provider.service') }}">Services</a>

            <svg width="4" height="7" viewBox="0 0 4 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0.384033 0.320312L2.88403 3.32031L0.384033 6.32031" stroke="#FDB932"/>
            </svg>

            <span>{{ \Illuminate\Support\Str::limit($service->title, 45) }}</span>
        </div>

        <section class="service-review-admin__banner">
            <img src="{{ asset($service->image ?? 'public/images/default_service_banner.png') }}" alt="{{ $service->title }}">

            <div class="service-review-admin__banner-content">
                <small>{{ $service->serviceCategory?->name ?? 'No Category' }}</small>
                <h1>{{ $service->title }}</h1>
                <p>{{ $service->description }}</p>
            </div>
        </section>

        <section class="service-review-admin__stats">
            <div class="service-review-admin__stat-card">
                <p>Average Rating</p>
                <h3>{{ number_format($averageRating, 1) }} ★</h3>
            </div>

            <div class="service-review-admin__stat-card">
                <p>Total Reviews</p>
                <h3>{{ number_format($ratingCount) }}</h3>
            </div>

            <div class="service-review-admin__stat-card">
                <p>Visible Reviews</p>
                <h3>{{ number_format($visibleCount) }}</h3>
            </div>

            <div class="service-review-admin__stat-card">
                <p>Hidden Reviews</p>
                <h3>{{ number_format($hiddenCount) }}</h3>
            </div>
        </section>

        <section class="service-review-admin__details">
            <h3>Service Details</h3>

            <div class="service-review-admin__details-grid">
                <p>
                    <strong>Service ID</strong>
                    {{ $service->service_id ?? '#'.$service->id }}
                </p>

                <p>
                    <strong>Slug</strong>
                    {{ $service->slug }}
                </p>

                <p>
                    <strong>Price</strong>
                    ₱{{ number_format($service->price ?? 0, 2) }}
                </p>

                <p>
                    <strong>Date Created</strong>
                    {{ $service->created_at?->format('M d, Y') }}
                </p>

                <p>
                    <strong>Specialization</strong>
                    {{ $service->specialization ?? 'N/A' }}
                </p>

                <p>
                    <strong>Public Link</strong>
                    <a href="{{ url('services/'.$service->slug) }}" target="_blank">
                        {{ url('services/'.$service->slug) }}
                    </a>
                </p>
            </div>
        </section>

        <section class="service-review-admin__comments">
            <h3>Service Comments</h3>

            @forelse($ratings as $rating)
                @php
                    $customer = $rating->customer;
                    $user = $customer?->user;

                    $customerName = trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? ''));

                    if (empty($customerName)) {
                        $customerName = 'Customer';
                    }

                    $initials = strtoupper(
                        substr($customer->first_name ?? 'C', 0, 1) .
                        substr($customer->last_name ?? '', 0, 1)
                    );
                @endphp

                <div class="service-review-admin__comment-card">
                    <div class="service-review-admin__avatar">
                        @if(!empty($customer?->profile_image))
                            <img src="{{ asset($customer->profile_image) }}" alt="{{ $customerName }}">
                        @else
                            {{ $initials }}
                        @endif
                    </div>

                    <div class="service-review-admin__comment-body">
                        <div class="service-review-admin__comment-top">
                            <div>
                                <h4>{{ $customerName }}</h4>
                                <p>{{ $user->email ?? 'No email' }}</p>
                                <p>{{ $rating->created_at?->format('M d, Y h:i A') }}</p>
                            </div>

                            <form method="POST"
                                action="{{ route('provider.service-rating.toggle-visibility', $rating->id) }}"
                                class="review-visibility-form review-toggle-box">
                                @csrf

                                <span class="review-toggle-label {{ $rating->is_visible ? 'is-visible' : 'is-hidden' }}">
                                    {{ $rating->is_visible ? 'Shown' : 'Hidden' }}
                                </span>

                                <label class="review-switch"
                                    data-tooltip="{{ $rating->is_visible ? 'This comment is visible on the public service detail page. Click to hide it.' : 'This comment is hidden from the public service detail page. Click to show it.' }}">
                                    <input type="checkbox"
                                        onchange="this.form.submit()"
                                        {{ $rating->is_visible ? 'checked' : '' }}>
                                    <span class="review-slider"></span>
                                </label>
                            </form>
                        </div>

                        <div class="service-review-admin__stars">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="{{ $i <= $rating->rating ? 'active' : '' }}">★</span>
                            @endfor
                        </div>

                        <p class="service-review-admin__comment">
                            {{ $rating->comment ?: 'No comment provided.' }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="service-review-admin__empty">
                    No comments or ratings yet for this service.
                </div>
            @endforelse

            <div class="service-review-admin__pagination">
                {{ $ratings->links() }}
            </div>
        </section>
    </div>
</main>
@endsection