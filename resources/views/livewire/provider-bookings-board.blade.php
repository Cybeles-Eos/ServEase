<div wire:poll.10s="refreshBookings">
    <div class="provider--bookings--main-d">
        <div class="pb-md-left">
            <div class="pb-md-left__head">
                <h3>Scheduled Bookings</h3>
                <p>
                    Accepted
                    <span style="color: #A6A6A6">
                        (<span>{{ $bookRequests->where('status', 'ACCEPTED')->count() }}</span>)
                    </span>
                </p>
            </div>

            <div class="pb-md-left__accepted-body">
                <div class="pb-md-left__accepted-body--main">
                    @php
                        $scheduleRequests = $bookRequests->where('status', 'ACCEPTED');
                    @endphp

                    @forelse($scheduleRequests as $request)
                        @php
                            $customerAvatar = $this->customerAvatarData($request);
                        @endphp
                        <div class="boxss-sd" wire:key="accepted-{{ $request->id }}">
                            <div class="boxss-sd-bking">
                                @if($customerAvatar['has_profile_image'])
                                    <img src="{{ asset($customerAvatar['profile_image']) }}"
                                         class="boxss-sd-bking__pfp"
                                         alt="{{ $customerAvatar['name'] }}">
                                @else
                                    <div class="boxss-sd-bking__pfp provider-booking-avatar"
                                         role="img"
                                         aria-label="{{ $customerAvatar['name'] }}">
                                        {{ $customerAvatar['initials'] }}
                                    </div>
                                @endif

                                <div class="boxss-sd-bking__pfp-d">
                                    <p class="boxss-sd-bking__pfp-d__name">
                                        {{ $request->bookingInfo['lname'] ?? '' }} {{ $request->bookingInfo['fname'] ?? '' }}
                                    </p>
                                    <a href="#" class="boxss-sd-bking__pfp-d__num">
                                        {{ $request->bookingInfo['number'] ?? '' }}
                                    </a>
                                    <a href="#" class="boxss-sd-bking__pfp-d__email">
                                        {{ $request->bookingInfo['email'] ?? '' }}
                                    </a>
                                    @php
                                        $custRatings = $request->bookingInfo?->customer?->receivedRatings ?? collect();
                                        $custCount = $custRatings->count();
                                        $custAvg = $custCount ? round($custRatings->avg('rating'), 1) : 0;
                                    @endphp
                                    <p class="provider-customer-rating">
                                        @if($custCount > 0)
                                            @for($i = 1; $i <= 5; $i++)
                                                <span style="color: {{ $i <= round($custAvg) ? '#FFBE42' : '#D1D5DB' }};">★</span>
                                            @endfor
                                            <span class="provider-customer-rating__val">{{ number_format($custAvg, 1) }} ({{ $custCount }})</span>
                                        @else
                                            <span class="provider-customer-rating__none">No ratings yet</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <hr>

                            <div class="boxss-sd-bking-info">
                                <div>
                                    <p class="boxss-sd-bking-label">
                                        {{ $request->bookingInfo->service['category'] ?? '' }}
                                    </p>
                                    <p class="boxss-sd-bking-info-serv-title">
                                        {{ \Illuminate\Support\Str::limit($request->bookingInfo->service['title'] ?? '', 40) }}
                                    </p>
                                </div>

                                <div>
                                    <p class="boxss-sd-bking-label">
                                        Date:
                                        <span>
                                            {{ !empty($request->bookingInfo['date']) ? \Carbon\Carbon::parse($request->bookingInfo['date'])->format('M d, Y') : '' }}
                                        </span>
                                    </p>
                                    <p class="boxss-sd-bking-label">
                                        {{ !empty($request->bookingInfo['time']) ? \Carbon\Carbon::parse($request->bookingInfo['time'])->format('g:i A') : '' }}
                                    </p>
                                </div>

                                <div>
                                    <p class="boxss-sd-bking-info-serv-head">Address:</p>
                                    <p class="boxss-sd-bking-label">
                                        {{ $request->bookingInfo['address'] ?? '' }}
                                    </p>
                                </div>

                            </div>

                            <div class="boxss-sd-bking-foo">
                                <p>
                                    {{ $request->bookingInfo->service?->pricing_type_label ?? 'Fixed Rate' }}:
                                    <span>{{ $request->bookingInfo->service?->price_label ?? '₱0.00' }}</span>
                                </p>

                                <form action="{{ route('provider.booking-request.cancel', $request->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-sm btn-danger" style="border-radius: 5px">
                                        Cancel
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div style="width: 100%; height: 256px; background-color: #fff; display: flex; justify-content: center; align-items: center;">
                            No Accepted Booking
                        </div>
                    @endforelse
                </div>
                <hr>
            </div>

            <div class="pb-md-left__table-c">
                <h3>Booking Request</h3>

                @php
                    $pendingRequests = $bookRequests->where('status', 'PENDING');
                @endphp

                <div class="pb-md-left-tblc-main">
                    <div class="pb-md-left-tblc-main-c">
                        <div class="pb-md-left-tblc-main-c__head">
                            <div style="justify-content: center">ID</div>
                            <div>Name</div>
                            <div>Service</div>
                            <div>Date & Time</div>
                            <div>Actions</div>
                        </div>

                        @forelse($pendingRequests as $request)
                            <div class="pb-md-left-tblc-main-c__tbody" wire:key="pending-{{ $request->id }}">
                                <div class="pb-md-left-tblc-main-id" style="justify-content: center">
                                    #{{ $loop->iteration }}
                                </div>

                                <div class="pb-md-left-tblc-main-name">
                                    <p>{{ $request->bookingInfo['lname'] ?? '' }} {{ $request->bookingInfo['fname'] ?? '' }}</p>
                                    <small>{{ $request->bookingInfo['address'] ?? '' }}</small>
                                    @php
                                        $custRatings = $request->bookingInfo?->customer?->receivedRatings ?? collect();
                                        $custCount = $custRatings->count();
                                        $custAvg = $custCount ? round($custRatings->avg('rating'), 1) : 0;
                                    @endphp
                                    <small class="provider-customer-rating provider-customer-rating--inline">
                                        @if($custCount > 0)
                                            <span style="color: #FFBE42;">★</span>
                                            {{ number_format($custAvg, 1) }} ({{ $custCount }})
                                        @else
                                            <span class="provider-customer-rating__none">No ratings yet</span>
                                        @endif
                                    </small>
                                </div>

                                <div class="pb-md-left-tblc-main-serv">
                                    <small>{{ $request->bookingInfo->service['category'] ?? '' }}</small>
                                    <p>{{ \Illuminate\Support\Str::limit($request->bookingInfo->service['title'] ?? '', 40) }}</p>
                                    <small>{{ $request->bookingInfo->service?->price_label ?? '₱0.00' }}</small>
                                </div>

                                <div class="pb-md-left-tblc-main-date">
                                    <p style="font-size: 14px">
                                        {{ !empty($request->bookingInfo['date']) ? \Carbon\Carbon::parse($request->bookingInfo['date'])->format('M d, Y') : '' }}
                                    </p>
                                    <small>
                                        {{ !empty($request->bookingInfo['time']) ? \Carbon\Carbon::parse($request->bookingInfo['time'])->format('g:i A') : '' }}
                                    </small>
                                </div>

                                <div class="pb-md-left-tblc-main-act" style="display:flex; gap:8px; align-items:center;">
                                    <form action="{{ route('provider.booking-request.accept', $request->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="pb-md-left-tblc-main-act__actp" style="border:none;">
                                            Accept
                                        </button>
                                    </form>

                                    <form action="{{ route('provider.booking-request.decline', $request->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="pb-md-left-tblc-main-act__remove" style="border:none;">
                                            Decline
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="provider-stbl-main-c__tbody" style="height: 55px; font-size: 14px; text-align:center; margin: 0; display: flex; align-items: center; justify-content:center; background-color: #F9F9F9">
                                No Booking Request
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="pb-md-right">
            <div class="pb-md-right-active">
                <div class="pb-md-right-active__head">
                    <h3>Todays Ongoing Book</h3>
                </div>

                @php
                    $ongoingRequests = $bookRequests->where('status', 'ONGOING');
                @endphp

                @forelse($ongoingRequests as $request)
                    @php
                        $customerAvatar = $this->customerAvatarData($request);
                        $ongoingStartedAt = $request->updated_at;
                        $ongoingService = $request->bookingInfo?->service;
                        $ongoingStartedAtIso = $ongoingStartedAt
                            ? \Carbon\Carbon::parse($ongoingStartedAt)->toIso8601String()
                            : '';
                    @endphp
                    <div class="pb-md-right-active__body provider-ongoing-card" wire:key="ongoing-{{ $request->id }}">
                        <div class="pb-md-right-active__body__head">
                            <div class="pbmd-rabh-box">
                                @if($customerAvatar['has_profile_image'])
                                    <img src="{{ asset($customerAvatar['profile_image']) }}"
                                         class="pbmd-rabh-box__pfp"
                                         alt="{{ $customerAvatar['name'] }}">
                                @else
                                    <div class="pbmd-rabh-box__pfp provider-booking-avatar"
                                         role="img"
                                         aria-label="{{ $customerAvatar['name'] }}">
                                        {{ $customerAvatar['initials'] }}
                                    </div>
                                @endif

                                <div class="pbmd-rabh-box__pfp-d">
                                    <p class="pbmd-rabh-box__pfp-d__name">
                                        {{ $request->bookingInfo['lname'] ?? '' }} {{ $request->bookingInfo['fname'] ?? '' }}
                                    </p>
                                    <a href="#" class="pbmd-rabh-box__pfp-d__num">
                                        {{ $request->bookingInfo['number'] ?? '' }}
                                    </a>
                                    <a href="#" class="pbmd-rabh-box__pfp-d__email">
                                        {{ $request->bookingInfo['email'] ?? '' }}
                                    </a>
                                    @php
                                        $custRatings = $request->bookingInfo?->customer?->receivedRatings ?? collect();
                                        $custCount = $custRatings->count();
                                        $custAvg = $custCount ? round($custRatings->avg('rating'), 1) : 0;
                                    @endphp
                                    <p class="provider-customer-rating">
                                        @if($custCount > 0)
                                            @for($i = 1; $i <= 5; $i++)
                                                <span style="color: {{ $i <= round($custAvg) ? '#FFBE42' : '#D1D5DB' }};">★</span>
                                            @endfor
                                            <span class="provider-customer-rating__val">{{ number_format($custAvg, 1) }} ({{ $custCount }})</span>
                                        @else
                                            <span class="provider-customer-rating__none">No ratings yet</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <p class="pb-md-right-active__body__head__rate">
                                {{ $request->bookingInfo->service?->pricing_type_label ?? 'Fixed Rate' }}:
                                <span>{{ $request->bookingInfo->service?->price_label ?? '₱0.00' }}</span>
                            </p>
                        </div>

                        <hr>

                        <div class="pb-md-right-active__body__details provider-ongoing-card__details">
                            <div>
                                <p class="pdmdrabd-label">{{ $request->bookingInfo->service['category'] ?? '' }}</p>
                                <p class="pdmdrabd-title">
                                    {{ \Illuminate\Support\Str::limit($request->bookingInfo->service['title'] ?? '', 40) }}
                                </p>
                            </div>

                            <div>
                                <p>Booking Ref:</p>
                                <p>#{{ $request->id }}</p>
                                <p>Started: {{ $ongoingStartedAt ? \Carbon\Carbon::parse($ongoingStartedAt)->format('g:i A') : 'Not recorded' }}</p>
                            </div>

                            <div>
                                <p>Date: {{ !empty($request->bookingInfo['date']) ? \Carbon\Carbon::parse($request->bookingInfo['date'])->format('M d, Y') : '' }}</p>
                                <p>Time: {{ !empty($request->bookingInfo['time']) ? \Carbon\Carbon::parse($request->bookingInfo['time'])->format('g:i A') : '' }}</p>
                            </div>

                            <div>
                                <p>Address:</p>
                                <p>{{ $request->bookingInfo['address'] ?? '' }}</p>
                            </div>

                            @if(!empty(trim($request->bookingInfo['notes'] ?? '')))
                                <div style="min-width: 0;">
                                    <p>Notes:</p>
                                    @if(\Illuminate\Support\Str::length($request->bookingInfo['notes']) > 120)
                                        <details style="font-size: 12px; color: #656565;">
                                            <summary style="cursor: pointer; color: #202020; font-weight: 600;">Read note</summary>
                                            <p style="margin: 4px 0 0; line-height: 1.35;">{{ $request->bookingInfo['notes'] }}</p>
                                        </details>
                                    @else
                                        <p style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                            {{ $request->bookingInfo['notes'] }}
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="provider-ongoing-card__actions">
                            <form
                                action="{{ route('provider.booking-request.complete', $request->id) }}"
                                method="POST"
                                class="provider-booking-action-form"
                                data-action="complete"
                                data-pricing-type="{{ $ongoingService?->pricing_type ?? 'fixed' }}"
                                data-hourly-rate="{{ (float) ($ongoingService?->price ?? 0) }}"
                                data-started-at="{{ $ongoingStartedAtIso }}"
                            >
                                @csrf
                                <button type="submit" class="provider-ongoing-card__btn provider-ongoing-card__btn--complete">
                                    Mark Complete
                                </button>
                            </form>

                            <form action="{{ route('provider.booking-request.cancel', $request->id) }}" method="POST" class="provider-booking-action-form" data-action="cancel">
                                @csrf
                                <button type="submit" class="provider-ongoing-card__btn provider-ongoing-card__btn--cancel">
                                    Cancel Service
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div style="width: 100%; height: 200px; background-color: #fff; display: flex; justify-content: center; align-items: center;">
                        No Ongoing Booking
                    </div>
                @endforelse
            </div>

            <div class="pb-md-right-completed">
                <div class="pb-md-right-completed__head">
                    <h3>Service History</h3>
                    <select wire:model.live="historyStatus" class="provider-history-filter">
                        <option value="COMPLETED">Completed</option>
                        <option value="CANCELLED">Cancelled</option>
                        <option value="expired">Expired</option>
                    </select>
                </div>

                @forelse($historyRequests as $request)
                    @php
                        $customerAvatar = $this->customerAvatarData($request);
                        $historyEndedAt = $request->responded_at ?? $request->updated_at;
                        $historyStatusLabel = ucfirst(strtolower($request->status));
                    @endphp
                    <div class="pb-md-right-completed__body" wire:key="history-{{ $request->id }}-{{ $request->status }}">
                        <div class="pbmdr-cb-box {{ in_array($request->status, ['CANCELLED', 'expired']) ? 'pbmdr-cb-box--cancelled' : '' }}">
                            <img src="{{ asset('images/complete-book.svg') }}" class="icon-cb-book" alt="icon">

                            <div class="pbmdr-cb-box__det">
                                <div class="pbmdr-cb-boxdet-p">
                                    @if($customerAvatar['has_profile_image'])
                                        <img src="{{ asset($customerAvatar['profile_image']) }}"
                                             class="pbmdr-cb-boxdet-p__pfp"
                                             alt="{{ $customerAvatar['name'] }}">
                                    @else
                                        <div class="pbmdr-cb-boxdet-p__pfp provider-booking-avatar"
                                             role="img"
                                             aria-label="{{ $customerAvatar['name'] }}">
                                            {{ $customerAvatar['initials'] }}
                                        </div>
                                    @endif

                                    <div class="pbmdr-cb-boxdet-p__pfp-d">
                                        <p class="pbmdr-cb-boxdet-p__pfp-d__name">
                                            {{ $request->bookingInfo['lname'] ?? '' }} {{ $request->bookingInfo['fname'] ?? '' }}
                                        </p>
                                        <a href="#" class="pbmdr-cb-boxdet-p__pfp-d__num">
                                            {{ $request->bookingInfo['number'] ?? '' }}
                                        </a>
                                        <a href="#" class="pbmdr-cb-boxdet-p__pfp-d__email">
                                            {{ $request->bookingInfo['email'] ?? '' }}
                                        </a>
                                        @php
                                            $custRatings = $request->bookingInfo?->customer?->receivedRatings ?? collect();
                                            $custCount = $custRatings->count();
                                            $custAvg = $custCount ? round($custRatings->avg('rating'), 1) : 0;
                                        @endphp
                                        <p class="provider-customer-rating">
                                            @if($custCount > 0)
                                                @for($i = 1; $i <= 5; $i++)
                                                    <span style="color: {{ $i <= round($custAvg) ? '#FFBE42' : '#D1D5DB' }};">★</span>
                                                @endfor
                                                <span class="provider-customer-rating__val">{{ number_format($custAvg, 1) }} ({{ $custCount }})</span>
                                            @else
                                                <span class="provider-customer-rating__none">No ratings yet</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div style="margin-top: 0px;">
                                    <p style="margin: 0; font-size: 12px; color: #656565;">
                                        {{ $request->bookingInfo->service['category'] ?? '' }}
                                    </p>
                                    <p style="margin: 0; font-weight: 600;">
                                        {{ \Illuminate\Support\Str::limit($request->bookingInfo->service['title'] ?? '', 40) }}
                                    </p>
                                    <p style="margin: 0; font-size: 12px; color: #656565;">
                                        {{ !empty($request->bookingInfo['date']) ? \Carbon\Carbon::parse($request->bookingInfo['date'])->format('M d, Y') : '' }}
                                        @if(!empty($request->bookingInfo['time']))
                                            • {{ \Carbon\Carbon::parse($request->bookingInfo['time'])->format('g:i A') }}
                                        @endif
                                    </p>
                                    <p style="margin: 0; font-size: 12px; color: #656565;">
                                        {{ $request->bookingInfo['address'] ?? '' }}
                                    </p>
                                    <p style="margin: 5px 0 0; font-size: 12px; font-weight: 600;">
                                        {{ $request->bookingInfo->service?->pricing_type_label ?? 'Fixed Rate' }}: {{ $request->bookingInfo->service?->price_label ?? '₱0.00' }}
                                    </p>
                                    @if(($request->bookingInfo->service?->pricing_type ?? 'fixed') === 'per_hour' && $request->completed_duration_label)
                                        <p style="margin: 2px 0 0; font-size: 12px; color: #656565;">
                                            Completed Time: {{ $request->completed_duration_label }}
                                        </p>
                                        <p style="margin: 2px 0 0; font-size: 12px; font-weight: 700;">
                                            Total: {{ $request->billing_total_label }}
                                        </p>
                                    @endif
                                    <p class="provider-history-ended">
                                        {{ $historyStatusLabel }}:
                                        <span>{{ $historyEndedAt ? \Carbon\Carbon::parse($historyEndedAt)->format('M d, Y g:i A') : 'Not recorded' }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="pbmdr-cb-box__foo">
                                @php
                                    $ratingValue = $request->rating?->rating ?? 0;
                                @endphp

                                @if($request->status === 'COMPLETED')
                                <p>
                                    Rated:
                                    @if($ratingValue > 0)
                                        @for($i = 1; $i <= 5; $i++)
                                            <span style="color: {{ $i <= $ratingValue ? '#FFBE42' : '#D1D5DB' }};">
                                                ★
                                            </span>
                                        @endfor
                                    @else
                                        <span style="font-size: 12px; color: #9CA3AF;">
                                            No rating yet
                                        </span>
                                    @endif
                                </p>

                                <div class="provider-customer-actions">
                                    @if($request->customerRating)
                                        <button type="button" class="provider-customer-action-btn is-done" disabled
                                                title="You rated this customer">
                                            <i class="fas fa-star"></i> Rated
                                        </button>
                                    @else
                                        <button type="button" class="provider-customer-action-btn"
                                                onclick="openRatingModal('rate-customer-modal-{{ $request->id }}')"
                                                title="Rate this customer">
                                            <i class="far fa-star"></i> Rate Customer
                                        </button>
                                    @endif

                                    @if($request->customerReport)
                                        <button type="button" class="provider-customer-action-btn provider-customer-action-btn--report is-done" disabled
                                                title="You reported this customer">
                                            <i class="fas fa-flag"></i> Reported
                                        </button>
                                    @else
                                        <button type="button" class="provider-customer-action-btn provider-customer-action-btn--report"
                                                onclick="openRatingModal('report-customer-modal-{{ $request->id }}')"
                                                title="Report this customer">
                                            <i class="far fa-flag"></i> Report
                                        </button>
                                    @endif
                                </div>

                                <a href="{{ route('booking.receipt', $request->id) }}"
                                target="_blank"
                                class="download-receipt-btn">
                                    Download Receipt
                                </a>
                                @elseif($request->status === 'CANCELLED')
                                    <p class="provider-history-cancelled">
                                        Cancelled by {{ $request->cancelled_by ? ucfirst($request->cancelled_by) : 'User' }}
                                    </p>
                                    <span style="font-size: 12px; color: #9CA3AF;">
                                        No receipt
                                    </span>
                                @else
                                    <p class="provider-history-cancelled">
                                        Expired
                                    </p>
                                    <span style="font-size: 12px; color: #9CA3AF;">
                                        No receipt
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if($request->status === 'COMPLETED')
                            @unless($request->customerRating)
                                <div id="rate-customer-modal-{{ $request->id }}" class="rating-modal-overlay" wire:ignore.self>
                                    <div class="rating-modal-box">
                                        <div class="rating-modal-head">
                                            <h3>Rate Customer</h3>
                                            <button type="button" class="rating-modal-close"
                                                    onclick="closeRatingModal('rate-customer-modal-{{ $request->id }}')">
                                                x
                                            </button>
                                        </div>

                                        <div class="rating-modal-body">
                                            <p class="rating-modal-provider-name">
                                                Customer:
                                                <strong>
                                                    {{ $request->bookingInfo['fname'] ?? '' }}
                                                    {{ $request->bookingInfo['lname'] ?? '' }}
                                                </strong>
                                            </p>

                                            <form method="POST"
                                                action="{{ route('provider.booking.rate-customer', $request->id) }}"
                                                class="customer-rating-form">
                                                @csrf

                                                <div class="star-rating">
                                                    @for($i = 5; $i >= 1; $i--)
                                                        <input type="radio"
                                                            id="rate-customer-{{ $request->id }}-{{ $i }}"
                                                            name="rating"
                                                            value="{{ $i }}"
                                                            required>
                                                        <label for="rate-customer-{{ $request->id }}-{{ $i }}">★</label>
                                                    @endfor
                                                </div>

                                                <textarea name="comment"
                                                        class="customer-rating-comment"
                                                        rows="3"
                                                        placeholder="Optional comment"></textarea>

                                                <div class="rating-modal-actions">
                                                    <button type="button" class="rating-cancel-btn"
                                                            onclick="closeRatingModal('rate-customer-modal-{{ $request->id }}')">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="customer-rating-submit">
                                                        Submit Rating
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endunless

                            @unless($request->customerReport)
                                <div id="report-customer-modal-{{ $request->id }}" class="rating-modal-overlay" wire:ignore.self>
                                    <div class="rating-modal-box">
                                        <div class="rating-modal-head">
                                            <h3>Report Customer</h3>
                                            <button type="button" class="rating-modal-close"
                                                    onclick="closeRatingModal('report-customer-modal-{{ $request->id }}')">
                                                x
                                            </button>
                                        </div>

                                        <div class="rating-modal-body">
                                            <p class="rating-modal-provider-name">
                                                Customer:
                                                <strong>
                                                    {{ $request->bookingInfo['fname'] ?? '' }}
                                                    {{ $request->bookingInfo['lname'] ?? '' }}
                                                </strong>
                                            </p>

                                            <form method="POST"
                                                action="{{ route('provider.booking.report-customer', $request->id) }}"
                                                class="customer-report-form">
                                                @csrf

                                                <label for="report-customer-reason-{{ $request->id }}">Reason</label>
                                                <select id="report-customer-reason-{{ $request->id }}" name="reason" required>
                                                    <option value="">Select a reason</option>
                                                    <option value="Rude or abusive behavior">Rude or abusive behavior</option>
                                                    <option value="No-show or unavailable">No-show or unavailable</option>
                                                    <option value="Refused to pay">Refused to pay</option>
                                                    <option value="Unsafe or suspicious conduct">Unsafe or suspicious conduct</option>
                                                    <option value="Incorrect booking details">Incorrect booking details</option>
                                                    <option value="Other">Other</option>
                                                </select>

                                                <label for="report-customer-details-{{ $request->id }}">Details</label>
                                                <textarea id="report-customer-details-{{ $request->id }}"
                                                        name="details"
                                                        rows="4"
                                                        placeholder="Describe what happened."></textarea>

                                                <div class="rating-modal-actions">
                                                    <button type="button" class="rating-cancel-btn"
                                                            onclick="closeRatingModal('report-customer-modal-{{ $request->id }}')">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="customer-rating-submit">
                                                        Submit Report
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endunless
                        @endif
                    </div>
                @empty
                    <div style="width: 100%; height: 100px; display: flex; justify-content: center; align-items: center;">
                        <p style="font-size: 14px; color: hsla(43, 64%, 2%, 0.6)">No {{ strtolower($historyStatus) }} booking</p>
                    </div>
                @endforelse
                
                @if($historyRequests && $historyRequests->total() > 0)
                    <div class="provider-history-pagination">
                        <p>
                            Showing {{ $historyRequests->total() ? $historyRequests->firstItem() : 0 }} to {{ $historyRequests->total() ? $historyRequests->lastItem() : 0 }} of {{ $historyRequests->total() }} results
                        </p>

                        @if($historyRequests->hasPages())
                            <div class="provider-history-pagination-actions">
                                @if($historyRequests->onFirstPage())
                                    <span class="provider-history-page-btn is-disabled" aria-disabled="true">
                                        <svg width="14" height="14" viewBox="0 0 20 20" fill="none">
                                            <path d="M12.5 15L7.5 10L12.5 5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                @else
                                    <button
                                        type="button"
                                        class="provider-history-page-btn"
                                        wire:click="previousPage('history_page')"
                                        wire:loading.attr="disabled"
                                        aria-label="Previous page"
                                    >
                                        <svg width="14" height="14" viewBox="0 0 20 20" fill="none">
                                            <path d="M12.5 15L7.5 10L12.5 5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                                @endif

                                <span class="provider-history-page-info">
                                    {{ $historyRequests->currentPage() }} / {{ $historyRequests->lastPage() }}
                                </span>

                                @if($historyRequests->hasMorePages())
                                    <button
                                        type="button"
                                        class="provider-history-page-btn provider-history-page-btn--active"
                                        wire:click="nextPage('history_page')"
                                        wire:loading.attr="disabled"
                                        aria-label="Next page"
                                    >
                                        <svg width="14" height="14" viewBox="0 0 20 20" fill="none">
                                            <path d="M7.5 5L12.5 10L7.5 15" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                                @else
                                    <span class="provider-history-page-btn is-disabled" aria-disabled="true">
                                        <svg width="14" height="14" viewBox="0 0 20 20" fill="none">
                                            <path d="M7.5 5L12.5 10L7.5 15" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    if (!window.providerBookingActionConfirmBound) {
        window.providerBookingActionConfirmBound = true;

        const pesoFormatter = new Intl.NumberFormat('en-PH', {
            style: 'currency',
            currency: 'PHP',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        function formatPeso(amount) {
            return pesoFormatter.format(Number.isFinite(amount) ? amount : 0);
        }

        function getDefaultDuration(startedAt) {
            const startedDate = startedAt ? new Date(startedAt) : null;
            const startedTime = startedDate && !Number.isNaN(startedDate.getTime())
                ? startedDate.getTime()
                : Date.now();
            const elapsedMinutes = Math.max(1, Math.floor((Date.now() - startedTime) / 60000));

            return {
                hours: Math.floor(elapsedMinutes / 60),
                minutes: elapsedMinutes % 60
            };
        }

        function syncHourlyTotal(rate) {
            const hoursInput = document.getElementById('hourly-completion-hours');
            const minutesInput = document.getElementById('hourly-completion-minutes');
            const title = document.querySelector('.swal2-title');

            if (!hoursInput || !minutesInput || !title) {
                return;
            }

            const hours = Math.max(0, parseInt(hoursInput.value || '0', 10));
            const minutes = Math.min(59, Math.max(0, parseInt(minutesInput.value || '0', 10)));
            const total = (((hours * 60) + minutes) / 60) * rate;

            hoursInput.value = hours;
            minutesInput.value = minutes;
            title.textContent = `Total ${formatPeso(total)}`;
        }

        function appendCompletionField(form, name, value) {
            let input = form.querySelector(`input[name="${name}"]`);

            if (!input) {
                input = document.createElement('input');
                input.type = 'hidden';
                input.name = name;
                form.appendChild(input);
            }

            input.value = value;
        }

        document.addEventListener('submit', function (event) {
            const form = event.target.closest('.provider-booking-action-form');

            if (!form || form.dataset.confirmed === 'true') {
                return;
            }

            event.preventDefault();

            const isCancel = form.dataset.action === 'cancel';
            const isHourlyCompletion = form.dataset.action === 'complete'
                && form.dataset.pricingType === 'per_hour';

            if (isHourlyCompletion) {
                const rate = parseFloat(form.dataset.hourlyRate || '0');
                const defaultDuration = getDefaultDuration(form.dataset.startedAt);

                Swal.fire({
                    title: 'Total ' + formatPeso((((defaultDuration.hours * 60) + defaultDuration.minutes) / 60) * rate),
                    html: `
                        <div class="hourly-completion-modal">
                            <div class="hourly-completion-modal__rate">
                                <span>Hourly rate</span>
                                <strong>${formatPeso(rate)}</strong>
                            </div>
                            <div class="hourly-completion-modal__fields">
                                <label>
                                    <span>Hours</span>
                                    <input id="hourly-completion-hours" type="number" min="0" max="9999" step="1" value="${defaultDuration.hours}">
                                </label>
                                <label>
                                    <span>Minutes</span>
                                    <input id="hourly-completion-minutes" type="number" min="0" max="59" step="1" value="${defaultDuration.minutes}">
                                </label>
                                <span class="hourly-completion-modal__help" aria-label="Hourly total computation guide">
                                    ?
                                    <span class="hourly-completion-modal__tooltip">
                                        Hourly total is computed using the completed hours and minutes. Formula: ((Hours x 60 + Minutes) / 60) x Rate.
                                    </span>
                                </span>
                            </div>
                        </div>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#16A34A',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Save',
                    cancelButtonText: 'Cancel',
                    didOpen: () => {
                        const htmlContainer = document.querySelector('.swal2-html-container');
                        const hoursInput = document.getElementById('hourly-completion-hours');
                        const minutesInput = document.getElementById('hourly-completion-minutes');

                        if (htmlContainer) {
                            htmlContainer.style.overflow = 'visible';
                        }

                        [hoursInput, minutesInput].forEach((input) => {
                            input.addEventListener('input', () => syncHourlyTotal(rate));
                        });
                    },
                    preConfirm: () => {
                        const hoursInput = document.getElementById('hourly-completion-hours');
                        const minutesInput = document.getElementById('hourly-completion-minutes');
                        const hours = Math.max(0, parseInt(hoursInput.value || '0', 10));
                        const minutes = Math.min(59, Math.max(0, parseInt(minutesInput.value || '0', 10)));

                        if (((hours * 60) + minutes) < 1) {
                            Swal.showValidationMessage('Completed time must be at least 1 minute.');
                            return false;
                        }

                        hoursInput.value = hours;
                        minutesInput.value = minutes;

                        return { hours, minutes };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        appendCompletionField(form, 'completed_hours', result.value.hours);
                        appendCompletionField(form, 'completed_minutes', result.value.minutes);
                        form.dataset.confirmed = 'true';
                        form.submit();
                    }
                });

                return;
            }

            Swal.fire({
                title: isCancel ? 'Cancel this ongoing service?' : 'Mark this service complete?',
                text: isCancel
                    ? 'This will end the ongoing booking and notify the customer.'
                    : 'This will move the booking to service history.',
                icon: isCancel ? 'warning' : 'question',
                showCancelButton: true,
                confirmButtonColor: isCancel ? '#DF4545' : '#16A34A',
                cancelButtonColor: '#6B7280',
                confirmButtonText: isCancel ? 'Yes, cancel service' : 'Yes, complete service',
                cancelButtonText: 'Go back'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.dataset.confirmed = 'true';
                    form.submit();
                }
            });
        });
    }
</script>
