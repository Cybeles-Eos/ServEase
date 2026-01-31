@extends('front.layouts.base')

@section('content')
    <main class="main-page page--services-detail">
        <section class="section--list m-padding m-width">
            <div class="psd-sl-category">
                <div class="psd-sl-category__head">
                    <a href="{{ url('/') }}" class="{{ Request::is('/') ? 's-act-link' : '' }}">Home</a>

                    <svg width="4" height="7" viewBox="0 0 4 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.384033 0.320312L2.88403 3.32031L0.384033 6.32031" stroke="#FDB932"/>
                    </svg>

                    <a href="{{ url('services') }}" class="{{ Request::is('services') ? 's-act-link' : '' }}">Services</a>

                    <svg width="4" height="7" viewBox="0 0 4 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.384033 0.320312L2.88403 3.32031L0.384033 6.32031" stroke="#FDB932"/>
                    </svg>

                    <a href="{{ url('service-detail') }}" class="{{ Request::is('service-detail') ? 's-act-link' : '' }}">Residential Pipe Repair Services</a>
                </div>
                <div class="psd-sl-category__side">
                    <h4>Related Services</h4>
                </div>
                <div class="psd-sl-category__rcon">
                    <a href="#" class="psdslcr-box">
                        <div class="psdslcr-box__head">
                            <div>
                                Plumber
                            </div>

                            <p>
                                <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.38803 1.09688L6.12137 2.56354C6.22136 2.76771 6.48803 2.96354 6.71303 3.00104L8.0422 3.22187C8.8922 3.36354 9.0922 3.98021 8.4797 4.58854L7.44636 5.62187C7.27136 5.79687 7.17553 6.13437 7.2297 6.37604L7.52553 7.65521C7.75886 8.66771 7.22136 9.05937 6.32553 8.53021L5.0797 7.79271C4.8547 7.65938 4.48387 7.65938 4.2547 7.79271L3.00887 8.53021C2.1172 9.05937 1.57553 8.66354 1.80887 7.65521L2.1047 6.37604C2.15887 6.13437 2.06303 5.79687 1.88803 5.62187L0.854698 4.58854C0.246365 3.98021 0.442199 3.36354 1.2922 3.22187L2.62137 3.00104C2.8422 2.96354 3.10887 2.76771 3.20886 2.56354L3.9422 1.09688C4.3422 0.301042 4.9922 0.301042 5.38803 1.09688Z" fill="#FFBE42" stroke="#FFBE42" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                4.9 <span>(128 reviews)</span>
                            </p>
                        </div>
                        <div class="psdslcr-box__text">
                            <h3>Water Heater Expert</h3>
                            <p>Professional repair and installation of tank and tankless water heaters to ensure...</p>
                        </div>
                    </a>
                    <a href="#" class="psdslcr-box">
                        <div class="psdslcr-box__head">
                            <div>
                                Plumber
                            </div>

                            <p>
                                <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.38803 1.09688L6.12137 2.56354C6.22136 2.76771 6.48803 2.96354 6.71303 3.00104L8.0422 3.22187C8.8922 3.36354 9.0922 3.98021 8.4797 4.58854L7.44636 5.62187C7.27136 5.79687 7.17553 6.13437 7.2297 6.37604L7.52553 7.65521C7.75886 8.66771 7.22136 9.05937 6.32553 8.53021L5.0797 7.79271C4.8547 7.65938 4.48387 7.65938 4.2547 7.79271L3.00887 8.53021C2.1172 9.05937 1.57553 8.66354 1.80887 7.65521L2.1047 6.37604C2.15887 6.13437 2.06303 5.79687 1.88803 5.62187L0.854698 4.58854C0.246365 3.98021 0.442199 3.36354 1.2922 3.22187L2.62137 3.00104C2.8422 2.96354 3.10887 2.76771 3.20886 2.56354L3.9422 1.09688C4.3422 0.301042 4.9922 0.301042 5.38803 1.09688Z" fill="#FFBE42" stroke="#FFBE42" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                4.9 <span>(128 reviews)</span>
                            </p>
                        </div>
                        <div class="psdslcr-box__text">
                            <h3>Emergency Leak and Drain Repair</h3>
                            <p>Professional repair and installation of tank and tankless water heaters to ensure...</p>
                        </div>
                    </a>
                    <a href="#" class="psdslcr-box">
                        <div class="psdslcr-box__head">
                            <div>
                                Plumber
                            </div>

                            <p>
                                <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.38803 1.09688L6.12137 2.56354C6.22136 2.76771 6.48803 2.96354 6.71303 3.00104L8.0422 3.22187C8.8922 3.36354 9.0922 3.98021 8.4797 4.58854L7.44636 5.62187C7.27136 5.79687 7.17553 6.13437 7.2297 6.37604L7.52553 7.65521C7.75886 8.66771 7.22136 9.05937 6.32553 8.53021L5.0797 7.79271C4.8547 7.65938 4.48387 7.65938 4.2547 7.79271L3.00887 8.53021C2.1172 9.05937 1.57553 8.66354 1.80887 7.65521L2.1047 6.37604C2.15887 6.13437 2.06303 5.79687 1.88803 5.62187L0.854698 4.58854C0.246365 3.98021 0.442199 3.36354 1.2922 3.22187L2.62137 3.00104C2.8422 2.96354 3.10887 2.76771 3.20886 2.56354L3.9422 1.09688C4.3422 0.301042 4.9922 0.301042 5.38803 1.09688Z" fill="#FFBE42" stroke="#FFBE42" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                4.9 <span>(128 reviews)</span>
                            </p>
                        </div>
                        <div class="psdslcr-box__text">
                            <h3>Pipe Leak Detection and Assessment</h3>
                            <p>Professional repair and installation of tank and tankless water heaters to ensure...</p>
                        </div>
                    </a>
                </div>
                <hr>
                <a href="{{ url('provider-signup') }}" class="join-now-cta-sd">
                    <img src="{{ asset('images/cta-join.png') }}" alt="cta-image">
                </a>
            </div>
            <div class="psd-sl-sdetail">
                <div class="psd-sl-sdetail__img">
                    <img src="{{ asset('images/service-detail-img.png') }}"  alt="image-detail">
                </div>
                <div class="psd-sl-sdetail__info">
                    <div class="psd-sl-sdetaili-description">
                        <p class="psd-sl-sdetaili-description__prt">Pluming</p>
                        <h3>Reliable Plumbing Solutions for Every Home and Business</h3>
                        <br>
                        <p>From minor leaks to major pipe repairs, our trusted Filipino plumbers deliver fast, safe, and professional service right at your doorstep. Whether it’s an emergency fix or routine maintenance, we make sure your water system runs smoothly and efficiently.</p>
                        <br>
                        <p>From minor leaks to major pipe repairs, our trusted Filipino plumbers deliver fast, safe, and professional service right at your doorstep. Whether it’s an emergency fix or routine maintenance, we make sure your water system runs smoothly and efficiently.</p>
                        <br>
                        <p>From minor leaks to major pipe repairs, our trusted Filipino plumbers deliver fast, safe, and professional service right at your doorstep. Whether it’s an emergency fix or routine maintenance, we make sure your water system runs smoothly and efficiently.</p>
                    
                        <div class="psd-sl-sdetaili-relateds">
                            <h4>Related Services</h4>
                            
                            <a href="#" class="psd-sl-sdetaili-relateds__bc">
                                <div class="psd-sl-sdetaili-relateds__bc__head">
                                    <div>
                                        Plumber
                                    </div>

                                    <p>
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.38803 1.09688L6.12137 2.56354C6.22136 2.76771 6.48803 2.96354 6.71303 3.00104L8.0422 3.22187C8.8922 3.36354 9.0922 3.98021 8.4797 4.58854L7.44636 5.62187C7.27136 5.79687 7.17553 6.13437 7.2297 6.37604L7.52553 7.65521C7.75886 8.66771 7.22136 9.05937 6.32553 8.53021L5.0797 7.79271C4.8547 7.65938 4.48387 7.65938 4.2547 7.79271L3.00887 8.53021C2.1172 9.05937 1.57553 8.66354 1.80887 7.65521L2.1047 6.37604C2.15887 6.13437 2.06303 5.79687 1.88803 5.62187L0.854698 4.58854C0.246365 3.98021 0.442199 3.36354 1.2922 3.22187L2.62137 3.00104C2.8422 2.96354 3.10887 2.76771 3.20886 2.56354L3.9422 1.09688C4.3422 0.301042 4.9922 0.301042 5.38803 1.09688Z" fill="#FFBE42" stroke="#FFBE42" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        4.9 <span>(128 reviews)</span>
                                    </p>
                                </div>
                                <div class="psd-sl-sdetaili-relateds__bc__text">
                                    <h3>Water Heater Expert</h3>
                                    <p>Professional repair and installation of tank and tankless water heaters to ensure...</p>
                                </div>
                            </a>

                            <a href="#" class="psd-sl-sdetaili-relateds__bc">
                                <div class="psd-sl-sdetaili-relateds__bc__head">
                                    <div>
                                        Plumber
                                    </div>

                                    <p>
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.38803 1.09688L6.12137 2.56354C6.22136 2.76771 6.48803 2.96354 6.71303 3.00104L8.0422 3.22187C8.8922 3.36354 9.0922 3.98021 8.4797 4.58854L7.44636 5.62187C7.27136 5.79687 7.17553 6.13437 7.2297 6.37604L7.52553 7.65521C7.75886 8.66771 7.22136 9.05937 6.32553 8.53021L5.0797 7.79271C4.8547 7.65938 4.48387 7.65938 4.2547 7.79271L3.00887 8.53021C2.1172 9.05937 1.57553 8.66354 1.80887 7.65521L2.1047 6.37604C2.15887 6.13437 2.06303 5.79687 1.88803 5.62187L0.854698 4.58854C0.246365 3.98021 0.442199 3.36354 1.2922 3.22187L2.62137 3.00104C2.8422 2.96354 3.10887 2.76771 3.20886 2.56354L3.9422 1.09688C4.3422 0.301042 4.9922 0.301042 5.38803 1.09688Z" fill="#FFBE42" stroke="#FFBE42" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        4.9 <span>(128 reviews)</span>
                                    </p>
                                </div>
                                <div class="psd-sl-sdetaili-relateds__bc__text">
                                    <h3>Water Heater Expert</h3>
                                    <p>Professional repair and installation of tank and tankless water heaters to ensure...</p>
                                </div>
                            </a>
                            <a href="#" class="psd-sl-sdetaili-relateds__bc">
                                <div class="psd-sl-sdetaili-relateds__bc__head">
                                    <div>
                                        Plumber
                                    </div>

                                    <p>
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.38803 1.09688L6.12137 2.56354C6.22136 2.76771 6.48803 2.96354 6.71303 3.00104L8.0422 3.22187C8.8922 3.36354 9.0922 3.98021 8.4797 4.58854L7.44636 5.62187C7.27136 5.79687 7.17553 6.13437 7.2297 6.37604L7.52553 7.65521C7.75886 8.66771 7.22136 9.05937 6.32553 8.53021L5.0797 7.79271C4.8547 7.65938 4.48387 7.65938 4.2547 7.79271L3.00887 8.53021C2.1172 9.05937 1.57553 8.66354 1.80887 7.65521L2.1047 6.37604C2.15887 6.13437 2.06303 5.79687 1.88803 5.62187L0.854698 4.58854C0.246365 3.98021 0.442199 3.36354 1.2922 3.22187L2.62137 3.00104C2.8422 2.96354 3.10887 2.76771 3.20886 2.56354L3.9422 1.09688C4.3422 0.301042 4.9922 0.301042 5.38803 1.09688Z" fill="#FFBE42" stroke="#FFBE42" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        4.9 <span>(128 reviews)</span>
                                    </p>
                                </div>
                                <div class="psd-sl-sdetaili-relateds__bc__text">
                                    <h3>Water Heater Expert</h3>
                                    <p>Professional repair and installation of tank and tankless water heaters to ensure...</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="psd-sl-sdetaili-details">
                        {{-- @guest
                            <button id="open-book" class="btn btn--tertiary">Book Now</button>
                        @endguest --}}
                        @guest
                            <a href="{{url('login')}}" class="btn btn--tertiary-d">Book Now</a>
                        @endguest
                        @auth
                            @if(auth()->user()->isCustomer())
                                <button id="open-book" class="btn btn--tertiary">Book Now</button>
                            @endif
                        @endauth
                        <div class="psd-sl-sdetaili-d-provider">
                            <div class="psd-sl-sdetaili-d-provider__con">
                                <img src="{{ asset('images/user.png') }}" alt="">
                                <div>
                                    <h4>Daniella B. Barcelon</h4>
                                    <p>
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.38803 1.09688L6.12137 2.56354C6.22136 2.76771 6.48803 2.96354 6.71303 3.00104L8.0422 3.22187C8.8922 3.36354 9.0922 3.98021 8.4797 4.58854L7.44636 5.62187C7.27136 5.79687 7.17553 6.13437 7.2297 6.37604L7.52553 7.65521C7.75886 8.66771 7.22136 9.05937 6.32553 8.53021L5.0797 7.79271C4.8547 7.65938 4.48387 7.65938 4.2547 7.79271L3.00887 8.53021C2.1172 9.05937 1.57553 8.66354 1.80887 7.65521L2.1047 6.37604C2.15887 6.13437 2.06303 5.79687 1.88803 5.62187L0.854698 4.58854C0.246365 3.98021 0.442199 3.36354 1.2922 3.22187L2.62137 3.00104C2.8422 2.96354 3.10887 2.76771 3.20886 2.56354L3.9422 1.09688C4.3422 0.301042 4.9922 0.301042 5.38803 1.09688Z" fill="#FFBE42" stroke="#FFBE42" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        4.9 <span>(128 reviews)</span>
                                    </p>
                                </div>
                            </div>
                            {{-- svg --}}
                            <svg width="16" height="16" class="mb-1" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.00033 7.99967C9.84127 7.99967 11.3337 6.50729 11.3337 4.66634C11.3337 2.82539 9.84127 1.33301 8.00033 1.33301C6.15938 1.33301 4.66699 2.82539 4.66699 4.66634C4.66699 6.50729 6.15938 7.99967 8.00033 7.99967Z" stroke="#858688" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M13.7268 14.6667C13.7268 12.0867 11.1601 10 8.0001 10C4.8401 10 2.27344 12.0867 2.27344 14.6667" stroke="#858688" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="psd-sl-sdetaili-d-service-info">
                            <p class="psd-sl-sdetaili-d-service-info__prc">
                                Service Price: <span>₱ 1,200.00</span>
                            </p>
                            <br>
                            <h4>More Details</h4>
                            <ul>
                                <li>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.83984 7.34663V10.66C2.83984 11.8733 2.83984 11.8733 3.98651 12.6466L7.13984 14.4666C7.61318 14.74 8.38651 14.74 8.85984 14.4666L12.0132 12.6466C13.1598 11.8733 13.1598 11.8733 13.1598 10.66V7.34663C13.1598 6.13329 13.1598 6.13329 12.0132 5.35996L8.85984 3.53996C8.38651 3.26663 7.61318 3.26663 7.13984 3.53996L3.98651 5.35996C2.83984 6.13329 2.83984 6.13329 2.83984 7.34663Z" stroke="#8F9296" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M11.6663 5.08634V3.33301C11.6663 1.99967 10.9997 1.33301 9.66634 1.33301H6.33301C4.99967 1.33301 4.33301 1.99967 4.33301 3.33301V5.03967" stroke="#8F9296" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M8.42018 7.32664L8.80018 7.91997C8.86018 8.01331 8.99351 8.10664 9.09351 8.13331L9.77351 8.30664C10.1935 8.41331 10.3068 8.77331 10.0335 9.10664L9.58685 9.64664C9.52018 9.73331 9.46685 9.88664 9.47351 9.99331L9.51351 10.6933C9.54018 11.1266 9.23351 11.3466 8.83351 11.1866L8.18018 10.9266C8.08018 10.8866 7.91351 10.8866 7.81351 10.9266L7.16018 11.1866C6.76018 11.3466 6.45351 11.12 6.48018 10.6933L6.52018 9.99331C6.52685 9.88664 6.47351 9.72664 6.40685 9.64664L5.96018 9.10664C5.68685 8.77331 5.80018 8.41331 6.22018 8.30664L6.90018 8.13331C7.00685 8.10664 7.14018 8.00664 7.19351 7.91997L7.57351 7.32664C7.81351 6.96664 8.18685 6.96664 8.42018 7.32664Z" stroke="#8F9296" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <p>Years of Experience: <span>2years</span></p>
                                </li>
                                <li>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.33301 5.99967V4.66634C1.33301 2.66634 2.66634 1.33301 4.66634 1.33301H11.333C13.333 1.33301 14.6663 2.66634 14.6663 4.66634V5.99967" stroke="#8F9296" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M1.33301 10V11.3333C1.33301 13.3333 2.66634 14.6667 4.66634 14.6667H11.333C13.333 14.6667 14.6663 13.3333 14.6663 11.3333V10" stroke="#8F9296" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M4.4668 6.17383L8.00013 8.2205L11.5068 6.18717" stroke="#8F9296" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M8 11.8472V8.21387" stroke="#8F9296" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M7.17348 4.19305L5.04015 5.37973C4.56015 5.6464 4.16016 6.31973 4.16016 6.87306V9.13307C4.16016 9.6864 4.55348 10.3597 5.04015 10.6264L7.17348 11.813C7.62682 12.0664 8.37349 12.0664 8.83349 11.813L10.9668 10.6264C11.4468 10.3597 11.8468 9.6864 11.8468 9.13307V6.87306C11.8468 6.31973 11.4535 5.6464 10.9668 5.37973L8.83349 4.19305C8.37349 3.93305 7.62682 3.93305 7.17348 4.19305Z" stroke="#8F9296" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <p>Specialization: Pipe Repair</p>
                                </li>   
                                <li>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.99992 8.95297C9.14867 8.95297 10.0799 8.02172 10.0799 6.87297C10.0799 5.72422 9.14867 4.79297 7.99992 4.79297C6.85117 4.79297 5.91992 5.72422 5.91992 6.87297C5.91992 8.02172 6.85117 8.95297 7.99992 8.95297Z" stroke="#8F9296" stroke-width="1.1"/>
                                        <path d="M2.41379 5.65968C3.72712 -0.113657 12.2805 -0.106991 13.5871 5.66634C14.3538 9.05301 12.2471 11.9197 10.4005 13.693C9.06046 14.9863 6.94046 14.9863 5.59379 13.693C3.75379 11.9197 1.64712 9.04634 2.41379 5.65968Z" stroke="#8F9296" stroke-width="1.1"/>
                                    </svg>
                                    <p>Area: Manila & nearby</p>
                                </li>
                                <li>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.6204 4.50635L12.3738 13.5264C12.2138 14.1997 11.6138 14.6663 10.9204 14.6663H2.16041C1.15375 14.6663 0.433756 13.6796 0.733756 12.713L3.54042 3.69971C3.73375 3.07304 4.31376 2.63965 4.96709 2.63965H13.1671C13.8004 2.63965 14.3271 3.02632 14.5471 3.55965C14.6738 3.84632 14.7004 4.17301 14.6204 4.50635Z" stroke="#8F9296" stroke-width="1.1" stroke-miterlimit="10"/>
                                        <path d="M10.667 14.6667H13.8537C14.7137 14.6667 15.387 13.94 15.327 13.08L14.667 4" stroke="#8F9296" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M6.45312 4.25301L7.14646 1.37305" stroke="#8F9296" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M10.9199 4.2605L11.5466 1.36719" stroke="#8F9296" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M5.13379 8H10.4671" stroke="#8F9296" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M4.4668 10.667H9.80013" stroke="#8F9296" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <p>Availability: Mon–Sun</p>
                                </li>
                                <li>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.99967 12.1331C9.47243 12.1331 10.6663 10.9392 10.6663 9.46647C10.6663 7.99371 9.47243 6.7998 7.99967 6.7998C6.52692 6.7998 5.33301 7.99371 5.33301 9.46647C5.33301 10.9392 6.52692 12.1331 7.99967 12.1331Z" stroke="#8F9296" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M6.95996 9.53322L7.39329 9.96655C7.51996 10.0932 7.72663 10.0932 7.85329 9.97322L9.03996 8.87988" stroke="#8F9296" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M5.33289 14.6667H10.6662C13.3462 14.6667 13.8262 13.5933 13.9662 12.2867L14.4662 6.95333C14.6462 5.32667 14.1796 4 11.3329 4H4.66623C1.81956 4 1.35289 5.32667 1.53289 6.95333L2.03289 12.2867C2.17289 13.5933 2.65289 14.6667 5.33289 14.6667Z" stroke="#8F9296" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M5.33301 3.99967V3.46634C5.33301 2.28634 5.33301 1.33301 7.46634 1.33301H8.53301C10.6663 1.33301 10.6663 2.28634 10.6663 3.46634V3.99967" stroke="#8F9296" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14.4329 7.33301C13.2795 8.17301 11.9995 8.75967 10.6729 9.09301" stroke="#8F9296" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M1.74707 7.51367C2.8604 8.27367 4.07374 8.81367 5.33374 9.12034" stroke="#8F9296" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <p>Job Completed: 13</p>
                                </li>
                            </ul>
                            <hr>
                            <a href="{{ url('provider-signup') }}" class="psd-sl-sdetaili-d-service-info__cta">
                                <img src="{{ asset('images/cta-join.png') }}" alt="cta-image">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Modals --}}
        <div class="booking-modal">
            <div class="booking-con-main">
                <p class="booking-con-main__pre-title">Pluming</p>
                <h2>Reliable Plumbing Solutions for Every Home and Business</h2>
                <form action="" id="bookingForm">
                    <div class="sbf-field-group-con">
                        <div class="sbf-field-group">
                            <label for="fname">First Name <span>*</span></label>
                            <input type="text" name="fname" required placeholder="Enter your first name...">
                        </div>
                        <div class="sbf-field-group">
                            <label for="lname">Last Name <span>*</span></label>
                            <input type="text" name="lname" required placeholder="Enter your last name...">
                        </div>
                    </div>
                    <div class="sbf-field-group">
                        <label for="address">Complete Address <span>*</span></label>
                        <input type="text" name="address" required placeholder="Enter your address...">
                    </div>
                    <div class="sbf-field-group-con">
                        <div class="sbf-field-group">
                            <label for="email">Email <span>*</span></label>
                            <input type="text" name="email" required placeholder="Enter your first name...">
                        </div>
                        <div class="sbf-field-group">
                            <label for="number">Contact Number <span>*</span></label>
                            <input type="text" name="number" required placeholder="Enter your last name...">
                        </div>
                    </div>
                    <div class="sbf-field-group-con mb-2">
                        <div class="sbf-field-group">
                            <label for="number">Preferred Date <span>*</span></label>
                            <input type="date" required name="date" id="date">
                        </div>
                        <div class="sbf-field-group">
                            <label for="number">Preferred Time <span>*</span></label>
                            <input type="time" required name="time" id="time">
                        </div>
                    </div>
                    @guest
                        <a href="{{url('login')}}" class="glb-btn-a">Send Book Request</a>
                    @endguest
                    @auth
                        @if(auth()->user()->isCustomer())
                            <button class="glb-btn" id="open-confirm" type="button">Send Book Request</button>
                        @endif
                    @endauth
                </form>
            </div>
        </div>
        <div class="confirm-modal">
            <div class="confirm-modal__content">
                <svg width="58" height="58" viewBox="0 0 58 58" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M29.0003 21.7494V33.8328M29.0003 51.7403H14.3553C5.96945 51.7403 2.46529 45.7469 6.52529 38.4244L14.0653 24.8428L21.1703 12.0828C25.472 4.32527 32.5286 4.32527 36.8303 12.0828L43.9353 24.8669L51.4753 38.4486C55.5353 45.7711 52.007 51.7644 43.6453 51.7644H29.0003V51.7403Z" stroke="#FFBE42" stroke-width="2.65263" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M28.9873 41.084H29.0102" stroke="#FFBE42" stroke-width="2.65263" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <h3>Confirm Booking</h3>
                <p>
                    Once confirmed, cancellation is strictly prohibited
                    and may result in penalties.
                </p>

                <div class="confirm-actions">
                    <button id="confirm-booking" type="button" class="glb-btn">
                        Confirm
                    </button>
                    <button id="cancel-confirm" type="button" class="glb-btn btn--ses">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </main>

