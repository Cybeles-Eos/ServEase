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

        <section class="section section--recent">
            <div class="section--recent__card">
                <div class="section--recent__card-header">
                    <div>
                        <h5>Recent Services</h5>
                        <p>Latest services added by providers.</p>
                    </div>
                </div>

                <div class="section--recent__table-wrapper">
                    <table class="section--recent__table section--recent__table--services">
                        <thead>
                            <tr>
                                <th>Service ID</th>
                                <th>Service Name</th>
                                <th>Provider</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Created At</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($recentServices as $service)
                                <tr>
                                    <td>
                                        <span class="section--recent__text section--recent__text--id" title="{{ $service->service_id }}">
                                            {{ $service->service_id }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="section--recent__text section--recent__text--name" title="{{ $service->title }}">
                                            {{ $service->title }}
                                        </span>
                                    </td>

                                    <td>
                                        <span
                                            class="section--recent__text section--recent__text--provider"
                                            title="{{ $service->provider ? $service->provider->first_name . ' ' . $service->provider->last_name : 'Unknown Provider' }}"
                                        >
                                            @if ($service->provider)
                                                {{ $service->provider->first_name }} {{ $service->provider->last_name }}
                                            @else
                                                Unknown Provider
                                            @endif
                                        </span>
                                    </td>

                                    <td>
                                        @if ($service->serviceCategory && $service->serviceCategory->is_active)
                                            <span class="section--recent__text section--recent__text--category" title="{{ $service->serviceCategory->name }}">
                                                {{ $service->serviceCategory->name }}
                                            </span>
                                        @else
                                            <span class="section--recent__status section--recent__status--disabled">
                                                No Category
                                            </span>
                                        @endif
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
                                        <span class="section--recent__text section--recent__text--date" title="{{ $service->created_at->format('M d, Y') }}">
                                            {{ $service->created_at->format('M d, Y') }}
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
                            <span class="section--recent__page-disabled">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                    <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        @else
                            <a href="{{ $recentServices->previousPageUrl() }}">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                    <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        @endif

                        <span class="section--recent__page-info">
                            {{ $recentServices->currentPage() }} / {{ $recentServices->lastPage() }}
                        </span>

                        @if ($recentServices->hasMorePages())
                            <a href="{{ $recentServices->nextPageUrl() }}">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                    <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        @else
                            <span class="section--recent__page-disabled">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                    <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        @endif
                    </div>
                @endif
            </div>

            <div class="section--recent__card">
                <div class="section--recent__card-header">
                    <div>
                        <h5>Recent Users</h5>
                        <p>Newest providers and customers.</p>
                    </div>
                </div>

                <div class="section--recent__table-wrapper">
                    <table class="section--recent__table section--recent__table--users">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Joined At</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($recentUsers as $user)
                                <tr>
                                    <td>
                                        <span class="section--recent__text section--recent__text--user" title="{{ $user->name }}">
                                            {{ $user->name }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="section--recent__text section--recent__text--email" title="{{ $user->email }}">
                                            {{ $user->email }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="section--recent__role">
                                            {{ ucfirst($user->role) }}
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
                                        <span class="section--recent__text section--recent__text--date" title="{{ $user->created_at->format('M d, Y') }}">
                                            {{ $user->created_at->format('M d, Y') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="section--recent__empty">
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
                            <span class="section--recent__page-disabled">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                    <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        @else
                            <a href="{{ $recentUsers->previousPageUrl() }}">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                    <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        @endif

                        <span class="section--recent__page-info">
                            {{ $recentUsers->currentPage() }} / {{ $recentUsers->lastPage() }}
                        </span>

                        @if ($recentUsers->hasMorePages())
                            <a href="{{ $recentUsers->nextPageUrl() }}">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                    <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        @else
                            <span class="section--recent__page-disabled">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                    <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        @endif
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection

@push('extrascripts')
@endpush