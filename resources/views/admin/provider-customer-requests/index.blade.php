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

    .provider-request-stat,
    .provider-request-card,
    .provider-request-empty {
        border: 1px solid #E4E7EC;
        border-radius: 8px;
        background: #fff;
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
        <div class="provider--dashboard__head">
            @auth
                <p>Hello {{ auth()->user()->name }}, manage your customer requests today!</p>
            @endauth
        </div>

        {{-- <div class="provider-request-head">
            <div>
                <h3>Customer Request Work</h3>
                <p>Track custom requests you applied to, accepted work, and completed request income.</p>
            </div>
        </div> --}}

        @php
            $acceptedApplicationCount = $applications->where('status', 'accepted')->count();
            $applicationsToday = $applications->filter(fn ($application) => $application->created_at?->isToday())->count();
            $completedTodayCount = $applications->filter(fn ($application) => $application->customerRequest?->completed_at?->isToday())->count();
            $incomeToday = $applications
                ->filter(fn ($application) => $application->customerRequest?->status === 'completed' && $application->customerRequest?->completed_at?->isToday())
                ->sum(fn ($application) => (float) ($application->customerRequest?->fixed_price ?? 0));
            $acceptedPercent = $appliedRequestCount > 0 ? round(($acceptedApplicationCount / $appliedRequestCount) * 100) : 0;
            $completedPercent = $appliedRequestCount > 0 ? round(($completedRequestCount / $appliedRequestCount) * 100) : 0;
            $incomeTodayPercent = $completedRequestIncome > 0 ? round(($incomeToday / $completedRequestIncome) * 100) : 0;
        @endphp

        <section class="provider--dashboard__header-box" style="margin-top: 0">
            <div class="pdhb-box">
                <div class="pdhb-box__top">
                    <p>Total Applications</p>

                    <svg width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.25 3.58522C9.25 2.02598 7.975 0.75 6.41695 0.75H0.75V10.9578H6.4518C9.25 10.9578 9.25 13.7939 9.25 13.7939M9.25 3.58522C9.25 2.02512 10.525 0.75 12.0831 0.75H17.75V10.9578H12.0831C9.25 10.9578 9.25 13.7939 9.25 13.7939M9.25 3.58522V13.7939M10.8438 14.75C11.0211 14.3824 11.2974 14.0716 11.6415 13.8525C11.9857 13.6334 12.3841 13.5147 12.792 13.5098H16.9M7.65625 14.75C7.48213 14.3799 7.20662 14.0669 6.86174 13.8473C6.51686 13.6278 6.11679 13.5107 5.70805 13.5098H1.6" stroke="#FFBE42" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="pdhb-box__count">
                    <p>{{ number_format($appliedRequestCount) }}</p>
                </div>

                <div class="pdhb-box__range">
                    <div>{{ $appliedRequestCount > 0 ? 100 : 0 }}%</div>
                    <p>+{{ number_format($applicationsToday) }} new applications today</p>
                </div>
            </div>

            <div class="pdhb-box">
                <div class="pdhb-box__top">
                    <p>Requests Completed</p>

                    <svg width="17" height="19" viewBox="0 0 17 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.3857 19L9.71429 16.1726L10.8411 15.0794L12.3857 16.5779L15.8731 13.1944L17 14.5233L12.3857 19ZM13.6 0C14.6686 0 15.5429 0.848214 15.5429 1.88492V10.6875C14.9309 10.4802 14.28 10.3671 13.6 10.3671V1.88492H8.74286V9.4246L6.31429 7.30407L3.88571 9.4246V1.88492H1.94286V16.9643H7.84914C7.96571 17.6429 8.20857 18.2743 8.54857 18.8492H1.94286C0.874286 18.8492 0 18.001 0 16.9643V1.88492C0 0.848214 0.874286 0 1.94286 0H13.6Z" fill="#FFBE42"/>
                    </svg>
                </div>
                <div class="pdhb-box__count">
                    <p>{{ number_format($completedRequestCount) }}</p>
                </div>

                <div class="pdhb-box__range">
                    <div>{{ $completedPercent }}%</div>
                    <p>+{{ number_format($completedTodayCount) }} today</p>
                </div>
            </div>

            <div class="pdhb-box">
                <div class="pdhb-box__top">
                    <p>Accepted Requests</p>

                    <svg width="23" height="17" viewBox="0 0 23 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.2003 9.59919C22.1215 9.65828 22.0318 9.70128 21.9364 9.72573C21.841 9.75017 21.7417 9.75558 21.6442 9.74165C21.5467 9.72772 21.4529 9.69473 21.3682 9.64455C21.2834 9.59436 21.2094 9.52798 21.1503 9.44919C20.6982 8.84156 20.1098 8.34856 19.4324 8.00986C18.7551 7.67117 18.0076 7.49625 17.2503 7.49919C17.1028 7.49918 16.9586 7.45568 16.8357 7.37414C16.7128 7.2926 16.6167 7.17664 16.5593 7.04075C16.5204 6.94848 16.5004 6.84934 16.5004 6.74919C16.5004 6.64904 16.5204 6.5499 16.5593 6.45763C16.6167 6.32174 16.7128 6.20578 16.8357 6.12424C16.9586 6.0427 17.1028 5.9992 17.2503 5.99919C17.6711 5.99915 18.0835 5.8811 18.4406 5.65845C18.7976 5.43579 19.0851 5.11746 19.2704 4.7396C19.4556 4.36175 19.5312 3.93952 19.4885 3.52087C19.4458 3.10223 19.2865 2.70395 19.0288 2.37127C18.7711 2.0386 18.4253 1.78487 18.0306 1.63889C17.6359 1.49292 17.2082 1.46056 16.796 1.54549C16.3838 1.63041 16.0038 1.82923 15.6989 2.11934C15.3941 2.40945 15.1767 2.77924 15.0715 3.18669C15.0469 3.2821 15.0037 3.37173 14.9445 3.45046C14.8852 3.52919 14.811 3.59547 14.7261 3.64553C14.6413 3.69559 14.5474 3.72843 14.4498 3.7422C14.3522 3.75596 14.2529 3.75038 14.1575 3.72575C14.0621 3.70113 13.9724 3.65796 13.8937 3.59869C13.815 3.53943 13.7487 3.46524 13.6986 3.38037C13.6486 3.29549 13.6157 3.20158 13.602 3.10401C13.5882 3.00643 13.5938 2.9071 13.6184 2.81169C13.7644 2.24667 14.0403 1.72353 14.4241 1.2839C14.8079 0.844258 15.289 0.500259 15.8291 0.279269C16.3692 0.0582794 16.9534 -0.0336011 17.5353 0.0109381C18.1172 0.0554774 18.6807 0.235207 19.1809 0.535827C19.681 0.836446 20.1042 1.24966 20.4166 1.74258C20.729 2.23551 20.922 2.79454 20.9803 3.3752C21.0387 3.95586 20.9607 4.54212 20.7526 5.08733C20.5444 5.63254 20.2119 6.12165 19.7815 6.51575C20.8014 6.95731 21.6879 7.65802 22.3531 8.54825C22.4122 8.62725 22.4551 8.71712 22.4794 8.81273C22.5037 8.90834 22.5089 9.0078 22.4947 9.10543C22.4805 9.20305 22.4472 9.29691 22.3967 9.38164C22.3462 9.46637 22.2794 9.5403 22.2003 9.59919Z" fill="#FFBE42"/>
                    </svg>
                </div>
                <div class="pdhb-box__count">
                    <p>{{ number_format($acceptedApplicationCount) }}</p>
                </div>

                <div class="pdhb-box__range">
                    <div>{{ $acceptedPercent }}%</div>
                    <p>{{ number_format($pendingApplicationCount) }} pending applications</p>
                </div>
            </div>

            <div class="pdhb-box">
                <div class="pdhb-box__top">
                    <p>Earnings</p>

                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.5761 11.3337C11.5761 10.4918 9.29681 9.80985 6.48517 9.80985M11.5761 11.3337C11.5761 12.1756 9.29681 12.8575 6.48517 12.8575C3.67354 12.8575 1.39426 12.1756 1.39426 11.3337M11.5761 11.3337V15.0952C11.5761 15.963 9.29681 16.667 6.48517 16.667C3.67354 16.667 1.39426 15.9638 1.39426 15.0952V11.3337M11.5761 11.3337C14.3572 11.3337 16.667 10.5817 16.667 9.80985V2.1908M6.48517 9.80985C3.67354 9.80985 1.39426 10.4918 1.39426 11.3337M6.48517 9.80985C3.27208 9.80985 0.666992 9.05785 0.666992 8.28604V4.47652M6.48517 2.95271C3.27208 2.95271 0.666992 3.63461 0.666992 4.47652M0.666992 4.47652C0.666992 5.31842 3.27208 6.00033 6.48517 6.00033C6.48517 6.77214 8.85099 7.52414 11.6321 7.52414C14.4132 7.52414 16.667 6.77214 16.667 6.00033M16.667 2.1908C16.667 1.3489 14.4124 0.666992 11.6321 0.666992C8.85172 0.666992 6.59717 1.3489 6.59717 2.1908M16.667 2.1908C16.667 3.03271 14.4124 3.71461 11.6321 3.71461C8.85172 3.71461 6.59717 3.03271 6.59717 2.1908M6.59717 2.1908V9.93633" stroke="#FFBE42" stroke-width="1.33333"/>
                    </svg>
                </div>
                <div class="pdhb-box__count">
                    <p><span>₱</span>{{ number_format($completedRequestIncome, 2) }}</p>
                </div>

                <div class="pdhb-box__range">
                    <div>{{ $incomeTodayPercent }}%</div>
                    <p>+PHP {{ number_format($incomeToday, 2) }} today</p>
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
