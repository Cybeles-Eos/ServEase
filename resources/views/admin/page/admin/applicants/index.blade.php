@extends('admin.layouts.auth')

{{-- Meta Section --}}
@section('title', 'Applicants Page')

@push('extrastylesheets')
<style>

</style>
@endpush

@section('content')
@include('admin.layouts.header')

<main class="main-dash-uix page-admin-applicants dash-sp">
    <p style="margin: 0; font-size: 14px; opacity: .6">Review provider applications and activate approved accounts.</p>
    <hr style="margin-top: 10px">

    <section class="section__table">
        <div class="page-admin-applicants__table-head">
            <div class="page-admin-applicants__table-title">
                <h4>Applicants</h4>
                <p class="section__table--label">
                    Review provider applications and activate approved accounts.
                </p>
            </div>

            <form method="GET" action="{{ route('admin.applicants') }}" class="page-admin-applicants__filters">
                <div class="page-admin-applicants__search">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                        <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"/>
                        <path d="M21 21L16.65 16.65"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"/>
                    </svg>

                    <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search applicants...">
                </div>

                <div class="page-admin-applicants__filter-group">
                    <select name="status" class="page-admin-applicants__select">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="declined" {{ request('status') === 'declined' ? 'selected' : '' }}>Declined</option>
                    </select>
                </div>

                <div class="page-admin-applicants__filter-actions">
                    <button type="submit" class="page-admin-applicants__filter-btn">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                            <path d="M22 3H2L10 12.46V19L14 21V12.46L22 3Z"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"/>
                        </svg>
                        Filter
                    </button>

                    @if(request()->hasAny(['search', 'status']))
                        <a href="{{ route('admin.applicants') }}" class="page-admin-applicants__clear-btn">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>
        
        <div class="admin-ustbl-main">
            <div class="admin-ustbl-main-c">
                <div class="admin-ustbl-main-c__head">
                    <div>Name</div>
                    <div>Email</div>
                    <div>Profession</div>
                    <div>Phone Number</div>
                    <div>Experience</div>
                    <div>Status</div>
                    <div>Actions</div>
                </div>

                @forelse ($applicants as $provider)
                    @php
                        $fullName = trim(($provider->first_name ?? '') . ' ' . ($provider->last_name ?? ''));
                        $fullName = $fullName !== '' ? $fullName : 'Provider Applicant';

                        $email = $provider->user?->email ?? $provider->personal_email ?? 'No email';
                        $phone = $provider->phone_number ?? 'No phone';
                        $profession = $provider->profession ?? 'N/A';
                        $experience = ($provider->year_exp ?? 0) . ' years';

                        $statusClass = match($provider->application_status) {
                            'accepted' => 'bg-success text-white',
                            'declined' => 'bg-danger text-white',
                            default => 'bg-warning text-dark',
                        };
                    @endphp

                    <div class="admin-ustbl-main-c__tbody">
                        <div class="prvstble-mctb-name">{{ $fullName }}</div>
                        <div class="prvstble-mctb-serv">{{ $email }}</div>
                        <div class="prvstble-mctb-date">{{ $profession }}</div>
                        <div class="prvstble-mctb-date">{{ $phone }}</div>
                        <div class="prvstble-mctb-date">{{ $experience }}</div>

                        <div class="prvstble-mctb-date">
                            <span class="badge {{ $statusClass }}" style="font-size: 11px">
                                {{ ucfirst($provider->application_status ?? 'pending') }}
                            </span>
                        </div>

                        <div class="prvstble-mctb-act">
                            <a href="{{ route('admin.applicants.show', $provider->id) }}"
                            title="View applicant"
                            class="applicant-action applicant-action--view">
                                <svg width="14" height="14" viewBox="0 0 16 16" fill="none">
                                    <path d="M8 3C4.5 3 1.73 5.11 1 8c.73 2.89 3.5 5 7 5s6.27-2.11 7-5c-.73-2.89-3.5-5-7-5Zm0 8.33a3.33 3.33 0 1 1 0-6.66 3.33 3.33 0 0 1 0 6.66Zm0-5.33a1.67 1.67 0 1 0 0 3.33 1.67 1.67 0 0 0 0-3.33Z"
                                        fill="currentColor"/>
                                </svg>
                            </a>

                            @if($provider->application_status !== 'accepted')
                                <form method="POST" action="{{ route('admin.applicants.accept', $provider->id) }}" class="applicant-accept-form">
                                    @csrf
                                    <button type="submit"
                                            title="Accept applicant"
                                            class="applicant-action applicant-action--accept">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                            <path d="M20 6L9 17L4 12"
                                                stroke="currentColor"
                                                stroke-width="2.2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                                </form>
                            @endif

                            @if($provider->application_status !== 'declined')
                                <form method="POST" action="{{ route('admin.applicants.decline', $provider->id) }}" class="applicant-decline-form">
                                    @csrf
                                    <input type="hidden" name="remarks" value="Declined by admin.">

                                    <button type="submit"
                                            title="Decline applicant"
                                            class="applicant-action applicant-action--decline">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                            <path d="M18 6L6 18M6 6L18 18"
                                                stroke="currentColor"
                                                stroke-width="2.2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="admin-ustbl-main-c__tbody" style="height: 55px; font-size: 14px; text-align:center; margin: 0; display: flex; align-items: center; justify-content:center;">
                        No provider applications yet
                    </div>
                @endforelse


            </div>
        </div>
    </section>
</main>
@endsection

@push('extrascripts')
<script>
    $(document).on('submit', '.applicant-accept-form', function (e) {
        e.preventDefault();

        const form = this;

        Swal.fire({
            title: 'Accept applicant?',
            text: 'This will activate the provider account and allow the provider to login.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, accept',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#22C55E',
            cancelButtonColor: '#6B7280',
            reverseButtons: true,
        }).then(function (result) {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    $(document).on('submit', '.applicant-decline-form', function (e) {
        e.preventDefault();

        const form = this;

        Swal.fire({
            title: 'Decline applicant?',
            text: 'This provider will remain inactive and will not be able to login.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, decline',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#DF4545',
            cancelButtonColor: '#6B7280',
            reverseButtons: true,
        }).then(function (result) {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>
@endpush