@extends('admin.layouts.auth')

{{-- Meta Section --}}
@section('title', 'General Settings')

{{-- Page Content --}}
@section('content')
    @include('admin.layouts.header')

    @push('extrastylesheets')
        <style>
            .smtp-usage-summary {
                display: grid;
                grid-template-columns: minmax(0, 1fr) auto;
                gap: 18px;
                align-items: start;
                margin-bottom: 18px;
            }

            .smtp-usage-copy h5,
            .smtp-usage-card h5 {
                margin: 0;
            }

            .smtp-usage-copy p {
                margin: 6px 0 0;
                font-size: 13px;
                line-height: 1.5;
                color: #6b7280;
            }

            .smtp-usage-metrics {
                display: grid;
                grid-template-columns: repeat(3, minmax(120px, 1fr));
                gap: 12px;
                margin: 16px 0;
            }

            .smtp-usage-metric {
                border: 1px solid #e6e8ec;
                border-radius: 8px;
                padding: 12px 14px;
                background: #fff;
            }

            .smtp-usage-metric span {
                display: block;
                font-size: 12px;
                color: #7a818c;
                margin-bottom: 6px;
            }

            .smtp-usage-metric strong {
                display: block;
                font-size: 22px;
                line-height: 1;
                color: #202124;
                font-weight: 700;
            }

            .smtp-usage-reset {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                min-height: 34px;
                padding: 0 12px;
                border-radius: 8px;
                background: #f7f8fa;
                color: #4b5563;
                font-size: 12px;
                font-weight: 600;
                white-space: nowrap;
            }

            .smtp-usage-off-badge {
                display: inline-flex;
                align-items: center;
                min-height: 22px;
                padding: 0 8px;
                border-radius: 999px;
                background: #fff1f2;
                color: #be123c;
                font-size: 11px;
                font-weight: 700;
            }

            .smtp-usage-actions {
                display: flex;
                align-items: center;
                gap: 12px;
                justify-content: flex-end;
                flex-wrap: wrap;
            }

            .smtp-otp-toggle {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                cursor: pointer;
                font-size: 12px;
                font-weight: 600;
                color: #4b5563;
                user-select: none;
            }

            .smtp-otp-toggle input {
                position: absolute;
                opacity: 0;
                pointer-events: none;
            }

            .smtp-otp-toggle__track {
                position: relative;
                width: 42px;
                height: 24px;
                border-radius: 999px;
                background: #d1d5db;
                transition: background-color .2s ease;
            }

            .smtp-otp-toggle__track::after {
                content: '';
                position: absolute;
                top: 3px;
                left: 3px;
                width: 18px;
                height: 18px;
                border-radius: 50%;
                background: #fff;
                box-shadow: 0 1px 3px rgba(15, 23, 42, .2);
                transition: transform .2s ease;
            }

            .smtp-otp-toggle input:checked + .smtp-otp-toggle__track {
                background: #FDB932;
            }

            .smtp-otp-toggle input:checked + .smtp-otp-toggle__track::after {
                transform: translateX(18px);
            }

            .smtp-usage-records {
                margin-top: 8px;
            }

            .smtp-usage-records table {
                width: 100%;
                border-collapse: collapse;
            }

            .smtp-usage-records th,
            .smtp-usage-records td {
                padding: 10px 0;
                border-top: 1px solid #eef0f3;
                font-size: 13px;
                color: #3f454d;
            }

            .smtp-usage-records th {
                color: #7a818c;
                font-weight: 600;
                text-align: left;
            }

            .smtp-usage-records td:last-child,
            .smtp-usage-records th:last-child {
                text-align: right;
            }

            .smtp-usage-progress {
                height: 7px;
                border-radius: 999px;
                background: #eef0f3;
                overflow: hidden;
            }

            .smtp-usage-progress span {
                display: block;
                height: 100%;
                border-radius: inherit;
                background: #FDB932;
            }

            .smtp-usage-pagination {
                margin-top: 14px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                border-top: 1px solid #EEF0F3;
                padding-top: 12px;
            }

            .smtp-usage-pagination p {
                margin: 0;
                color: #374151;
                font-size: 12px;
                line-height: 1.4;
            }

            .smtp-usage-pagination-actions {
                display: flex;
                align-items: center;
                gap: 7px;
            }

            .smtp-usage-page-btn,
            .smtp-usage-page-info {
                min-width: 30px;
                height: 30px;
                border-radius: 4px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 12px;
                text-decoration: none;
            }

            .smtp-usage-page-btn {
                border: 1px solid #E5E7EB;
                background: #FFFFFF;
                color: #374151;
            }

            .smtp-usage-page-btn--active,
            .smtp-usage-page-btn:hover {
                border-color: #111827;
                background: #111827;
                color: #FFFFFF;
            }

            .smtp-usage-page-btn.is-disabled {
                background: #F9FAFB;
                color: #9CA3AF;
                cursor: not-allowed;
            }

            .smtp-usage-page-btn svg {
                display: block;
            }

            .smtp-usage-page-info {
                border: 1px solid #E5E7EB;
                background: #FFFFFF;
                color: #6B7280;
                padding: 0 9px;
                white-space: nowrap;
            }

            @media screen and (max-width: 768px) {
                .smtp-usage-summary,
                .smtp-usage-metrics {
                    grid-template-columns: 1fr;
                }

                .smtp-usage-reset {
                    width: fit-content;
                }

                .smtp-usage-actions {
                    justify-content: flex-start;
                }

                .smtp-usage-pagination {
                    align-items: flex-start;
                    flex-direction: column;
                }
            }
        </style>
    @endpush

    <main class="main-dash-uix page-admin-setting dash-sp">
        <p style="margin: 0; font-size: 14px; opacity: .6">General Setting</p>
        <hr style="margin-top: 10px">

        <section class="p-a-gs-card section smtp-usage-card">
            <div class="smtp-usage-summary">
                <div class="smtp-usage-copy">
                    <h5>SMTP Usage</h5>
                    <p>Daily Brevo email verification usage for account creation and OTP resends.</p>
                </div>

                <div class="smtp-usage-actions">
                    <div class="smtp-usage-reset">
                        Resets daily at 12:00 AM PH time

                        @unless ($platformSettings->otp_enabled)
                            <span class="smtp-usage-off-badge">OTP Feature Off</span>
                        @endunless
                    </div>

                    <form action="{{ route('admin.setting.otp-feature.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <label class="smtp-otp-toggle">
                            <input
                                type="checkbox"
                                name="otp_enabled"
                                value="1"
                                onchange="this.form.submit()"
                                {{ $platformSettings->otp_enabled ? 'checked' : '' }}
                            >
                            <span class="smtp-otp-toggle__track" aria-hidden="true"></span>
                            <span>Use OTP</span>
                        </label>
                    </form>
                </div>
            </div>

            <div class="smtp-usage-metrics">
                <div class="smtp-usage-metric">
                    <span>Used today</span>
                    <strong>{{ number_format($smtpUsedToday) }}</strong>
                </div>

                <div class="smtp-usage-metric">
                    <span>Remaining today</span>
                    <strong>{{ number_format($smtpRemainingToday) }}</strong>
                </div>

                <div class="smtp-usage-metric">
                    <span>Daily limit</span>
                    <strong>{{ number_format($smtpDailyLimit) }}</strong>
                </div>
            </div>

            <div class="smtp-usage-progress" aria-label="SMTP usage progress">
                <span style="width: {{ min(($smtpUsedToday / max($smtpDailyLimit, 1)) * 100, 100) }}%"></span>
            </div>

            <div class="smtp-usage-records">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Used</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($smtpUsageRecords as $smtpUsage)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($smtpUsage->getRawOriginal('date'))->format('M d, Y') }}</td>
                                <td>{{ number_format($smtpUsage->used) }} / {{ number_format($smtpDailyLimit) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">No SMTP usage records yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="smtp-usage-pagination">
                <p>
                    Showing {{ $smtpUsageRecords->total() ? $smtpUsageRecords->firstItem() : 0 }} to {{ $smtpUsageRecords->total() ? $smtpUsageRecords->lastItem() : 0 }} of {{ $smtpUsageRecords->total() }} results
                </p>

                @if ($smtpUsageRecords->hasPages())
                    <div class="smtp-usage-pagination-actions">
                        @if ($smtpUsageRecords->onFirstPage())
                            <span class="smtp-usage-page-btn is-disabled" aria-disabled="true">
                                <svg width="14" height="14" viewBox="0 0 20 20" fill="none">
                                    <path d="M12.5 15L7.5 10L12.5 5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        @else
                            <a href="{{ $smtpUsageRecords->previousPageUrl() }}" class="smtp-usage-page-btn" aria-label="Previous page">
                                <svg width="14" height="14" viewBox="0 0 20 20" fill="none">
                                    <path d="M12.5 15L7.5 10L12.5 5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        @endif

                        <span class="smtp-usage-page-info">
                            {{ $smtpUsageRecords->currentPage() }} / {{ $smtpUsageRecords->lastPage() }}
                        </span>

                        @if ($smtpUsageRecords->hasMorePages())
                            <a href="{{ $smtpUsageRecords->nextPageUrl() }}" class="smtp-usage-page-btn smtp-usage-page-btn--active" aria-label="Next page">
                                <svg width="14" height="14" viewBox="0 0 20 20" fill="none">
                                    <path d="M7.5 5L12.5 10L7.5 15" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        @else
                            <span class="smtp-usage-page-btn is-disabled" aria-disabled="true">
                                <svg width="14" height="14" viewBox="0 0 20 20" fill="none">
                                    <path d="M7.5 5L12.5 10L7.5 15" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        @endif
                    </div>
                @endif
            </div>
        </section>

        <section class="p-a-gs-card section service-category">
            <div class="p-a-gs-card-header">
                <h5>Service Category</h5>

                <form
                    action="{{ route('admin.setting.service-categories.store') }}"
                    method="POST"
                    class="mct-inline-create-form"
                >
                    @csrf

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Add category name here..."
                        required
                    >

                    <button type="submit">
                        Add Category
                    </button>
                </form>
            </div>

            @error('name')
                <small class="mct-form-error">{{ $message }}</small>
            @enderror

            <hr style="margin-bottom: 12px">

            {{-- <div class="mct-table-topbar">
                <form action="{{ route('admin.setting') }}" method="GET" class="mct-mini-search-form">
                    <input
                        type="text"
                        name="category_search"
                        value="{{ $categorySearch ?? '' }}"
                        placeholder="Search category..."
                    >

                    <button type="submit">
                        Search
                    </button>

                    @if (!empty($categorySearch))
                        <a href="{{ route('admin.setting') }}">
                            Clear
                        </a>
                    @endif
                </form>

                <span class="mct-result-count">
                    Showing {{ $serviceCategories->count() }} of {{ $serviceCategories->total() }}
                </span>
            </div> --}}

            <div class="mct-table-wrapper">
                <table class="mct-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Created At</th>
                            <th class="mct-text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($serviceCategories as $category)
                            <tr>
                                <td>
                                    <div class="mct-name-with-status">
                                        <span>{{ $category->name }}</span>

                                        @if ($category->is_active)
                                            <small class="mct-status mct-status-active">Active</small>
                                        @else
                                            <small class="mct-status mct-status-disabled">Disabled</small>
                                        @endif
                                    </div>
                                </td>

                                <td>
                                    {{ $category->created_at->format('M d, Y') }}
                                </td>

                                <td>
                                    <div class="mct-actions">
                                        <button
                                            type="button"
                                            class="mct-action-btn"
                                            title="View"
                                            onclick="openViewCategoryModal(this)"
                                            data-name="{{ $category->name }}"
                                            data-status="{{ $category->is_active ? 'Active' : 'Disabled' }}"
                                            data-created="{{ $category->created_at->format('M d, Y h:i A') }}"
                                        >
                                            <i class="fa fa-eye"></i>
                                        </button>

                                        <button
                                            type="button"
                                            class="mct-action-btn"
                                            title="Edit"
                                            onclick="openEditCategoryModal(this)"
                                            data-name="{{ $category->name }}"
                                            data-active="{{ $category->is_active ? 1 : 0 }}"
                                            data-update-url="{{ route('admin.setting.service-categories.update', $category) }}"
                                        >
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M3 13V10.6389L10.3333 3.31944C10.4444 3.21759 10.5672 3.13889 10.7017 3.08333C10.8361 3.02778 10.9772 3 11.125 3C11.2728 3 11.4163 3.02778 11.5556 3.08333C11.6948 3.13889 11.8152 3.22222 11.9167 3.33333L12.6806 4.11111C12.7917 4.21296 12.8728 4.33333 12.9239 4.47222C12.975 4.61111 13.0004 4.75 13 4.88889C13 5.03704 12.9746 5.17833 12.9239 5.31278C12.8731 5.44722 12.792 5.56981 12.6806 5.68056L5.36111 13H3ZM11.1111 5.66667L11.8889 4.88889L11.1111 4.11111L10.3333 4.88889L11.1111 5.66667Z" fill="#535353"/>
                                            </svg>
                                        </button>

                                        <form
                                            action="{{ route('admin.setting.service-categories.destroy', $category) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this category?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="mct-action-btn mct-action-delete" title="Delete">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="mct-empty">
                                    @if (!empty($categorySearch))
                                        No service categories found for "{{ $categorySearch }}".
                                    @else
                                        No service categories found.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($serviceCategories->hasPages())
                <div class="mct-pagination">
                    <p>
                        Showing {{ $serviceCategories->total() ? $serviceCategories->firstItem() : 0 }} to {{ $serviceCategories->total() ? $serviceCategories->lastItem() : 0 }} of {{ $serviceCategories->total() }} results
                    </p>

                    <div class="mct-pagination-actions">
                        @if ($serviceCategories->onFirstPage())
                            <span class="mct-page-disabled"><i class="fa fa-chevron-left"></i></span>
                        @else
                            <a href="{{ $serviceCategories->previousPageUrl() }}"><i class="fa fa-chevron-left"></i></a>
                        @endif

                        <span class="mct-page-info">
                            {{ $serviceCategories->currentPage() }} / {{ $serviceCategories->lastPage() }}
                        </span>

                        @if ($serviceCategories->hasMorePages())
                            <a href="{{ $serviceCategories->nextPageUrl() }}"><i class="fa fa-chevron-right"></i></a>
                        @else
                            <span class="mct-page-disabled"><i class="fa fa-chevron-right"></i></span>
                        @endif
                    </div>
                </div>

            @endif
        </section>
        
        <section class="p-a-gs-card section platform-contact">
            <div class="p-a-gs-card-header">
                <div>
                    <h5>Platform Contact Settings</h5>
                    <p class="p-a-gs-card-subtitle">Contact details shown across the site footer, contact page, email templates, and admin support.</p>
                </div>
            </div>

            <hr style="margin-bottom: 16px">

            <form
                action="{{ route('admin.setting.platform-contact.update') }}"
                method="POST"
                class="p-a-gs-settings-form"
            >
                @csrf
                @method('PUT')

                <div class="p-a-gs-form-grid">
                    <div class="p-a-gs-form-group">
                        <label for="platform_email">Platform Email</label>
                        <input
                            type="email"
                            id="platform_email"
                            name="platform_email"
                            value="{{ old('platform_email', $platformSettings->platform_email) }}"
                            placeholder="support@servease.com"
                        >
                        @error('platform_email')
                            <small class="mct-form-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="p-a-gs-form-group">
                        <label for="phone_number">Phone Number</label>
                        <input
                            type="text"
                            id="phone_number"
                            name="phone_number"
                            value="{{ old('phone_number', $platformSettings->phone_number) }}"
                            placeholder="09XXXXXXXXX"
                        >
                        @error('phone_number')
                            <small class="mct-form-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="p-a-gs-form-group">
                        <label for="facebook_page">Facebook Page</label>
                        <input
                            type="url"
                            id="facebook_page"
                            name="facebook_page"
                            value="{{ old('facebook_page', $platformSettings->facebook_page) }}"
                            placeholder="https://facebook.com/yourpage"
                        >
                        @error('facebook_page')
                            <small class="mct-form-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="p-a-gs-form-group">
                        <label for="support_hours">Support Hours</label>
                        <input
                            type="text"
                            id="support_hours"
                            name="support_hours"
                            value="{{ old('support_hours', $platformSettings->support_hours) }}"
                            placeholder="Mon–Sat, 8:00 AM – 5:00 PM"
                        >
                        @error('support_hours')
                            <small class="mct-form-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="p-a-gs-form-group p-a-gs-form-group--full">
                        <label for="office_address">Office Address</label>
                        <textarea
                            id="office_address"
                            name="office_address"
                            rows="3"
                            placeholder="Burgos Barangay Hall Rodriguez, Rizal"
                        >{{ old('office_address', $platformSettings->office_address) }}</textarea>
                        @error('office_address')
                            <small class="mct-form-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="p-a-gs-form-actions">
                    <button type="submit" class="p-a-gs-btn-save">
                        Save Contact Settings
                    </button>
                </div>
            </form>
        </section>

        <section class="p-a-gs-card section platform-branding">
            <div class="p-a-gs-card-header">
                <div>
                    <h5>Platform Branding &amp; Legal</h5>
                    <p class="p-a-gs-card-subtitle">Platform identity and legal links used in the footer, emails, and public pages.</p>
                </div>
            </div>

            <hr style="margin-bottom: 16px">

            <form
                action="{{ route('admin.setting.platform-branding.update') }}"
                method="POST"
                class="p-a-gs-settings-form"
            >
                @csrf
                @method('PUT')

                <div class="p-a-gs-form-grid">
                    <div class="p-a-gs-form-group">
                        <label for="platform_name">Platform Name</label>
                        <input
                            type="text"
                            id="platform_name"
                            name="platform_name"
                            value="{{ old('platform_name', $platformSettings->platform_name) }}"
                            placeholder="ServEase"
                        >
                        @error('platform_name')
                            <small class="mct-form-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="p-a-gs-form-group">
                        <label for="service_area">Service Area</label>
                        <input
                            type="text"
                            id="service_area"
                            name="service_area"
                            value="{{ old('service_area', $platformSettings->service_area) }}"
                            placeholder="Burgos Barangay Hall Rodriguez, Rizal"
                        >
                        @error('service_area')
                            <small class="mct-form-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="p-a-gs-form-group p-a-gs-form-group--full">
                        <label for="platform_tagline">Platform Tagline</label>
                        <input
                            type="text"
                            id="platform_tagline"
                            name="platform_tagline"
                            value="{{ old('platform_tagline', $platformSettings->platform_tagline) }}"
                            placeholder="Service help with ease and convenience."
                        >
                        @error('platform_tagline')
                            <small class="mct-form-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="p-a-gs-form-group">
                        <label for="privacy_policy_url">Privacy Policy URL</label>
                        <input
                            type="url"
                            id="privacy_policy_url"
                            name="privacy_policy_url"
                            value="{{ old('privacy_policy_url', $platformSettings->privacy_policy_url) }}"
                            placeholder="https://yoursite.com/privacy"
                        >
                        @error('privacy_policy_url')
                            <small class="mct-form-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="p-a-gs-form-group">
                        <label for="terms_url">Terms &amp; Conditions URL</label>
                        <input
                            type="url"
                            id="terms_url"
                            name="terms_url"
                            value="{{ old('terms_url', $platformSettings->terms_url) }}"
                            placeholder="https://yoursite.com/terms"
                        >
                        @error('terms_url')
                            <small class="mct-form-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="p-a-gs-form-actions">
                    <button type="submit" class="p-a-gs-btn-save">
                        Save Branding Settings
                    </button>
                </div>
            </form>
        </section>


    </main>

    {{-- Modals For Service Category --}}
    <div class="mct-modal" id="editCategoryModal">
        <div class="mct-modal-backdrop" onclick="closeEditCategoryModal()"></div>

        <div class="mct-modal-box">
            <div class="mct-modal-header">
                <h5>Edit Service Category</h5>

                <button type="button" onclick="closeEditCategoryModal()">
                    &times;
                </button>
            </div>

            <form method="POST" id="editCategoryForm">
                @csrf
                @method('PUT')

                <div class="mct-modal-body">
                    <div class="mct-form-group">
                        <label>Category Name</label>
                        <input
                            type="text"
                            name="name"
                            id="editCategoryName"
                            required
                        >
                    </div>

                    <div class="mct-toggle-row">
                        <div>
                            <label>Enable Category</label>
                            <small>Turn off to disable this category.</small>
                        </div>

                        <label class="mct-switch">
                            <input
                                type="checkbox"
                                name="is_active"
                                value="1"
                                id="editCategoryStatus"
                            >
                            <span></span>
                        </label>
                    </div>
                </div>

                <div class="mct-modal-footer">
                    <button type="button" class="mct-btn-light" onclick="closeEditCategoryModal()">
                        Cancel
                    </button>

                    <button type="submit" class="mct-btn-dark">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="mct-modal" id="viewCategoryModal">
        <div class="mct-modal-backdrop" onclick="closeViewCategoryModal()"></div>

        <div class="mct-modal-box">
            <div class="mct-modal-header">
                <h5>View Service Category</h5>

                <button type="button" onclick="closeViewCategoryModal()">
                    &times;
                </button>
            </div>

            <div class="mct-modal-body">
                <div class="mct-view-row">
                    <span>Name</span>
                    <strong id="viewCategoryName"></strong>
                </div>

                <div class="mct-view-row">
                    <span>Status</span>
                    <strong id="viewCategoryStatus"></strong>
                </div>

                <div class="mct-view-row">
                    <span>Created At</span>
                    <strong id="viewCategoryCreated"></strong>
                </div>
            </div>

            <div class="mct-modal-footer">
                <button type="button" class="mct-btn-light" onclick="closeViewCategoryModal()">
                    Close
                </button>
            </div>
        </div>
    </div>


    {{-- Only Show When Someone is login --}}
@endsection
@push('extrascripts')
    {{-- For ServiceCategory --}}
    <script>
        function openEditCategoryModal(button) {
            const modal = document.getElementById('editCategoryModal');
            const form = document.getElementById('editCategoryForm');
            const nameInput = document.getElementById('editCategoryName');
            const statusInput = document.getElementById('editCategoryStatus');

            form.action = button.dataset.updateUrl;
            nameInput.value = button.dataset.name;
            statusInput.checked = button.dataset.active === '1';

            modal.classList.add('show');
        }

        function closeEditCategoryModal() {
            document.getElementById('editCategoryModal').classList.remove('show');
        }

        function openViewCategoryModal(button) {
            document.getElementById('viewCategoryName').innerText = button.dataset.name;
            document.getElementById('viewCategoryStatus').innerText = button.dataset.status;
            document.getElementById('viewCategoryCreated').innerText = button.dataset.created;

            document.getElementById('viewCategoryModal').classList.add('show');
        }

        function closeViewCategoryModal() {
            document.getElementById('viewCategoryModal').classList.remove('show');
        }
    </script>
@endpush
