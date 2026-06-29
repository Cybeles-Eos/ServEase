@extends('admin.layouts.auth')

@section('title', 'Admin Audit Logs')

@section('content')
    @include('admin.layouts.header')

    <main class="main-dash-uix page-admin-bookings page-admin-audit-logs dash-sp">
        <p style="margin: 0; font-size: 14px; opacity: .6">Review recorded Servease activity across bookings, services, users, reports, profiles, applicants, and settings.</p>
        <hr style="margin-top: 10px">

        <section class="section__table">
            <div class="page-admin-bookings__table-head page-admin-audit-logs__table-head th--audith">
                <div class="page-admin-bookings__table-title">
                    <h4>Audit Logs</h4>
                    <p class="section__table--label">
                        System activity recorded from actual account, booking, service, and admin actions.
                    </p>
                </div>

                <form method="GET" action="{{ route('admin.audit-logs') }}" class="page-admin-bookings__filters page-admin-audit-logs__filters" style="justify-content: flex-end !important">
                    <div class="page-admin-bookings__search page-admin-audit-logs__search">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                            <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M21 21L16.65 16.65" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                        <input type="text" name="search" value="{{ $search }}" placeholder="Search audit logs...">
                    </div>

                    <div class="page-admin-bookings__filter-group page-admin-audit-logs__filter-group">
                        {{-- <div class="page-admin-bookings__select-wrap">
                            <select name="module" class="page-admin-bookings__select">
                                <option value="">All Modules</option>
                                @foreach ($moduleOptions as $moduleOption)
                                    <option value="{{ $moduleOption }}" {{ $module === $moduleOption ? 'selected' : '' }}>
                                        {{ $moduleOption }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}

                        <div class="page-admin-bookings__select-wrap">
                            <select name="event" class="page-admin-bookings__select">
                                <option value="">All Activities</option>
                                @foreach ($eventOptions as $eventOption)
                                    <option value="{{ $eventOption }}" {{ $event === $eventOption ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $eventOption)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <input type="date" name="date_from" value="{{ $dateFrom }}" class="page-admin-audit-logs__date" aria-label="Date from">
                        <input type="date" name="date_to" value="{{ $dateTo }}" class="page-admin-audit-logs__date" aria-label="Date to">
                    </div>

                    <div class="page-admin-bookings__filter-actions page-admin-audit-logs__actions">
                        <button type="submit" class="page-admin-bookings__filter-btn">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                <path d="M22 3H2L10 12.46V19L14 21V12.46L22 3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Filter
                        </button>

                        @if(request()->hasAny(['search', 'module', 'event', 'date_from', 'date_to']))
                            <a href="{{ route('admin.audit-logs') }}" class="page-admin-bookings__clear-btn">
                                Clear
                            </a>
                        @endif

                        <button type="button" class="page-admin-bookings__filter-btn" onclick="window.print()">
                            <i class="fas fa-print"></i>
                            Print Audit Log
                        </button>
                    </div>
                </form>
            </div>

            <div class="admin-ustbl-main">
                <div class="admin-ustbl-main-c admin-ustbl-main-c--audit-logs">
                    <div class="admin-ustbl-main-c__head">
                        <div>Date/Time</div>
                        <div>Actor</div>
                        <div>Role</div>
                        <div>Module</div>
                        <div>Activity</div>
                        <div>Subject</div>
                        <div>Details</div>
                    </div>

                    @forelse ($auditLogs as $log)
                        @php
                            $eventClass = \Illuminate\Support\Str::slug($log->event);
                            $moduleClass = \Illuminate\Support\Str::slug($log->module);
                        @endphp

                        <div class="admin-ustbl-main-c__tbody">
                            <div class="audit-table-cell">
                                <strong>{{ $log->created_at?->format('Y-m-d') ?? 'No date' }}</strong>
                                <span>{{ $log->created_at?->format('H:i:s') ?? '' }}</span>
                            </div>
                            <div class="audit-table-cell">
                                <strong title="{{ $log->actor_name }}">{{ \Illuminate\Support\Str::limit($log->actor_name ?: 'System', 28) }}</strong>
                            </div>
                            <div class="audit-table-cell">
                                <span>{{ ucfirst($log->actor_role ?: 'system') }}</span>
                            </div>
                            <div class="audit-table-cell">
                                <span class="audit-log-badge audit-log-badge--module audit-log-badge--{{ $moduleClass }}">
                                    {{ $log->module }}
                                </span>
                            </div>
                            <div class="audit-table-cell">
                                <span class="audit-log-badge audit-log-badge--event audit-log-badge--{{ $eventClass }}">
                                    {{ strtoupper(str_replace('_', ' ', $log->event)) }}
                                </span>
                            </div>
                            <div class="audit-table-cell">
                                <strong title="{{ $log->subject_label }}">{{ \Illuminate\Support\Str::limit($log->subject_label ?: 'System record', 32) }}</strong>
                            </div>
                            <div class="audit-table-cell audit-table-cell--description">
                                <p>{{ $log->description }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="admin-ustbl-main-c__tbody admin-ustbl-main-c__tbody--empty">
                            No audit log records yet
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="page-admin-bookings__pagination">
                <p style="margin: 0">
                    Showing {{ $auditLogs->total() ? $auditLogs->firstItem() : 0 }} to {{ $auditLogs->total() ? $auditLogs->lastItem() : 0 }} of {{ $auditLogs->total() }} results
                </p>

                @if ($auditLogs->hasPages())
                    <div class="page-admin-bookings__pagination-actions">
                        @if ($auditLogs->onFirstPage())
                            <span class="page-admin-bookings__page-btn is-disabled" aria-disabled="true">
                                <svg width="14" height="14" viewBox="0 0 20 20" fill="none">
                                    <path d="M12.5 15L7.5 10L12.5 5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        @else
                            <a href="{{ $auditLogs->previousPageUrl() }}" class="page-admin-bookings__page-btn" aria-label="Previous page">
                                <svg width="14" height="14" viewBox="0 0 20 20" fill="none">
                                    <path d="M12.5 15L7.5 10L12.5 5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        @endif

                        <span class="page-admin-bookings__page-info">
                            {{ $auditLogs->currentPage() }} / {{ $auditLogs->lastPage() }}
                        </span>

                        @if ($auditLogs->hasMorePages())
                            <a href="{{ $auditLogs->nextPageUrl() }}" class="page-admin-bookings__page-btn page-admin-bookings__page-btn--active" aria-label="Next page">
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
