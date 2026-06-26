@extends('front.layouts.base')

@push('extrastylesheets')
<style>
    .provider-schedule-summary {
        margin-top: 20px;
        border-top: 1px solid #E5E7EB;
        padding-top: 20px;
    }

    .provider-schedule-summary__head {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: space-between;
        gap: 5px;
        margin-bottom: 10px;
    }

    .provider-schedule-summary__head h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 700;
        color: #171515;
    }

    .provider-schedule-summary__estimate {
        margin: 0;
        color: #6B7280;
        font-size: 12px;
        line-height: 1.4;
        text-align: left;
        /* max-width: 150px; */
    }

    .provider-schedule-summary__estimate span {
        color: #F59E0B;
        font-weight: 700;
        white-space: nowrap;
    }

    .provider-schedule-summary__item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        color: #171515;
    }

    .provider-schedule-summary__item svg {
        flex: 0 0 16px;
        margin-top: 2px;
    }

    .provider-schedule-summary__item p {
        margin: 0;
        font-size: 14px;
        line-height: 1.45;
    }

    .provider-schedule-summary__item strong {
        font-weight: 700;
    }

    .provider-schedule-summary__item span {
        display: inline-flex;
        margin-left: 0px;
        color: #F59E0B;
        font-size: 12px;
        font-weight: 700;
    }

    .provider-schedule-summary__note {
        margin: 6px 0 0 26px;
        color: #6B7280;
        font-size: 12px;
        line-height: 1.45;
    }

    @media (max-width: 592px) {
        .provider-schedule-summary__head {
            flex-direction: column;
        }

        .provider-schedule-summary__estimate {
            max-width: none;
            text-align: left;
        }
    }
</style>
@endpush

