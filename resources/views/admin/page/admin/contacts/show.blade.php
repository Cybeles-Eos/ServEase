@extends('admin.layouts.auth')

@section('title', 'View Contact Message')

@push('extrastylesheets')
<style>
    .admin-contacts--show {
        width: 100%;
        min-height: calc(100vh - 74px);
        background-color: #F5F7FA;
        padding: 15px;
        padding-bottom: 25px;
    }

    .admin-contacts__head {
        width: 100%;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 18px;
        padding-bottom: 14px;
        border-bottom: 1px solid #E0E2E7;
    }

    .admin-contacts__eyebrow {
        margin: 0 0 5px;
        color: #FFBE42;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .admin-contacts__title {
        margin: 0;
        color: #171515;
        font-size: 28px;
        font-weight: 700;
        line-height: 1.15;
    }

    .admin-contacts__text {
        margin: 8px 0 0;
        color: #667085;
        font-size: 14px;
    }

    .admin-contacts__reset {
        min-height: 38px;
        border: 1px solid #E0E2E7;
        border-radius: 5px;
        padding: 9px 13px;
        background: #FFFFFF;
        color: #171515;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
    }

    .admin-contacts__reset:hover {
        border-color: #FFBE42;
        background: #FFF7E6;
        color: #171515;
    }

    .admin-contacts__show-card {
        width: 100%;
        margin-top: 20px;
        border: 1px solid #E0E2E7;
        border-radius: 2px;
        background: #FFFFFF;
        padding: 20px;
    }

    .admin-contacts__info-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        border: 1px solid #E0E2E7;
        border-bottom: none;
    }

    .admin-contacts__info {
        min-height: 88px;
        padding: 15px;
        border-right: 1px solid #E0E2E7;
        border-bottom: 1px solid #E0E2E7;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 7px;
        min-width: 0;
    }

    .admin-contacts__info:nth-child(3n) {
        border-right: none;
    }

    .admin-contacts__info span,
    .admin-contacts__message span {
        color: #667085;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .admin-contacts__info strong {
        color: #171515;
        font-size: 14px;
        font-weight: 600;
        line-height: 1.35;
        overflow-wrap: anywhere;
    }

    .admin-contacts__message {
        margin-top: 18px;
        border: 1px solid #E0E2E7;
        border-radius: 2px;
        padding: 18px;
        background: #FCFCFD;
    }

    .admin-contacts__message p {
        margin: 10px 0 0;
        color: #171515;
        font-size: 14px;
        line-height: 1.65;
        white-space: pre-wrap;
        overflow-wrap: anywhere;
    }

    .cont-show__breadcrumb {
        display: flex;
        align-items: center;
        gap: 9px;
        flex-wrap: wrap;
        font-size: 13px;
        margin-bottom: 4px;
    }

    .cont-show__breadcrumb a {
        color: #6B7280;
        text-decoration: none;
        font-weight: 500;
    }

    .cont-show__breadcrumb a:hover {
        color: #FDB932;
    }

    .cont-show__breadcrumb span {
        color: #202020;
        font-weight: 600;
    }

    @media (max-width: 992px) {
        .admin-contacts__head {
            flex-direction: column;
        }

        .admin-contacts__info-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .admin-contacts__info:nth-child(3n) {
            border-right: 1px solid #E0E2E7;
        }

        .admin-contacts__info:nth-child(2n) {
            border-right: none;
        }
    }

    @media (max-width: 592px) {
        .admin-contacts__show-card {
            padding: 15px;
        }

        .admin-contacts__info-grid {
            grid-template-columns: 1fr;
        }

        .admin-contacts__info,
        .admin-contacts__info:nth-child(2n),
        .admin-contacts__info:nth-child(3n) {
            border-right: none;
        }
    }
</style>
@endpush

@section('content')
    @include('admin.layouts.header')

    <main class="main-dash-uix admin-contacts admin-contacts--show dash-sp">
        <p style="margin: 0; font-size: 14px; opacity: .6">
            View contact messages, booking questions, provider concerns, and platform suggestions.
        </p>
        <hr style="margin-top: 10px">

        <div class="cont-show__breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>

            <svg width="4" height="7" viewBox="0 0 4 7" fill="none">
                <path d="M0.384033 0.320312L2.88403 3.32031L0.384033 6.32031" stroke="#FDB932"/>
            </svg>

            <a href="{{ url('admin/contacts') }}">Contacts</a>

            <svg width="4" height="7" viewBox="0 0 4 7" fill="none">
                <path d="M0.384033 0.320312L2.88403 3.32031L0.384033 6.32031" stroke="#FDB932"/>
            </svg>

            <span>Contact #{{ $contact->id }}</span>
        </div>

        <section class="admin-contacts__show-card">
            <h3 class="mb-4">Contact Info</h3>
            <div class="admin-contacts__info-grid">
                <div class="admin-contacts__info">
                    <span>Contact ID</span>
                    <strong>#{{ $contact->id }}</strong>
                </div>

                <div class="admin-contacts__info">
                    <span>Name</span>
                    <strong>{{ $contact->fullname }}</strong>
                </div>

                <div class="admin-contacts__info">
                    <span>Email</span>
                    <strong>{{ $contact->email }}</strong>
                </div>

                <div class="admin-contacts__info">
                    <span>Phone</span>
                    <strong>{{ $contact->phone ?? 'N/A' }}</strong>
                </div>

                <div class="admin-contacts__info">
                    <span>Subject</span>
                    <strong>{{ $contact->subject }}</strong>
                </div>

                <div class="admin-contacts__info">
                    <span>Date Sent</span>
                    <strong>{{ $contact->created_at->format('M d, Y h:i A') }}</strong>
                </div>
            </div>

            <div class="admin-contacts__message">
                <span>Message</span>
                <p>{{ $contact->message ?: 'No message provided.' }}</p>
            </div>
        </section>
    </main>
@endsection

@push('extrascripts')
@endpush
