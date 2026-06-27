@extends('admin.layouts.auth')

@section('title', 'Customer Requests - Servease')

@push('extrastylesheets')
<style>
    .customer-requests-workspace {
        display: grid;
        grid-template-columns: minmax(300px, 390px) minmax(0, 1fr);
        gap: 18px;
        align-items: start;
        padding: 15px;
        padding-top: 25px;
        padding-left: 0;
    }

    .customer-request-panel,
    .customer-request-card,
    .customer-request-stat-card {
        border: 1px solid #E4E7EC;
        border-radius: 8px;
        background: #fff;
    }

    .customer-request-panel {
        padding: 18px;
    }

    .customer-request-panel__head {
        margin-bottom: 16px;
    }

    .customer-request-panel__head h3,
    .customer-request-list-head h3 {
        margin: 0;
        color: #171515;
        font-size: 18px;
        line-height: 1.2;
        font-weight: 800;
    }

    .customer-request-panel__head p,
    .customer-request-list-head p {
        margin: 6px 0 0;
        color: #667085;
        font-size: 12px;
        line-height: 1.45;
    }

    .customer-request-form {
        display: grid;
        gap: 12px;
    }

    .customer-request-form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .customer-request-field {
        display: grid;
        gap: 6px;
        min-width: 0;
    }

    .customer-request-field label {
        margin: 0;
        color: #344054;
        font-size: 12px;
        font-weight: 700;
    }

    .customer-request-field input,
    .customer-request-field textarea,
    .customer-request-field select {
        width: 100%;
        border: 1px solid #D0D5DD;
        border-radius: 6px;
        background: #fff;
        padding: 9px 10px;
        color: #171515;
        font-size: 13px;
        outline: none;
    }

    .customer-request-field textarea {
        min-height: 86px;
        resize: vertical;
    }

    .customer-request-error {
        color: #dc2626;
        font-size: 11px;
    }

    .customer-request-submit,
    .customer-request-action {
        border: 0;
        border-radius: 6px;
        min-height: 38px;
        padding: 0 14px;
        background: #FFBE42;
        color: #171515;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
    }

    .customer-request-action--complete {
        background: #22C55E;
        color: #fff;
    }

    .customer-request-list-area {
        display: grid;
        gap: 14px;
        min-width: 0;
    }

    .customer-request-list-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
    }

    .customer-request-filter {
        position: relative;
        min-width: 170px;
    }

    .customer-request-filter select {
        width: 100%;
        height: 38px;
        border: 1px solid #D0D5DD;
        border-radius: 6px;
        background: #fff;
        color: #344054;
        font-size: 12px;
        padding: 0 34px 0 12px;
        appearance: none;
        outline: none;
    }

    .customer-request-filter svg {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
    }

    .customer-request-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 10px;
    }

    .customer-request-stat-card {
        padding: 13px;
    }

    .customer-request-stat-card span {
        display: block;
        color: #667085;
        font-size: 11px;
        font-weight: 600;
    }

    .customer-request-stat-card strong {
        display: block;
        margin-top: 6px;
        color: #171515;
        font-size: 21px;
        line-height: 1;
        font-weight: 800;
    }

    .customer-request-card {
        overflow: hidden;
    }

    .customer-request-card-main {
        display: grid;
        grid-template-columns: 170px minmax(0, 1fr);
    }

    .customer-request-card-main img {
        width: 100%;
        height: 100%;
        min-height: 172px;
        object-fit: cover;
        background: #F2F4F7;
    }

    .customer-request-card-body {
        display: grid;
        gap: 10px;
        padding: 15px;
        min-width: 0;
    }

    .customer-request-card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
    }

    .customer-request-status {
        display: inline-flex;
        align-items: center;
        min-height: 24px;
        padding: 0 9px;
        border-radius: 999px;
        background: #FFF7E6;
        color: #B45309;
        font-size: 11px;
        font-weight: 800;
        text-transform: capitalize;
    }

    .customer-request-status--accepted {
        background: #ECFDF5;
        color: #15803D;
    }

    .customer-request-status--completed {
        background: #EFF6FF;
        color: #1D4ED8;
    }

    .customer-request-price {
        color: #171515;
        font-size: 14px;
        font-weight: 800;
        white-space: nowrap;
    }

    .customer-request-card h4 {
        margin: 0;
        color: #171515;
        font-size: 17px;
        line-height: 1.25;
        font-weight: 800;
    }

    .customer-request-card p {
        margin: 0;
        color: #667085;
        font-size: 12px;
        line-height: 1.45;
    }

    .customer-request-card-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .customer-request-chip {
        display: inline-flex;
        align-items: center;
        min-height: 26px;
        border-radius: 5px;
        background: #F7F8FA;
        padding: 0 9px;
        color: #475467;
        font-size: 11px;
        font-weight: 700;
    }

    .customer-request-applications {
        border-top: 1px solid #EEF0F3;
        padding: 13px 15px 15px;
    }

    .customer-request-applications h5 {
        margin: 0 0 8px;
        color: #171515;
        font-size: 13px;
        font-weight: 800;
    }

    .customer-request-application {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        padding: 10px 0;
        border-top: 1px solid #F2F4F7;
    }

    .customer-request-application:first-of-type {
        border-top: 0;
        padding-top: 0;
    }

    .customer-request-application strong {
        color: #171515;
        font-size: 13px;
        font-weight: 800;
    }

    .customer-request-empty {
        border: 1px solid #E4E7EC;
        border-radius: 8px;
        background: #fff;
        padding: 28px;
        text-align: center;
    }

    .customer-request-empty h3 {
        margin: 0;
        color: #171515;
        font-size: 18px;
        font-weight: 800;
    }

    .customer-request-empty p {
        margin: 6px 0 0;
        color: #667085;
        font-size: 13px;
    }

    .customer-request-panel .filepond--root {
        font-family: inherit;
        margin-bottom: 0;
    }

    .customer-request-panel .filepond--panel-root {
        background-color: #fff !important;
        border: 1.5px dashed #D0D5DD;
    }

    .customer-request-panel .filepond--drop-label {
        color: #667085;
        font-size: 12px;
    }

    @media (max-width: 1200px) {
        .customer-requests-workspace {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .customer-request-list-head,
        .customer-request-application {
            flex-direction: column;
        }

        .customer-request-filter {
            width: 100%;
        }

        .customer-request-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .customer-request-form-row,
        .customer-request-card-main {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
    @include('admin.layouts.header')

    <main class="main-dash-uix dash-sp">
        <div class="customer-requests-workspace">
            <section class="customer-request-panel">
                <div class="customer-request-panel__head">
                    <h3>Create Customer Request</h3>
                    <p>Post a custom service need so verified providers can apply.</p>
                </div>

                <form method="POST" action="{{ route('customer.requests.store') }}" enctype="multipart/form-data" class="customer-request-form">
                    @csrf

                    <div class="customer-request-field">
                        <label>Request Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" required maxlength="255" placeholder="Example: TV not working">
                        @error('title') <small class="customer-request-error">{{ $message }}</small> @enderror
                    </div>

                    <div class="customer-request-form-row">
                        <div class="customer-request-field">
                            <label>Service Type</label>
                            <input type="text" name="service_type" value="{{ old('service_type') }}" required maxlength="100" placeholder="Appliance repair">
                            @error('service_type') <small class="customer-request-error">{{ $message }}</small> @enderror
                        </div>

                        <div class="customer-request-field">
                            <label>Fixed Price</label>
                            <input type="number" name="fixed_price" value="{{ old('fixed_price') }}" min="100" max="1000000" step="0.01" oninput="this.value = this.value.slice(0, 7)" required placeholder="100.00">
                            @error('fixed_price') <small class="customer-request-error">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="customer-request-field">
                        <label>Description</label>
                        <textarea name="description" required maxlength="2000" placeholder="Describe the problem, location access, and what you need done.">{{ old('description') }}</textarea>
                        @error('description') <small class="customer-request-error">{{ $message }}</small> @enderror
                    </div>

                    <div class="customer-request-field">
                        <label>Image</label>
                        <input type="file" name="image" id="customerRequestImage" accept="image/*">
                        @error('image') <small class="customer-request-error">{{ $message }}</small> @enderror
                    </div>

                    <div class="customer-request-form-row">
                        <div class="customer-request-field">
                            <label>Contact Name</label>
                            <input type="text" name="contact_name" value="{{ old('contact_name', $contactName) }}" required>
                            @error('contact_name') <small class="customer-request-error">{{ $message }}</small> @enderror
                        </div>

                        <div class="customer-request-field">
                            <label>Contact Phone</label>
                            <input type="text" name="contact_phone" value="{{ old('contact_phone', $contactPhone) }}" required>
                            @error('contact_phone') <small class="customer-request-error">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="customer-request-field">
                        <label>Contact Email</label>
                        <input type="email" name="contact_email" value="{{ old('contact_email', $contactEmail) }}" required>
                        @error('contact_email') <small class="customer-request-error">{{ $message }}</small> @enderror
                    </div>

                    <div class="customer-request-field">
                        <label>Contact Address</label>
                        <textarea name="contact_address" required>{{ old('contact_address', $contactAddress) }}</textarea>
                        @error('contact_address') <small class="customer-request-error">{{ $message }}</small> @enderror
                    </div>

                    <button type="submit" class="customer-request-submit">Create Request</button>
                </form>
            </section>

            <section class="customer-request-list-area">
                <div class="customer-request-list-head">
                    <div>
                        <h3>My Customer Requests</h3>
                        <p>Track applicants, accepted providers, and completed custom work.</p>
                    </div>

                    <form method="GET" action="{{ route('customer.requests.index') }}" class="customer-request-filter">
                        <select name="status" onchange="this.form.submit()">
                            <option value="" {{ $selectedStatus === '' ? 'selected' : '' }}>All Status</option>
                            <option value="open" {{ $selectedStatus === 'open' ? 'selected' : '' }}>Open</option>
                            <option value="accepted" {{ $selectedStatus === 'accepted' ? 'selected' : '' }}>Accepted</option>
                            <option value="completed" {{ $selectedStatus === 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        <svg width="7" height="4" viewBox="0 0 7 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.5 0.5L3.5 3.5L6.5 0.5" stroke="#282828" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </form>
                </div>

                <div class="customer-request-stats">
                    <div class="customer-request-stat-card"><span>Total Requests</span><strong>{{ number_format($requestStats['total']) }}</strong></div>
                    <div class="customer-request-stat-card"><span>Open</span><strong>{{ number_format($requestStats['open']) }}</strong></div>
                    <div class="customer-request-stat-card"><span>Accepted</span><strong>{{ number_format($requestStats['accepted']) }}</strong></div>
                    <div class="customer-request-stat-card"><span>Completed</span><strong>{{ number_format($requestStats['completed']) }}</strong></div>
                </div>

                @forelse($requests as $request)
                    @php
                        $badgeClass = match ($request->status) {
                            'accepted' => 'customer-request-status--accepted',
                            'completed' => 'customer-request-status--completed',
                            default => '',
                        };
                        $requestReference = '#CR-' . str_pad((string) $request->id, 5, '0', STR_PAD_LEFT);
                    @endphp

                    <article class="customer-request-card">
                        <div class="customer-request-card-main">
                            <img src="{{ $request->image_path ? asset($request->image_path) : asset('images/serv-bg.png') }}" alt="{{ $request->title }}">

                            <div class="customer-request-card-body">
                                <div class="customer-request-card-top">
                                    <span class="customer-request-status {{ $badgeClass }}">{{ $request->status }}</span>
                                    <span class="customer-request-price">{{ $request->fixed_price_label }}</span>
                                </div>

                                <div>
                                    <h4>{{ $request->title }}</h4>
                                    <p>{{ \Illuminate\Support\Str::limit($request->description, 180) }}</p>
                                </div>

                                <div class="customer-request-card-meta">
                                    <span class="customer-request-chip">{{ $requestReference }}</span>
                                    <span class="customer-request-chip">{{ $request->service_type ?: 'Custom service' }}</span>
                                    <span class="customer-request-chip">{{ $request->applications->count() }} {{ $request->applications->count() === 1 ? 'applicant' : 'applicants' }}</span>
                                    <span class="customer-request-chip">{{ $request->created_at?->format('M d, Y g:i A') }}</span>
                                </div>

                                @if($request->acceptedProvider)
                                    <p>
                                        Accepted Provider:
                                        <strong>{{ trim(($request->acceptedProvider->first_name ?? '') . ' ' . ($request->acceptedProvider->last_name ?? '')) ?: 'Provider' }}</strong>
                                        {{ $request->acceptedProvider->phone_number ? ' - ' . $request->acceptedProvider->phone_number : '' }}
                                        {{ $request->acceptedProvider->user?->email ? ' - ' . $request->acceptedProvider->user->email : '' }}
                                    </p>
                                @endif

                                @if($request->status === 'accepted')
                                    <form method="POST" action="{{ route('customer.requests.complete', $request) }}">
                                        @csrf
                                        <button type="submit" class="customer-request-action customer-request-action--complete">Mark Complete</button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        <div class="customer-request-applications">
                            <h5>Provider Applications</h5>

                            @forelse($request->applications as $application)
                                @php($provider = $application->provider)
                                <div class="customer-request-application">
                                    <div>
                                        <strong>{{ trim(($provider->first_name ?? '') . ' ' . ($provider->last_name ?? '')) ?: 'Provider' }}</strong>
                                        <p>{{ $provider->phone_number ?? 'No phone' }} {{ $provider->user?->email ? ' - ' . $provider->user->email : '' }}</p>
                                        <p>Status: {{ ucfirst($application->status) }}</p>
                                        @if($application->notes)
                                            <p>Notes: {{ $application->notes }}</p>
                                        @endif
                                    </div>

                                    @if($request->status === 'open' && $application->status === 'pending')
                                        <form method="POST" action="{{ route('customer.requests.applications.accept', [$request, $application]) }}">
                                            @csrf
                                            <button type="submit" class="customer-request-action">Accept Provider</button>
                                        </form>
                                    @endif
                                </div>
                            @empty
                                <p>No provider applications yet.</p>
                            @endforelse
                        </div>
                    </article>
                @empty
                    <article class="customer-request-empty">
                        <h3>No customer requests found</h3>
                        <p>Create a new request or change the status filter.</p>
                    </article>
                @endforelse
            </section>
        </div>
    </main>
@endsection

@push('extrascripts')
<script>
    if (window.FilePond && document.querySelector('#customerRequestImage')) {
        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginFileValidateType,
            FilePondPluginFileValidateSize
        );

        FilePond.create(document.querySelector('#customerRequestImage'), {
            allowMultiple: false,
            maxFiles: 1,
            storeAsFile: true,
            acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp'],
            maxFileSize: '5MB',
            labelIdle: 'Drop request image or <span class="filepond--label-action">Browse</span>',
        });
    }
</script>
@endpush