@section('content')
    <main class="main-page page--services-detail">
        <section class="section--list m-padding m-width">
            <div class="psd-sl-category">
                <div class="psd-sl-category__head" >
                    <a href="{{ url('/') }}" class="">Home</a>

                    <svg width="4" height="7" viewBox="0 0 4 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.384033 0.320312L2.88403 3.32031L0.384033 6.32031" stroke="#FDB932"/>
                    </svg>

                    <a href="{{ url('services') }}" class="">Services</a>

                    <svg width="4" height="7" viewBox="0 0 4 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.384033 0.320312L2.88403 3.32031L0.384033 6.32031" stroke="#FDB932"/>
                    </svg>

                    <a href="{{ url('services/'.$service->slug) }}" class="s-act-link">{{ $service->title }}</a>
                </div>
                <div class="psd-sl-category__side">
                    <h4>Related Services</h4>
                </div>
                <div class="psd-sl-category__rcon">
                   @if($related->isNotEmpty())
                        @foreach($related as $rel)
                        {{-- {{ route('services.show', $rel->id) }} --}}
                            <a href="{{url('services/'.$rel->slug)}}" class="psdslcr-box">
                                <div class="psdslcr-box__head">
                                    <div>
                                        {{ $rel->serviceCategory?->name ?? 'No Category' }}
                                    </div>

                                    <p>
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.38803 1.09688L6.12137 2.56354C6.22136 2.76771 6.48803 2.96354 6.71303 3.00104L8.0422 3.22187C8.8922 3.36354 9.0922 3.98021 8.4797 4.58854L7.44636 5.62187C7.27136 5.79687 7.17553 6.13437 7.2297 6.37604L7.52553 7.65521C7.75886 8.66771 7.22136 9.05937 6.32553 8.53021L5.0797 7.79271C4.8547 7.65938 4.48387 7.65938 4.2547 7.79271L3.00887 8.53021C2.1172 9.05937 1.57553 8.66354 1.80887 7.65521L2.1047 6.37604C2.15887 6.13437 2.06303 5.79687 1.88803 5.62187L0.854698 4.58854C0.246365 3.98021 0.442199 3.36354 1.2922 3.22187L2.62137 3.00104C2.8422 2.96354 3.10887 2.76771 3.20886 2.56354L3.9422 1.09688C4.3422 0.301042 4.9922 0.301042 5.38803 1.09688Z" fill="#FFBE42" stroke="#FFBE42" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        {{ $rel->rating }} <span>({{ $rel->reviews }} reviews)</span>
                                    </p>
                                </div>
                                <div class="psdslcr-box__text">
                                    <h3>{{ $rel->title }}</h3>
                                    <p>{{ Str::limit($rel->description, 60) }}</p>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="psdslcr-box-empty">
                            <p>No Related Services</p>
                        </div>
                    @endif

                </div>
                <hr>
                <a href="{{ url('provider-signup') }}" class="join-now-cta-sd">
                    <img src="{{ asset('images/cta-join.png') }}" alt="cta-image">
                </a>
            </div>
            <div class="psd-sl-sdetail">
                <div class="psd-sl-sdetail__img">
                    <img src="{{ asset($service->image ?? 'images/default_service_banner.png') }}"  alt="image-detail">
                </div>
                <div class="psd-sl-sdetail__info">
                    <div class="psd-sl-sdetaili-description">
                        @if ($service->category)
                            <p class="psd-sl-sdetaili-description__prt">{{ $service->category }}</p>
                        @endif
                        <h3>{{ $service->title }}</h3>
                        <br>

                        {{-- Content: Soon to be resolved --}}
                        {!! $service->content !!}

                        {{-- Comments --}}
                        @php
                            $ratings = collect($service->rating_comments ?? []);
                            $averageRating = $service->rating ?? 0;
                            $ratingCount = $service->reviews ?? 0;
                        @endphp

                        <div class="service-review-section">
                            <div class="service-review-section__head">
                                <div class="service-review-section__head-m">
                                    <p class="rate-til">Customer Reviews</p>
                                    <p>
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="service-review-section__head-m-s {{ $i <= round($averageRating) ? 'is-active' : '' }}">★</span>
                                        @endfor

                                        <strong>{{ number_format($averageRating, 1) }}/5</strong>
                                        <small>({{ $ratingCount }} {{ Str::plural('review', $ratingCount) }})</small>
                                    </p>
                                </div>
                            </div>

                            <div class="service-review-section__list">
                            @forelse($ratings as $rating)

                                    <div class="service-review-card">
                                        <div class="service-review-card__avatar">
                                            @if(!empty($rating->customer_image))
                                                <img src="{{ asset($rating->customer_image) }}" alt="{{ $rating->customer_name }}">
                                            @else
                                                <span>{{ $rating->customer_initials ?? 'C' }}</span>
                                            @endif
                                        </div>

                                        <div class="service-review-card__body">
                                            <div class="service-review-card__top">
                                                <div>
                                                    <h6>{{ $rating->customer_name ?? 'Customer' }}</h6>
                                                    <p>{{ $rating->customer_email ?? 'No email' }}</p>
                                                </div>

                                                <small>{{ $rating->date ?? '' }}</small>
                                            </div>

                                            <div class="service-review-card__stars">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <span class="{{ $i <= $rating->rating ? 'is-active' : '' }}">★</span>
                                                @endfor
                                            </div>

                                            @if(!empty($rating->comment))
                                                <p class="service-review-card__comment">
                                                    “{{ $rating->comment }}”
                                                </p>
                                            @else
                                                <p class="service-review-card__comment service-review-card__comment--empty">
                                                    No comment provided.
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="service-review-empty">
                                        <p>No customer reviews yet.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        @if($related->isNotEmpty())
                            <div class="psd-sl-sdetaili-relateds">
                                <h4>Related Services</h4>
                                
                                @foreach($related as $rel)
                                    <a href="{{ route('services.show', $rel->id) }}" class="psd-sl-sdetaili-relateds__bc">
                                        <div class="psd-sl-sdetaili-relateds__bc__head">
                                            <div>
                                                {{ $rel->serviceCategory?->name ?? 'No Category' }}
                                            </div>

                                            <p>
                                                <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M5.38803 1.09688L6.12137 2.56354C6.22136 2.76771 6.48803 2.96354 6.71303 3.00104L8.0422 3.22187C8.8922 3.36354 9.0922 3.98021 8.4797 4.58854L7.44636 5.62187C7.27136 5.79687 7.17553 6.13437 7.2297 6.37604L7.52553 7.65521C7.75886 8.66771 7.22136 9.05937 6.32553 8.53021L5.0797 7.79271C4.8547 7.65938 4.48387 7.65938 4.2547 7.79271L3.00887 8.53021C2.1172 9.05937 1.57553 8.66354 1.80887 7.65521L2.1047 6.37604C2.15887 6.13437 2.06303 5.79687 1.88803 5.62187L0.854698 4.58854C0.246365 3.98021 0.442199 3.36354 1.2922 3.22187L2.62137 3.00104C2.8422 2.96354 3.10887 2.76771 3.20886 2.56354L3.9422 1.09688C4.3422 0.301042 4.9922 0.301042 5.38803 1.09688Z" fill="#FFBE42" stroke="#FFBE42" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                {{ $rel->rating }} <span>({{ $rel->reviews }} reviews)</span>
                                            </p>
                                        </div>
                                        <div class="psd-sl-sdetaili-relateds__bc__text">
                                            <h3>{{ $rel->title }}</h3>
                                            <p>{{ Str::limit($rel->description, 60) }}</p>
                                        </div>
                                    </a>
                                @endforeach

                            </div>
                        @endif

                    </div>
                    <div class="psd-sl-sdetaili-details">
                        @guest
                            <a href="{{ url('login') }}" class="btn btn--tertiary-d">Book Now</a>
                        @endguest

                        @auth
                            @if(auth()->user()->isCustomer())
                                @php
                                    $customer = auth()->user()->customer;

                                    $hasIncompleteDetails =
                                        !$customer ||
                                        empty($customer->street_address) ||
                                        empty($customer->city) ||
                                        empty($customer->barangay) ||
                                        empty($customer->zipcode) ||
                                        empty($customer->phone_number);
                                @endphp

                                @if($service->has_existing_booking)
                                    <button type="button" class="btn btn--tertiary" disabled>
                                        Already Booked
                                    </button>
                                @elseif($hasIncompleteDetails)
                                    <button type="button" id="open-book-alert" class="btn btn--tertiary">
                                        Book Now
                                    </button>
                                @else
                                    <button id="open-book" class="btn btn--tertiary">Book Now</button>
                                @endif
                            @endif
                        @endauth
                        <div class="psd-sl-sdetaili-d-provider">
                            <div class="psd-sl-sdetaili-d-provider__con">
                                @php
                                    $fname = explode(' ', $service->provider_fname)[0] ?? '';
                                    $lname = explode(' ', $service->provider_lname)[0] ?? '';
                                    $profileImage = $service->provider_profile ?? null;
                                @endphp
                                <div style="position: relative; width: 50px; height: 50px; min-width: 50px; min-height: 50px; padding-top: 0 !important; flex: 0 0 50px;">
                                    @if ($profileImage)
                                        <img src="{{asset($profileImage)}}" alt="user_profile">
                                    @else
                                        <div style="background-color: #FDB932; display: flex; align-items: center; justify-content: center; object-position: center; object-fit: cover; border-radius: 12px; width: 50px; height: 50px; min-width: 50px; min-height: 50px; padding-top: 0 !important;">
                                            <p style="color: white; margin: 0 !important; font-size: 17px; letter-spacing: 0; line-height: 1; font-weight: 600; display: flex; align-items: center; justify-content: center; height: 100%; width: 100%;">{{ strtoupper(substr($fname, 0, 1) . substr($lname, 0, 1)) }}</p>
                                        </div>
                                    @endif
                                    @php
                                        $providerStatusColor = $service->provider_has_ongoing_today
                                            ? '#F59E0B'
                                            : ($service->provider_is_available_now ? '#22C55E' : '#EF4444');
                                        $providerStatusTitle = $service->provider_has_ongoing_today
                                            ? 'Provider has an ongoing schedule today'
                                            : ($service->provider_is_available_now ? 'Available now' : 'Currently unavailable');
                                    @endphp
                                    <span
                                        title="{{ $providerStatusTitle }}"
                                        aria-label="{{ $providerStatusTitle }}"
                                        style="position: absolute; top: -4px; right: -4px; width: 14px; height: 14px; border-radius: 999px; border: 2px solid #fff; background: {{ $providerStatusColor }}; box-shadow: 0 1px 4px rgba(0,0,0,.18);"
                                    ></span>
                                </div>
                                {{-- <img src="{{ asset('images/user.png') }}" alt=""> --}}
                                <div>
                                    <h4>{{ $service->provider_name }}</h4>
                                    <p>
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.38803 1.09688L6.12137 2.56354C6.22136 2.76771 6.48803 2.96354 6.71303 3.00104L8.0422 3.22187C8.8922 3.36354 9.0922 3.98021 8.4797 4.58854L7.44636 5.62187C7.27136 5.79687 7.17553 6.13437 7.2297 6.37604L7.52553 7.65521C7.75886 8.66771 7.22136 9.05937 6.32553 8.53021L5.0797 7.79271C4.8547 7.65938 4.48387 7.65938 4.2547 7.79271L3.00887 8.53021C2.1172 9.05937 1.57553 8.66354 1.80887 7.65521L2.1047 6.37604C2.15887 6.13437 2.06303 5.79687 1.88803 5.62187L0.854698 4.58854C0.246365 3.98021 0.442199 3.36354 1.2922 3.22187L2.62137 3.00104C2.8422 2.96354 3.10887 2.76771 3.20886 2.56354L3.9422 1.09688C4.3422 0.301042 4.9922 0.301042 5.38803 1.09688Z" fill="#FFBE42" stroke="#FFBE42" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        {{ number_format($service->provider_rating ?? 0, 1) }}
                                        <span>({{ $service->provider_reviews ?? 0 }} reviews)</span>
                                    </p>
                                </div>
                            </div>
                            {{-- svg --}}
                            <svg width="16" height="16" class="mb-1" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.00033 7.99967C9.84127 7.99967 11.3337 6.50729 11.3337 4.66634C11.3337 2.82539 9.84127 1.33301 8.00033 1.33301C6.15938 1.33301 4.66699 2.82539 4.66699 4.66634C4.66699 6.50729 6.15938 7.99967 8.00033 7.99967Z" stroke="#858688" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M13.7268 14.6667C13.7268 12.0867 11.1601 10 8.0001 10C4.8401 10 2.27344 12.0867 2.27344 14.6667" stroke="#858688" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="psd-sl-sdetaili-d-service-info">
                            <p class="psd-sl-sdetaili-d-service-info__prc">
                                {{ $service->pricing_type_label }}: <span>{{ $service->price_label }}</span>
                            </p>
                            <br>
                            <h4>More Details {{ $service->provider_name }}</h4>
                            <ul>
                                <li>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.83984 7.34663V10.66C2.83984 11.8733 2.83984 11.8733 3.98651 12.6466L7.13984 14.4666C7.61318 14.74 8.38651 14.74 8.85984 14.4666L12.0132 12.6466C13.1598 11.8733 13.1598 11.8733 13.1598 10.66V7.34663C13.1598 6.13329 13.1598 6.13329 12.0132 5.35996L8.85984 3.53996C8.38651 3.26663 7.61318 3.26663 7.13984 3.53996L3.98651 5.35996C2.83984 6.13329 2.83984 6.13329 2.83984 7.34663Z" stroke="#8F9296" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M11.6663 5.08634V3.33301C11.6663 1.99967 10.9997 1.33301 9.66634 1.33301H6.33301C4.99967 1.33301 4.33301 1.99967 4.33301 3.33301V5.03967" stroke="#8F9296" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M8.42018 7.32664L8.80018 7.91997C8.86018 8.01331 8.99351 8.10664 9.09351 8.13331L9.77351 8.30664C10.1935 8.41331 10.3068 8.77331 10.0335 9.10664L9.58685 9.64664C9.52018 9.73331 9.46685 9.88664 9.47351 9.99331L9.51351 10.6933C9.54018 11.1266 9.23351 11.3466 8.83351 11.1866L8.18018 10.9266C8.08018 10.8866 7.91351 10.8866 7.81351 10.9266L7.16018 11.1866C6.76018 11.3466 6.45351 11.12 6.48018 10.6933L6.52018 9.99331C6.52685 9.88664 6.47351 9.72664 6.40685 9.64664L5.96018 9.10664C5.68685 8.77331 5.80018 8.41331 6.22018 8.30664L6.90018 8.13331C7.00685 8.10664 7.14018 8.00664 7.19351 7.91997L7.57351 7.32664C7.81351 6.96664 8.18685 6.96664 8.42018 7.32664Z" stroke="#8F9296" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <p>Years of Experience: <span>{{ $service->provider_exp }}years</span></p>
                                </li>
                                <li>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.33301 5.99967V4.66634C1.33301 2.66634 2.66634 1.33301 4.66634 1.33301H11.333C13.333 1.33301 14.6663 2.66634 14.6663 4.66634V5.99967" stroke="#8F9296" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M1.33301 10V11.3333C1.33301 13.3333 2.66634 14.6667 4.66634 14.6667H11.333C13.333 14.6667 14.6663 13.3333 14.6663 11.3333V10" stroke="#8F9296" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M4.4668 6.17383L8.00013 8.2205L11.5068 6.18717" stroke="#8F9296" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M8 11.8472V8.21387" stroke="#8F9296" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M7.17348 4.19305L5.04015 5.37973C4.56015 5.6464 4.16016 6.31973 4.16016 6.87306V9.13307C4.16016 9.6864 4.55348 10.3597 5.04015 10.6264L7.17348 11.813C7.62682 12.0664 8.37349 12.0664 8.83349 11.813L10.9668 10.6264C11.4468 10.3597 11.8468 9.6864 11.8468 9.13307V6.87306C11.8468 6.31973 11.4535 5.6464 10.9668 5.37973L8.83349 4.19305C8.37349 3.93305 7.62682 3.93305 7.17348 4.19305Z" stroke="#8F9296" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <p>Specialization: {{ $service->specialization }}</p>
                                </li>   
                                <li>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.99992 8.95297C9.14867 8.95297 10.0799 8.02172 10.0799 6.87297C10.0799 5.72422 9.14867 4.79297 7.99992 4.79297C6.85117 4.79297 5.91992 5.72422 5.91992 6.87297C5.91992 8.02172 6.85117 8.95297 7.99992 8.95297Z" stroke="#8F9296" stroke-width="1.1"/>
                                        <path d="M2.41379 5.65968C3.72712 -0.113657 12.2805 -0.106991 13.5871 5.66634C14.3538 9.05301 12.2471 11.9197 10.4005 13.693C9.06046 14.9863 6.94046 14.9863 5.59379 13.693C3.75379 11.9197 1.64712 9.04634 2.41379 5.65968Z" stroke="#8F9296" stroke-width="1.1"/>
                                    </svg>
                                    <p>Area: {{ $service->provider_area }}</p>
                                </li>
                                <li>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8 8C9.84095 8 11.3333 6.50762 11.3333 4.66667C11.3333 2.82572 9.84095 1.33334 8 1.33334C6.15905 1.33334 4.66667 2.82572 4.66667 4.66667C4.66667 6.50762 6.15905 8 8 8Z" stroke="#8F9296" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M13.7267 14.6667C13.7267 12.0867 11.16 10 8 10C4.84 10 2.27333 12.0867 2.27333 14.6667" stroke="#8F9296" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <p>Gender: {{ $service->provider_gender }}</p>
                                </li>
                                <li>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.6204 4.50635L12.3738 13.5264C12.2138 14.1997 11.6138 14.6663 10.9204 14.6663H2.16041C1.15375 14.6663 0.433756 13.6796 0.733756 12.713L3.54042 3.69971C3.73375 3.07304 4.31376 2.63965 4.96709 2.63965H13.1671C13.8004 2.63965 14.3271 3.02632 14.5471 3.55965C14.6738 3.84632 14.7004 4.17301 14.6204 4.50635Z" stroke="#8F9296" stroke-width="1.1" stroke-miterlimit="10"/>
                                        <path d="M10.667 14.6667H13.8537C14.7137 14.6667 15.387 13.94 15.327 13.08L14.667 4" stroke="#8F9296" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M6.45312 4.25301L7.14646 1.37305" stroke="#8F9296" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M10.9199 4.2605L11.5466 1.36719" stroke="#8F9296" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M5.13379 8H10.4671" stroke="#8F9296" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M4.4668 10.667H9.80013" stroke="#8F9296" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <p>Availability: {{ $service->provider_availability }}</p>
                                </li>
                                <li>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.99967 12.1331C9.47243 12.1331 10.6663 10.9392 10.6663 9.46647C10.6663 7.99371 9.47243 6.7998 7.99967 6.7998C6.52692 6.7998 5.33301 7.99371 5.33301 9.46647C5.33301 10.9392 6.52692 12.1331 7.99967 12.1331Z" stroke="#8F9296" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M6.95996 9.53322L7.39329 9.96655C7.51996 10.0932 7.72663 10.0932 7.85329 9.97322L9.03996 8.87988" stroke="#8F9296" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M5.33289 14.6667H10.6662C13.3462 14.6667 13.8262 13.5933 13.9662 12.2867L14.4662 6.95333C14.6462 5.32667 14.1796 4 11.3329 4H4.66623C1.81956 4 1.35289 5.32667 1.53289 6.95333L2.03289 12.2867C2.17289 13.5933 2.65289 14.6667 5.33289 14.6667Z" stroke="#8F9296" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M5.33301 3.99967V3.46634C5.33301 2.28634 5.33301 1.33301 7.46634 1.33301H8.53301C10.6663 1.33301 10.6663 2.28634 10.6663 3.46634V3.99967" stroke="#8F9296" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14.4329 7.33301C13.2795 8.17301 11.9995 8.75967 10.6729 9.09301" stroke="#8F9296" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M1.74707 7.51367C2.8604 8.27367 4.07374 8.81367 5.33374 9.12034" stroke="#8F9296" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <p>All Job Completed: {{ $service->jobs }}</p>
                                </li>
                            </ul>
                            @if($service->provider_has_schedule_today && $service->provider_schedule_preview)
                                <div class="provider-schedule-summary">
                                    <div class="provider-schedule-summary__head">
                                        <h4>Provider Schedule</h4>
                                        <p class="provider-schedule-summary__estimate">
                                            Possible completion between <span>{{ $service->provider_completion_estimate }}</span>
                                        </p>
                                    </div>

                                    <div class="provider-schedule-summary__item">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                            <path d="M5.33289 14.6667H10.6662C13.3462 14.6667 13.8262 13.5933 13.9662 12.2867L14.4662 6.95333C14.6462 5.32667 14.1796 4 11.3329 4H4.66623C1.81956 4 1.35289 5.32667 1.53289 6.95333L2.03289 12.2867C2.17289 13.5933 2.65289 14.6667 5.33289 14.6667Z" stroke="#8F9296" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M5.33301 3.99967V3.46634C5.33301 2.28634 5.33301 1.33301 7.46634 1.33301H8.53301C10.6663 1.33301 10.6663 2.28634 10.6663 3.46634V3.99967" stroke="#8F9296" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M5.13379 8H10.4671" stroke="#8F9296" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M4.4668 10.667H9.80013" stroke="#8F9296" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <p>
                                            <strong>Date:</strong>
                                            {{ $service->provider_schedule_preview->date }}
                                            @if($service->provider_schedule_preview->time)
                                                - {{ $service->provider_schedule_preview->time }}
                                            @endif
                                            <span>{{ $service->provider_schedule_preview->status }}</span>
                                        </p>
                                    </div>

                                    <p class="provider-schedule-summary__note">
                                        This provider already has a schedule today. You can wait for the current schedule to finish or choose another available date.
                                    </p>
                                </div>
                            @endif
                            <hr>
                            <a href="{{ url('provider-signup') }}" class="psd-sl-sdetaili-d-service-info__cta">
                                <img src="{{ asset('images/cta-join.png') }}" alt="cta-image">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Modals --}}
        <div class="booking-modal">
            <div class="booking-con-main">
                <p class="booking-con-main__pre-title">{{ $service->category }}</p>
                <h2>{{ $service->title }}</h2>

                @php
                    $activeUserFname = '';
                    $activeUserLname = '';
                    $activeUserAddress = '';
                    $activeUserEmail = '';
                    $activeUserPhone = '';

                    if (auth()->check() && auth()->user()->isCustomer()) {
                        $activeCustomer = auth()->user()->customer;

                        if ($activeCustomer) {
                            $activeUserFname = $activeCustomer->first_name ?? '';
                            $activeUserLname = $activeCustomer->last_name ?? '';
                            $activeUserAddress = trim(
                                ($activeCustomer->street_address ?? '') . ', ' .
                                ($activeCustomer->barangay ?? '') . ', ' .
                                ($activeCustomer->city ?? ''),
                                ', '
                            );
                            $activeUserEmail = $activeCustomer->user->email ?? '';
                            $activeUserPhone = $activeCustomer->phone_number ?? '';
                        }
                    }
                @endphp
                <form action="{{ route('customer.book') }}" method="POST" id="bookingForm">
                    @csrf
                    <button type="button" id="toggleBookingDetails" class="booking-details-toggle" aria-expanded="false">
                        <span>Show booking details</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="sbf-field-group-con booking-customer-detail">
                        <div class="sbf-field-group">
                            <label for="fname">First Name <span>*</span></label>
                            <input type="text" name="fname" value="{{ $activeUserFname }}" required placeholder="Enter your first name...">
                        </div>
                        <div class="sbf-field-group">
                            <label for="lname">Last Name <span>*</span></label>
                            <input type="text" name="lname" value="{{ $activeUserLname }}" required placeholder="Enter your last name...">
                        </div>
                    </div>
                    <div class="sbf-field-group booking-customer-detail">
                        <label for="address">Complete Address <span>*</span></label>
                        <input type="text" name="address" value="{{ $activeUserAddress }}" required placeholder="Enter your address...">
                    </div>
                    <div class="sbf-field-group-con booking-customer-detail">
                        <div class="sbf-field-group">
                            <label for="email">Email <span>*</span></label>
                            <input type="text" name="email" value="{{ $activeUserEmail }}" required placeholder="Enter your first name...">
                        </div>
                        <div class="sbf-field-group">
                            <label for="number">Contact Number <span>*</span></label>
                            <input type="text" name="number" value="{{ $activeUserPhone }}" required placeholder="Enter your last name...">
                        </div>
                    </div>
                    <div class="sbf-field-group booking-customer-detail">
                        <label for="notes">Notes</label>
                        <textarea name="notes" id="notes" maxlength="200" rows="3" placeholder="Optional note for the provider...">{{ old('notes') }}</textarea>
                    </div>
                    <div class="booking-schedule-picker">
                        <div class="booking-schedule-picker__head">
                            <div>
                                <label>Preferred Schedule <span>*</span></label>
                                <strong id="selectedScheduleLabel">Select a date</strong>
                            </div>
                            <button type="button" id="resetSchedule" class="booking-schedule-picker__reset">Reset Schedule</button>
                        </div>

                        <div class="booking-schedule-picker__nav">
                            <button type="button" id="bookingCalendarPrev" aria-label="Previous month">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <span id="bookingCalendarMonth"></span>
                            <button type="button" id="bookingCalendarToday">Today</button>
                            <button type="button" id="bookingCalendarNext" aria-label="Next month">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>

                        <div class="booking-schedule-picker__weekdays">
                            <span>Sun</span>
                            <span>Mon</span>
                            <span>Tue</span>
                            <span>Wed</span>
                            <span>Thu</span>
                            <span>Fri</span>
                            <span>Sat</span>
                        </div>

                        <div id="bookingCalendarGrid" class="booking-schedule-picker__grid"></div>

                        <div id="bookingTimePanel" class="booking-schedule-picker__time" hidden>
                            <label for="bookingTimePicker">Time</label>
                            <input type="time" id="bookingTimePicker">
                        </div>

                        <input type="hidden" name="date" id="date">
                        <input type="hidden" name="time" id="time">
                    </div>
                    <input type="number" name="service_id" value="{{$service->id}}" hidden>
                    @guest
                        <a href="{{url('login')}}" class="glb-btn-a">Send Book Request</a>
                    @endguest
                    @auth
                        @if(auth()->user()->isCustomer())
                            <button class="glb-btn" id="open-confirm" type="button">Send Book Request</button>
                        @endif
                    @endauth
                </form>
            </div>
        </div>
        <div class="confirm-modal">
            <div class="confirm-modal__content">
                <svg width="58" height="58" viewBox="0 0 58 58" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M29.0003 21.7494V33.8328M29.0003 51.7403H14.3553C5.96945 51.7403 2.46529 45.7469 6.52529 38.4244L14.0653 24.8428L21.1703 12.0828C25.472 4.32527 32.5286 4.32527 36.8303 12.0828L43.9353 24.8669L51.4753 38.4486C55.5353 45.7711 52.007 51.7644 43.6453 51.7644H29.0003V51.7403Z" stroke="#FFBE42" stroke-width="2.65263" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M28.9873 41.084H29.0102" stroke="#FFBE42" stroke-width="2.65263" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <h3>Confirm Booking</h3>
                <p>
                    Once confirmed, cancellation is strictly prohibited
                    and may result in penalties.
                </p>

                <div class="confirm-actions">
                    <button id="confirm-booking" type="button" class="glb-btn">
                        Confirm
                    </button>
                    <button id="cancel-confirm" type="button" class="glb-btn btn--ses">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </main>

