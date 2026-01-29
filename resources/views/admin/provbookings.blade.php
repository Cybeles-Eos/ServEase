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
        <div class="provider--bookings--tables">

            <div class="provider--bookings--tables--main">
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
            <div class="pbft-body">
                <div class="pbft-body--id">
                    #SB-00123
                </div>
                <div class="pbft-body--client-name">
                    <img src="{{asset('images/user.png')}}" alt="pfp">
                    Juan Dela Cruz
                </div>
                <div class="pbft-body--des">
                    <p>Plumbing</p>
                    <p>Water Heater ExpertWater Heater ExpertWater Heater ExpertWater Heater ExpertWater Heater Expert</p>
                </div>
                <div>
                    June 25, 2024 - 10:00 AM
                </div>
                <div>
                    12 Completed • 3 Cancelled
                </div>
                <div class="pbft-body--status">
                    <span class="pending-sbox">Pending</span>
                </div>
                <div class="pbft-body--actions">
                    <button class="btn-confirm">
                        <svg width="11" height="8" viewBox="0 0 11 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.52564 5.85L9.17564 0.2C9.30897 0.0666668 9.46453 0 9.64231 0C9.82009 0 9.97564 0.0666668 10.109 0.2C10.2423 0.333333 10.309 0.491778 10.309 0.675333C10.309 0.858889 10.2423 1.01711 10.109 1.15L3.99231 7.28333C3.85897 7.41667 3.70342 7.48333 3.52564 7.48333C3.34786 7.48333 3.19231 7.41667 3.05897 7.28333L0.192308 4.41667C0.0589744 4.28333 -0.00502564 4.12511 0.000307692 3.942C0.00564103 3.75889 0.0751964 3.60044 0.208974 3.46667C0.342752 3.33289 0.501197 3.26622 0.684308 3.26667C0.867419 3.26711 1.02564 3.33378 1.15897 3.46667L3.52564 5.85Z" fill="white"/>
                        </svg>
                        Accept</button>
                    <button class="btn-cancel">
                        <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.5 7.49067L3.99533 3.99533L7.49067 7.49067M7.49067 0.5L3.99467 3.99533L0.5 0.5" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Decline</button>
                </div>

            </div>
            <div class="pbft-body">
                <div class="pbft-body--id">
                    #SB-00123
                </div>
                <div class="pbft-body--client-name">
                    <img src="{{asset('images/user.png')}}" alt="pfp">
                    Juan Dela Cruz
                </div>
                <div class="pbft-body--des">
                    <p>Plumbing</p>
                    <p>Water Heater ExpertWater Heater ExpertWater Heater ExpertWater Heater ExpertWater Heater Expert</p>
                </div>
                <div>
                    June 25, 2024 - 10:00 AM
                </div>
                <div>
                    12 Completed • 3 Cancelled
                </div>
                <div class="pbft-body--status">
                    <span class="pending-sbox">Pending</span>
                </div>
                <div class="pbft-body--actions">
                    <button class="btn-confirm">
                        <svg width="11" height="8" viewBox="0 0 11 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.52564 5.85L9.17564 0.2C9.30897 0.0666668 9.46453 0 9.64231 0C9.82009 0 9.97564 0.0666668 10.109 0.2C10.2423 0.333333 10.309 0.491778 10.309 0.675333C10.309 0.858889 10.2423 1.01711 10.109 1.15L3.99231 7.28333C3.85897 7.41667 3.70342 7.48333 3.52564 7.48333C3.34786 7.48333 3.19231 7.41667 3.05897 7.28333L0.192308 4.41667C0.0589744 4.28333 -0.00502564 4.12511 0.000307692 3.942C0.00564103 3.75889 0.0751964 3.60044 0.208974 3.46667C0.342752 3.33289 0.501197 3.26622 0.684308 3.26667C0.867419 3.26711 1.02564 3.33378 1.15897 3.46667L3.52564 5.85Z" fill="white"/>
                        </svg>
                        Accept</button>
                    <button class="btn-cancel">
                        <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.5 7.49067L3.99533 3.99533L7.49067 7.49067M7.49067 0.5L3.99467 3.99533L0.5 0.5" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Decline</button>
                </div>

            </div>
            <div class="pbft-body">
                <div class="pbft-body--id">
                    #SB-00123
                </div>
                <div class="pbft-body--client-name">
                    <img src="{{asset('images/user.png')}}" alt="pfp">
                    Juan Dela Cruz
                </div>
                <div class="pbft-body--des">
                    <p>Plumbing</p>
                    <p>Water Heater ExpertWater Heater ExpertWater Heater ExpertWater Heater ExpertWater Heater Expert</p>
                </div>
                <div>
                    June 25, 2024 - 10:00 AM
                </div>
                <div>
                    12 Completed • 3 Cancelled
                </div>
                <div class="pbft-body--status">
                    <span class="pending-sbox">Pending</span>
                </div>
                <div class="pbft-body--actions">
                    <button class="btn-confirm">
                        <svg width="11" height="8" viewBox="0 0 11 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.52564 5.85L9.17564 0.2C9.30897 0.0666668 9.46453 0 9.64231 0C9.82009 0 9.97564 0.0666668 10.109 0.2C10.2423 0.333333 10.309 0.491778 10.309 0.675333C10.309 0.858889 10.2423 1.01711 10.109 1.15L3.99231 7.28333C3.85897 7.41667 3.70342 7.48333 3.52564 7.48333C3.34786 7.48333 3.19231 7.41667 3.05897 7.28333L0.192308 4.41667C0.0589744 4.28333 -0.00502564 4.12511 0.000307692 3.942C0.00564103 3.75889 0.0751964 3.60044 0.208974 3.46667C0.342752 3.33289 0.501197 3.26622 0.684308 3.26667C0.867419 3.26711 1.02564 3.33378 1.15897 3.46667L3.52564 5.85Z" fill="white"/>
                        </svg>
                        Accept</button>
                    <button class="btn-cancel">
                        <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.5 7.49067L3.99533 3.99533L7.49067 7.49067M7.49067 0.5L3.99467 3.99533L0.5 0.5" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Decline</button>
                </div>

            </div>
            <div class="pbft-body">
                <div class="pbft-body--id">
                    #SB-00123
                </div>
                <div class="pbft-body--client-name">
                    <img src="{{asset('images/user.png')}}" alt="pfp">
                    Juan Dela Cruz
                </div>
                <div class="pbft-body--des">
                    <p>Plumbing</p>
                    <p>Water Heater ExpertWater Heater ExpertWater Heater ExpertWater Heater ExpertWater Heater Expert</p>
                </div>
                <div>
                    June 25, 2024 - 10:00 AM
                </div>
                <div>
                    12 Completed • 3 Cancelled
                </div>
                <div class="pbft-body--status">
                    <span class="pending-sbox">Pending</span>
                </div>
                <div class="pbft-body--actions">
                    <button class="btn-confirm">
                        <svg width="11" height="8" viewBox="0 0 11 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.52564 5.85L9.17564 0.2C9.30897 0.0666668 9.46453 0 9.64231 0C9.82009 0 9.97564 0.0666668 10.109 0.2C10.2423 0.333333 10.309 0.491778 10.309 0.675333C10.309 0.858889 10.2423 1.01711 10.109 1.15L3.99231 7.28333C3.85897 7.41667 3.70342 7.48333 3.52564 7.48333C3.34786 7.48333 3.19231 7.41667 3.05897 7.28333L0.192308 4.41667C0.0589744 4.28333 -0.00502564 4.12511 0.000307692 3.942C0.00564103 3.75889 0.0751964 3.60044 0.208974 3.46667C0.342752 3.33289 0.501197 3.26622 0.684308 3.26667C0.867419 3.26711 1.02564 3.33378 1.15897 3.46667L3.52564 5.85Z" fill="white"/>
                        </svg>
                        Accept</button>
                    <button class="btn-cancel">
                        <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.5 7.49067L3.99533 3.99533L7.49067 7.49067M7.49067 0.5L3.99467 3.99533L0.5 0.5" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Decline</button>
                </div>

            </div>
            <div class="pbft-body">
                <div class="pbft-body--id">
                    #SB-00123
                </div>
                <div class="pbft-body--client-name">
                    <img src="{{asset('images/user.png')}}" alt="pfp">
                    Juan Dela Cruz
                </div>
                <div class="pbft-body--des">
                    <p>Plumbing</p>
                    <p>Water Heater ExpertWater Heater ExpertWater Heater ExpertWater Heater ExpertWater Heater Expert</p>
                </div>
                <div>
                    June 25, 2024 - 10:00 AM
                </div>
                <div>
                    12 Completed • 3 Cancelled
                </div>
                <div class="pbft-body--status">
                    <span class="pending-sbox">Pending</span>
                </div>
                <div class="pbft-body--actions">
                    <button class="btn-confirm">
                        <svg width="11" height="8" viewBox="0 0 11 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.52564 5.85L9.17564 0.2C9.30897 0.0666668 9.46453 0 9.64231 0C9.82009 0 9.97564 0.0666668 10.109 0.2C10.2423 0.333333 10.309 0.491778 10.309 0.675333C10.309 0.858889 10.2423 1.01711 10.109 1.15L3.99231 7.28333C3.85897 7.41667 3.70342 7.48333 3.52564 7.48333C3.34786 7.48333 3.19231 7.41667 3.05897 7.28333L0.192308 4.41667C0.0589744 4.28333 -0.00502564 4.12511 0.000307692 3.942C0.00564103 3.75889 0.0751964 3.60044 0.208974 3.46667C0.342752 3.33289 0.501197 3.26622 0.684308 3.26667C0.867419 3.26711 1.02564 3.33378 1.15897 3.46667L3.52564 5.85Z" fill="white"/>
                        </svg>
                        Accept</button>
                    <button class="btn-cancel">
                        <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.5 7.49067L3.99533 3.99533L7.49067 7.49067M7.49067 0.5L3.99467 3.99533L0.5 0.5" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Decline</button>
                </div>

            </div>
            <div class="pbft-body">
                <div class="pbft-body--id">
                    #SB-00123
                </div>
                <div class="pbft-body--client-name">
                    <img src="{{asset('images/user.png')}}" alt="pfp">
                    Juan Dela Cruz
                </div>
                <div class="pbft-body--des">
                    <p>Plumbing</p>
                    <p>Water Heater ExpertWater Heater ExpertWater Heater ExpertWater Heater ExpertWater Heater Expert</p>
                </div>
                <div>
                    June 25, 2024 - 10:00 AM
                </div>
                <div>
                    12 Completed • 3 Cancelled
                </div>
                <div class="pbft-body--status">
                    <span class="pending-sbox">Pending</span>
                </div>
                <div class="pbft-body--actions">
                    <button class="btn-confirm">
                        <svg width="11" height="8" viewBox="0 0 11 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.52564 5.85L9.17564 0.2C9.30897 0.0666668 9.46453 0 9.64231 0C9.82009 0 9.97564 0.0666668 10.109 0.2C10.2423 0.333333 10.309 0.491778 10.309 0.675333C10.309 0.858889 10.2423 1.01711 10.109 1.15L3.99231 7.28333C3.85897 7.41667 3.70342 7.48333 3.52564 7.48333C3.34786 7.48333 3.19231 7.41667 3.05897 7.28333L0.192308 4.41667C0.0589744 4.28333 -0.00502564 4.12511 0.000307692 3.942C0.00564103 3.75889 0.0751964 3.60044 0.208974 3.46667C0.342752 3.33289 0.501197 3.26622 0.684308 3.26667C0.867419 3.26711 1.02564 3.33378 1.15897 3.46667L3.52564 5.85Z" fill="white"/>
                        </svg>
                        Accept</button>
                    <button class="btn-cancel">
                        <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.5 7.49067L3.99533 3.99533L7.49067 7.49067M7.49067 0.5L3.99467 3.99533L0.5 0.5" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Decline</button>
                </div>

            </div>
            </div>

        </div>

    </main>

@endsection
@push('extrascripts')

@endpush