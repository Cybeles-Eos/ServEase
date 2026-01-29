@extends('admin.layouts.auth')

{{-- Meta Section --}}
@section('title', 'Provider Bookings - Servease')

{{-- Page Content --}}
@section('content')
    @include('admin.layouts.header')
    @include('admin.layouts.sidebar')

    <main class="main-dash-uix provider--bookings dash-sp">
        {{-- <div class="provider--bookings__head">
            @auth
                <p>Hello {{ auth()->user()->name }}, manage you bookings today!</p>
            @endauth
        </div> --}}
        <div class="provider--bookings__head">
            <h3>Pending Site Bookings</h3>
            <p>Review and manage your booking request</p>
        </div>
        <div class="provider--bookings__filters">
            <div class="provider--bookings__filters--search-bar">
                <input type="text" placeholder="Search by customer name or service...">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g opacity="0.3">
                        <path d="M14.0001 14.0001L11.1048 11.1048M11.1048 11.1048C11.6001 10.6095 11.9929 10.0216 12.261 9.3745C12.529 8.72742 12.6669 8.03387 12.6669 7.33347C12.6669 6.63307 12.529 5.93953 12.261 5.29244C11.9929 4.64535 11.6001 4.0574 11.1048 3.56214C10.6095 3.06688 10.0216 2.67402 9.3745 2.40599C8.72742 2.13795 8.03387 2 7.33347 2C6.63307 2 5.93953 2.13795 5.29244 2.40599C4.64535 2.67402 4.0574 3.06688 3.56214 3.56214C2.56192 4.56236 2 5.91895 2 7.33347C2 8.748 2.56192 10.1046 3.56214 11.1048C4.56236 12.105 5.91895 12.6669 7.33347 12.6669C8.748 12.6669 10.1046 12.105 11.1048 11.1048Z" stroke="black" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                </svg>
            </div>

            <div class="provider--bookings__filters--dropdowns">
                <select name="" class="provider--bookings__filters--dropdowns--sort" id="">
                    <option value="">Status</option>
                    <option value="">Pending</option>
                    <option value="">Confirmed</option>
                    <option value="">Cancelled</option>
                </select>
                <svg width="7" height="4" viewBox="0 0 7 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0.5 0.5L3.5 3.5L6.5 0.5" stroke="#282828" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>
        <div class="provider--bookings__filters--tables">
            <div class="pbft-header">
                <div class="pbft-header--id">
                    Booking ID
                </div>
                <div>
                    Client Name
                </div>
                <div>
                    Service Type
                </div>
                <div>
                    Booking Date & Time
                </div>
                <div>
                    Booking History
                </div>
                <div>
                    Status
                </div>
                <div>
                    Actions
                </div>
            </div>
        </div>

    </main>

@endsection
@push('extrascripts')

@endpush