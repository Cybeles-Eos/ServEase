@extends('admin.layouts.auth')

{{-- Meta Section --}}
@section('title', 'Provider Bookings - Servease')

{{-- Page Content --}}
@section('content')
    @include('admin.layouts.header')
    

    <main class="main-dash-uix provider--bookings dash-sp">
        <div class="provider--bookings__head">
            <h3>Pending Site Bookings</h3>
            <p>Review and manage your booking request</p>
        </div>

        <div class="provider--bookings--main-d">
            <div class="pb-md-left">
                <div class="pb-md-left__head">
                    <h3>Scheduled Bookings</h3>
                    <p>Accepted <span style="color: #A6A6A6">(<span>{{ $bookRequests->where('status', 'schedule')->where('provider_id', auth()->user()->provider->id)->count() }}</span>)</span></p>
                </div>

                <div class="pb-md-left__accepted-body">
                    <div class="pb-md-left__accepted-body--main">
                        
                        {{-- Sample Accepted Bookings --}}
                        @php
                            $providerId = auth()->user()->provider->id;
                            $scheduleRequests = collect(); // Make sure its a array

                            if ($providerId) {
                                $scheduleRequests = $bookRequests
                                    ->where('provider_id', $providerId)
                                    ->where('status', 'schedule');
                            }
                        @endphp
                        @forelse($scheduleRequests as $request)
                            <div class="boxss-sd">
                                
                                <div class="boxss-sd-bking">
                                    <img src="{{asset($request->bookingInfo->customer['profile_image'] ?? 'images/user.png')}}" class="boxss-sd-bking__pfp" alt="profile-image">
                                    <div class="boxss-sd-bking__pfp-d">
                                        <p class="boxss-sd-bking__pfp-d__name">{{$request->bookingInfo['lname']}} {{$request->bookingInfo['fname']}}</p>
                                        <a href="#" class="boxss-sd-bking__pfp-d__num">{{$request->bookingInfo['number']}}</a>
                                        <a href="#" class="boxss-sd-bking__pfp-d__email">{{$request->bookingInfo['email']}}</a>
                                    </div>
                                </div>
                                <hr>
                                <div class="boxss-sd-bking-info">
                                    <div>
                                        <p class="boxss-sd-bking-label">{{ $request->bookingInfo->service['category'] ?? '' }}</p>
                                        <p class="boxss-sd-bking-info-serv-title">{{ \Illuminate\Support\Str::limit($request->bookingInfo->service['title'], 40) }}</p>
                                    </div>
                                    <div>
                                        <p class="boxss-sd-bking-label">Date: <span class="">{{ \Carbon\Carbon::parse($request->bookingInfo['date'] ?? null)->format('M d, Y') }}</span></p>
                                        <p class="boxss-sd-bking-label">{{ $request->bookingInfo['time'] ? \Carbon\Carbon::parse($request->bookingInfo['time'])->format('g:i A') : '' }}</p>
                                    </div>
                                    <div>
                                        <p class="boxss-sd-bking-info-serv-head">Address:</p>
                                        <p class="boxss-sd-bking-label">{{ $request->bookingInfo['address'] ?? '' }}</p>
                                    </div>
                                </div>
                                <div class="boxss-sd-bking-foo">
                                    <p>Fixed Rate: <span>₱{{ number_format($request->bookingInfo->service['price'], 2) }}</span></p>
                                    <button class="btn-sm btn-danger" style="border-radius: 5px">Cancel</button>
                                </div>

                            </div>
                        @empty
                            <div style="width: 100%; height: 256px; background-color: #fff; display: flex; justify-content: center; align-items: center;">
                                <svg width="134" height="130" viewBox="0 0 134 130" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g opacity="0.4" clip-path="url(#clip0_1462_10389)">
                                    <path d="M85.0685 29.2363H48.9614C48.1385 29.2373 47.3497 29.5626 46.7679 30.1408C46.1861 30.7191 45.8588 31.5031 45.8578 32.3209V112.078L45.444 112.204L36.5863 114.9C36.1665 115.027 35.7131 114.983 35.3256 114.779C34.938 114.574 34.6481 114.225 34.5193 113.808L8.17184 28.2718C8.04362 27.8546 8.08732 27.4039 8.29334 27.0187C8.49935 26.6334 8.85083 26.3453 9.27052 26.2175L22.9202 22.0636L62.491 10.0254L76.1405 5.87151C76.3483 5.80797 76.5666 5.78577 76.7829 5.80617C76.9993 5.82658 77.2095 5.88919 77.4015 5.99042C77.5935 6.09165 77.7635 6.22952 77.9018 6.39613C78.0401 6.56275 78.144 6.75483 78.2076 6.9614L84.9423 28.825L85.0685 29.2363Z" fill="#F2F2F2"/>
                                    <path d="M92.9485 28.8256L84.8315 2.47491C84.6965 2.03586 84.4757 1.62756 84.1818 1.27334C83.888 0.919121 83.5267 0.625927 83.1188 0.410511C82.7109 0.195094 82.2642 0.0616764 81.8044 0.0178857C81.3446 -0.025905 80.8806 0.0207897 80.4389 0.155297L61.2484 5.99341L21.6797 18.0336L2.4891 23.8738C1.59761 24.1458 0.851147 24.7584 0.413569 25.5769C-0.0240087 26.3954 -0.116956 27.353 0.155132 28.2395L27.8971 118.295C28.1182 119.011 28.5642 119.637 29.1697 120.083C29.7752 120.528 30.5083 120.768 31.2615 120.769C31.6101 120.769 31.9567 120.717 32.2898 120.615L45.4449 116.613L45.8587 116.486V116.056L45.4449 116.181L32.1677 120.222C31.3808 120.461 30.5309 120.379 29.8044 119.995C29.0779 119.612 28.5341 118.958 28.2924 118.176L0.552477 28.1182C0.432697 27.7309 0.39095 27.324 0.429626 26.9207C0.468302 26.5174 0.586638 26.1257 0.777865 25.7679C0.969092 25.4101 1.22945 25.0934 1.54403 24.8357C1.85861 24.5781 2.22123 24.3847 2.61113 24.2665L21.8017 18.4264L61.3705 6.38824L80.5611 0.548072C80.8568 0.458372 81.1642 0.412636 81.4734 0.412349C82.137 0.41383 82.7827 0.626453 83.3159 1.01907C83.8491 1.41169 84.2417 1.96368 84.4364 2.59419L92.5161 28.8256L92.6444 29.2369H93.0747L92.9485 28.8256Z" fill="#3F3D56"/>
                                    <path d="M25.3839 26.285C24.9851 26.2847 24.5969 26.1574 24.2762 25.9218C23.9555 25.6861 23.7193 25.3546 23.6021 24.9757L20.9371 16.3241C20.8655 16.0917 20.8406 15.8476 20.864 15.6056C20.8873 15.3637 20.9584 15.1287 21.0731 14.914C21.1878 14.6994 21.344 14.5093 21.5326 14.3546C21.7213 14.2 21.9387 14.0838 22.1726 14.0127L58.5755 2.93613C59.0477 2.79291 59.5578 2.84176 59.9939 3.07195C60.4299 3.30214 60.7562 3.69487 60.9012 4.16395L63.5663 12.8157C63.7103 13.285 63.6611 13.792 63.4295 14.2253C63.1979 14.6587 62.8028 14.983 62.3309 15.1272L25.9279 26.2037C25.7516 26.2575 25.5683 26.2849 25.3839 26.285Z" fill="#D9D9D9"/>
                                    <path d="M39.3432 9.24316C41.6286 9.24316 43.4813 7.4018 43.4813 5.13037C43.4813 2.85894 41.6286 1.01758 39.3432 1.01758C37.0578 1.01758 35.2051 2.85894 35.2051 5.13037C35.2051 7.4018 37.0578 9.24316 39.3432 9.24316Z" fill="#D9D9D9"/>
                                    <path d="M39.343 7.73604C40.7902 7.73604 41.9634 6.57003 41.9634 5.13169C41.9634 3.69335 40.7902 2.52734 39.343 2.52734C37.8958 2.52734 36.7227 3.69335 36.7227 5.13169C36.7227 6.57003 37.8958 7.73604 39.343 7.73604Z" fill="white"/>
                                    <path d="M124.689 119.719H54.7548C54.2885 119.719 53.8415 119.535 53.5118 119.207C53.1821 118.879 52.9966 118.435 52.9961 117.971V34.6874C52.9966 34.224 53.1821 33.7797 53.5118 33.452C53.8415 33.1243 54.2885 32.94 54.7548 32.9395H124.689C125.155 32.94 125.602 33.1243 125.932 33.452C126.262 33.7797 126.447 34.224 126.448 34.6874V117.971C126.447 118.435 126.262 118.879 125.932 119.207C125.602 119.534 125.155 119.719 124.689 119.719Z" fill="#F1F1F1"/>
                                    <path d="M92.5145 28.8262H48.9608C48.0283 28.8275 47.1344 29.1962 46.475 29.8515C45.8157 30.5069 45.4447 31.3953 45.4434 32.322V116.182L45.8572 116.056V32.322C45.8582 31.5043 46.1855 30.7203 46.7673 30.142C47.3491 29.5637 48.1379 29.2384 48.9608 29.2375H92.6428L92.5145 28.8262ZM130.482 28.8262H48.9608C48.0283 28.8275 47.1344 29.1962 46.475 29.8515C45.8157 30.5069 45.4447 31.3953 45.4434 32.322V126.505C45.4447 127.432 45.8157 128.32 46.475 128.976C47.1344 129.631 48.0283 130 48.9608 130.001H130.482C131.414 130 132.308 129.631 132.968 128.976C133.627 128.32 133.998 127.432 133.999 126.505V32.322C133.998 31.3953 133.627 30.5069 132.968 29.8515C132.308 29.1962 131.414 28.8275 130.482 28.8262ZM133.585 126.505C133.584 127.323 133.257 128.107 132.675 128.685C132.093 129.263 131.305 129.589 130.482 129.59H48.9608C48.1379 129.589 47.3491 129.263 46.7673 128.685C46.1855 128.107 45.8582 127.323 45.8572 126.505V32.322C45.8582 31.5043 46.1855 30.7203 46.7673 30.142C47.3491 29.5637 48.1379 29.2384 48.9608 29.2375H130.482C131.305 29.2384 132.093 29.5637 132.675 30.142C133.257 30.7203 133.584 31.5043 133.585 32.322V126.505Z" fill="#3F3D56"/>
                                    <path d="M108.757 37.8727H70.6864C70.1927 37.8722 69.7193 37.677 69.3702 37.33C69.0211 36.9831 68.8248 36.5126 68.8242 36.0219V26.9738C68.8248 26.4831 69.0212 26.0127 69.3703 25.6657C69.7194 25.3188 70.1927 25.1236 70.6864 25.123H108.757C109.251 25.1236 109.724 25.3188 110.073 25.6657C110.422 26.0127 110.619 26.4831 110.619 26.9738V36.0219C110.619 36.5126 110.422 36.9831 110.073 37.33C109.724 37.677 109.251 37.8722 108.757 37.8727Z" fill="#D9D9D9"/>
                                    <path d="M89.7221 25.7412C92.0075 25.7412 93.8602 23.8999 93.8602 21.6284C93.8602 19.357 92.0075 17.5156 89.7221 17.5156C87.4367 17.5156 85.584 19.357 85.584 21.6284C85.584 23.8999 87.4367 25.7412 89.7221 25.7412Z" fill="#D9D9D9"/>
                                    <path d="M89.7217 24.1332C91.1137 24.1332 92.2422 23.0116 92.2422 21.6281C92.2422 20.2446 91.1137 19.123 89.7217 19.123C88.3296 19.123 87.2012 20.2446 87.2012 21.6281C87.2012 23.0116 88.3296 24.1332 89.7217 24.1332Z" fill="white"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_1462_10389">
                                    <rect width="134" height="130" fill="white"/>
                                    </clipPath>
                                    </defs>
                                </svg>
                            </div>
                        @endforelse
                        {{-- <div class="boxss-sd">
                            
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

                        </div> --}}

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

                            {{-- Sample request card --}}
                            @php
                                $providerId = auth()->user()->provider->id;
                                $pendingRequests = collect();

                                if ($providerId) {
                                    $pendingRequests = $bookRequests
                                        ->where('provider_id', $providerId)
                                        ->where('status', 'pending');
                                }
                            @endphp
                            @forelse($pendingRequests as $request)
                                <div class="pb-md-left-tblc-main-c__tbody">
                                    <div class="pb-md-left-tblc-main-id" style="justify-content: center">#{{ $loop->iteration }}</div>
                                    <div class="pb-md-left-tblc-main-name">
                                        <p>{{ $request->bookingInfo['lname'] ?? '' }} {{ $request->bookingInfo['fname'] ?? '' }}</p>
                                        <small>{{ $request->bookingInfo['address'] ?? '' }}</small>
                                    </div>
                                    <div class="pb-md-left-tblc-main-serv">
                                        <small>{{ $request->bookingInfo->service['category'] ?? '' }}</small>
                                        <p>{{ \Illuminate\Support\Str::limit($request->bookingInfo->service['title'], 40) }}</p>
                                        <small>₱{{ number_format($request->bookingInfo->service['price'], 2) }}</small>
                                    </div>
                                    <div class="pb-md-left-tblc-main-date">
                                        <p style="font-size: 14px">{{ \Carbon\Carbon::parse($request->bookingInfo['date'] ?? null)->format('M d, Y') }}</p>
                                        <small>{{ $request->bookingInfo['time'] ? \Carbon\Carbon::parse($request->bookingInfo['time'])->format('g:i A') : '' }}</small>
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
                            @empty
                                <div class="provider-stbl-main-c__tbody" style="height: 55px; font-size: 14px; text-align:center; margin: 0; display: flex; align-items: center; justify-content:center; background-color: #F9F9F9">
                                    No Booking Request
                                </div>
                            @endforelse
                            {{-- <div class="pb-md-left-tblc-main-c__tbody">
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
                            </div> --}}

                        </div>
                    </div>
                </div>
                
            </div>
            <div class="pb-md-right">

                {{-- Sample Active Ongoing Card --}}
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

                    {{-- Sample Complete Card --}}
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

                    {{-- @foreach($bookRequests as $request)
                        <div class="pbmdr-card">
                            <h4>{{ $request->bookingInfo->service->title }}</h4>
                            <p><strong>Customer:</strong> {{ $request->bookingInfo->customer->first_name }} {{ $request->bookingInfo->customer->last_name }}</p>
                            <p><strong>Status:</strong> {{ ucfirst($request->status) }}</p>
                            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($request->bookingInfo->date)->format('F d, Y') }}</p>
                            <p><strong>Time:</strong> {{ $request->bookingInfo->time }}</p>
                        </div>
                    @endforeach --}}
                </div>
            </div>
        </div>
    </main>     
                    <script>
                        console.log(@json($bookRequests));
                    </script>
                    <script>console.log({{ auth()->user()->provider->id }});</script>
@endsection
@push('extrascripts')

@endpush