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
                                    Fixed Rate:
                                    <span>₱{{ number_format($request->bookingInfo->service['price'] ?? 0, 2) }}</span>
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
                                </div>

                                <div class="pb-md-left-tblc-main-serv">
                                    <small>{{ $request->bookingInfo->service['category'] ?? '' }}</small>
                                    <p>{{ \Illuminate\Support\Str::limit($request->bookingInfo->service['title'] ?? '', 40) }}</p>
                                    <small>₱{{ number_format($request->bookingInfo->service['price'] ?? 0, 2) }}</small>
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
                                </div>
                            </div>

                            <p class="pb-md-right-active__body__head__rate">
                                Fixed Rate:
                                <span>₱{{ number_format($request->bookingInfo->service['price'] ?? 0, 2) }}</span>
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
                            <form action="{{ route('provider.booking-request.complete', $request->id) }}" method="POST" class="provider-booking-action-form" data-action="complete">
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
                    </select>
                </div>

                @php
                    $historyRequests = $bookRequests->where('status', $historyStatus);
                @endphp

                @forelse($historyRequests as $request)
                    @php
                        $customerAvatar = $this->customerAvatarData($request);
                        $historyEndedAt = $request->responded_at ?? $request->updated_at;
                        $historyStatusLabel = ucfirst(strtolower($request->status));
                    @endphp
                    <div class="pb-md-right-completed__body" wire:key="history-{{ $request->id }}-{{ $request->status }}">
                        <div class="pbmdr-cb-box {{ $request->status === 'CANCELLED' ? 'pbmdr-cb-box--cancelled' : '' }}">
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
                                        Fixed Rate: ₱{{ number_format($request->bookingInfo->service['price'] ?? 0, 2) }}
                                    </p>
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
                                <a href="{{ route('booking.receipt', $request->id) }}"
                                target="_blank"
                                class="download-receipt-btn">
                                    Download Receipt
                                </a>
                                @else
                                    <p class="provider-history-cancelled">
                                        Cancelled by {{ $request->cancelled_by ? ucfirst($request->cancelled_by) : 'User' }}
                                    </p>
                                    <span style="font-size: 12px; color: #9CA3AF;">
                                        No receipt
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="width: 100%; height: 100px; display: flex; justify-content: center; align-items: center;">
                        <p style="font-size: 14px; color: hsla(43, 64%, 2%, 0.6)">No {{ strtolower($historyStatus) }} booking</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
    if (!window.providerBookingActionConfirmBound) {
        window.providerBookingActionConfirmBound = true;

        document.addEventListener('submit', function (event) {
            const form = event.target.closest('.provider-booking-action-form');

            if (!form || form.dataset.confirmed === 'true') {
                return;
            }

            event.preventDefault();

            const isCancel = form.dataset.action === 'cancel';

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
