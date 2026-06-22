@extends('admin.layouts.auth')

@section('title', 'Provider Reports')

@push('extrastylesheets')
    <style>
        .admin-reports__status-select {
            position: relative;
            display: inline-flex;
            align-items: center;
        }

        .admin-reports__status-select select {
            padding-right: 34px;
        }

        .admin-reports__status-select::after {
            content: "";
            position: absolute;
            right: 12px;
            top: 47%;
            width: 7px;
            height: 7px;
            border-right: 1.5px solid currentColor;
            border-bottom: 1.5px solid currentColor;
            transform: translateY(-50%) rotate(45deg);
            pointer-events: none;
            opacity: .75;
        }
    </style>
@endpush

@section('content')
    @include('admin.layouts.header')

    <main class="main-dash-uix admin-reports dash-sp">
        <section class="admin-reports__head">
            <div>
                <p>Provider Quality Control</p>
                <h1>Reports</h1>
                <span>Review customer reports by provider, service, reason, and account risk level.</span>
            </div>

            <form method="GET" action="{{ route('admin.reports') }}">
                <div class="admin-reports__status-select">
                    <select name="status" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="OPEN" {{ $status === 'OPEN' ? 'selected' : '' }}>Open</option>
                        <option value="REVIEWED" {{ $status === 'REVIEWED' ? 'selected' : '' }}>Reviewed</option>
                        <option value="DISMISSED" {{ $status === 'DISMISSED' ? 'selected' : '' }}>Dismissed</option>
                    </select>
                </div>
            </form>
        </section>

        <section class="admin-reports__cards">
            <div>
                <span>Total Reports</span>
                <strong>{{ number_format($totalReports) }}</strong>
                <p>All customer-submitted provider reports</p>
            </div>
            <div>
                <span>Open Reports</span>
                <strong>{{ number_format($openReports) }}</strong>
                <p>Reports waiting for admin review</p>
            </div>
            <div>
                <span>Subject to Disable</span>
                <strong>{{ number_format($subjectProviderCount) }}</strong>
                <p>Providers with any health signal at 20/20</p>
            </div>
        </section>

        <section class="admin-reports__insights">
            <div class="admin-reports__panel">
                <div class="admin-reports__panel-head">
                    <h2>Provider Account Health</h2>
                    <p>Ranked by reports, declined requests, and provider cancellations.</p>
                </div>

                <div class="admin-reports__summary-list">
                    @forelse ($providerSummaries as $provider)
                        <article class="admin-reports__health-row">
                            <div class="admin-reports__health-main">
                                <strong>{{ $provider->provider_name }}</strong>
                                <span>{{ $provider->provider_email ?: 'No email' }}</span>
                                <div class="admin-reports__health-bars">
                                    <p>
                                        <span>Reports</span>
                                        <b>{{ $provider->reports_count }}/{{ \App\Models\Provider::ACCOUNT_HEALTH_LIMIT }}</b>
                                        <i><u class="{{ $provider->reports_count >= \App\Models\Provider::ACCOUNT_HEALTH_LIMIT ? 'is-danger-bar' : '' }}" style="width: {{ min(100, round(($provider->reports_count / \App\Models\Provider::ACCOUNT_HEALTH_LIMIT) * 100)) }}%"></u></i>
                                    </p>
                                    <p>
                                        <span>Declined</span>
                                        <b>{{ $provider->declined_count }}/{{ \App\Models\Provider::ACCOUNT_HEALTH_LIMIT }}</b>
                                        <i><u class="{{ $provider->declined_count >= \App\Models\Provider::ACCOUNT_HEALTH_LIMIT ? 'is-danger-bar' : '' }}" style="width: {{ min(100, round(($provider->declined_count / \App\Models\Provider::ACCOUNT_HEALTH_LIMIT) * 100)) }}%"></u></i>
                                    </p>
                                    <p>
                                        <span>Cancelled</span>
                                        <b>{{ $provider->provider_cancelled_count }}/{{ \App\Models\Provider::ACCOUNT_HEALTH_LIMIT }}</b>
                                        <i><u class="{{ $provider->provider_cancelled_count >= \App\Models\Provider::ACCOUNT_HEALTH_LIMIT ? 'is-danger-bar' : '' }}" style="width: {{ min(100, round(($provider->provider_cancelled_count / \App\Models\Provider::ACCOUNT_HEALTH_LIMIT) * 100)) }}%"></u></i>
                                    </p>
                                </div>
                            </div>
                            <div class="admin-reports__health-action">
                                <b>{{ number_format($provider->max_count) }}</b>
                                <em class="{{ $provider->risk_class }}">{{ $provider->risk_label }}</em>

                                @if($provider->is_subject && $provider->user_is_active)
                                    <form method="POST"
                                          action="{{ route('admin.reports.provider.deactivate', $provider->provider_id) }}"
                                          class="admin-reports__deactivate-form">
                                        @csrf
                                        <button type="submit">Deactivate Account</button>
                                    </form>
                                @elseif(! $provider->user_is_active)
                                    <span class="admin-reports__disabled-label">Account Disabled</span>
                                @endif
                            </div>
                        </article>
                    @empty
                        <p class="admin-reports__empty">No provider health signals yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="admin-reports__panel">
                <div class="admin-reports__panel-head">
                    <h2>Reported Services</h2>
                    <p>Services with the most customer reports.</p>
                </div>

                <div class="admin-reports__summary-list">
                    @forelse ($serviceSummaries as $service)
                        <article>
                            <div>
                                <strong>{{ \Illuminate\Support\Str::limit($service->service_title, 42, '...') }}</strong>
                                <span>{{ $service->provider_name }}</span>
                            </div>
                            <div>
                                <b>{{ number_format($service->reports_count) }}</b>
                                <em class="{{ $service->reports_count >= 20 ? 'is-danger' : ($service->reports_count > 0 ? 'is-warning' : 'is-normal') }}">
                                    {{ $service->reports_count >= 20 ? 'High Risk' : 'Reported' }}
                                </em>
                            </div>
                        </article>
                    @empty
                        <p class="admin-reports__empty">No service reports yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="admin-reports__panel">
                <div class="admin-reports__panel-head">
                    <h2>Top Reasons</h2>
                    <p>Most common customer report reasons.</p>
                </div>

                <div class="admin-reports__reason-list">
                    @forelse ($reasonBreakdown as $reason)
                        <div>
                            <span>{{ $reason->reason }}</span>
                            <strong>{{ number_format($reason->reports_count) }}</strong>
                        </div>
                    @empty
                        <p class="admin-reports__empty">No reasons recorded yet.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="admin-reports__table">
            <div class="admin-reports__panel-head">
                <h2>Report Records</h2>
                <p>Latest customer reports with booking and service context.</p>
            </div>

            <div class="admin-reports__table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Provider</th>
                            <th>Customer</th>
                            <th>Service</th>
                            <th>Reason</th>
                            <th>Provider Count</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reports as $report)
                            @php
                                $providerName = trim(($report->provider->first_name ?? '') . ' ' . ($report->provider->last_name ?? '')) ?: 'Provider';
                                $customerName = trim(($report->customer->first_name ?? '') . ' ' . ($report->customer->last_name ?? '')) ?: 'Customer';
                                $providerHealth = $providerHealthById->get($report->provider_id);
                                $providerCount = $providerHealth?->max_count ?? \App\Models\ServiceReport::where('provider_id', $report->provider_id)->count();
                                $riskLabel = $providerHealth?->risk_label
                                    ?? ($providerCount >= 20 ? 'Subject to Deactivation Review' : ($providerCount >= 10 ? 'Needs Review' : 'Monitoring'));
                            @endphp

                            <tr>
                                <td>
                                    <strong>{{ $providerName }}</strong>
                                    <span>{{ $report->provider->user->email ?? 'No email' }}</span>
                                </td>
                                <td>{{ $customerName }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($report->service->title ?? 'Service', 34, '...') }}</td>
                                <td>
                                    <strong>{{ $report->reason }}</strong>
                                    @if($report->details)
                                        <span>{{ \Illuminate\Support\Str::limit($report->details, 80, '...') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <b>{{ number_format($providerCount) }}</b>
                                    <span>{{ $riskLabel }}</span>
                                </td>
                                <td>
                                    <em>{{ ucfirst(strtolower($report->status)) }}</em>
                                </td>
                                <td>{{ $report->created_at?->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="admin-reports__empty-cell">No reports found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($reports->hasPages())
                <div class="admin-reports__pagination">
                    {{ $reports->links() }}
                </div>
            @endif
        </section>
    </main>
@endsection

@push('extrascripts')
    <script>
        document.querySelectorAll('.admin-reports__deactivate-form').forEach(function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Deactivate provider account?',
                    text: 'The provider will no longer be able to access provider features.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#991B1B',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Deactivate account',
                    cancelButtonText: 'Cancel'
                }).then(function (result) {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
