@extends('admin.layouts.auth')

@section('title', 'Applicant Details')

@push('extrastylesheets')
<style>
    .applicant-show {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .applicant-show__breadcrumb {
        display: flex;
        align-items: center;
        gap: 9px;
        flex-wrap: wrap;
        font-size: 13px;
        margin-bottom: 4px;
    }

    .applicant-show__breadcrumb a {
        color: #6B7280;
        text-decoration: none;
        font-weight: 500;
    }

    .applicant-show__breadcrumb a:hover {
        color: #FDB932;
    }

    .applicant-show__breadcrumb span {
        color: #202020;
        font-weight: 600;
    }

    .applicant-show__header {
        background: #fff;
        border: 1px solid #E0E2E7;
        border-radius: 14px;
        padding: 18px;
        display: flex;
        justify-content: space-between;
        gap: 16px;
        align-items: center;
    }

    .applicant-show__profile {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .applicant-show__avatar {
        width: 58px;
        height: 58px;
        border-radius: 50%;
        background: #FFBE42;
        color: #fff;
        font-weight: 800;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex: 0 0 58px;
    }

    .applicant-show__avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .applicant-show__profile h1 {
        margin: 0;
        font-size: 22px;
        font-weight: 800;
        color: #202020;
    }

    .applicant-show__profile p {
        margin: 3px 0 0;
        font-size: 13px;
        color: #6B7280;
    }

    .applicant-show__actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .applicant-show__actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .applicant-show__actions form {
        margin: 0;
    }

    .applicant-action {
        min-height: 30px;
        padding: 7px 10px;
        border-radius: 7px;
        border: 1px solid transparent;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 800;
        line-height: 1;
        cursor: pointer;
        text-decoration: none;
        transition: 0.2s ease;
        white-space: nowrap;
    }

    .applicant-action svg {
        flex: 0 0 auto;
    }

    .applicant-action--accept {
        background: #DCFCE7;
        color: #166534;
    }

    .applicant-action--accept:hover {
        background: #BBF7D0;
    }

    .applicant-action--decline {
        background: #FEE2E2;
        color: #991B1B;
    }

    .applicant-action--decline:hover {
        background: #FECACA;
    }

    .applicant-show__grid {
        display: grid;
        grid-template-columns: 380px 1fr;
        gap: 16px;
        align-items: start;
    }

    .applicant-show-card {
        background: #fff;
        border: 1px solid #E0E2E7;
        border-radius: 14px;
        padding: 18px;
    }

    .applicant-show-card h3 {
        margin: 0 0 14px;
        font-size: 17px;
        font-weight: 800;
        color: #202020;
    }

    .applicant-detail-row {
        display: grid;
        grid-template-columns: 130px 1fr;
        gap: 10px;
        padding: 9px 0;
        border-bottom: 1px solid #F1F1F1;
        font-size: 13px;
    }

    .applicant-detail-row:last-child {
        border-bottom: none;
    }

    .applicant-detail-row span {
        color: #858688;
        font-weight: 600;
    }

    .applicant-detail-row strong {
        color: #202020;
        font-weight: 700;
        word-break: break-word;
    }

    .application-badge {
        display: inline-flex;
        padding: 4px 9px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
    }

    .application-badge--pending {
        background: #FEF3C7;
        color: #92400E;
    }

    .application-badge--accepted {
        background: #DCFCE7;
        color: #166534;
    }

    .application-badge--declined {
        background: #FEE2E2;
        color: #991B1B;
    }

    .resume-viewer {
        width: 100%;
        height: 720px;
        border: 1px solid #E0E2E7;
        border-radius: 10px;
        overflow: hidden;
        background: #F9FAFB;
    }

    .resume-viewer iframe {
        width: 100%;
        height: 100%;
        border: none;
    }

    .resume-empty {
        height: 320px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px dashed #D1D5DB;
        border-radius: 10px;
        color: #6B7280;
        font-size: 14px;
    }

    .resume-actions {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        align-items: center;
        margin-bottom: 12px;
    }

    .resume-actions a {
        color: #2563EB;
        font-size: 13px;
        font-weight: 800;
        text-decoration: none;
    }

    .resume-actions a:hover {
        text-decoration: underline;
    }

    @media (max-width: 1100px) {
        .applicant-show__grid {
            grid-template-columns: 1fr;
        }

        .resume-viewer {
            height: 560px;
        }
    }

    @media (max-width: 640px) {
        .applicant-show__header {
            flex-direction: column;
            align-items: flex-start;
        }

        .applicant-detail-row {
            grid-template-columns: 1fr;
            gap: 3px;
        }
    }
.applicant-documents {
    display: flex;
    flex-direction: column;
    gap: 18px;
}

.applicant-document-block {
    width: 100%;
}

.applicant-document-block + .applicant-document-block {
    padding-top: 18px;
    border-top: 1px solid #E0E2E7;
}
</style>
@endpush

@section('content')
@include('admin.layouts.header')

@php
    $fullName = trim(($provider->first_name ?? '') . ' ' . ($provider->last_name ?? ''));
    $initials = strtoupper(substr($provider->first_name ?? 'P', 0, 1) . substr($provider->last_name ?? '', 0, 1));

    $resumeUrl = $provider->resume_path
        ? route('admin.applicants.document', [$provider, 'resume'])
        : null;

    $barangayClearanceUrl = $provider->barangay_clearance_path
        ? route('admin.applicants.document', [$provider, 'barangay-clearance'])
        : null;
@endphp

<main class="main-dash-uix page-admin-applicants dash-sp">
    <div class="applicant-show">
        <div class="applicant-show__breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>

            <svg width="4" height="7" viewBox="0 0 4 7" fill="none">
                <path d="M0.384033 0.320312L2.88403 3.32031L0.384033 6.32031" stroke="#FDB932"/>
            </svg>

            <a href="{{ route('admin.applicants') }}">Applicants</a>

            <svg width="4" height="7" viewBox="0 0 4 7" fill="none">
                <path d="M0.384033 0.320312L2.88403 3.32031L0.384033 6.32031" stroke="#FDB932"/>
            </svg>

            <span>{{ $fullName ?: 'Provider Applicant' }}</span>
        </div>

        <section class="applicant-show__header">
            <div class="applicant-show__profile">
                <div class="applicant-show__avatar">
                    @if(!empty($provider->profile_image))
                        <img src="{{ asset($provider->profile_image) }}" alt="{{ $fullName }}">
                    @else
                        {{ $initials }}
                    @endif
                </div>

                <div>
                    <h1>{{ $fullName ?: 'Provider Applicant' }}</h1>
                    <p>{{ $provider->user?->email ?? 'No email' }}</p>
                    <p>{{ $provider->phone_number ?? 'No phone' }}</p>
                </div>
            </div>

            <div class="applicant-show__actions">
                @if($provider->application_status !== 'accepted')
                    <form method="POST"
                        action="{{ route('admin.applicants.accept', $provider->id) }}"
                        class="applicant-accept-form">
                        @csrf

                        <button type="submit"
                                class="applicant-action applicant-action--accept"
                                title="Accept applicant">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                                <path d="M20 6L9 17L4 12"
                                    stroke="currentColor"
                                    stroke-width="2.2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"/>
                            </svg>
                            <span>Accept</span>
                        </button>
                    </form>
                @endif

                @if($provider->application_status !== 'declined')
                    <form method="POST"
                        action="{{ route('admin.applicants.decline', $provider->id) }}"
                        class="applicant-decline-form">
                        @csrf

                        <input type="hidden" name="remarks" value="Declined by admin.">

                        <button type="submit"
                                class="applicant-action applicant-action--decline"
                                title="Decline applicant">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                                <path d="M18 6L6 18M6 6L18 18"
                                    stroke="currentColor"
                                    stroke-width="2.2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"/>
                            </svg>
                            <span>Decline</span>
                        </button>
                    </form>
                @endif
            </div>
        </section>

        <div class="applicant-show__grid">
            <section class="applicant-show-card">
                <h3>Applicant Details</h3>

                <div class="applicant-detail-row">
                    <span>Status</span>
                    <strong>
                        <span class="application-badge application-badge--{{ $provider->application_status }}">
                            {{ ucfirst($provider->application_status) }}
                        </span>
                    </strong>
                </div>

                <div class="applicant-detail-row">
                    <span>First Name</span>
                    <strong>{{ $provider->first_name ?? 'N/A' }}</strong>
                </div>

                <div class="applicant-detail-row">
                    <span>Last Name</span>
                    <strong>{{ $provider->last_name ?? 'N/A' }}</strong>
                </div>

                <div class="applicant-detail-row">
                    <span>Email</span>
                    <strong>{{ $provider->user?->email ?? 'N/A' }}</strong>
                </div>

                <div class="applicant-detail-row">
                    <span>Phone</span>
                    <strong>{{ $provider->phone_number ?? 'N/A' }}</strong>
                </div>

                <div class="applicant-detail-row">
                    <span>Profession</span>
                    <strong>{{ $provider->profession ?? 'N/A' }}</strong>
                </div>

                <div class="applicant-detail-row">
                    <span>Experience</span>
                    <strong>{{ $provider->year_exp ?? 0 }} years</strong>
                </div>

                <div class="applicant-detail-row">
                    <span>Address</span>
                    <strong>{{ $provider->home_address ?? 'N/A' }}</strong>
                </div>

                <div class="applicant-detail-row">
                    <span>City</span>
                    <strong>{{ $provider->city ?? $provider->province ?? 'N/A' }}</strong>
                </div>

                <div class="applicant-detail-row">
                    <span>Barangay</span>
                    <strong>{{ $provider->barangay ?? 'N/A' }}</strong>
                </div>

                <div class="applicant-detail-row">
                    <span>ZIP Code</span>
                    <strong>{{ $provider->zipcode ?? 'N/A' }}</strong>
                </div>

                <div class="applicant-detail-row">
                    <span>Date Applied</span>
                    <strong>{{ $provider->created_at?->format('M d, Y h:i A') ?? 'N/A' }}</strong>
                </div>

                @if(!empty($provider->application_reviewed_at))
                    <div class="applicant-detail-row">
                        <span>Reviewed At</span>
                        <strong>{{ \Carbon\Carbon::parse($provider->application_reviewed_at)->format('M d, Y h:i A') }}</strong>
                    </div>
                @endif

                @if(!empty($provider->application_remarks))
                    <div class="applicant-detail-row">
                        <span>Remarks</span>
                        <strong>{{ $provider->application_remarks }}</strong>
                    </div>
                @endif
            </section>

            {{-- <section class="applicant-show-card">
                <div class="resume-actions">
                    <h3 style="margin:0;">Resume Viewer</h3>

                    @if($resumeUrl)
                        <a href="{{ $resumeUrl }}" target="_blank">
                            Open in new tab
                        </a>
                    @endif
                </div>

                @if($resumeUrl)
                    <div class="resume-viewer">
                        <iframe src="{{ $resumeUrl }}"></iframe>
                    </div>
                @else
                    <div class="resume-empty">
                        No resume uploaded by this provider.
                    </div>
                @endif
            </section> --}}
<section class="applicant-show-card applicant-documents">
    <div class="applicant-document-block">
        <div class="resume-actions">
            <h3 style="margin:0;">Barangay Clearance Viewer</h3>

            @if($barangayClearanceUrl)
                <a href="{{ $barangayClearanceUrl }}" target="_blank">
                    Open in new tab
                </a>
            @endif
            @if($provider->application_status !== 'declined')
                <form method="POST" action="{{ route('admin.applicants.decline', $provider->id) }}" class="applicant-decline-form applicant-resubmit-form">
                    @csrf
                    <input type="hidden" name="remarks" value="Please resubmit your barangay clearance.">
                    <input type="hidden" name="resubmission_required_documents[]" value="barangay_clearance">
                    <button type="submit" class="applicant-action applicant-action--decline applicant-action--text">Request resubmit</button>
                </form>
            @endif
        </div>

        @if($barangayClearanceUrl)
            <div class="resume-viewer">
                <iframe src="{{ $barangayClearanceUrl }}"></iframe>
            </div>
        @else
            <div class="resume-empty">
                No barangay clearance uploaded by this provider.
            </div>
        @endif
    </div>

    <div class="applicant-document-block">
        <div class="resume-actions">
            <h3 style="margin:0;">Resume Viewer</h3>

            @if($resumeUrl)
                <a href="{{ $resumeUrl }}" target="_blank">
                    Open in new tab
                </a>
            @endif
            @if($provider->application_status !== 'declined')
                <form method="POST" action="{{ route('admin.applicants.decline', $provider->id) }}" class="applicant-decline-form applicant-resubmit-form">
                    @csrf
                    <input type="hidden" name="remarks" value="Please resubmit your resume.">
                    <input type="hidden" name="resubmission_required_documents[]" value="resume">
                    <button type="submit" class="applicant-action applicant-action--decline applicant-action--text">Request resubmit</button>
                </form>
            @endif
        </div>

        @if($resumeUrl)
            <div class="resume-viewer">
                <iframe src="{{ $resumeUrl }}"></iframe>
            </div>
        @else
            <div class="resume-empty">
                No resume uploaded by this provider.
            </div>
        @endif
    </div>
</section>
        </div>
    </div>
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

        const isResubmitRequest = form.classList.contains('applicant-resubmit-form');

        Swal.fire({
            title: isResubmitRequest ? 'Request resubmission?' : 'Decline applicant?',
            text: isResubmitRequest
                ? 'This will decline the current application and ask the provider to upload the selected document again.'
                : 'This will decline the provider application.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: isResubmitRequest ? 'Request resubmit' : 'Yes, decline',
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
