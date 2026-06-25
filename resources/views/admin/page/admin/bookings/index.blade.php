@extends('admin.layouts.auth')

@section('title', 'Admin Ongoing Bookings')

@section('content')
    @include('admin.layouts.header')

    <main class="main-dash-uix page-admin-bookings dash-sp">
        <p style="margin: 0; font-size: 14px; opacity: .6">Review all provider bookings and monitor active service activity.</p>
        <hr style="margin-top: 10px">

        <section class="page-admin-bookings__summary">
            <article>
                <span>Total Bookings</span>
                <strong>{{ number_format($totalBookings) }}</strong>
                <p>All provider booking records</p>
            </article>
            <article>
                <span>Total Ongoing</span>
                <strong>{{ number_format($ongoingBookings) }}</strong>
                <p>Bookings currently in service</p>
            </article>
            <article>
                <span>Total Done</span>
                <strong>{{ number_format($completedBookings) }}</strong>
                <p>Completed provider jobs</p>
            </article>
            <article>
                <span>Total Cancelled</span>
                <strong>{{ number_format($cancelledBookings) }}</strong>
                <p>Cancelled booking records</p>
            </article>
        </section>

        <section class="section__table">
            <div class="page-admin-bookings__table-head">
                <div class="page-admin-bookings__table-title">
                    <h4>Ongoing Bookings</h4>
                    <p class="section__table--label">
                        All bookings across done, cancelled, ongoing, and request states.
                    </p>
                </div>

                <form method="GET" action="{{ route('admin.ongoing-bookings') }}" class="page-admin-bookings__filters">
                    <div class="page-admin-bookings__search">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                            <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M21 21L16.65 16.65" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                        <input type="text" name="search" value="{{ $search }}" placeholder="Search bookings...">
                    </div>

                    <div class="page-admin-bookings__filter-group">
                        <div class="page-admin-bookings__select-wrap">
                            <select name="status" class="page-admin-bookings__select">
                                <option value="">All Status</option>
                                @foreach ($allowedStatuses as $allowedStatus)
                                    <option value="{{ $allowedStatus }}" {{ $status === $allowedStatus ? 'selected' : '' }}>
                                        {{ ucfirst(strtolower($allowedStatus)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="page-admin-bookings__filter-actions">
                        <button type="submit" class="page-admin-bookings__filter-btn">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                <path d="M22 3H2L10 12.46V19L14 21V12.46L22 3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Filter
                        </button>

                        @if(request()->hasAny(['search', 'status']))
                            <a href="{{ route('admin.ongoing-bookings') }}" class="page-admin-bookings__clear-btn">
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="admin-ustbl-main">
                <div class="admin-ustbl-main-c">
                    <div class="admin-ustbl-main-c__head">
                        <div>Booking</div>
                        <div>Customer</div>
                        <div>Provider</div>
                        <div>Service</div>
                        <div>Schedule</div>
                        <div>Status</div>
                        <div>Updated</div>
                    </div>

                    @forelse ($bookings as $booking)
                        @php
                            $bookingInfo = $booking->bookingInfo;
                            $service = $bookingInfo?->service;
                            $provider = $booking->provider ?? $service?->provider;
                            $customerName = trim(($bookingInfo->fname ?? '') . ' ' . ($bookingInfo->lname ?? '')) ?: 'Customer';
                            $providerName = trim(($provider->first_name ?? '') . ' ' . ($provider->last_name ?? '')) ?: 'Provider';
                            $statusClass = strtolower($booking->status);
                        @endphp

                        <div class="admin-ustbl-main-c__tbody">
                            <div class="booking-table-cell booking-table-cell--id">
                                <strong>#{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</strong>
                                <span>{{ $booking->created_at?->format('M d, Y') ?? 'No date' }}</span>
                            </div>
                            <div class="booking-table-cell">
                                <strong title="{{ $customerName }}">{{ \Illuminate\Support\Str::limit($customerName, 30) }}</strong>
                                <span title="{{ $bookingInfo?->email }}">{{ $bookingInfo?->email ?: 'No email' }}</span>
                                <span title="{{ $bookingInfo?->address }}">{{ \Illuminate\Support\Str::limit($bookingInfo?->address ?: 'No address', 36) }}</span>
                            </div>
                            <div class="booking-table-cell">
                                <strong title="{{ $providerName }}">{{ \Illuminate\Support\Str::limit($providerName, 30) }}</strong>
                                <span>{{ $provider?->phone_number ?: 'No phone' }}</span>
                            </div>
                            <div class="booking-table-cell">
                                <strong title="{{ $service?->title }}">{{ \Illuminate\Support\Str::limit($service?->title ?? 'Service unavailable', 34) }}</strong>
                                <span>{{ $service?->serviceCategory?->name ?? $service?->category ?? 'No category' }}</span>
                                <span>{{ $service?->price_label ?? '₱0.00' }}</span>
                            </div>
                            <div class="booking-table-cell">
                                <strong>{{ $bookingInfo?->date ? \Carbon\Carbon::parse($bookingInfo->date)->format('M d, Y') : 'No date' }}</strong>
                                <span>{{ $bookingInfo?->time ? \Carbon\Carbon::parse($bookingInfo->time)->format('g:i A') : 'No time' }}</span>
                            </div>
                            <div class="booking-table-cell">
                                <span class="booking-status booking-status--{{ $statusClass }}">
                                    {{ ucfirst(strtolower($booking->status)) }}
                                </span>
                                @if($booking->cancelled_by)
                                    <small>By {{ ucfirst($booking->cancelled_by) }}</small>
                                @endif
                            </div>
                            <div class="booking-table-cell">
                                <strong>{{ $booking->updated_at?->format('M d, Y') ?? 'No date' }}</strong>
                                <span>{{ $booking->updated_at?->format('g:i A') ?? '' }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="admin-ustbl-main-c__tbody admin-ustbl-main-c__tbody--empty">
                            No booking records found
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="page-admin-bookings__pagination">
                <p style="margin: 0">
                    Showing {{ $bookings->total() ? $bookings->firstItem() : 0 }} to {{ $bookings->total() ? $bookings->lastItem() : 0 }} of {{ $bookings->total() }} results
                </p>

                @if ($bookings->hasPages())
                    <div class="page-admin-bookings__pagination-actions">
                        @if ($bookings->onFirstPage())
                            <span class="page-admin-bookings__page-btn is-disabled" aria-disabled="true">
                                <svg width="14" height="14" viewBox="0 0 20 20" fill="none">
                                    <path d="M12.5 15L7.5 10L12.5 5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        @else
                            <a href="{{ $bookings->previousPageUrl() }}" class="page-admin-bookings__page-btn" aria-label="Previous page">
                                <svg width="14" height="14" viewBox="0 0 20 20" fill="none">
                                    <path d="M12.5 15L7.5 10L12.5 5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        @endif

                        <span class="page-admin-bookings__page-info">
                            {{ $bookings->currentPage() }} / {{ $bookings->lastPage() }}
                        </span>

                        @if ($bookings->hasMorePages())
                            <a href="{{ $bookings->nextPageUrl() }}" class="page-admin-bookings__page-btn page-admin-bookings__page-btn--active" aria-label="Next page">
                                <svg width="14" height="14" viewBox="0 0 20 20" fill="none">
                                    <path d="M7.5 5L12.5 10L7.5 15" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        @else
                            <span class="page-admin-bookings__page-btn is-disabled" aria-disabled="true">
                                <svg width="14" height="14" viewBox="0 0 20 20" fill="none">
                                    <path d="M7.5 5L12.5 10L7.5 15" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        @endif
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection
