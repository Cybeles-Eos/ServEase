@extends('admin.layouts.auth')

@section('title', 'Provider Booking Calendar - Servease')

@section('content')
    @include('admin.layouts.header')

    <main class="main-dash-uix provider-calendar dash-sp">
        <section class="provider-calendar__hero">
            <div>
                <p>Booking Calendar</p>
                <h1>{{ $currentMonth->format('F Y') }}</h1>
                <span>Track provider-approved customer bookings by date and review the details for each service request.</span>
            </div>

            <div class="provider-calendar__actions">
                <a href="{{ route('provider.booking-calendar', ['month' => $previousMonth, 'date' => \Carbon\Carbon::parse($previousMonth . '-01')->toDateString()]) }}" aria-label="Previous month">
                    <i class="fas fa-chevron-left"></i>
                </a>
                <a href="{{ route('provider.booking-calendar', ['month' => now()->format('Y-m'), 'date' => now()->toDateString()]) }}">Today</a>
                <a href="{{ route('provider.booking-calendar', ['month' => $nextMonth, 'date' => \Carbon\Carbon::parse($nextMonth . '-01')->toDateString()]) }}" aria-label="Next month">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </section>

        <section class="provider-calendar__stats">
            <div>
                <span>This Month</span>
                <strong>{{ number_format($monthBookingsCount) }}</strong>
                <p>Active booking schedules</p>
            </div>
            <div>
                <span>Today</span>
                <strong>{{ number_format($todayBookingsCount) }}</strong>
                <p>Bookings scheduled today</p>
            </div>
            <div>
                <span>Confirmed</span>
                <strong>{{ number_format($confirmedBookingsCount) }}</strong>
                <p>Accepted, ongoing, and completed</p>
            </div>
        </section>

        <section class="provider-calendar__workspace">
            <div class="provider-calendar__board">
                <div class="provider-calendar__weekdays">
                    <span>Sun</span>
                    <span>Mon</span>
                    <span>Tue</span>
                    <span>Wed</span>
                    <span>Thu</span>
                    <span>Fri</span>
                    <span>Sat</span>
                </div>

                <div class="provider-calendar__grid">
                    @foreach ($calendarDays as $day)
                        @php
                            $dateKey = $day->toDateString();
                            $dayBookings = $bookingsByDate->get($dateKey, collect());
                            $isCurrentMonth = $day->month === $currentMonth->month;
                            $isToday = $dateKey === now()->toDateString();
                            $isSelected = $dateKey === $selectedDate;
                        @endphp

                        <a
                            href="{{ route('provider.booking-calendar', ['month' => $currentMonth->format('Y-m'), 'date' => $dateKey]) }}"
                            class="provider-calendar__day {{ !$isCurrentMonth ? 'is-muted' : '' }} {{ $isToday ? 'is-today' : '' }} {{ $isSelected ? 'is-selected' : '' }}"
                        >
                            <div class="provider-calendar__day-top">
                                <span>{{ $day->format('j') }}</span>
                                @if ($dayBookings->isNotEmpty())
                                    <i>{{ $dayBookings->count() }}</i>
                                @endif
                            </div>

                            @if ($dayBookings->isNotEmpty())
                                <div class="provider-calendar__day-events">
                                    @foreach ($dayBookings->take(2) as $booking)
                                        @php
                                            $bookingInfo = $booking->bookingInfo;
                                            $customerName = trim(($bookingInfo->fname ?? '') . ' ' . ($bookingInfo->lname ?? '')) ?: 'Customer';
                                            $statusClass = strtolower($booking->status);
                                        @endphp
                                        <span>
                                            <b class="provider-calendar__dot provider-calendar__dot--{{ $statusClass }}"></b>
                                            {{ \Illuminate\Support\Str::limit($customerName, 16, '...') }}
                                            @if ($bookingInfo?->time)
                                                {{ $bookingInfo->time->format('g:i A') }}
                                            @endif
                                        </span>
                                    @endforeach

                                    @if ($dayBookings->count() > 2)
                                        <em>+{{ $dayBookings->count() - 2 }} more</em>
                                    @endif
                                </div>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>

            <aside class="provider-calendar__details">
                <div class="provider-calendar__details-head">
                    <span>Selected Date</span>
                    <strong>{{ \Carbon\Carbon::parse($selectedDate)->format('M d, Y') }}</strong>
                    <p>{{ $selectedBookings->count() }} {{ $selectedBookings->count() === 1 ? 'booking' : 'bookings' }}</p>
                </div>

                <div class="provider-calendar__details-list">
                    @forelse ($selectedBookings as $booking)
                        @php
                            $bookingInfo = $booking->bookingInfo;
                            $service = $bookingInfo?->service;
                            $customerName = trim(($bookingInfo->fname ?? '') . ' ' . ($bookingInfo->lname ?? '')) ?: 'Customer';
                            $statusClass = strtolower($booking->status);
                        @endphp

                        <article>
                            <div>
                                <h2>{{ $customerName }}</h2>
                                <span class="provider-calendar__status provider-calendar__status--{{ $statusClass }}">
                                    {{ ucfirst(strtolower($booking->status)) }}
                                </span>
                            </div>

                            <p>{{ $service?->title ?? 'Booked service' }}</p>

                            <ul>
                                <li>
                                    <i class="far fa-clock"></i>
                                    {{ $bookingInfo?->time ? $bookingInfo->time->format('g:i A') : 'No time set' }}
                                </li>
                                <li>
                                    <i class="fas fa-phone-alt"></i>
                                    {{ $bookingInfo?->number ?? 'No phone number' }}
                                </li>
                                <li>
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $bookingInfo?->address ?: 'No address provided' }}
                                </li>
                            </ul>
                        </article>
                    @empty
                        <div class="provider-calendar__empty">
                            <i class="far fa-calendar"></i>
                            <strong>No bookings on this date</strong>
                            <p>Select another day with a dot to view scheduled customer details.</p>
                        </div>
                    @endforelse
                </div>
            </aside>
        </section>
    </main>
@endsection
