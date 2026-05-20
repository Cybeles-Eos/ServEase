<section class="cusdash-right" wire:poll.10s="refreshBookings">
    @if (!empty($ongoingBookings))
        <div class="cusdash-right__cards-con">
            <div class="cusdash-right__cards-con--active-box">
                <div class="cdrcc-ordbox active" wire:key="ongoing-booking-{{ $ongoingBookings->id }}">
                    <div class="cdrcc-ordbox--img">
                        <img src="{{ asset('images/serv-bg.png') }}" alt="thumbnail">
                    </div>

                    <div class="cdrcc-ordbox--info">
                        <div class="cdrcc-ordbox-i">
                            <div class="cdrcc-ordbox-i--profile">
                                <img src="{{ asset($ongoingBookings->service->provider->profile_image ?? 'images/user.png') }}" alt="profile">

                                <div class="cdrcc-ordbox-i--profile__dtl">
                                    <h3>
                                        {{ $ongoingBookings->service->provider->first_name ?? '' }}
                                        {{ $ongoingBookings->service->provider->last_name ?? '' }}
                                    </h3>

                                    <div class="cdrcc-ordbox-i--profile__dtl--con">
                                        <div>
                                            <a href="#">
                                                {{ $ongoingBookings->service->provider->phone_number ?? '' }}
                                            </a>
                                        </div>

                                        <div>
                                            <a href="#">
                                                @if(!empty($ongoingBookings->service->provider->personal_email))
                                                    {{ $ongoingBookings->service->provider->personal_email }}
                                                @else
                                                    {{ $ongoingBookings->service->provider->user->email ?? '' }}
                                                @endif
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="cdrcc-ordbox-i--status">
                                <button disabled class="cus-tbns-sty cus-tbns-sty__ongoing">
                                    <span></span> Service Ongoing
                                </button>
                            </div>
                        </div>

                        <div class="cdrcc-ordbox-d">
                            <div class="cdrcc-ordbox-d-l">
                                <div class="cdrcc-ordbox-d-l--service-type">
                                    <h4>{{ $ongoingBookings->service->title ?? '' }}</h4>
                                    <p>{{ $ongoingBookings->service->description ?? '' }}</p>
                                </div>

                                <div class="cdrcc-ordbox-d-l--sched">
                                    <p class="cdrcc-ordbox-d-l--sched__label">Service Schedule:</p>
                                    <p class="cdrcc-ordbox-d-l--sched__txt">
                                        Date:
                                        <span>
                                            {{ !empty($ongoingBookings->date) ? \Carbon\Carbon::parse($ongoingBookings->date)->format('M d, Y') : '' }}
                                        </span>
                                    </p>
                                    <p class="cdrcc-ordbox-d-l--sched__txt">
                                        Time:
                                        <span>
                                            {{ !empty($ongoingBookings->time) ? \Carbon\Carbon::parse($ongoingBookings->time)->format('g:i A') : '' }}
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <div class="cdrcc-ordbox-d-r">
                                @php
                                    $price = number_format((float) ($ongoingBookings->service->price ?? 0), 2, '.', '');
                                    [$whole, $decimal] = explode('.', $price);
                                @endphp

                                <p>Service Price:</p>
                                <h4>₱{{ $whole }}<span>.{{ $decimal ?: '00' }}</span></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="cusdash-right__head">
        <h4>Bookings <span>({{ number_format($bookingListCount) }})</span></h4>

        <div class="cusdash-right__head__filter">
            <select wire:model.live="selectedStatus" class="cusdash-right__head__filter--sort">
                <option value="">All Status</option>
                <option value="PENDING">Pending</option>
                <option value="ACCEPTED">Accepted</option>
                <option value="ONGOING">Ongoing</option>
                <option value="COMPLETED">Completed</option>
                <option value="DECLINED">Declined</option>
                <option value="CANCELLED">Cancelled</option>
            </select>

            <svg width="7" height="4" viewBox="0 0 7 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0.5 0.5L3.5 3.5L6.5 0.5" stroke="#282828" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
    </div>

    <div class="cusdash-right__cards-con">
        @forelse ($allBookings as $booking)
            <div class="cdrcc-ordbox" wire:key="customer-booking-{{ $booking->id }}-{{ $booking->status }}">
                <div class="cdrcc-ordbox--img">
                    <img src="{{ asset('images/serv-bg.png') }}" alt="thumbnail">
                </div>

                <div class="cdrcc-ordbox--info">
                    <div class="cdrcc-ordbox-i">
                        <div class="cdrcc-ordbox-i--profile">
                            <img src="{{ asset($booking->service->provider->profile_image ?? 'images/user.png') }}" alt="profile">

                            <div class="cdrcc-ordbox-i--profile__dtl">
                                <h3>
                                    {{ $booking->service->provider->first_name ?? '' }}
                                    {{ $booking->service->provider->last_name ?? '' }}
                                </h3>

                                <div class="cdrcc-ordbox-i--profile__dtl--con">
                                    <div>
                                        <a href="#">{{ $booking->service->provider->phone_number ?? '' }}</a>
                                    </div>

                                    <div>
                                        <a href="#">
                                            @if(!empty($booking->service->provider->personal_email))
                                                {{ $booking->service->provider->personal_email }}
                                            @else
                                                {{ $booking->service->provider->user->email ?? '' }}
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="cdrcc-ordbox-i--status">
                            @php
                                $statusClass = match($booking->status) {
                                    'PENDING' => 'cus-tbns-sty__pending',
                                    'ACCEPTED' => 'cus-tbns-sty__sceduled',
                                    'ONGOING' => 'cus-tbns-sty__ongoing',
                                    'COMPLETED' => 'cus-tbns-sty__completed',
                                    'DECLINED' => 'cus-tbns-sty__cancelled',
                                    'CANCELLED' => 'cus-tbns-sty__cancelled',
                                    default => 'cus-tbns-sty__pending',
                                };
                            @endphp

                            <button disabled class="cus-tbns-sty {{ $statusClass }}">
                                <span></span> {{ ucfirst(strtolower($booking->status)) }}
                            </button>

                            @if(in_array($booking->status, ['PENDING', 'ACCEPTED']))
                                <form method="POST" action="{{ route('customer.booking.cancel', $booking->bookingRequest?->id) }}" class="customer-cancel-booking-form">
                                    @csrf
                                    <button type="submit" class="btn-sm btn-danger">
                                        Cancel
                                    </button>
                                </form>
                            @endif

                            @if($booking->status == 'COMPLETED')
                                <a href="{{ route('booking.receipt', $booking->bookingRequest?->id) }}"
                                target="_blank"
                                class="receipt">
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 1.5C0 1.10218 0.158035 0.720644 0.43934 0.43934C0.720644 0.158035 1.10218 0 1.5 0H7.83333C8.23116 0 8.61269 0.158035 8.89399 0.43934C9.1753 0.720644 9.33333 1.10218 9.33333 1.5V7.33333H12V9.83333C12 10.408 11.7717 10.9591 11.3654 11.3654C10.9591 11.7717 10.408 12 9.83333 12H2.16667C1.59203 12 1.04093 11.7717 0.634602 11.3654C0.228273 10.9591 0 10.408 0 9.83333V1.5ZM9.33333 11H9.83333C10.1428 11 10.4395 10.8771 10.6583 10.6583C10.8771 10.4395 11 10.1428 11 9.83333V8.33333H9.33333V11ZM1.5 1C1.36739 1 1.24021 1.05268 1.14645 1.14645C1.05268 1.24021 1 1.36739 1 1.5V9.83333C1 10.4773 1.52267 11 2.16667 11H8.33333V1.5C8.33333 1.36739 8.28065 1.24021 8.18689 1.14645C8.09312 1.05268 7.96594 1 7.83333 1H1.5ZM2.83333 2.66667C2.70073 2.66667 2.57355 2.71935 2.47978 2.81311C2.38601 2.90688 2.33333 3.03406 2.33333 3.16667C2.33333 3.29928 2.38601 3.42645 2.47978 3.52022C2.57355 3.61399 2.70073 3.66667 2.83333 3.66667H6.5C6.63261 3.66667 6.75979 3.61399 6.85355 3.52022C6.94732 3.42645 7 3.29928 7 3.16667C7 3.03406 6.94732 2.90688 6.85355 2.81311C6.75979 2.71935 6.63261 2.66667 6.5 2.66667H2.83333ZM2.33333 5.83333C2.33333 5.70073 2.38601 5.57355 2.47978 5.47978C2.57355 5.38601 2.70073 5.33333 2.83333 5.33333H6.5C6.63261 5.33333 6.75979 5.38601 6.85355 5.47978C6.94732 5.57355 7 5.70073 7 5.83333C7 5.96594 6.94732 6.09312 6.85355 6.18689C6.75979 6.28065 6.63261 6.33333 6.5 6.33333H2.83333C2.70073 6.33333 2.57355 6.28065 2.47978 6.18689C2.38601 6.09312 2.33333 5.96594 2.33333 5.83333ZM2.83333 8C2.70073 8 2.57355 8.05268 2.47978 8.14645C2.38601 8.24022 2.33333 8.36739 2.33333 8.5C2.33333 8.63261 2.38601 8.75979 2.47978 8.85355C2.57355 8.94732 2.70073 9 2.83333 9H4.83333C4.96594 9 5.09312 8.94732 5.18689 8.85355C5.28065 8.75979 5.33333 8.63261 5.33333 8.5C5.33333 8.36739 5.28065 8.24022 5.18689 8.14645C5.09312 8.05268 4.96594 8 4.83333 8H2.83333Z" fill="#202020"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="cdrcc-ordbox-d">
                        <div class="cdrcc-ordbox-d-l">
                            <div class="cdrcc-ordbox-d-l--service-type">
                                <h4>{{ $booking->service->title ?? '' }}</h4>
                                <p>{{ $booking->service->description ?? '' }}</p>
                            </div>

                            <div class="cdrcc-ordbox-d-l--sched">
                                <p class="cdrcc-ordbox-d-l--sched__label">Service Schedule:</p>
                                <p class="cdrcc-ordbox-d-l--sched__txt">
                                    Date:
                                    <span>
                                        {{ !empty($booking->date) ? \Carbon\Carbon::parse($booking->date)->format('M d, Y') : '' }}
                                    </span>
                                </p>
                                <p class="cdrcc-ordbox-d-l--sched__txt">
                                    Time:
                                    <span>
                                        {{ !empty($booking->time) ? \Carbon\Carbon::parse($booking->time)->format('g:i A') : '' }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="cdrcc-ordbox-d-r">
                            @php
                                $price = number_format((float) ($booking->service->price ?? 0), 2, '.', '');
                                [$whole, $decimal] = explode('.', $price);
                            @endphp

                            <p>Service Price:</p>

                            @if($booking->status == 'COMPLETED')
                                <h4 class="paid">Paid</h4>
                            @else
                                <h4>₱{{ $whole }}<span>.{{ $decimal ?: '00' }}</span></h4>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div style="display: flex;justify-content: center;align-items: center;height: 60px;color: rgba(0, 0, 0, 0.3);font-size: 14px;font-weight: 500;text-align: center;">
                No bookings
            </div>
        @endforelse
    </div>
</section>