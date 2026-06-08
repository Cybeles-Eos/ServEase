@extends('admin.layouts.auth')

@section('title', 'Provider Reports')

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
                <select name="status" onchange="this.form.submit()">
                    <option value="">All Status</option>
                    <option value="OPEN" {{ $status === 'OPEN' ? 'selected' : '' }}>Open</option>
                    <option value="REVIEWED" {{ $status === 'REVIEWED' ? 'selected' : '' }}>Reviewed</option>
                    <option value="DISMISSED" {{ $status === 'DISMISSED' ? 'selected' : '' }}>Dismissed</option>
                </select>
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
                <p>Providers with 20 or more reports</p>
            </div>
        </section>

        <section class="admin-reports__insights">
            <div class="admin-reports__panel">
                <div class="admin-reports__panel-head">
                    <h2>Provider Report Status</h2>
                    <p>Ranked by total reports across all services.</p>
                </div>

                <div class="admin-reports__summary-list">
                    @forelse ($providerSummaries as $provider)
                        @php
                            $riskLabel = $provider->reports_count >= 20
                                ? 'Subject to Disable'
                                : ($provider->reports_count >= 10 ? 'Needs Review' : 'Monitoring');
                            $riskClass = $provider->reports_count >= 20
                                ? 'is-danger'
                                : ($provider->reports_count >= 10 ? 'is-warning' : 'is-normal');
                        @endphp

                        <article>
                            <div>
                                <strong>{{ $provider->provider_name }}</strong>
                                <span>{{ $provider->provider_email ?: 'No email' }}</span>
                            </div>
                            <div>
                                <b>{{ number_format($provider->reports_count) }}</b>
                                <em class="{{ $riskClass }}">{{ $riskLabel }}</em>
                            </div>
                        </article>
                    @empty
                        <p class="admin-reports__empty">No provider reports yet.</p>
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
                                $providerCount = $providerSummaries->firstWhere('provider_id', $report->provider_id)?->reports_count
                                    ?? \App\Models\ServiceReport::where('provider_id', $report->provider_id)->count();
                                $riskLabel = $providerCount >= 20
                                    ? 'Subject to Disable'
                                    : ($providerCount >= 10 ? 'Needs Review' : 'Monitoring');
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
