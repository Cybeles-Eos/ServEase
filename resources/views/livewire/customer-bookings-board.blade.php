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
                                @php
                                    $providerRating = $booking->service?->provider?->ratings?->avg('rating') ?? 0;
                                    $providerRatingCount = $booking->service?->provider?->ratings?->count() ?? 0;
                                @endphp

                                <p class="provider-overall-rating">
                                    Provider Rating:
                                    <strong>{{ number_format($providerRating, 1) }}/5</strong>
                                    <span>({{ $providerRatingCount }} reviews)</span>
                                </p>
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

                            {{-- @if($booking->status == 'COMPLETED')
                                <a href="{{ route('booking.receipt', $booking->bookingRequest?->id) }}"
                                target="_blank"
                                class="receipt">
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 1.5C0 1.10218 0.158035 0.720644 0.43934 0.43934C0.720644 0.158035 1.10218 0 1.5 0H7.83333C8.23116 0 8.61269 0.158035 8.89399 0.43934C9.1753 0.720644 9.33333 1.10218 9.33333 1.5V7.33333H12V9.83333C12 10.408 11.7717 10.9591 11.3654 11.3654C10.9591 11.7717 10.408 12 9.83333 12H2.16667C1.59203 12 1.04093 11.7717 0.634602 11.3654C0.228273 10.9591 0 10.408 0 9.83333V1.5ZM9.33333 11H9.83333C10.1428 11 10.4395 10.8771 10.6583 10.6583C10.8771 10.4395 11 10.1428 11 9.83333V8.33333H9.33333V11ZM1.5 1C1.36739 1 1.24021 1.05268 1.14645 1.14645C1.05268 1.24021 1 1.36739 1 1.5V9.83333C1 10.4773 1.52267 11 2.16667 11H8.33333V1.5C8.33333 1.36739 8.28065 1.24021 8.18689 1.14645C8.09312 1.05268 7.96594 1 7.83333 1H1.5ZM2.83333 2.66667C2.70073 2.66667 2.57355 2.71935 2.47978 2.81311C2.38601 2.90688 2.33333 3.03406 2.33333 3.16667C2.33333 3.29928 2.38601 3.42645 2.47978 3.52022C2.57355 3.61399 2.70073 3.66667 2.83333 3.66667H6.5C6.63261 3.66667 6.75979 3.61399 6.85355 3.52022C6.94732 3.42645 7 3.29928 7 3.16667C7 3.03406 6.94732 2.90688 6.85355 2.81311C6.75979 2.71935 6.63261 2.66667 6.5 2.66667H2.83333ZM2.33333 5.83333C2.33333 5.70073 2.38601 5.57355 2.47978 5.47978C2.57355 5.38601 2.70073 5.33333 2.83333 5.33333H6.5C6.63261 5.33333 6.75979 5.38601 6.85355 5.47978C6.94732 5.57355 7 5.70073 7 5.83333C7 5.96594 6.94732 6.09312 6.85355 6.18689C6.75979 6.28065 6.63261 6.33333 6.5 6.33333H2.83333C2.70073 6.33333 2.57355 6.28065 2.47978 6.18689C2.38601 6.09312 2.33333 5.96594 2.33333 5.83333ZM2.83333 8C2.70073 8 2.57355 8.05268 2.47978 8.14645C2.38601 8.24022 2.33333 8.36739 2.33333 8.5C2.33333 8.63261 2.38601 8.75979 2.47978 8.85355C2.57355 8.94732 2.70073 9 2.83333 9H4.83333C4.96594 9 5.09312 8.94732 5.18689 8.85355C5.28065 8.75979 5.33333 8.63261 5.33333 8.5C5.33333 8.36739 5.28065 8.24022 5.18689 8.14645C5.09312 8.05268 4.96594 8 4.83333 8H2.83333Z" fill="#202020"/>
                                    </svg>
                                </a>
                            @endif --}}
                            @if($booking->status == 'COMPLETED')
                                <button type="button"
                                        class="receipt"
                                        style="background: transparent; border: 1px solid #E0E2E7; border-radius: 6px"
                                        onclick="openRatingModal('rating-modal-{{ $booking->id }}')">
                                    {!! $booking->bookingRequest?->rating ? '<svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.125 7.5H4.14063C4.22396 7.5 4.30479 7.48438 4.38313 7.45313C4.46146 7.42188 4.53167 7.375 4.59375 7.3125L7.53125 4.375C7.625 4.28125 7.69542 4.17438 7.7425 4.05438C7.78958 3.93438 7.81292 3.81729 7.8125 3.70313C7.81208 3.58896 7.78604 3.47708 7.73438 3.3675C7.68271 3.25792 7.615 3.15625 7.53125 3.0625L6.96875 2.46875C6.875 2.375 6.77083 2.30479 6.65625 2.25812C6.54167 2.21146 6.42188 2.18792 6.29688 2.1875C6.18229 2.1875 6.06521 2.21104 5.94563 2.25812C5.82604 2.30521 5.71917 2.37542 5.625 2.46875L2.6875 5.40625C2.625 5.46875 2.57813 5.53917 2.54688 5.6175C2.51563 5.69583 2.5 5.77646 2.5 5.85938V6.875C2.5 7.05208 2.56 7.20063 2.68 7.32063C2.8 7.44063 2.94833 7.50042 3.125 7.5ZM3.4375 6.5625V5.96875L5.01563 4.39062L5.32813 4.67188L5.60938 4.98438L4.03125 6.5625H3.4375ZM5.32813 4.67188L5.60938 4.98438L5.01563 4.39062L5.32813 4.67188ZM5.73438 7.5H9.375C9.55208 7.5 9.70063 7.44 9.82063 7.32C9.94063 7.2 10.0004 7.05167 10 6.875C9.99958 6.69833 9.93958 6.55 9.82 6.43C9.70042 6.31 9.55208 6.25 9.375 6.25H6.98438L5.73438 7.5ZM2.5 10L1.0625 11.4375C0.864584 11.6354 0.637918 11.6798 0.382501 11.5706C0.127084 11.4615 -0.000415649 11.266 1.01792e-06 10.9844V1.25C1.01792e-06 0.90625 0.122501 0.612083 0.367501 0.3675C0.612501 0.122917 0.906668 0.000416667 1.25 0H11.25C11.5938 0 11.8881 0.1225 12.1331 0.3675C12.3781 0.6125 12.5004 0.906667 12.5 1.25V8.75C12.5 9.09375 12.3777 9.38813 12.1331 9.63313C11.8885 9.87813 11.5942 10.0004 11.25 10H2.5ZM1.96875 8.75H11.25V1.25H1.25V9.45312L1.96875 8.75Z" fill="#202020"/></svg>' : '<svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.22529 9.28986L5.50023 7.55476L7.77517 9.28986L6.92207 6.42928L9.05483 4.92865H6.40073L5.50023 2.02117L4.59973 4.92865H1.94564L4.07839 6.42928L3.22529 9.28986ZM5.50023 8.74588L2.63096 10.9077C2.52985 10.9765 2.42843 11.0068 2.32669 10.9987C2.22495 10.9906 2.13142 10.9621 2.04611 10.9134C1.9608 10.8646 1.89603 10.7911 1.85179 10.693C1.80756 10.5948 1.80661 10.4907 1.84895 10.3806L2.94471 6.81851L0.219525 4.87237C0.114625 4.80734 0.0476404 4.7245 0.0185717 4.62383C-0.0104969 4.52316 -0.00544172 4.42281 0.0337378 4.32276C0.0729174 4.22272 0.131687 4.14238 0.210046 4.08173C0.288405 4.02107 0.383826 3.99075 0.496309 3.99075H3.9182L5.03671 0.354525C5.07968 0.243853 5.14161 0.156941 5.2225 0.0937895C5.30275 0.0312631 5.39533 0 5.50023 0C5.60513 0 5.69771 0.0312631 5.77796 0.0937895C5.85885 0.156941 5.92078 0.243853 5.96375 0.354525L7.08226 3.99075H10.5042C10.616 3.99075 10.7114 4.02107 10.7904 4.08173C10.8694 4.14238 10.9282 4.22272 10.9667 4.32276C11.0053 4.42281 11.0103 4.52316 10.9819 4.62383C10.9522 4.72512 10.8852 4.80828 10.7809 4.87331L8.05575 6.81851L9.15151 10.3806C9.19385 10.4913 9.1929 10.5954 9.14867 10.693C9.10443 10.7905 9.03966 10.864 8.95435 10.9134C8.86904 10.9628 8.77551 10.9912 8.67377 10.9987C8.57203 11.0062 8.47061 10.9759 8.3695 10.9077L5.50023 8.74588Z" fill="#202020"/></svg>' !!}
                                </button>

                                <a href="{{ route('booking.receipt', $booking->bookingRequest?->id) }}"
                                target="_blank"
                                class="receipt"
                                style="border: 1px solid #E0E2E7; border-radius: 6px"
                                title="Download Receipt">
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

                                @php
                                    $serviceRating = $booking->service?->ratings?->avg('rating') ?? 0;
                                    $serviceRatingCount = $booking->service?->ratings?->count() ?? 0;
                                @endphp

                                <p class="service-card-rating">
                                    Service Rating:
                                    <strong>{{ number_format($serviceRating, 1) }}/5</strong>
                                    <span>({{ $serviceRatingCount }} reviews)</span>
                                </p>

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

                    {{-- @if($booking->status === 'COMPLETED' && $booking->bookingRequest)
                        <div class="customer-rating-box">
                            @if($booking->bookingRequest->rating)
                                <div class="customer-rating-box__rated">
                                    <p class="customer-rating-box__title">Your Service Rating</p>

                                    <div class="customer-rating-box__stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="{{ $i <= $booking->bookingRequest->rating->rating ? 'is-active' : '' }}">★</span>
                                        @endfor
                                    </div>

                                    @if(!empty($booking->bookingRequest->rating->comment))
                                        <p class="customer-rating-box__comment">
                                            "{{ $booking->bookingRequest->rating->comment }}"
                                        </p>
                                    @endif
                                </div>
                            @else
                                <form method="POST"
                                    action="{{ route('customer.booking.rate-service', $booking->bookingRequest->id) }}"
                                    class="customer-rating-form">
                                    @csrf

                                    <p class="customer-rating-box__title">Rate this service</p>

                                    <div class="star-rating">
                                        @for($i = 5; $i >= 1; $i--)
                                            <input type="radio"
                                                id="rating-{{ $booking->id }}-{{ $i }}"
                                                name="rating"
                                                value="{{ $i }}"
                                                required>

                                            <label for="rating-{{ $booking->id }}-{{ $i }}">★</label>
                                        @endfor
                                    </div>

                                    <textarea name="comment"
                                            class="customer-rating-comment"
                                            rows="2"
                                            placeholder="Optional comment"></textarea>

                                    <button type="submit" class="customer-rating-submit">
                                        Submit Rating
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif --}}
                </div>

            </div>

            {{-- Modal --}}
            @if($booking->status === 'COMPLETED' && $booking->bookingRequest)
                <div id="rating-modal-{{ $booking->id }}" class="rating-modal-overlay">
                    <div class="rating-modal-box">
                        <div class="rating-modal-head">
                            <h3>
                                {{ $booking->bookingRequest->rating ? 'Your Service Rating' : 'Rate this Service' }}
                            </h3>

                            <button type="button"
                                    class="rating-modal-close"
                                    onclick="closeRatingModal('rating-modal-{{ $booking->id }}')">
                                ×
                            </button>
                        </div>

                        <div class="rating-modal-body">
                            <p class="rating-modal-service-title">
                                {{ $booking->service->title ?? '' }}
                            </p>

                            <p class="rating-modal-provider-name">
                                Provider:
                                <strong>
                                    {{ $booking->service->provider->first_name ?? '' }}
                                    {{ $booking->service->provider->last_name ?? '' }}
                                </strong>
                            </p>

                            @if($booking->bookingRequest->rating)
                                <div class="customer-rating-box__rated">
                                    <div class="customer-rating-box__stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="{{ $i <= $booking->bookingRequest->rating->rating ? 'is-active' : '' }}">★</span>
                                        @endfor
                                    </div>

                                    @if(!empty($booking->bookingRequest->rating->comment))
                                        <p class="customer-rating-box__comment">
                                            "{{ $booking->bookingRequest->rating->comment }}"
                                        </p>
                                    @endif
                                </div>
                            @else
                                <form method="POST"
                                    action="{{ route('customer.booking.rate-service', $booking->bookingRequest->id) }}"
                                    class="customer-rating-form">
                                    @csrf

                                    <div class="star-rating">
                                        @for($i = 5; $i >= 1; $i--)
                                            <input type="radio"
                                                id="rating-{{ $booking->id }}-{{ $i }}"
                                                name="rating"
                                                value="{{ $i }}"
                                                required>
                                            <label for="rating-{{ $booking->id }}-{{ $i }}">★</label>
                                        @endfor
                                    </div>

                                    <textarea name="comment"
                                            class="customer-rating-comment"
                                            rows="3"
                                            placeholder="Optional comment"></textarea>

                                    <div class="rating-modal-actions">
                                        <button type="button"
                                                class="rating-cancel-btn"
                                                onclick="closeRatingModal('rating-modal-{{ $booking->id }}')">
                                            Cancel
                                        </button>

                                        <button type="submit" class="customer-rating-submit">
                                            Submit Rating
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <div style="display: flex;justify-content: center;align-items: center;height: 60px;color: rgba(0, 0, 0, 0.3);font-size: 14px;font-weight: 500;text-align: center;">
                No bookings
            </div>
        @endforelse
    </div>
</section>