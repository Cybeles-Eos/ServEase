@extends('admin.layouts.auth')

{{-- Meta Section --}}
@section('title', 'Provider Bookings - Servease')
@push('extrastylesheets')
    <style>
        .provider-history-pagination {
            margin-top: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            border-top: 1px solid #EEF0F3;
            padding-top: 12px;
        }

        .provider-history-pagination p {
            margin: 0;
            color: #374151;
            font-size: 12px;
            line-height: 1.4;
        }

        .provider-history-pagination-actions {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .provider-history-page-btn,
        .provider-history-page-info {
            min-width: 30px;
            height: 30px;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            text-decoration: none;
        }

        .provider-history-page-btn {
            border: 1px solid #E5E7EB;
            background: #FFFFFF;
            color: #374151;
            cursor: pointer;
            padding: 0;
        }

        .provider-history-page-btn--active,
        .provider-history-page-btn:hover {
            border-color: #111827;
            background: #111827;
            color: #FFFFFF;
        }

        .provider-history-page-btn.is-disabled,
        .provider-history-page-btn:disabled {
            background: #F9FAFB;
            color: #9CA3AF;
            cursor: not-allowed;
            border-color: #E5E7EB;
        }

        .provider-history-page-btn.is-disabled:hover,
        .provider-history-page-btn:disabled:hover {
            background: #F9FAFB;
            color: #9CA3AF;
            border-color: #E5E7EB;
        }

        .provider-history-page-btn svg {
            display: block;
        }

        .provider-history-page-info {
            border: 1px solid #E5E7EB;
            background: #FFFFFF;
            color: #6B7280;
            padding: 0 9px;
            white-space: nowrap;
        }

        @media screen and (max-width: 768px) {
            .provider-history-pagination {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
@endpush
{{-- Page Content --}}
@section('content')
    @include('admin.layouts.header')
    

    <main class="main-dash-uix provider--bookings dash-sp">
        <div class="provider--bookings__head">
            <h3>Pending Site Bookings</h3>
            <p>Review and manage your booking request</p>
        </div>

        <livewire:provider-bookings-board />
    </main>     
    <script>
        console.log(@json($bookRequests));
    </script>
    <script>console.log({{ auth()->user()->provider->id }});</script>
@endsection
@push('extrascripts')

@endpush