@extends('admin.layouts.auth')

@section('title', 'Customer Requests - Servease')

@push('extrastylesheets')
    <style>
        .cr-request-modal {
            position: fixed;
            inset: 0;
            width: 100vw;
            min-height: 100vh;
            z-index: 1050;
            display: none;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            padding: 28px 18px;
            background: rgba(17, 24, 39, .42);
        }

        .cr-request-modal.is-open {
            display: flex !important;
            justify-content: center;
            align-items: center;
        }

        .cr-request-modal__panel {

            width: min(680px, 100%);
            max-height: calc(100vh - 56px);
            overflow-y: auto;
            border-radius: 8px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 22px 55px rgba(15, 23, 42, .22);
        }

        .cr-request-modal__head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            border-bottom: 1px solid #EEF0F3;
            background: #fff;
            padding: 18px 20px 14px;
        }

        .cr-request-modal__head h2 {
            margin: 0;
            color: #171515;
            font-size: 20px !important;
            line-height: 1.2;
            font-weight: 800;
        }

        .cr-request-modal__head p {
            margin: 5px 0 0;
            color: #667085;
            font-size: 12px;
            line-height: 1.45;
        }

        .cr-request-modal__close {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border: 0;
            border-radius: 50%;
            background: transparent;
            color: #111827;
            font-size: 28px;
            line-height: 1;
            cursor: pointer;
            transition: background .18s ease, color .18s ease;
        }

        .cr-request-modal__close:hover,
        .cr-request-modal__close:focus {
            background: #F2F4F7;
            color: #000;
            outline: none;
        }

        .cr-request-form {
            display: grid;
            gap: 13px;
            padding: 18px 20px 20px;
        }

        .cr-request-form__row {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .cr-request-field {
            display: grid;
            gap: 6px;
            min-width: 0;
        }

        .cr-request-field label {
            margin: 0;
            color: #344054;
            font-size: 12px;
            font-weight: 700;
        }

        .cr-request-field input,
        .cr-request-field textarea {
            width: 100%;
            border: 1px solid #D0D5DD;
            border-radius: 6px;
            background: #fff;
            padding: 9px 10px;
            color: #171515;
            font-size: 13px;
            outline: none;
        }

        .cr-request-field textarea {
            min-height: 90px;
            resize: vertical;
        }

        .cr-request-field small {
            color: #dc2626;
            font-size: 11px;
        }

        .cr-request-modal__actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            border-top: 1px solid #EEF0F3;
            padding-top: 14px;
        }

        .cr-request-modal__cancel,
        .cr-request-modal__submit {
            min-height: 38px;
            border-radius: 6px;
            padding: 0 15px;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;
        }

        .cr-request-modal__cancel {
            border: 1px solid #D0D5DD;
            background: #fff;
            color: #344054;
        }

        .cr-request-modal__submit {
            border: 0;
            background: #FFBE42;
            color: #171515;
        }

        .cr-request-modal .filepond--root {
            margin-bottom: 0;
            font-family: inherit;
        }

        .cr-request-modal .filepond--panel-root {
            border: 1.5px dashed #D0D5DD;
            background: #fff !important;
        }

        .cr-request-modal .filepond--drop-label {
            color: #667085;
            font-size: 12px;
        }

        @media (max-width: 720px) {
            .cr-request-form__row {
                grid-template-columns: 1fr;
            }

            .cr-request-modal__panel {
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')
    @include('admin.layouts.header')

    <main class="main-dash-uix dash-sp page--customer-request-dashboard">
        <div class="cr-dashboard">
            <div class="cr-dashboard__note">
                <p>Manage your Request today!</p>
            </div>

            <div class="cr-dashboard__layout">
                <aside class="cr-dashboard__side">
                    <a href="#" class="cr-dashboard__btn" id="openCustomerRequestModal">
                        <div>Add New Request</div>
                        <div>+</div>
                    </a>

                    <div class="cr-dashboard__stats">
                        <div class="cr-stat-card">
                            <div>
                                <span>Total Request</span>
                                <strong>{{ number_format($requestStats['total']) }}</strong>
                            </div>

                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M3.3335 3.33301H12.6668V12.6663H3.3335V3.33301Z" stroke="#FDB932" stroke-width="1.2"/>
                                <path d="M5.6665 5.66699H10.3332" stroke="#FDB932" stroke-width="1.2" stroke-linecap="round"/>
                            </svg>
                        </div>

                        <div class="cr-stat-card">
                            <div>
                                <span>Open</span>
                                <strong>{{ number_format($requestStats['open']) }}</strong>
                            </div>

                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M4 2.66699H12V13.3337H4V2.66699Z" stroke="#FDB932" stroke-width="1.2"/>
                                <path d="M6 6H10" stroke="#FDB932" stroke-width="1.2" stroke-linecap="round"/>
                            </svg>
                        </div>

                        <div class="cr-stat-card">
                            <div>
                                <span>Accepted</span>
                                <strong>{{ number_format($requestStats['accepted']) }}</strong>
                            </div>

                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M3.3335 3.33301H12.6668V12.6663H3.3335V3.33301Z" stroke="#FDB932" stroke-width="1.2"/>
                                <path d="M5.3335 8L7.3335 10L10.6668 6.33301" stroke="#FDB932" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>

                        <div class="cr-stat-card">
                            <div>
                                <span>Completed</span>
                                <strong>{{ number_format($requestStats['completed']) }}</strong>
                            </div>

                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M4 2.66699H12V13.3337H4V2.66699Z" stroke="#FDB932" stroke-width="1.2"/>
                                <path d="M5.3335 8L7.3335 10L10.6668 6.33301" stroke="#FDB932" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>

                        <div class="cr-stat-card">
                            <div>
                                <span>Total Cancel</span>
                                <strong>{{ number_format($requestStats['cancelled']) }}</strong>
                            </div>

                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M3.3335 3.33301H12.6668V12.6663H3.3335V3.33301Z" stroke="#EF4444" stroke-width="1.2"/>
                                <path d="M5.6665 5.66699L10.3332 10.3337M10.3332 5.66699L5.6665 10.3337" stroke="#EF4444" stroke-width="1.2" stroke-linecap="round"/>
                            </svg>
                        </div>
                    </div>
                </aside>

                <section class="cr-dashboard__main">
                    <div class="cr-dashboard__head">
                        <div>
                            <h1>My Requests</h1>
                            <p>Track applicants, accepted providers, and completed custom work.</p>
                        </div>

                        <div class="cr-dashboard__filter">
                            <select name="status">
                                <option value="" {{ $selectedStatus === '' ? 'selected' : '' }}>All Status</option>
                                <option value="open" {{ $selectedStatus === 'open' ? 'selected' : '' }}>Open</option>
                                <option value="accepted" {{ $selectedStatus === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="completed" {{ $selectedStatus === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $selectedStatus === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>

                            <svg width="7" height="4" viewBox="0 0 7 4" fill="none">
                                <path d="M0.5 0.5L3.5 3.5L6.5 0.5" stroke="#282828" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>

                    <div class="cr-request-grid">
                        @forelse($requests as $request)
                            @php
                                $applicationCount = $request->applications->count();

                                $acceptedProviderName = $request->acceptedProvider
                                    ? trim(($request->acceptedProvider->first_name ?? '') . ' ' . ($request->acceptedProvider->last_name ?? ''))
                                    : null;

                                $acceptedProviderName = $acceptedProviderName ?: 'Dawn Izach';

                                $isAccepted = $request->status === 'accepted';
                                $isCompleted = $request->status === 'completed';
                                $isCancelled = $request->status === 'cancelled';
                                $isOpen = $request->status === 'open';
                                $isClosed = $isCompleted || $isCancelled || $request->status === 'closed';
                                $detailModalId = 'customerRequestDetailModal' . $request->id;
                                $editModalId = 'customerRequestEditModal' . $request->id;
                                $profileName = trim(($request->customer->first_name ?? '') . ' ' . ($request->customer->last_name ?? ''));
                                $customerName = $request->contact_name ?: ($profileName ?: 'Customer');
                                $customerEmail = $request->contact_email ?: ($request->customer->user->email ?? 'Email not provided');
                                $customerPhone = $request->contact_phone ?: ($request->customer->phone_number ?? 'Phone not provided');
                                $customerAddress = $request->contact_address ?: 'Address not provided';
                                $preferredDate = $request->preferred_date ? $request->preferred_date->format('M d, Y') : null;
                                $preferredTime = $request->preferred_time ? $request->preferred_time->format('g:i A') : null;
                                $preferredSchedule = trim(implode(' ', array_filter([$preferredDate, $preferredTime]))) ?: 'Not specified';
                            @endphp

                            <article class="cr-request-card {{ $isClosed ? 'cr-request-card--disabled' : '' }}">
                                <div class="cr-request-card__media">
                                    <img
                                        src="{{ $request->image_path ? asset($request->image_path) : asset('images/serv-bg.png') }}"
                                        alt="{{ $request->title }}"
                                    >

                                    <span>{{ $request->service_type ?: 'Service Type' }}</span>
                                </div>

                                <div class="cr-request-card__body">
                                    <h2>{{ $request->title ?: 'Residential Pipe Repair Service' }}</h2>

                                    <p>
                                        {{ \Illuminate\Support\Str::limit($request->description ?: 'Available at any hour to stop major leaks and repair burst pipes before they worsen.', 92) }}
                                    </p>

                                    <div class="cr-request-card__meta">
                                        <div>
                                            <span>Posted</span>
                                            <strong>{{ $request->created_at?->format('M d') ?: 'Jun 27' }}</strong>
                                        </div>

                                        <div>
                                            <span>Budget</span>
                                            <strong>{{ $request->fixed_price_label ?: '₱ 1,200.00' }}</strong>
                                        </div>

                                        <div class="{{ $isAccepted ? 'is-accepted' : '' }}">
                                            <span>{{ $isAccepted ? '' : 'Applications' }}</span>
                                            <strong>{{ $isAccepted ? 'Accepted' : $applicationCount }}</strong>
                                        </div>
                                    </div>

                                    @if($isAccepted)
                                        <div class="cr-request-card__actions cr-request-card__actions--accepted">
                                            <button type="button" class="cr-btn cr-btn--provider" data-open-request-detail="{{ $detailModalId }}">
                                                Provider: {{ $acceptedProviderName }}

                                                <svg width="11" height="8" viewBox="0 0 11 8" fill="none">
                                                    <path d="M6.5 1L9.5 4L6.5 7" stroke="#FDB932" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M1 4H9" stroke="#FDB932" stroke-linecap="round"/>
                                                </svg>
                                            </button>

                                        </div>
                                    @elseif($isOpen)
                                        <div class="cr-request-card__actions cr-request-card__actions--open">
                                            <button type="button" class="cr-btn cr-btn--view" data-open-request-detail="{{ $detailModalId }}">
                                                View Details
                                            </button>

                                            <button type="button" class="cr-btn cr-btn--edit" data-open-request-edit="{{ $editModalId }}" title="Edit Request" aria-label="Edit Request">
                                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                    <path d="M4 20H8.5L19.25 9.25C20.2165 8.2835 20.2165 6.7165 19.25 5.75L18.25 4.75C17.2835 3.7835 15.7165 3.7835 14.75 4.75L4 15.5V20Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                                                    <path d="M13.5 6L18 10.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                </svg>
                                            </button>

                                            <form method="POST" action="{{ route('customer.requests.destroy', $request) }}" class="js-customer-request-delete">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="cr-btn cr-btn--close" title="Delete Request">
                                                    &times;
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($isCompleted)
                                        <div class="cr-request-card__actions cr-request-card__actions--closed">
                                            <button type="button" class="cr-btn cr-btn--completed" style="cursor: default">
                                                Completed
                                            </button>

                                            <button type="button" class="cr-btn cr-btn--history" data-open-request-detail="{{ $detailModalId }}" title="View Details" aria-label="View request details">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                    <path d="M2.5 12C4.7 7.8 8 5.75 12 5.75C16 5.75 19.3 7.8 21.5 12C19.3 16.2 16 18.25 12 18.25C8 18.25 4.7 16.2 2.5 12Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                                    <path d="M12 14.75C13.5188 14.75 14.75 13.5188 14.75 12C14.75 10.4812 13.5188 9.25 12 9.25C10.4812 9.25 9.25 10.4812 9.25 12C9.25 13.5188 10.4812 14.75 12 14.75Z" stroke="currentColor" stroke-width="1.8"/>
                                                </svg>
                                            </button>
                                        </div>
                                    @elseif($isCancelled)
                                        <div class="cr-request-card__actions cr-request-card__actions--closed">
                                            <button type="button" class="cr-btn cr-btn--request-close">
                                                Cancelled
                                            </button>

                                            <button type="button" class="cr-btn cr-btn--history" data-open-request-detail="{{ $detailModalId }}" title="View Details" aria-label="View request details">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                    <path d="M2.5 12C4.7 7.8 8 5.75 12 5.75C16 5.75 19.3 7.8 21.5 12C19.3 16.2 16 18.25 12 18.25C8 18.25 4.7 16.2 2.5 12Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                                    <path d="M12 14.75C13.5188 14.75 14.75 13.5188 14.75 12C14.75 10.4812 13.5188 9.25 12 9.25C10.4812 9.25 9.25 10.4812 9.25 12C9.25 13.5188 10.4812 14.75 12 14.75Z" stroke="currentColor" stroke-width="1.8"/>
                                                </svg>
                                            </button>
                                        </div>
                                    @else
                                        <div class="cr-request-card__actions cr-request-card__actions--closed">
                                            <button type="button" class="cr-btn cr-btn--request-close">
                                                Request Close
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </article>

                            <div class="cr-detail-modal" id="{{ $detailModalId }}" aria-hidden="true">
                                <div class="cr-detail-modal__panel" role="dialog" aria-modal="true" aria-labelledby="{{ $detailModalId }}Title">
                                    <button type="button" class="cr-detail-modal__close" data-close-request-detail aria-label="Close">&times;</button>

                                    <div class="cr-detail-modal__summary">
                                        <h2 id="{{ $detailModalId }}Title">{{ $request->title ?: 'Residential Pipe Repair Service' }}</h2>
                                        <p>{{ \Illuminate\Support\Str::limit($request->description ?: 'Available at any hour to stop major leaks and repair burst pipes before they worsen.', 110) }}</p>

                                        <div class="cr-detail-modal__media">
                                            <img
                                                src="{{ $request->image_path ? asset($request->image_path) : asset('images/serv-bg.png') }}"
                                                alt="{{ $request->title }}"
                                            >
                                            <span>{{ $request->service_type ?: 'Service Type' }}</span>
                                        </div>

                                        <div class="cr-detail-modal__meta">
                                            <div>
                                                <span>Posted</span>
                                                <strong>{{ $request->created_at?->format('M d') ?: 'Jun 27' }}</strong>
                                            </div>
                                            <div>
                                                <span>Budget</span>
                                                <strong>{{ $request->fixed_price_label ?: '₱ 1,200.00' }}</strong>
                                            </div>
                                            <div>
                                                <span>Applications</span>
                                                <strong>{{ $applicationCount }}</strong>
                                            </div>
                                        </div>

                                        <div class="cr-detail-modal__info">
                                            <p>Customer: {{ $customerName }}</p>
                                            <p>{{ $customerEmail }}</p>
                                            <p>{{ $customerPhone }}</p>
                                            <p>Address: {{ $customerAddress }}</p>
                                            <p>Preferred: {{ $preferredSchedule }}</p>
                                        </div>
                                    </div>

                                    <div class="cr-detail-modal__applications">
                                        @if(($isAccepted || $isCompleted || $isCancelled) && $request->acceptedProvider)
                                            @php
                                                $provider = $request->acceptedProvider;
                                                $acceptedApplication = $request->applications->firstWhere('id', $request->accepted_application_id);
                                                $providerName = trim(($provider->first_name ?? '') . ' ' . ($provider->last_name ?? '')) ?: 'Provider';
                                                $providerAddress = trim(implode(', ', array_filter([
                                                    $provider->home_address ?? null,
                                                    $provider->barangay ?? null,
                                                    $provider->city ?? null,
                                                ]))) ?: 'Address not provided';
                                                $providerEmail = $provider->user->email ?? 'Email not provided';
                                                $providerPhone = $provider->phone_number ?? 'Phone not provided';
                                                $completedJobs = $provider->completed_customer_requests_count ?? 0;
                                                $historyLabel = $isCompleted ? 'Completed' : ($isCancelled ? 'Cancelled' : 'Accepted');
                                                $historyDate = $isCompleted
                                                    ? $request->completed_at?->format('M d, Y g:i A')
                                                    : ($isCancelled ? $request->updated_at?->format('M d, Y g:i A') : $request->accepted_at?->format('M d, Y g:i A'));
                                            @endphp

                                            <h3>{{ $isAccepted ? 'Provider Accepted' : 'Request History' }}</h3>

                                            <article class="cr-application-card cr-application-card--accepted">
                                                <img src="{{ $provider->profile_image ? asset($provider->profile_image) : asset('images/user-1.png') }}" alt="{{ $providerName }}">

                                                <div>
                                                    <h4>{{ $providerName }}</h4>
                                                    <p>{{ $providerEmail }} <span>{{ $providerPhone }}</span></p>
                                                    <p>Address: {{ $providerAddress }}</p>
                                                    <p>Job Done: {{ number_format($completedJobs) }}</p>
                                                    @if($acceptedApplication?->notes)
                                                        <p>Notes: {{ $acceptedApplication->notes }}</p>
                                                    @endif
                                                </div>
                                            </article>

                                            <div class="cr-detail-modal__accepted-note">
                                                @if($isAccepted)
                                                    <p><strong>Need more details?</strong> Contact your provider directly for any questions regarding this request. Please answer any calls from your provider, as they may need to confirm important service details.</p>
                                                @else
                                                    <p><strong>Status:</strong> {{ $historyLabel }}{{ $historyDate ? ' on ' . $historyDate : '' }}. This history keeps the accepted provider and request details for your records.</p>
                                                @endif
                                            </div>

                                            @if($isAccepted)
                                                <div class="cr-detail-modal__actions">
                                                    <form method="POST" action="{{ route('customer.requests.cancel', $request) }}" class="js-customer-request-cancel">
                                                        @csrf
                                                        <button type="submit" class="cr-detail-modal__cancel">Cancel Request</button>
                                                    </form>

                                                    <form method="POST" action="{{ route('customer.requests.complete', $request) }}">
                                                        @csrf
                                                        <button type="submit" class="cr-detail-modal__complete">Mark Complete</button>
                                                    </form>
                                                </div>
                                            @endif
                                        @else
                                            <h3>Provider Applications</h3>

                                            @forelse($request->applications as $application)
                                                @php
                                                    $provider = $application->provider;
                                                    $providerName = trim(($provider->first_name ?? '') . ' ' . ($provider->last_name ?? '')) ?: 'Provider';
                                                    $providerAddress = trim(implode(', ', array_filter([
                                                        $provider->home_address ?? null,
                                                        $provider->barangay ?? null,
                                                        $provider->city ?? null,
                                                    ]))) ?: 'Address not provided';
                                                    $providerEmail = $provider->user->email ?? 'Email not provided';
                                                    $providerPhone = $provider->phone_number ?? 'Phone not provided';
                                                    $completedJobs = $provider->completed_customer_requests_count ?? 0;
                                                @endphp

                                                <article class="cr-application-card">
                                                    <img src="{{ $provider->profile_image ? asset($provider->profile_image) : asset('images/user-1.png') }}" alt="{{ $providerName }}">

                                                    <div>
                                                        <h4>{{ $providerName }}</h4>
                                                        <p>{{ $providerEmail }} <span>{{ $providerPhone }}</span></p>
                                                        <p>Address: {{ $providerAddress }}</p>
                                                        <p>Job Done: {{ number_format($completedJobs) }}</p>
                                                        @if($application->notes)
                                                            <p>Notes: {{ $application->notes }}</p>
                                                        @endif
                                                    </div>

                                                    @if($isOpen && $application->status === 'pending')
                                                        <form method="POST" action="{{ route('customer.requests.applications.accept', [$request, $application]) }}">
                                                            @csrf
                                                            <button type="submit">Accept Provider</button>
                                                        </form>
                                                    @else
                                                        <span>{{ ucfirst($application->status) }}</span>
                                                    @endif
                                                </article>
                                            @empty
                                                <div class="cr-detail-modal__empty">No provider applications yet.</div>
                                            @endforelse
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if($isOpen)
                                <div class="cr-request-modal cr-edit-request-modal" id="{{ $editModalId }}" aria-hidden="true">
                                    <div class="cr-request-modal__panel" role="dialog" aria-modal="true" aria-labelledby="{{ $editModalId }}Title">
                                        <div class="cr-request-modal__head">
                                            <div>
                                                <h2 id="{{ $editModalId }}Title">Edit Request</h2>
                                                <p>Update this customer request while it is still open.</p>
                                            </div>

                                            <button type="button" class="cr-request-modal__close" data-close-request-edit aria-label="Close">&times;</button>
                                        </div>

                                        <form method="POST" action="{{ route('customer.requests.update', $request) }}" enctype="multipart/form-data" class="cr-request-form">
                                            @csrf
                                            @method('PUT')

                                            <div class="cr-request-field">
                                                <label>Request Title</label>
                                                <input type="text" name="title" value="{{ old('title', $request->title) }}" required maxlength="255" data-one-space autocomplete="off">
                                            </div>

                                            <div class="cr-request-form__row">
                                                <div class="cr-request-field">
                                                    <label>Service Type</label>
                                                    <input type="text" name="service_type" value="{{ old('service_type', $request->service_type) }}" required maxlength="100" data-one-space autocomplete="off">
                                                </div>

                                                <div class="cr-request-field">
                                                    <label>Fixed Price</label>
                                                    <input type="number" name="fixed_price" value="{{ old('fixed_price', $request->fixed_price) }}" min="100" max="100000" step="0.01" data-no-space data-price-limit="100000" inputmode="decimal" required>
                                                </div>
                                            </div>

                                            <div class="cr-request-form__row">
                                                <div class="cr-request-field">
                                                    <label>Preferred Date</label>
                                                    <input type="date" name="preferred_date" value="{{ old('preferred_date', $request->preferred_date?->format('Y-m-d')) }}" min="{{ now()->toDateString() }}">
                                                </div>

                                                <div class="cr-request-field">
                                                    <label>Preferred Time</label>
                                                    <input type="time" name="preferred_time" value="{{ old('preferred_time', $request->preferred_time?->format('H:i')) }}">
                                                </div>
                                            </div>

                                            <div class="cr-request-field">
                                                <label>Description</label>
                                                <textarea name="description" required maxlength="2000" data-one-space>{{ old('description', $request->description) }}</textarea>
                                            </div>

                                            <div class="cr-request-field">
                                                <label>Image</label>
                                                <input type="hidden" name="remove_image" class="js-request-remove-image" value="0">
                                                <input
                                                    type="file"
                                                    name="image"
                                                    id="customerRequestEditImage{{ $request->id }}"
                                                    class="js-customer-request-edit-image"
                                                    accept="image/*"
                                                    data-existing-image="{{ $request->image_path ? asset($request->image_path) : '' }}"
                                                >
                                            </div>

                                            <div class="cr-request-form__row">
                                                <div class="cr-request-field">
                                                    <label>Contact Name</label>
                                                    <input type="text" name="contact_name" value="{{ old('contact_name', $request->contact_name) }}" required maxlength="255" data-one-space autocomplete="name">
                                                </div>

                                                <div class="cr-request-field">
                                                    <label>Contact Phone</label>
                                                    <input type="text" name="contact_phone" value="{{ old('contact_phone', $request->contact_phone) }}" required maxlength="50" data-no-space inputmode="tel" autocomplete="tel">
                                                </div>
                                            </div>

                                            <div class="cr-request-field">
                                                <label>Contact Email</label>
                                                <input type="email" name="contact_email" value="{{ old('contact_email', $request->contact_email) }}" required maxlength="255" data-no-space inputmode="email" autocomplete="email">
                                            </div>

                                            <div class="cr-request-field">
                                                <label>Contact Address</label>
                                                <textarea name="contact_address" required maxlength="1000" data-one-space>{{ old('contact_address', $request->contact_address) }}</textarea>
                                            </div>

                                            <div class="cr-request-modal__actions">
                                                <button type="button" class="cr-request-modal__cancel" data-close-request-edit>Cancel</button>
                                                <button type="submit" class="cr-request-modal__submit">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <article class="cr-empty">
                                <h3>No customer requests found</h3>
                                <p>Create a new request or change the status filter.</p>
                            </article>
                        @endforelse
                    </div>
                </section>
            </div>
        </div>
    </main>

    <div class="cr-request-modal" id="customerRequestModal" aria-hidden="true">
        <div class="cr-request-modal__panel" role="dialog" aria-modal="true" aria-labelledby="customerRequestModalTitle">
            <div class="cr-request-modal__head">
                <div>
                    <h2 id="customerRequestModalTitle">Add New Request</h2>
                    <p>Create a custom request for providers to review and apply.</p>
                </div>

                <button type="button" class="cr-request-modal__close" data-close-customer-request-modal aria-label="Close">&times;</button>
            </div>

            <form method="POST" action="{{ route('customer.requests.store') }}" enctype="multipart/form-data" class="cr-request-form">
                @csrf

                <div class="cr-request-field">
                    <label>Request Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" required maxlength="255" data-one-space autocomplete="off" placeholder="Example: TV not working">
                    @error('title') <small>{{ $message }}</small> @enderror
                </div>

                <div class="cr-request-form__row">
                    <div class="cr-request-field">
                        <label>Service Type</label>
                        <input type="text" name="service_type" value="{{ old('service_type') }}" required maxlength="100" data-one-space autocomplete="off" placeholder="Appliance repair">
                        @error('service_type') <small>{{ $message }}</small> @enderror
                    </div>

                    <div class="cr-request-field">
                        <label>Fixed Price</label>
                        <input type="number" name="fixed_price" value="{{ old('fixed_price') }}" min="100" max="100000" step="0.01" data-no-space data-price-limit="100000" inputmode="decimal" required placeholder="100.00">
                        @error('fixed_price') <small>{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="cr-request-form__row">
                    <div class="cr-request-field">
                        <label>Preferred Date</label>
                        <input type="date" name="preferred_date" value="{{ old('preferred_date') }}" min="{{ now()->toDateString() }}">
                        @error('preferred_date') <small>{{ $message }}</small> @enderror
                    </div>

                    <div class="cr-request-field">
                        <label>Preferred Time</label>
                        <input type="time" name="preferred_time" value="{{ old('preferred_time') }}">
                        @error('preferred_time') <small>{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="cr-request-field">
                    <label>Description</label>
                    <textarea name="description" required maxlength="2000" data-one-space placeholder="Describe the problem, location access, and what you need done.">{{ old('description') }}</textarea>
                    @error('description') <small>{{ $message }}</small> @enderror
                </div>

                <div class="cr-request-field">
                    <label>Image</label>
                    <input type="file" name="image" id="customerRequestImage" accept="image/*">
                    @error('image') <small>{{ $message }}</small> @enderror
                </div>

                <div class="cr-request-form__row">
                    <div class="cr-request-field">
                        <label>Contact Name</label>
                        <input type="text" name="contact_name" value="{{ old('contact_name', $contactName) }}" required maxlength="255" data-one-space autocomplete="name">
                        @error('contact_name') <small>{{ $message }}</small> @enderror
                    </div>

                    <div class="cr-request-field">
                        <label>Contact Phone</label>
                        <input type="text" name="contact_phone" value="{{ old('contact_phone', $contactPhone) }}" required maxlength="50" data-no-space inputmode="tel" autocomplete="tel">
                        @error('contact_phone') <small>{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="cr-request-field">
                    <label>Contact Email</label>
                    <input type="email" name="contact_email" value="{{ old('contact_email', $contactEmail) }}" required maxlength="255" data-no-space inputmode="email" autocomplete="email">
                    @error('contact_email') <small>{{ $message }}</small> @enderror
                </div>

                <div class="cr-request-field">
                    <label>Contact Address</label>
                    <textarea name="contact_address" required maxlength="1000" data-one-space>{{ old('contact_address', $contactAddress) }}</textarea>
                    @error('contact_address') <small>{{ $message }}</small> @enderror
                </div>

                <div class="cr-request-modal__actions">
                    <button type="button" class="cr-request-modal__cancel" data-close-customer-request-modal>Cancel</button>
                    <button type="submit" class="cr-request-modal__submit">Create Request</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('extrascripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('customerRequestModal');
        const openButton = document.getElementById('openCustomerRequestModal');
        const closeButtons = document.querySelectorAll('[data-close-customer-request-modal]');
        const priceInputs = document.querySelectorAll('[data-price-limit]');
        const detailModals = document.querySelectorAll('.cr-detail-modal');
        const detailOpenButtons = document.querySelectorAll('[data-open-request-detail]');
        const detailCloseButtons = document.querySelectorAll('[data-close-request-detail]');
        const editModals = document.querySelectorAll('.cr-edit-request-modal');
        const editOpenButtons = document.querySelectorAll('[data-open-request-edit]');
        const editCloseButtons = document.querySelectorAll('[data-close-request-edit]');
        const cancelForms = document.querySelectorAll('.js-customer-request-cancel');
        const deleteForms = document.querySelectorAll('.js-customer-request-delete');
        const statusFilter = document.querySelector('.cr-dashboard__filter select');

        if (modal && modal.parentElement !== document.body) {
            document.body.appendChild(modal);
        }

        function openModal() {
            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        if (openButton && modal) {
            openButton.addEventListener('click', function (event) {
                event.preventDefault();
                openModal();
            });
        }

        closeButtons.forEach((button) => {
            button.addEventListener('click', closeModal);
        });

        function openDetailModal(modalId) {
            const detailModal = document.getElementById(modalId);

            if (!detailModal) {
                return;
            }

            detailModal.classList.add('is-open');
            detailModal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function closeDetailModal(detailModal) {
            if (!detailModal) {
                return;
            }

            detailModal.classList.remove('is-open');
            detailModal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        detailOpenButtons.forEach((button) => {
            button.addEventListener('click', function () {
                openDetailModal(this.dataset.openRequestDetail);
            });
        });

        detailCloseButtons.forEach((button) => {
            button.addEventListener('click', function () {
                closeDetailModal(this.closest('.cr-detail-modal'));
            });
        });

        detailModals.forEach((detailModal) => {
            detailModal.addEventListener('click', function (event) {
                if (event.target === detailModal) {
                    closeDetailModal(detailModal);
                }
            });
        });

        function openEditModal(modalId) {
            const editModal = document.getElementById(modalId);

            if (!editModal) {
                return;
            }

            editModal.classList.add('is-open');
            editModal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function closeEditModal(editModal) {
            if (!editModal) {
                return;
            }

            editModal.classList.remove('is-open');
            editModal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        editOpenButtons.forEach((button) => {
            button.addEventListener('click', function () {
                openEditModal(this.dataset.openRequestEdit);
            });
        });

        editCloseButtons.forEach((button) => {
            button.addEventListener('click', function () {
                closeEditModal(this.closest('.cr-edit-request-modal'));
            });
        });

        editModals.forEach((editModal) => {
            editModal.addEventListener('click', function (event) {
                if (event.target === editModal) {
                    closeEditModal(editModal);
                }
            });
        });

        cancelForms.forEach((form) => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                Swal.fire({
                    icon: 'warning',
                    title: 'Close Request?',
                    text: 'Cancelling this request may reflect in your account health. This action will close the request for providers.',
                    showCancelButton: true,
                    confirmButtonText: 'Close Request',
                    cancelButtonText: 'Keep Request',
                    confirmButtonColor: '#EF4444',
                    cancelButtonColor: '#6B7280',
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        deleteForms.forEach((form) => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                Swal.fire({
                    icon: 'warning',
                    title: 'Delete Request?',
                    text: 'This will permanently remove this customer request from your dashboard.',
                    showCancelButton: true,
                    confirmButtonText: 'Delete Request',
                    cancelButtonText: 'Keep Request',
                    confirmButtonColor: '#EF4444',
                    cancelButtonColor: '#6B7280',
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        if (statusFilter) {
            statusFilter.addEventListener('change', function () {
                const url = new URL(window.location.href);

                if (this.value) {
                    url.searchParams.set('status', this.value);
                } else {
                    url.searchParams.delete('status');
                }

                window.location.href = url.toString();
            });
        }

        priceInputs.forEach((input) => {
            input.addEventListener('input', function () {
                const max = Number(this.dataset.priceLimit || 100000);
                let value = this.value.replace(/[^\d.]/g, '');
                const parts = value.split('.');

                if (parts.length > 2) {
                    value = parts.shift() + '.' + parts.join('');
                }

                if (value.includes('.')) {
                    const splitValue = value.split('.');
                    value = splitValue[0] + '.' + splitValue[1].slice(0, 2);
                }

                if (Number(value) > max) {
                    value = String(max);
                }

                this.value = value;
            });
        });

        if (modal) {
            modal.addEventListener('click', function (event) {
                if (event.target === modal) {
                    closeModal();
                }
            });
        }

        if (window.FilePond && document.querySelector('#customerRequestImage')) {
            FilePond.registerPlugin(
                FilePondPluginImagePreview,
                FilePondPluginFileValidateType,
                FilePondPluginFileValidateSize
            );

            FilePond.create(document.querySelector('#customerRequestImage'), {
                allowMultiple: false,
                maxFiles: 1,
                storeAsFile: true,
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp'],
                maxFileSize: '3MB',
                labelIdle: 'Drop request image or <span class="filepond--label-action">Browse</span>',
            });

            document.querySelectorAll('.js-customer-request-edit-image').forEach((input) => {
                const existingImage = input.dataset.existingImage || null;
                const removeInput = input.closest('form')?.querySelector('.js-request-remove-image');
                const pond = FilePond.create(input, {
                    allowMultiple: false,
                    maxFiles: 1,
                    storeAsFile: true,
                    acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp'],
                    maxFileSize: '3MB',
                    labelIdle: 'Drop request image or <span class="filepond--label-action">Browse</span>',
                    files: existingImage ? [
                        {
                            source: existingImage,
                            options: { type: 'remote' },
                        },
                    ] : [],
                });

                pond.on('removefile', function () {
                    if (removeInput) {
                        removeInput.value = '1';
                    }
                });

                pond.on('addfile', function () {
                    if (removeInput) {
                        removeInput.value = '0';
                    }
                });
            });
        }

        @if($errors->any())
            openModal();
        @endif
    });
</script>
@endpush