@endsection
@push('extrascripts')
{{-- For Booking Modal --}}
<script>

    $(document).ready(function () {
        const providerAvailability = @json($service->provider_availability_data);
        const providerBookedDates = @json($service->provider_booked_dates);
        const providerBookedSlots = @json($service->provider_booked_slots);
        const bookedDateSet = new Set(providerBookedDates);
        const dayKeys = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
        const today = new Date();
        let calendarCursor = new Date(today.getFullYear(), today.getMonth(), 1);

        function padDatePart(value) {
            return String(value).padStart(2, '0');
        }

        function toDateValue(date) {
            return `${date.getFullYear()}-${padDatePart(date.getMonth() + 1)}-${padDatePart(date.getDate())}`;
        }

        function currentTimeValue() {
            const now = new Date();

            return `${padDatePart(now.getHours())}:${padDatePart(now.getMinutes())}`;
        }

        function toMinutes(timeValue) {
            if (!timeValue) {
                return null;
            }

            const [hour, minute] = timeValue.split(':').map(Number);

            return (hour * 60) + minute;
        }

        function maxTimeValue(firstTime, secondTime) {
            if (!firstTime) {
                return secondTime || '';
            }

            if (!secondTime) {
                return firstTime;
            }

            return toMinutes(firstTime) >= toMinutes(secondTime) ? firstTime : secondTime;
        }

        function toReadableDate(dateValue) {
            if (!dateValue) {
                return 'Select a date';
            }

            return new Date(dateValue + 'T00:00:00').toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });
        }

        function toReadableTime(timeValue) {
            if (!timeValue) {
                return 'choose a time';
            }

            const [hour, minute] = timeValue.split(':');
            return new Date(2000, 0, 1, hour, minute).toLocaleTimeString('en-US', {
                hour: 'numeric',
                minute: '2-digit'
            });
        }

        function isPastDate(date) {
            const todayOnly = new Date(today.getFullYear(), today.getMonth(), today.getDate());
            return date < todayOnly;
        }

        function isTodayDateValue(dateValue) {
            return dateValue === toDateValue(new Date());
        }

        function hasValidTimeRemaining(dateValue) {
            if (!isTodayDateValue(dateValue)) {
                return true;
            }

            const nowTime = currentTimeValue();

            if (providerAvailability.end_time && nowTime >= providerAvailability.end_time) {
                return false;
            }

            return true;
        }

        function isPastSchedule(dateValue, timeValue) {
            if (!dateValue || !timeValue) {
                return false;
            }

            return new Date(`${dateValue}T${timeValue}`) < new Date();
        }

        function isProviderAvailableDate(date) {
            const availableDays = providerAvailability.days || dayKeys;
            return availableDays.includes(dayKeys[date.getDay()]);
        }

        function isProviderAvailableTime(timeValue) {
            if (!timeValue) {
                return false;
            }

            if (!providerAvailability.start_time || !providerAvailability.end_time) {
                return true;
            }

            return timeValue >= providerAvailability.start_time && timeValue < providerAvailability.end_time;
        }

        function updateScheduleLabel() {
            const selectedDate = $('#date').val();
            const selectedTime = $('#time').val();
            const label = selectedDate
                ? `${toReadableDate(selectedDate)} at ${toReadableTime(selectedTime)}`
                : 'Select a date';

            $('#selectedScheduleLabel').text(label);
        }

        function clearScheduleSelection() {
            $('#date').val('');
            $('#time').val('');
            $('#bookingTimePicker').val('');
            $('#bookingTimePanel').attr('hidden', true);
            updateScheduleLabel();
            renderBookingCalendar();
        }

        function selectScheduleDate(dateValue) {
            const minTime = isTodayDateValue(dateValue)
                ? maxTimeValue(providerAvailability.start_time || '', currentTimeValue())
                : (providerAvailability.start_time || '');
            const defaultTime = minTime;

            $('#date').val(dateValue);
            $('#time').val(defaultTime);
            $('#bookingTimePicker')
                .val(defaultTime)
                .attr('min', minTime || null)
                .attr('max', providerAvailability.end_time || null);
            $('#bookingTimePanel').removeAttr('hidden');
            updateScheduleLabel();
            renderBookingCalendar();
        }

        function renderBookingCalendar() {
            const monthStart = new Date(calendarCursor.getFullYear(), calendarCursor.getMonth(), 1);
            const calendarStart = new Date(monthStart);
            calendarStart.setDate(calendarStart.getDate() - calendarStart.getDay());

            $('#bookingCalendarMonth').text(monthStart.toLocaleDateString('en-US', {
                month: 'long',
                year: 'numeric'
            }));

            const selectedDate = $('#date').val();
            const cells = [];

            for (let index = 0; index < 42; index++) {
                const day = new Date(calendarStart);
                day.setDate(calendarStart.getDate() + index);

                const dateValue = toDateValue(day);
                const isCurrentMonth = day.getMonth() === calendarCursor.getMonth();
                const isToday = dateValue === toDateValue(today);
                const isSelected = dateValue === selectedDate;
                const isBooked = bookedDateSet.has(dateValue);
                const isUnavailable = isPastDate(day) || !isProviderAvailableDate(day) || !hasValidTimeRemaining(dateValue);
                const isDisabled = isBooked || isUnavailable;
                const classes = [
                    'booking-schedule-picker__day',
                    !isCurrentMonth ? 'is-muted' : '',
                    isToday ? 'is-today' : '',
                    isSelected ? 'is-selected' : '',
                    isBooked ? 'is-booked' : '',
                    isUnavailable ? 'is-unavailable' : '',
                    isDisabled ? 'is-disabled' : ''
                ].filter(Boolean).join(' ');

                cells.push(`
                    <button type="button" class="${classes}" data-date="${dateValue}" ${isDisabled ? 'disabled' : ''}>
                        <span>${day.getDate()}</span>
                        ${isBooked ? '<i aria-label="Booked"></i>' : ''}
                    </button>
                `);
            }

            $('#bookingCalendarGrid').html(cells.join(''));
        }

        /* ------------------------
        OPEN BOOKING MODAL
        ------------------------- */
        $('#open-book').on('click', function () {
            renderBookingCalendar();
            $('.booking-modal').fadeIn(200);
        });

        $('#bookingCalendarPrev').on('click', function () {
            calendarCursor = new Date(calendarCursor.getFullYear(), calendarCursor.getMonth() - 1, 1);
            renderBookingCalendar();
        });

        $('#bookingCalendarNext').on('click', function () {
            calendarCursor = new Date(calendarCursor.getFullYear(), calendarCursor.getMonth() + 1, 1);
            renderBookingCalendar();
        });

        $('#bookingCalendarToday').on('click', function () {
            calendarCursor = new Date(today.getFullYear(), today.getMonth(), 1);
            renderBookingCalendar();
        });

        $('#bookingCalendarGrid').on('click', '.booking-schedule-picker__day:not(:disabled)', function () {
            selectScheduleDate($(this).data('date'));
        });

        $('#bookingTimePicker').on('change', function () {
            $('#time').val($(this).val());
            updateScheduleLabel();
        });

        $('#resetSchedule').on('click', function () {
            clearScheduleSelection();
        });

        $('#toggleBookingDetails').on('click', function () {
            const form = $('#bookingForm');
            const isOpen = form.toggleClass('is-details-open').hasClass('is-details-open');

            $(this).attr('aria-expanded', isOpen ? 'true' : 'false');
            $(this).find('span').text(isOpen ? 'Hide booking details' : 'Show booking details');
        });

        /* ------------------------
        OPEN CONFIRM MODAL
        ------------------------- */
        $('#open-confirm').on('click', function () {

            // optional: simple form validation
            if (!$('#bookingForm')[0].checkValidity()) {
                $('#bookingForm')[0].reportValidity();
                return;
            }

            const selectedDate = $('#date').val();
            const selectedTime = $('#time').val();

            if (!selectedDate || !selectedTime) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Select Schedule',
                    text: 'Please select an available date and time before sending your booking request.',
                    confirmButtonColor: '#FDB932'
                });
                return;
            }

            const selectedDateObject = new Date(selectedDate + 'T00:00:00');

            if (isPastSchedule(selectedDate, selectedTime)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Schedule',
                    text: 'Please choose a future time for today before sending your booking request.',
                    confirmButtonColor: '#FDB932'
                });
                return;
            }

            if (!isProviderAvailableDate(selectedDateObject) || !isProviderAvailableTime(selectedTime)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Provider Unavailable',
                    text: 'This provider is not available at the selected time. Please choose a time within their working hours.',
                    confirmButtonColor: '#FDB932'
                });
                return;
            }

            const isSlotBooked = bookedDateSet.has(selectedDate) || providerBookedSlots.some(function (slot) {
                return slot.date === selectedDate;
            });

            if (isSlotBooked) {
                Swal.fire({
                    icon: 'error',
                    title: 'Schedule Unavailable',
                    text: 'This schedule is already booked. Please choose another date.',
                    confirmButtonColor: '#FDB932'
                });
                return;
            }

            $('.booking-modal').hide();
            $('.confirm-modal').fadeIn(200);
        });

        /* ------------------------
        CONFIRM BOOKING
        ------------------------- */
        $('#confirm-booking').on('click', function () {

            // submit form via normal POST
            $('#bookingForm').submit();

            // OR AJAX submit (optional)
            // $.post('/booking', $('#bookingForm').serialize());

        });

        /* ------------------------
        CANCEL CONFIRMATION
        ------------------------- */
        $('#cancel-confirm').on('click', function () {
            $('.confirm-modal').hide();
            $('.booking-modal').fadeIn(200);
        });

        /* ------------------------
        CLICK OUTSIDE CLOSE
        ------------------------- */
        $('.booking-modal, .confirm-modal').on('click', function (e) {
            if ($(e.target).is(this)) {
                $(this).fadeOut(200);
            }
        });

    });

</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alertButton = document.getElementById('open-book-alert');

        if (alertButton) {
            alertButton.addEventListener('click', function () {
                Swal.fire({
                    icon: 'warning',
                    title: 'Incomplete Details',
                    text: 'Please complete your details first before booking.',
                    confirmButtonText: 'Go to Profile',
                    showCancelButton: true,
                    confirmButtonColor: '#FFBE42',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('customer.setting') }}";
                    }
                });
            });
        }
    });
</script>
@endpush
