@extends('admin.layouts.auth')

{{-- Meta Section --}}
@section('title', 'Admin Dashboard')

{{-- Page Content --}}
@section('content')
    @include('admin.layouts.header')

    <main class="main-dash-uix dash-sp admin--dash">
        <section class="section section--header">
            <div class="section--header__card">
                <div class="section--header__card-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <path d="M17 21V19C17 16.7909 15.2091 15 13 15H5C2.79086 15 1 16.7909 1 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11Z" stroke="currentColor" stroke-width="2"/>
                        <path d="M23 21V19C23 17.2 21.8 15.7 20 15.2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M16 3.2C17.8 3.7 19 5.2 19 7C19 8.8 17.8 10.3 16 10.8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>

                <div class="section--header__card-content">
                    <p class="section--header__card-label">All Users</p>
                    <h3 class="section--header__card-value">{{ $totalUsers }}</h3>
                    <span class="section--header__card-desc">Providers and customers</span>
                </div>
            </div>

            <div class="section--header__card">
                <div class="section--header__card-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <path d="M20 21V19C20 16.7909 18.2091 15 16 15H8C5.79086 15 4 16.7909 4 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </div>

                <div class="section--header__card-content">
                    <p class="section--header__card-label">Providers</p>
                    <h3 class="section--header__card-value">{{ $totalProviders }}</h3>
                    <span class="section--header__card-desc">Active providers</span>
                </div>
            </div>

            <div class="section--header__card">
                <div class="section--header__card-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" stroke="currentColor" stroke-width="2"/>
                        <path d="M3 22C3.7 17.7 7.4 15 12 15C16.6 15 20.3 17.7 21 22" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>

                <div class="section--header__card-content">
                    <p class="section--header__card-label">Customers</p>
                    <h3 class="section--header__card-value">{{ $totalCustomers }}</h3>
                    <span class="section--header__card-desc">Active customers</span>
                </div>
            </div>

            <div class="section--header__card">
                <div class="section--header__card-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <path d="M5 3H19C20.1046 3 21 3.89543 21 5V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V5C3 3.89543 3.89543 3 5 3Z" stroke="currentColor" stroke-width="2"/>
                        <path d="M7 8H17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M7 12H17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M7 16H13" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>

                <div class="section--header__card-content">
                    <p class="section--header__card-label">Services</p>
                    <h3 class="section--header__card-value">{{ $totalServices }}</h3>
                    <span class="section--header__card-desc">Active services</span>
                </div>
            </div>
        </section>
        <section class="section section--header">
            <div class="section--header__card">
                <div class="section--header__card-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <path d="M6 3V6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M18 3V6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M4 8H20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M5 5H19C20.1046 5 21 5.89543 21 7V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V7C3 5.89543 3.89543 5 5 5Z" stroke="currentColor" stroke-width="2"/>
                        <path d="M8 12H16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M8 16H13" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>

                <div class="section--header__card-content">
                    <p class="section--header__card-label">Overall Provider Bookings</p>
                    <h3 class="section--header__card-value">{{ number_format($totalBookings) }}</h3>
                    <span class="section--header__card-desc">Providers and customers</span>
                </div>
            </div>

            <div class="section--header__card">
                <div class="section--header__card-icon">
                    <svg width="17" height="19" viewBox="0 0 17 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12.3857 19L9.71429 16.1726L10.8411 15.0794L12.3857 16.5779L15.8731 13.1944L17 14.5233L12.3857 19ZM13.6 0C14.6686 0 15.5429 0.848214 15.5429 1.88492V10.6875C14.9309 10.4802 14.28 10.3671 13.6 10.3671V1.88492H8.74286V9.4246L6.31429 7.30407L3.88571 9.4246V1.88492H1.94286V16.9643H7.84914C7.96571 17.6429 8.20857 18.2743 8.54857 18.8492H1.94286C0.874286 18.8492 0 18.001 0 16.9643V1.88492C0 0.848214 0.874286 0 1.94286 0H13.6Z" fill="#FFBE42"/>
                    </svg>
                </div>

                <div class="section--header__card-content">
                    <p class="section--header__card-label">Completed Provider Jobs</p>
                    <h3 class="section--header__card-value">{{ number_format($completedBookings) }}</h3>
                    <span class="section--header__card-desc">Finished bookings from all providers</span>
                </div>
            </div>

            <div class="section--header__card">
                <div class="section--header__card-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <path d="M12 8V12L14.5 14.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </div>

                <div class="section--header__card-content">
                    <p class="section--header__card-label">Pending Provider Requests</p>
                    <h3 class="section--header__card-value">{{ number_format($pendingBookings) }}</h3>
                    <span class="section--header__card-desc">Booking requests waiting for provider action</span>
                </div>
            </div>
        </section>

        <section class="section section--analytics">
            <div class="section--analytics__main">
                <div class="section--analytics__header">
                    <div>
                        <h3>
                            {{ $selectedMonth ? 'Daily Provider Booking Analytics' : 'Monthly Provider Booking Analytics' }}
                        </h3>

                        <p>
                            Platform-wide provider bookings
                            @if ($selectedMonth)
                                for {{ \Carbon\Carbon::create()->month($selectedMonth)->format('F') }} {{ $selectedYear }}
                            @else
                                for {{ $selectedYear }}
                            @endif
                        </p>
                    </div>

                    <form method="GET" action="{{ route('admin.dashboard') }}" class="admin-chart-filter">
                        <select name="year" onchange="this.form.submit()">
                            @for ($filterYear = now()->year; $filterYear >= now()->year - 5; $filterYear--)
                                <option value="{{ $filterYear }}" {{ $selectedYear == $filterYear ? 'selected' : '' }}>
                                    {{ $filterYear }}
                                </option>
                            @endfor
                        </select>

                        <select name="month" onchange="this.form.submit()">
                            <option value="" {{ empty($selectedMonth) ? 'selected' : '' }}>
                                All Months
                            </option>

                            @for ($month = 1; $month <= 12; $month++)
                                <option value="{{ $month }}" {{ $selectedMonth == $month ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                </option>
                            @endfor
                        </select>
                    </form>
                </div>

                <div class="section--analytics__legend">
                    <span class="section--analytics__legend-item section--analytics__legend-item--bookings">
                        <i></i> Bookings
                    </span>
                </div>

                <div class="section--analytics__chart">
                    <canvas id="adminBookingAnalyticsChart"></canvas>
                </div>
            </div>

            {{-- <div class="section--analytics__side">
                <div class="section--analytics__mini-card">
                    <span>Overall Provider Bookings</span>
                    <strong>{{ number_format($totalBookings) }}</strong>
                    <p>Total booking requests across all providers</p>
                </div>

                <div class="section--analytics__mini-card">
                    <span>Completed Provider Jobs</span>
                    <strong>{{ number_format($completedBookings) }}</strong>
                    <p>Finished bookings from all providers</p>
                </div>

                <div class="section--analytics__mini-card">
                    <span>Pending Provider Requests</span>
                    <strong>{{ number_format($pendingBookings) }}</strong>
                    <p>Booking requests waiting for provider action</p>
                </div>
            </div> --}}
            <div class="section--analytics__side">
                <h3 style="font-size: 18px; font-weight: 700">Top Providers</h3>
                <div class="section--analytics__side-header">
                    <form method="GET" action="{{ route('admin.dashboard') }}">
                        <input type="hidden" name="year" value="{{ $selectedYear }}">
                        <input type="hidden" name="month" value="{{ $selectedMonth }}">

                        <select name="provider_ranking" onchange="this.form.submit()">
                            <option value="bookings" {{ $providerRankingMode === 'bookings' ? 'selected' : '' }}>
                                Ranking by bookings
                            </option>
                            <option value="ratings" {{ $providerRankingMode === 'ratings' ? 'selected' : '' }}>
                                Ranking by ratings
                            </option>
                        </select>
                    </form>
                </div>

                <div class="provider-ranking-list">
                    @forelse ($topProviders as $rankIndex => $provider)
                        @php
                            $providerName = trim(($provider->first_name ?? '') . ' ' . ($provider->last_name ?? '')) ?: ($provider->user?->name ?? 'Provider');
                            $providerDate = $provider->created_at ? $provider->created_at->format('Y-m-d') : 'No date';
                        @endphp

                        <div class="provider-ranking-item">
                            <div class="provider-ranking-item__rank provider-ranking-item__rank--{{ $rankIndex + 1 }}">
                                <div class="provider-ranking-item__rank-icon"></div>
                            </div>

                            <div class="provider-ranking-item__avatar">
                                @if (!empty($provider->profile_image))
                                    <img src="{{ asset($provider->profile_image) }}" alt="{{ $providerName }}" loading="lazy">
                                @else
                                    <span>{{ strtoupper(substr($providerName, 0, 1)) }}</span>
                                @endif
                            </div>

                            <div class="provider-ranking-item__info">
                                <strong title="{{ $providerName }}">{{ \Illuminate\Support\Str::limit($providerName, 24) }}</strong>
                                <span>
                                    @if ($providerRankingMode === 'ratings')
                                        {{ number_format($provider->ratings_count) }} {{ \Illuminate\Support\Str::plural('rating', $provider->ratings_count) }}
                                    @else
                                        {{ $providerDate }}
                                    @endif
                                </span>
                            </div>

                            <div class="provider-ranking-item__bookings">
                                @if ($providerRankingMode === 'ratings')
                                    {{ number_format((float) $provider->average_rating, 1) }}
                                @else
                                    {{ number_format($provider->total_bookings) }}
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="provider-ranking-empty">
                            No provider ranking data yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="section section--recent">
            <div class="section--recent__card">
                <div class="section--recent__card-header">
                    <div>
                        <h5>Recent Services</h5>
                        <p>Latest provider services with booking activity.</p>
                    </div>

                    <span class="section--recent__badge">
                        {{ $recentServices->total() }} Total
                    </span>
                </div>

                <div class="section--recent__table-wrapper">
                    <table class="section--recent__table section--recent__table--services">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Provider</th>
                                <th>Category</th>
                                <th>Bookings</th>
                                <th>Status</th>
                                <th>Created</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($recentServices as $service)
                                <tr>
                                    <td>
                                        <div class="section--recent__primary">
                                            <strong title="{{ $service->title }}">
                                                {{ \Illuminate\Support\Str::limit($service->title, 26) }}
                                            </strong>
                                            <span title="{{ $service->service_id }}">
                                                {{ $service->service_id ?? 'No ID' }}
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="section--recent__primary">
                                            <strong>
                                                @if ($service->provider)
                                                    {{ $service->provider->first_name }} {{ $service->provider->last_name }}
                                                @else
                                                    Unknown Provider
                                                @endif
                                            </strong>
                                            <span>Provider</span>
                                        </div>
                                    </td>

                                    <td>
                                        @if ($service->serviceCategory)
                                            <span class="section--recent__category">
                                                {{ \Illuminate\Support\Str::limit($service->serviceCategory->name, 20) }}
                                            </span>
                                        @else
                                            <span class="section--recent__status section--recent__status--disabled">
                                                No Category
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <strong class="section--recent__metric">
                                            {{ number_format($service->dashboard_bookings_count ?? 0) }}
                                        </strong>
                                    </td>

                                    <td>
                                        @if ($service->is_active)
                                            <span class="section--recent__status section--recent__status--active">
                                                Active
                                            </span>
                                        @else
                                            <span class="section--recent__status section--recent__status--disabled">
                                                Disabled
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="section--recent__date">
                                            {{ $service->created_at ? $service->created_at->format('M d, Y') : 'N/A' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="section--recent__empty">
                                        No recent services found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($recentServices->hasPages())
                    <div class="section--recent__pagination">
                        @if ($recentServices->onFirstPage())
                            <span class="section--recent__page-disabled">‹</span>
                        @else
                            <a href="{{ $recentServices->previousPageUrl() }}">‹</a>
                        @endif

                        <span class="section--recent__page-info">
                            {{ $recentServices->currentPage() }} / {{ $recentServices->lastPage() }}
                        </span>

                        @if ($recentServices->hasMorePages())
                            <a href="{{ $recentServices->nextPageUrl() }}">›</a>
                        @else
                            <span class="section--recent__page-disabled">›</span>
                        @endif
                    </div>
                @endif
            </div>

            <div class="section--recent__card">
                <div class="section--recent__card-header">
                    <div>
                        <h5>Recent Users</h5>
                        <p>Newest providers and customers registered in the platform.</p>
                    </div>

                    <span class="section--recent__badge">
                        {{ $recentUsers->total() }} Total
                    </span>
                </div>

                <div class="section--recent__table-wrapper">
                    <table class="section--recent__table section--recent__table--users">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Contact</th>
                                <th>Role</th>
                                <th>Details</th>
                                <th>Status</th>
                                <th>Joined</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($recentUsers as $user)
                                <tr>
                                    <td>
                                        <div class="section--recent__user">
                                            @php
                                                $profileImage = null;

                                                if ($user->role === 'provider' && $user->provider && $user->provider->profile_image) {
                                                    $profileImage = $user->provider->profile_image;
                                                }

                                                if ($user->role === 'customer' && $user->customer && $user->customer->profile_image) {
                                                    $profileImage = $user->customer->profile_image;
                                                }
                                            @endphp

                                            @if ($profileImage)
                                                <img
                                                    class="section--recent__avatar-img"
                                                    src="{{ asset($profileImage) }}"
                                                    alt="{{ $user->name }}"
                                                    loading="lazy"
                                                >
                                            @else
                                                <div class="section--recent__avatar">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                            @endif

                                            <div class="section--recent__primary">
                                                <strong title="{{ $user->name }}">
                                                    {{ \Illuminate\Support\Str::limit($user->name, 22) }}
                                                </strong>
                                                <span>ID: {{ $user->id }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="section--recent__primary">
                                            <strong title="{{ $user->email }}">
                                                {{ \Illuminate\Support\Str::limit($user->email, 26) }}
                                            </strong>

                                            <span>
                                                @if ($user->role === 'provider' && $user->provider)
                                                    {{ $user->provider->phone_number ?? 'No phone' }}
                                                @elseif ($user->role === 'customer' && $user->customer)
                                                    {{ $user->customer->phone_number ?? 'No phone' }}
                                                @else
                                                    No phone
                                                @endif
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="section--recent__role">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="section--recent__date">
                                            @if ($user->role === 'provider' && $user->provider)
                                                {{ $user->provider->profession ?? 'No profession' }}
                                            @elseif ($user->role === 'customer' && $user->customer)
                                                {{ $user->customer->city ?? 'No city' }}
                                            @else
                                                No details
                                            @endif
                                        </span>
                                    </td>

                                    <td>
                                        @if ($user->is_active)
                                            <span class="section--recent__status section--recent__status--active">
                                                Active
                                            </span>
                                        @else
                                            <span class="section--recent__status section--recent__status--disabled">
                                                Disabled
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="section--recent__date">
                                            {{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="section--recent__empty">
                                        No recent users found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($recentUsers->hasPages())
                    <div class="section--recent__pagination">
                        @if ($recentUsers->onFirstPage())
                            <span class="section--recent__page-disabled">‹</span>
                        @else
                            <a href="{{ $recentUsers->previousPageUrl() }}">‹</a>
                        @endif

                        <span class="section--recent__page-info">
                            {{ $recentUsers->currentPage() }} / {{ $recentUsers->lastPage() }}
                        </span>

                        @if ($recentUsers->hasMorePages())
                            <a href="{{ $recentUsers->nextPageUrl() }}">›</a>
                        @else
                            <span class="section--recent__page-disabled">›</span>
                        @endif
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection

@push('extrascripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('adminBookingAnalyticsChart');

        if (!ctx) {
            return;
        }

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($chartLabels),
                datasets: [
                    {
                        label: 'Bookings',
                        data: @json($analyticsBookings),
                        backgroundColor: '#FBBF24',
                        borderRadius: 6,
                        barThickness: 18,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function (ctx) {
                                return 'Bookings: ' + Number(ctx.raw).toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            borderDash: [4, 4],
                            color: '#E5E7EB'
                        },
                        ticks: {
                            callback: value => Number(value).toLocaleString()
                        }
                    }
                }
            }
        });
    });
</script>
@endpush