@endsection
@push('extrascripts')
<script>
$(document).ready(function () {

    /* ------------------------
       OPEN BOOKING MODAL
    ------------------------- */
    $('#open-book').on('click', function () {
        $('.booking-modal').fadeIn(200);
    });

    /* ------------------------
       OPEN CONFIRM MODAL
    ------------------------- */
    $('#open-confirm').on('click', function () {

        // optional: simple form validation
        if (!$('#bookingForm')[0].checkValidity()) {
            $('#bookingForm')[0].reportValidity();
            return;
        }

        $('.booking-modal').hide();
        $('.confirm-modal').fadeIn(200);
    });

    /* ------------------------
       CONFIRM BOOKING
    ------------------------- */
    $('#confirm-booking').on('click', function () {

        // submit form via normal POST
        $('#bookingForm').submit();

        // OR AJAX submit (optional)
        // $.post('/booking', $('#bookingForm').serialize());

    });

    /* ------------------------
       CANCEL CONFIRMATION
    ------------------------- */
    $('#cancel-confirm').on('click', function () {
        $('.confirm-modal').hide();
        $('.booking-modal').fadeIn(200);
    });

    /* ------------------------
       CLICK OUTSIDE CLOSE
    ------------------------- */
    $('.booking-modal, .confirm-modal').on('click', function (e) {
        if ($(e.target).is(this)) {
            $(this).fadeOut(200);
        }
    });

});




</script>
@endpush