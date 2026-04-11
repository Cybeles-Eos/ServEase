@extends('admin.layouts.auth')

{{-- Meta Section --}}
@section('title', 'Provider Bookings - Servease')

{{-- Page Content --}}
@section('content')
    @include('admin.layouts.header')
    

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

        <div class="provider--bookings--main-d">
            <div class="pb-md-left">
                <div class="pb-md-left__head">
                    <h3>Scheduled Bookings</h3>
                    <p>Accepted <span style="color: #A6A6A6">(<span>3</span>)</span></p>
                </div>

                <div class="pb-md-left__accepted-body">
                    <div class="pb-md-left__accepted-body--main">
                        
                        {{-- Accepted Bookings --}}
                        <div class="boxss-sd">
                            
                            <div class="boxss-sd-bking">
                                <img src="{{asset('images/user.png')}}" class="boxss-sd-bking__pfp" alt="profile-image">
                                <div class="boxss-sd-bking__pfp-d">
                                    <p class="boxss-sd-bking__pfp-d__name">Spenzer Corporalli</p>
                                    <a href="#" class="boxss-sd-bking__pfp-d__num">09125240151</a>
                                    <a href="#" class="boxss-sd-bking__pfp-d__email">spen@gmail.com</a>
                                </div>
                            </div>
                            <hr>
                            <div class="boxss-sd-bking-info">
                                <div>
                                    <p class="boxss-sd-bking-label">Plumbing</p>
                                    <p class="boxss-sd-bking-info-serv-title"> {{ \Illuminate\Support\Str::limit('Water Heater Expert', 20, '...') }}</p>
                                </div>
                                <div>
                                    <p class="boxss-sd-bking-label">Date: <span class="">Dec 10, 2025</span></p>
                                    <p class="boxss-sd-bking-label">Water Heater Expert</p>
                                </div>
                                <div>
                                    <p class="boxss-sd-bking-info-serv-head">Address:</p>
                                    <p class="boxss-sd-bking-label">21, 4th St Virginia summerville Mambugan Antipolo City</p>
                                </div>
                            </div>
                            <div class="boxss-sd-bking-foo">
                                <p>Fixed Rate: <span>₱1,200.00</span></p>
                                <button class="btn-sm btn-danger" style="border-radius: 5px">Cancel</button>
                            </div>

                        </div>
                        <div class="boxss-sd">
                            
                            <div class="boxss-sd-bking">
                                <img src="{{asset('images/user.png')}}" class="boxss-sd-bking__pfp" alt="profile-image">
                                <div class="boxss-sd-bking__pfp-d">
                                    <p class="boxss-sd-bking__pfp-d__name">Spenzer Corporalli</p>
                                    <a href="#" class="boxss-sd-bking__pfp-d__num">09125240151</a>
                                    <a href="#" class="boxss-sd-bking__pfp-d__email">spen@gmail.com</a>
                                </div>
                            </div>
                            <hr>
                            <div class="boxss-sd-bking-info">
                                <div>
                                    <p class="boxss-sd-bking-label">Plumbing</p>
                                    <p class="boxss-sd-bking-info-serv-title"> {{ \Illuminate\Support\Str::limit('Water Heater Expert', 20, '...') }}</p>
                                </div>
                                <div>
                                    <p class="boxss-sd-bking-label">Date: <span class="">Dec 10, 2025</span></p>
                                    <p class="boxss-sd-bking-label">Water Heater Expert</p>
                                </div>
                                <div>
                                    <p class="boxss-sd-bking-info-serv-head">Address:</p>
                                    <p class="boxss-sd-bking-label">21, 4th St Virginia summerville Mambugan Antipolo City</p>
                                </div>
                            </div>

                            <div class="boxss-sd-bking-foo">
                                <p>Fixed Rate: <span>₱1,200.00</span></p>
                                <button class="btn-sm btn-danger" style="border-radius: 5px">Cancel</button>
                            </div>

                        </div>
                        <div class="boxss-sd">
                            
                            <div class="boxss-sd-bking">
                                <img src="{{asset('images/user.png')}}" class="boxss-sd-bking__pfp" alt="profile-image">
                                <div class="boxss-sd-bking__pfp-d">
                                    <p class="boxss-sd-bking__pfp-d__name">Spenzer Corporalli</p>
                                    <a href="#" class="boxss-sd-bking__pfp-d__num">09125240151</a>
                                    <a href="#" class="boxss-sd-bking__pfp-d__email">spen@gmail.com</a>
                                </div>
                            </div>
                            <hr>
                            <div class="boxss-sd-bking-info">
                                <div>
                                    <p class="boxss-sd-bking-label">Plumbing</p>
                                    <p class="boxss-sd-bking-info-serv-title"> {{ \Illuminate\Support\Str::limit('Water Heater Expert', 20, '...') }}</p>
                                </div>
                                <div>
                                    <p class="boxss-sd-bking-label">Date: <span class="">Dec 10, 2025</span></p>
                                    <p class="boxss-sd-bking-label">Water Heater Expert</p>
                                </div>
                                <div>
                                    <p class="boxss-sd-bking-info-serv-head">Address:</p>
                                    <p class="boxss-sd-bking-label">21, 4th St Virginia summerville Mambugan Antipolo City</p>
                                </div>
                            </div>

                            <div class="boxss-sd-bking-foo">
                                <p>Fixed Rate: <span>₱1,200.00</span></p>
                                <button class="btn-sm btn-danger" style="border-radius: 5px">Cancel</button>
                            </div>

                        </div>

                    </div>
                    <hr>
                </div>
                
                <div class="pb-md-left__head-req">
                    {{-- s --}}
                </div>

                <div class="pb-md-left__table-c">
                    <h3>Booking Request</h3> 

                    <div class="pb-md-left-tblc-main">
                        <div class="pb-md-left-tblc-main-c">
                            <div class="pb-md-left-tblc-main-c__head">
                                <div style="justify-content: center">ID</div>
                                <div>Name</div>
                                <div>Service</div>
                                <div>Date & Time</div>
                                <div>Actions</div>
                            </div>
                            <div class="pb-md-left-tblc-main-c__tbody">
                                <div class="pb-md-left-tblc-main-id" style="justify-content: center">#R123</div>
                                <div class="pb-md-left-tblc-main-name">
                                    <p>Spenzer Corporalli</p>
                                    <small>21, 4th St Virginia summerville Mambugan Antipolo City</small>
                                </div>
                                <div class="pb-md-left-tblc-main-serv">
                                    <small>Plumber</small>
                                    <p>{{ \Illuminate\Support\Str::limit('Water Heater Expert...', 40) }}</p>
                                    <small>₱1,200.00</small>
                                </div>
                                <div class="pb-md-left-tblc-main-date">
                                    <p style="font-size: 14px">Dec 10, 2025</p>
                                    <small>1: 25 PM</small>
                                </div>
                                <div class="pb-md-left-tblc-main-act">
                                    <a href="#" class="pb-md-left-tblc-main-act__actp">
                                        <svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.64423 4.3875L6.88173 0.15C6.98173 0.0500001 7.0984 0 7.23173 0C7.36507 0 7.48173 0.0500001 7.58173 0.15C7.68173 0.25 7.73173 0.368833 7.73173 0.5065C7.73173 0.644167 7.68173 0.762834 7.58173 0.8625L2.99423 5.4625C2.89423 5.5625 2.77756 5.6125 2.64423 5.6125C2.5109 5.6125 2.39423 5.5625 2.29423 5.4625L0.144231 3.3125C0.0442308 3.2125 -0.00376923 3.09383 0.000230769 2.9565C0.00423077 2.81917 0.0563973 2.70033 0.156731 2.6C0.257064 2.49967 0.375898 2.44967 0.513231 2.45C0.650564 2.45033 0.769231 2.50033 0.869231 2.6L2.64423 4.3875Z" fill="white"/>
                                        </svg>
                                        Accept
                                    </a>
                                    <a href="#" class="pb-md-left-tblc-main-act__remove">
                                        <svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0.5 5.743L3.1215 3.1215L5.743 5.743M5.743 0.5L3.121 3.1215L0.5 0.5" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Decline
                                    </a>
                                    
                                </div>
                            </div>
                            <div class="pb-md-left-tblc-main-c__tbody">
                                <div class="pb-md-left-tblc-main-id" style="justify-content: center">#R123</div>
                                <div class="pb-md-left-tblc-main-name">
                                    <p>Spenzer Corporalli</p>
                                    <small>21, 4th St Virginia summerville Mambugan Antipolo City</small>
                                </div>
                                <div class="pb-md-left-tblc-main-serv">
                                    <small>Plumber</small>
                                    <p>{{ \Illuminate\Support\Str::limit('Water Heater Expert...', 40) }}</p>
                                    <small>₱1,200.00</small>
                                </div>
                                <div class="pb-md-left-tblc-main-date">
                                    <p style="font-size: 14px">Dec 10, 2025</p>
                                    <small>1: 25 PM</small>
                                </div>
                                <div class="pb-md-left-tblc-main-act">
                                    <a href="#" class="pb-md-left-tblc-main-act__actp">
                                        <svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.64423 4.3875L6.88173 0.15C6.98173 0.0500001 7.0984 0 7.23173 0C7.36507 0 7.48173 0.0500001 7.58173 0.15C7.68173 0.25 7.73173 0.368833 7.73173 0.5065C7.73173 0.644167 7.68173 0.762834 7.58173 0.8625L2.99423 5.4625C2.89423 5.5625 2.77756 5.6125 2.64423 5.6125C2.5109 5.6125 2.39423 5.5625 2.29423 5.4625L0.144231 3.3125C0.0442308 3.2125 -0.00376923 3.09383 0.000230769 2.9565C0.00423077 2.81917 0.0563973 2.70033 0.156731 2.6C0.257064 2.49967 0.375898 2.44967 0.513231 2.45C0.650564 2.45033 0.769231 2.50033 0.869231 2.6L2.64423 4.3875Z" fill="white"/>
                                        </svg>
                                        Accept
                                    </a>
                                    <a href="#" class="pb-md-left-tblc-main-act__remove">
                                        <svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0.5 5.743L3.1215 3.1215L5.743 5.743M5.743 0.5L3.121 3.1215L0.5 0.5" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Decline
                                    </a>
                                    
                                </div>
                            </div>
                            <div class="pb-md-left-tblc-main-c__tbody">
                                <div class="pb-md-left-tblc-main-id" style="justify-content: center">#R123</div>
                                <div class="pb-md-left-tblc-main-name">
                                    <p>Spenzer Corporalli</p>
                                    <small>21, 4th St Virginia summerville Mambugan Antipolo City</small>
                                </div>
                                <div class="pb-md-left-tblc-main-serv">
                                    <small>Plumber</small>
                                    <p>{{ \Illuminate\Support\Str::limit('Water Heater Expert...', 40) }}</p>
                                    <small>₱1,200.00</small>
                                </div>
                                <div class="pb-md-left-tblc-main-date">
                                    <p style="font-size: 14px">Dec 10, 2025</p>
                                    <small>1: 25 PM</small>
                                </div>
                                <div class="pb-md-left-tblc-main-act">
                                    <a href="#" class="pb-md-left-tblc-main-act__actp">
                                        <svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.64423 4.3875L6.88173 0.15C6.98173 0.0500001 7.0984 0 7.23173 0C7.36507 0 7.48173 0.0500001 7.58173 0.15C7.68173 0.25 7.73173 0.368833 7.73173 0.5065C7.73173 0.644167 7.68173 0.762834 7.58173 0.8625L2.99423 5.4625C2.89423 5.5625 2.77756 5.6125 2.64423 5.6125C2.5109 5.6125 2.39423 5.5625 2.29423 5.4625L0.144231 3.3125C0.0442308 3.2125 -0.00376923 3.09383 0.000230769 2.9565C0.00423077 2.81917 0.0563973 2.70033 0.156731 2.6C0.257064 2.49967 0.375898 2.44967 0.513231 2.45C0.650564 2.45033 0.769231 2.50033 0.869231 2.6L2.64423 4.3875Z" fill="white"/>
                                        </svg>
                                        Accept
                                    </a>
                                    <a href="#" class="pb-md-left-tblc-main-act__remove">
                                        <svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0.5 5.743L3.1215 3.1215L5.743 5.743M5.743 0.5L3.121 3.1215L0.5 0.5" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Decline
                                    </a>
                                    
                                </div>
                            </div>
                            <div class="pb-md-left-tblc-main-c__tbody">
                                <div class="pb-md-left-tblc-main-id" style="justify-content: center">#R123</div>
                                <div class="pb-md-left-tblc-main-name">
                                    <p>Spenzer Corporalli</p>
                                    <small>21, 4th St Virginia summerville Mambugan Antipolo City</small>
                                </div>
                                <div class="pb-md-left-tblc-main-serv">
                                    <small>Plumber</small>
                                    <p>{{ \Illuminate\Support\Str::limit('Water Heater Expert...', 40) }}</p>
                                    <small>₱1,200.00</small>
                                </div>
                                <div class="pb-md-left-tblc-main-date">
                                    <p style="font-size: 14px">Dec 10, 2025</p>
                                    <small>1: 25 PM</small>
                                </div>
                                <div class="pb-md-left-tblc-main-act">
                                    <a href="#" class="pb-md-left-tblc-main-act__actp">
                                        <svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.64423 4.3875L6.88173 0.15C6.98173 0.0500001 7.0984 0 7.23173 0C7.36507 0 7.48173 0.0500001 7.58173 0.15C7.68173 0.25 7.73173 0.368833 7.73173 0.5065C7.73173 0.644167 7.68173 0.762834 7.58173 0.8625L2.99423 5.4625C2.89423 5.5625 2.77756 5.6125 2.64423 5.6125C2.5109 5.6125 2.39423 5.5625 2.29423 5.4625L0.144231 3.3125C0.0442308 3.2125 -0.00376923 3.09383 0.000230769 2.9565C0.00423077 2.81917 0.0563973 2.70033 0.156731 2.6C0.257064 2.49967 0.375898 2.44967 0.513231 2.45C0.650564 2.45033 0.769231 2.50033 0.869231 2.6L2.64423 4.3875Z" fill="white"/>
                                        </svg>
                                        Accept
                                    </a>
                                    <a href="#" class="pb-md-left-tblc-main-act__remove">
                                        <svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0.5 5.743L3.1215 3.1215L5.743 5.743M5.743 0.5L3.121 3.1215L0.5 0.5" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Decline
                                    </a>
                                    
                                </div>
                            </div>
                            <div class="pb-md-left-tblc-main-c__tbody">
                                <div class="pb-md-left-tblc-main-id" style="justify-content: center">#R123</div>
                                <div class="pb-md-left-tblc-main-name">
                                    <p>Spenzer Corporalli</p>
                                    <small>21, 4th St Virginia summerville Mambugan Antipolo City</small>
                                </div>
                                <div class="pb-md-left-tblc-main-serv">
                                    <small>Plumber</small>
                                    <p>{{ \Illuminate\Support\Str::limit('Water Heater Expert...', 40) }}</p>
                                    <small>₱1,200.00</small>
                                </div>
                                <div class="pb-md-left-tblc-main-date">
                                    <p style="font-size: 14px">Dec 10, 2025</p>
                                    <small>1: 25 PM</small>
                                </div>
                                <div class="pb-md-left-tblc-main-act">
                                    <a href="#" class="pb-md-left-tblc-main-act__actp">
                                        <svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.64423 4.3875L6.88173 0.15C6.98173 0.0500001 7.0984 0 7.23173 0C7.36507 0 7.48173 0.0500001 7.58173 0.15C7.68173 0.25 7.73173 0.368833 7.73173 0.5065C7.73173 0.644167 7.68173 0.762834 7.58173 0.8625L2.99423 5.4625C2.89423 5.5625 2.77756 5.6125 2.64423 5.6125C2.5109 5.6125 2.39423 5.5625 2.29423 5.4625L0.144231 3.3125C0.0442308 3.2125 -0.00376923 3.09383 0.000230769 2.9565C0.00423077 2.81917 0.0563973 2.70033 0.156731 2.6C0.257064 2.49967 0.375898 2.44967 0.513231 2.45C0.650564 2.45033 0.769231 2.50033 0.869231 2.6L2.64423 4.3875Z" fill="white"/>
                                        </svg>
                                        Accept
                                    </a>
                                    <a href="#" class="pb-md-left-tblc-main-act__remove">
                                        <svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0.5 5.743L3.1215 3.1215L5.743 5.743M5.743 0.5L3.121 3.1215L0.5 0.5" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Decline
                                    </a>
                                    
                                </div>
                            </div>
                            <div class="pb-md-left-tblc-main-c__tbody">
                                <div class="pb-md-left-tblc-main-id" style="justify-content: center">#R123</div>
                                <div class="pb-md-left-tblc-main-name">
                                    <p>Spenzer Corporalli</p>
                                    <small>21, 4th St Virginia summerville Mambugan Antipolo City</small>
                                </div>
                                <div class="pb-md-left-tblc-main-serv">
                                    <small>Plumber</small>
                                    <p>{{ \Illuminate\Support\Str::limit('Water Heater Expert...', 40) }}</p>
                                    <small>₱1,200.00</small>
                                </div>
                                <div class="pb-md-left-tblc-main-date">
                                    <p style="font-size: 14px">Dec 10, 2025</p>
                                    <small>1: 25 PM</small>
                                </div>
                                <div class="pb-md-left-tblc-main-act">
                                    <a href="#" class="pb-md-left-tblc-main-act__actp">
                                        <svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.64423 4.3875L6.88173 0.15C6.98173 0.0500001 7.0984 0 7.23173 0C7.36507 0 7.48173 0.0500001 7.58173 0.15C7.68173 0.25 7.73173 0.368833 7.73173 0.5065C7.73173 0.644167 7.68173 0.762834 7.58173 0.8625L2.99423 5.4625C2.89423 5.5625 2.77756 5.6125 2.64423 5.6125C2.5109 5.6125 2.39423 5.5625 2.29423 5.4625L0.144231 3.3125C0.0442308 3.2125 -0.00376923 3.09383 0.000230769 2.9565C0.00423077 2.81917 0.0563973 2.70033 0.156731 2.6C0.257064 2.49967 0.375898 2.44967 0.513231 2.45C0.650564 2.45033 0.769231 2.50033 0.869231 2.6L2.64423 4.3875Z" fill="white"/>
                                        </svg>
                                        Accept
                                    </a>
                                    <a href="#" class="pb-md-left-tblc-main-act__remove">
                                        <svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0.5 5.743L3.1215 3.1215L5.743 5.743M5.743 0.5L3.121 3.1215L0.5 0.5" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Decline
                                    </a>
                                    
                                </div>
                            </div>
                            <div class="pb-md-left-tblc-main-c__tbody">
                                <div class="pb-md-left-tblc-main-id" style="justify-content: center">#R123</div>
                                <div class="pb-md-left-tblc-main-name">
                                    <p>Spenzer Corporalli</p>
                                    <small>21, 4th St Virginia summerville Mambugan Antipolo City</small>
                                </div>
                                <div class="pb-md-left-tblc-main-serv">
                                    <small>Plumber</small>
                                    <p>{{ \Illuminate\Support\Str::limit('Water Heater Expert...', 40) }}</p>
                                    <small>₱1,200.00</small>
                                </div>
                                <div class="pb-md-left-tblc-main-date">
                                    <p style="font-size: 14px">Dec 10, 2025</p>
                                    <small>1: 25 PM</small>
                                </div>
                                <div class="pb-md-left-tblc-main-act">
                                    <a href="#" class="pb-md-left-tblc-main-act__actp">
                                        <svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.64423 4.3875L6.88173 0.15C6.98173 0.0500001 7.0984 0 7.23173 0C7.36507 0 7.48173 0.0500001 7.58173 0.15C7.68173 0.25 7.73173 0.368833 7.73173 0.5065C7.73173 0.644167 7.68173 0.762834 7.58173 0.8625L2.99423 5.4625C2.89423 5.5625 2.77756 5.6125 2.64423 5.6125C2.5109 5.6125 2.39423 5.5625 2.29423 5.4625L0.144231 3.3125C0.0442308 3.2125 -0.00376923 3.09383 0.000230769 2.9565C0.00423077 2.81917 0.0563973 2.70033 0.156731 2.6C0.257064 2.49967 0.375898 2.44967 0.513231 2.45C0.650564 2.45033 0.769231 2.50033 0.869231 2.6L2.64423 4.3875Z" fill="white"/>
                                        </svg>
                                        Accept
                                    </a>
                                    <a href="#" class="pb-md-left-tblc-main-act__remove">
                                        <svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0.5 5.743L3.1215 3.1215L5.743 5.743M5.743 0.5L3.121 3.1215L0.5 0.5" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Decline
                                    </a>
                                    
                                </div>
                            </div>
                            <div class="pb-md-left-tblc-main-c__tbody">
                                <div class="pb-md-left-tblc-main-id" style="justify-content: center">#R123</div>
                                <div class="pb-md-left-tblc-main-name">
                                    <p>Spenzer Corporalli</p>
                                    <small>21, 4th St Virginia summerville Mambugan Antipolo City</small>
                                </div>
                                <div class="pb-md-left-tblc-main-serv">
                                    <small>Plumber</small>
                                    <p>{{ \Illuminate\Support\Str::limit('Water Heater Expert...', 40) }}</p>
                                    <small>₱1,200.00</small>
                                </div>
                                <div class="pb-md-left-tblc-main-date">
                                    <p style="font-size: 14px">Dec 10, 2025</p>
                                    <small>1: 25 PM</small>
                                </div>
                                <div class="pb-md-left-tblc-main-act">
                                    <a href="#" class="pb-md-left-tblc-main-act__actp">
                                        <svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.64423 4.3875L6.88173 0.15C6.98173 0.0500001 7.0984 0 7.23173 0C7.36507 0 7.48173 0.0500001 7.58173 0.15C7.68173 0.25 7.73173 0.368833 7.73173 0.5065C7.73173 0.644167 7.68173 0.762834 7.58173 0.8625L2.99423 5.4625C2.89423 5.5625 2.77756 5.6125 2.64423 5.6125C2.5109 5.6125 2.39423 5.5625 2.29423 5.4625L0.144231 3.3125C0.0442308 3.2125 -0.00376923 3.09383 0.000230769 2.9565C0.00423077 2.81917 0.0563973 2.70033 0.156731 2.6C0.257064 2.49967 0.375898 2.44967 0.513231 2.45C0.650564 2.45033 0.769231 2.50033 0.869231 2.6L2.64423 4.3875Z" fill="white"/>
                                        </svg>
                                        Accept
                                    </a>
                                    <a href="#" class="pb-md-left-tblc-main-act__remove">
                                        <svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0.5 5.743L3.1215 3.1215L5.743 5.743M5.743 0.5L3.121 3.1215L0.5 0.5" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Decline
                                    </a>
                                    
                                </div>
                            </div>
                            <div class="pb-md-left-tblc-main-c__tbody">
                                <div class="pb-md-left-tblc-main-id" style="justify-content: center">#R123</div>
                                <div class="pb-md-left-tblc-main-name">
                                    <p>Spenzer Corporalli</p>
                                    <small>21, 4th St Virginia summerville Mambugan Antipolo City</small>
                                </div>
                                <div class="pb-md-left-tblc-main-serv">
                                    <small>Plumber</small>
                                    <p>{{ \Illuminate\Support\Str::limit('Water Heater Expert...', 40) }}</p>
                                    <small>₱1,200.00</small>
                                </div>
                                <div class="pb-md-left-tblc-main-date">
                                    <p style="font-size: 14px">Dec 10, 2025</p>
                                    <small>1: 25 PM</small>
                                </div>
                                <div class="pb-md-left-tblc-main-act">
                                    <a href="#" class="pb-md-left-tblc-main-act__actp">
                                        <svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.64423 4.3875L6.88173 0.15C6.98173 0.0500001 7.0984 0 7.23173 0C7.36507 0 7.48173 0.0500001 7.58173 0.15C7.68173 0.25 7.73173 0.368833 7.73173 0.5065C7.73173 0.644167 7.68173 0.762834 7.58173 0.8625L2.99423 5.4625C2.89423 5.5625 2.77756 5.6125 2.64423 5.6125C2.5109 5.6125 2.39423 5.5625 2.29423 5.4625L0.144231 3.3125C0.0442308 3.2125 -0.00376923 3.09383 0.000230769 2.9565C0.00423077 2.81917 0.0563973 2.70033 0.156731 2.6C0.257064 2.49967 0.375898 2.44967 0.513231 2.45C0.650564 2.45033 0.769231 2.50033 0.869231 2.6L2.64423 4.3875Z" fill="white"/>
                                        </svg>
                                        Accept
                                    </a>
                                    <a href="#" class="pb-md-left-tblc-main-act__remove">
                                        <svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0.5 5.743L3.1215 3.1215L5.743 5.743M5.743 0.5L3.121 3.1215L0.5 0.5" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Decline
                                    </a>
                                    
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                
            </div>
            <div class="pb-md-right">
                <div class="pb-md-right-active">
                    <div class="pb-md-right-active__head">
                        <h3>Todays Ongoing Book </h3>

                        <span class="booking-help-tooltip">
                            <i class="fa fa-question-circle"></i>
                            <span class="booking-help-tooltip__text">
                                <strong>Reminders:</strong><br>
                                - Booking will automatically end in 16 hours if not ended yet.<br>
                                - Please contact the customer for any updates or delays.<br>
                                - Be on time and prepared.
                            </span>
                        </span>
                    </div>
                    <div class="pb-md-right-active__body">

                        <div class="pb-md-right-active__body__head">
                            <div class="pbmd-rabh-box">
                                <img src="{{asset('images/user.png')}}" class="pbmd-rabh-box__pfp" alt="profile-image">
                                <div class="pbmd-rabh-box__pfp-d">
                                    <p class="pbmd-rabh-box__pfp-d__name">Spenzer Corporalli</p>
                                    <a href="#" class="pbmd-rabh-box__pfp-d__num">09125240151</a>
                                    <a href="#" class="pbmd-rabh-box__pfp-d__email">spen@gmail.com</a>
                                </div>
                            </div>

                            <p class="pb-md-right-active__body__head__rate">Fixed Rate: <span>₱1,200.00</span></p>
                        </div>
                        <hr>
                        <div class="pb-md-right-active__body__details">
                            <div>
                                <p class="pdmdrabd-label">Plumbing</p>
                                <p class="pdmdrabd-title">Water Heater Expert</p>
                            </div>
                            <div>
                                <p>Date: Dec 10, 2025</p>
                                <p>Time: 1: 25 PM</p>
                            </div>
                            <div>
                                <p>Address:</p>
                                <p>21, 4th St Virginia summerville Mambugan Antipolo City</p>
                            </div>
                        </div>
                        <button >Mark as complete</button>
                    </div>
                </div>
                

                <div class="pb-md-right-completed">

                    <div class="pb-md-right-completed__head">
                        <h3>Completed Services</h3>
                        <p>Completed <span style="color: #A6A6A6">(<span>3</span>)</span></p>
                    </div>

                    <div class="pb-md-right-completed__body">
                        <div class="pbmdr-cb-box">
                            <img src="{{asset('images/complete-book.svg')}}" class="icon-cb-book" alt="icon">
                            <div class="pbmdr-cb-box__det">
                                <div class="pbmdr-cb-boxdet-p">
                                    <img src="{{asset('images/user.png')}}" class="pbmdr-cb-boxdet-p__pfp" alt="profile-image">
                                    <div class="pbmdr-cb-boxdet-p__pfp-d">
                                        <p class="pbmdr-cb-boxdet-p__pfp-d__name">Spenzer Corporalli</p>
                                        <a href="#" class="pbmdr-cb-boxdet-p__pfp-d__num">09125240151</a>
                                        <a href="#" class="pbmdr-cb-boxdet-p__pfp-d__email">spen@gmail.com</a>
                                    </div>
                                </div>
                            </div>
     
                            <div class="pbmdr-cb-box__foo"> 
                                <p>
                                    Rated: 
                                    <span><i class="fa fa-star" style="font-size: 12px; color: #FFBE42; margin-right: -1.8px; margin-bottom: 2px"></i></span>
                                    <span><i class="fa fa-star" style="font-size: 12px; color: #FFBE42; margin-right: -1.8px; margin-bottom: 2px"></i></span>
                                    <span><i class="fa fa-star" style="font-size: 12px; color: #FFBE42; margin-right: -1.8px; margin-bottom: 2px"></i></span>
                                    
                                </p>
                                <button>
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.5 5.5H9V2.5C9 1.95 8.55 1.5 8 1.5H2C1.45 1.5 1 1.95 1 2.5V9C1 9.825 1.675 10.5 2.5 10.5H9.5C10.325 10.5 11 9.825 11 9V6C11 5.725 10.775 5.5 10.5 5.5ZM2.5 9.5C2.225 9.5 2 9.275 2 9V2.5H8V9C7.99975 9.17028 8.02849 9.33937 8.085 9.5H2.5ZM10 9C10 9.275 9.775 9.5 9.5 9.5C9.225 9.5 9 9.275 9 9V6.5H10V9Z" fill="#656565"/>
                                        <path d="M3 3.5H7V4.5H3V3.5ZM3 5.5H7V6.5H3V5.5ZM5.5 7.5H7V8.5H5.5V7.5Z" fill="#656565"/>
                                    </svg>

                                    Download Receipt
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="pb-md-right-completed__body">
                        <div class="pbmdr-cb-box">
                            <img src="{{asset('images/complete-book.svg')}}" class="icon-cb-book" alt="icon">
                            <div class="pbmdr-cb-box__det">
                                <div class="pbmdr-cb-boxdet-p">
                                    <img src="{{asset('images/user.png')}}" class="pbmdr-cb-boxdet-p__pfp" alt="profile-image">
                                    <div class="pbmdr-cb-boxdet-p__pfp-d">
                                        <p class="pbmdr-cb-boxdet-p__pfp-d__name">Spenzer Corporalli</p>
                                        <a href="#" class="pbmdr-cb-boxdet-p__pfp-d__num">09125240151</a>
                                        <a href="#" class="pbmdr-cb-boxdet-p__pfp-d__email">spen@gmail.com</a>
                                    </div>
                                </div>
                            </div>
     
                            <div class="pbmdr-cb-box__foo"> 
                                <p>
                                    Rated: 
                                    <span><i class="fa fa-star" style="font-size: 12px; color: #FFBE42; margin-right: -1.8px; margin-bottom: 2px"></i></span>
                                    <span><i class="fa fa-star" style="font-size: 12px; color: #FFBE42; margin-right: -1.8px; margin-bottom: 2px"></i></span>
                                    <span><i class="fa fa-star" style="font-size: 12px; color: #FFBE42; margin-right: -1.8px; margin-bottom: 2px"></i></span>
                                    
                                </p>
                                <button>
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.5 5.5H9V2.5C9 1.95 8.55 1.5 8 1.5H2C1.45 1.5 1 1.95 1 2.5V9C1 9.825 1.675 10.5 2.5 10.5H9.5C10.325 10.5 11 9.825 11 9V6C11 5.725 10.775 5.5 10.5 5.5ZM2.5 9.5C2.225 9.5 2 9.275 2 9V2.5H8V9C7.99975 9.17028 8.02849 9.33937 8.085 9.5H2.5ZM10 9C10 9.275 9.775 9.5 9.5 9.5C9.225 9.5 9 9.275 9 9V6.5H10V9Z" fill="#656565"/>
                                        <path d="M3 3.5H7V4.5H3V3.5ZM3 5.5H7V6.5H3V5.5ZM5.5 7.5H7V8.5H5.5V7.5Z" fill="#656565"/>
                                    </svg>

                                    Download Receipt
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="pb-md-right-completed__body">
                        <div class="pbmdr-cb-box">
                            <img src="{{asset('images/complete-book.svg')}}" class="icon-cb-book" alt="icon">
                            <div class="pbmdr-cb-box__det">
                                <div class="pbmdr-cb-boxdet-p">
                                    <img src="{{asset('images/user.png')}}" class="pbmdr-cb-boxdet-p__pfp" alt="profile-image">
                                    <div class="pbmdr-cb-boxdet-p__pfp-d">
                                        <p class="pbmdr-cb-boxdet-p__pfp-d__name">Spenzer Corporalli</p>
                                        <a href="#" class="pbmdr-cb-boxdet-p__pfp-d__num">09125240151</a>
                                        <a href="#" class="pbmdr-cb-boxdet-p__pfp-d__email">spen@gmail.com</a>
                                    </div>
                                </div>
                            </div>
     
                            <div class="pbmdr-cb-box__foo"> 
                                <p>
                                    Rated: 
                                    <span><i class="fa fa-star" style="font-size: 12px; color: #FFBE42; margin-right: -1.8px; margin-bottom: 2px"></i></span>
                                    <span><i class="fa fa-star" style="font-size: 12px; color: #FFBE42; margin-right: -1.8px; margin-bottom: 2px"></i></span>
                                    <span><i class="fa fa-star" style="font-size: 12px; color: #FFBE42; margin-right: -1.8px; margin-bottom: 2px"></i></span>
                                    
                                </p>
                                <button>
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.5 5.5H9V2.5C9 1.95 8.55 1.5 8 1.5H2C1.45 1.5 1 1.95 1 2.5V9C1 9.825 1.675 10.5 2.5 10.5H9.5C10.325 10.5 11 9.825 11 9V6C11 5.725 10.775 5.5 10.5 5.5ZM2.5 9.5C2.225 9.5 2 9.275 2 9V2.5H8V9C7.99975 9.17028 8.02849 9.33937 8.085 9.5H2.5ZM10 9C10 9.275 9.775 9.5 9.5 9.5C9.225 9.5 9 9.275 9 9V6.5H10V9Z" fill="#656565"/>
                                        <path d="M3 3.5H7V4.5H3V3.5ZM3 5.5H7V6.5H3V5.5ZM5.5 7.5H7V8.5H5.5V7.5Z" fill="#656565"/>
                                    </svg>

                                    Download Receipt
                                </button>
                            </div>
                        </div>
                    </div>

                </div>



                
            </div>
        </div>
        {{-- <div class="provider--bookings__filters">
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

      
            </div>
            <script>
                console.log(@json($bookRequests));
            </script>
        </div> --}}
        
    </main>     

@endsection
@push('extrascripts')

@endpush