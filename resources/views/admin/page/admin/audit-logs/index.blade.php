@extends('admin.layouts.auth')

@section('title', 'Admin Audit Logs')

@section('content')
    @include('admin.layouts.header')

    <main class="main-dash-uix page-admin-bookings page-admin-audit-logs dash-sp">
        <p style="margin: 0; font-size: 14px; opacity: .6">Review recorded Servease activity across bookings, services, users, reports, profiles, applicants, and settings.</p>
        <hr style="margin-top: 10px">

        <section class="section__table">
            <div class="page-admin-bookings__table-head page-admin-audit-logs__table-head">
                <div class="page-admin-bookings__table-title">
                    <h4>Audit Logs</h4>
                    <p class="section__table--label">
                        System activity recorded from actual account, booking, service, and admin actions.
                    </p>
                </div>
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
