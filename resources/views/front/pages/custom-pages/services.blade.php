@extends('front.layouts.base')

@section('content')
    <main class="main-page page--services">
        <section class="section--list m-padding">
            <div class="ps-sl-category">
                <div class="ps-sl-category__head">
                    <a href="{{ url('/') }}" class="{{ Request::is('/') ? 's-act-link' : '' }}">Home</a>

                    <svg width="4" height="7" viewBox="0 0 4 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.384033 0.320312L2.88403 3.32031L0.384033 6.32031" stroke="#FDB932"/>
                    </svg>

                    <a href="{{ url('services') }}" class="{{ Request::is('services') ? 's-act-link' : '' }}">Services</a>
                </div>
                <div class="ps-sl-category__count">
                    <h4>17 Services Available</h4>
                </div>
                <div class="ps-sl-category__search">
                    <input type="text" placeholder="What are you looking for?">
                    <svg width="16" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.3739 11.5129L16.9467 14.8861L15.7669 16L12.1941 12.6268C10.9094 13.5971 9.28022 14.1776 7.50827 14.1776C3.3637 14.1776 0 11.0018 0 7.08881C0 3.17579 3.3637 0 7.50827 0C11.6528 0 15.0165 3.17579 15.0165 7.08881C15.0165 8.76177 14.4017 10.3 13.3739 11.5129ZM11.7001 10.9284C12.7203 9.93584 13.348 8.58187 13.348 7.08881C13.348 4.04259 10.7347 1.57529 7.50827 1.57529C4.2818 1.57529 1.6685 4.04259 1.6685 7.08881C1.6685 10.135 4.2818 12.6023 7.50827 12.6023C9.08968 12.6023 10.5238 12.0096 11.5751 11.0465L11.7001 10.9284Z" fill="#979797" fill-opacity="0.6"/>
                    </svg>
                </div>
                <div class="ps-sl-category__cat">
                    <h4>Categories</h4>
                    <div class="ps-sl-cc-main">


                        <div class="ps-sl-cc-main__box">
                            <div>
                                <input type="checkbox">
                                <p class="ps-category-title">Plumber</p>
                            </div>
                            <p class="ps-category-count">
                                <span></span>    
                                16 Providers
                            </p>
                        </div>
                        <div class="ps-sl-cc-main__box">
                            <div>
                                <input type="checkbox">
                                <p class="ps-category-title">Electrician</p>
                            </div>
                            <p class="ps-category-count">
                                <span></span>    
                                12 Providers
                            </p>
                        </div>
                        <div class="ps-sl-cc-main__box">
                            <div>
                                <input type="checkbox">
                                <p class="ps-category-title">Painter</p>
                            </div>
                            <p class="ps-category-count">
                                <span></span>    
                                4 Providers
                            </p>
                        </div>
                        <div class="ps-sl-cc-main__box">
                            <div>
                                <input type="checkbox">
                                <p class="ps-category-title">Gardener</p>
                            </div>
                            <p class="ps-category-count">
                                <span></span>    
                                8 Providers
                            </p>
                        </div>
                        <div class="ps-sl-cc-main__box">
                            <div>
                                <input type="checkbox">
                                <p class="ps-category-title">Technician</p>
                            </div>
                            <p class="ps-category-count">
                                <span></span>    
                                15 Providers
                            </p>
                        </div>

                    </div>
                </div>
                <hr>
                <a href="{{ url('sign-in') }}" class="join-now-cta"><img src="{{ asset('images/cta-join.png') }}" alt=""></a>
            </div>
            <div class="ps-sl-cards">

                <div class="ps-sl-cards__head">
                    <button class="ps-serv-btn-cat-m">
                        <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 4H11.5V5H14V8H10.5V9H12V10.071C11.5287 10.1927 11.1179 10.4821 10.8447 10.885C10.5715 11.2879 10.4546 11.7766 10.5159 12.2595C10.5773 12.7424 10.8126 13.1864 11.1779 13.5082C11.5431 13.83 12.0132 14.0075 12.5 14.0075C12.9868 14.0075 13.4569 13.83 13.8221 13.5082C14.1874 13.1864 14.4227 12.7424 14.4841 12.2595C14.5454 11.7766 14.4285 11.2879 14.1553 10.885C13.8821 10.4821 13.4713 10.1927 13 10.071V9H14C14.2651 8.9996 14.5192 8.89412 14.7067 8.70667C14.8941 8.51922 14.9996 8.26509 15 8V5C15 4.73478 14.8946 4.48043 14.7071 4.29289C14.5196 4.10536 14.2652 4 14 4ZM13.5 12C13.5 12.1978 13.4414 12.3911 13.3315 12.5556C13.2216 12.72 13.0654 12.8482 12.8827 12.9239C12.7 12.9996 12.4989 13.0194 12.3049 12.9808C12.1109 12.9422 11.9327 12.847 11.7929 12.7071C11.653 12.5673 11.5578 12.3891 11.5192 12.1951C11.4806 12.0011 11.5004 11.8 11.5761 11.6173C11.6518 11.4346 11.78 11.2784 11.9444 11.1685C12.1089 11.0586 12.3022 11 12.5 11C12.7651 11.0004 13.0192 11.1059 13.2067 11.2933C13.3941 11.4808 13.4996 11.7349 13.5 12ZM9 2H6.5V3H9V6H5.5V7H7V10.071C6.52867 10.1927 6.11791 10.4821 5.8447 10.885C5.57149 11.2879 5.4546 11.7766 5.51594 12.2595C5.57728 12.7424 5.81263 13.1864 6.17788 13.5082C6.54314 13.83 7.01321 14.0075 7.5 14.0075C7.98679 14.0075 8.45686 13.83 8.82212 13.5082C9.18737 13.1864 9.42272 12.7424 9.48406 12.2595C9.5454 11.7766 9.42851 11.2879 9.1553 10.885C8.8821 10.4821 8.47133 10.1927 8 10.071V7H9C9.26522 7 9.51957 6.89464 9.70711 6.70711C9.89464 6.51957 10 6.26522 10 6V3C10 2.73478 9.89464 2.48043 9.70711 2.29289C9.51957 2.10536 9.26522 2 9 2ZM8.5 12C8.5 12.1978 8.44135 12.3911 8.33147 12.5556C8.22159 12.72 8.06541 12.8482 7.88268 12.9239C7.69996 12.9996 7.49889 13.0194 7.30491 12.9808C7.11093 12.9422 6.93275 12.847 6.79289 12.7071C6.65304 12.5673 6.5578 12.3891 6.51921 12.1951C6.48063 12.0011 6.50043 11.8 6.57612 11.6173C6.65181 11.4346 6.77998 11.2784 6.94443 11.1685C7.10888 11.0586 7.30222 11 7.5 11C7.76509 11.0004 8.01922 11.1059 8.20667 11.2933C8.39412 11.4808 8.4996 11.7349 8.5 12ZM4 0H1C0.734784 0 0.48043 0.105357 0.292893 0.292893C0.105357 0.48043 0 0.734784 0 1V4C0 4.26522 0.105357 4.51957 0.292893 4.70711C0.48043 4.89464 0.734784 5 1 5H2V10.071C1.52867 10.1927 1.11791 10.4821 0.844699 10.885C0.571493 11.2879 0.454603 11.7766 0.515941 12.2595C0.577278 12.7424 0.812631 13.1864 1.17788 13.5082C1.54314 13.83 2.01321 14.0075 2.5 14.0075C2.98679 14.0075 3.45686 13.83 3.82212 13.5082C4.18737 13.1864 4.42272 12.7424 4.48406 12.2595C4.5454 11.7766 4.42851 11.2879 4.1553 10.885C3.88209 10.4821 3.47133 10.1927 3 10.071V5H4C4.26522 5 4.51957 4.89464 4.70711 4.70711C4.89464 4.51957 5 4.26522 5 4V1C5 0.734784 4.89464 0.48043 4.70711 0.292893C4.51957 0.105357 4.26522 0 4 0ZM3.5 12C3.5 12.1978 3.44135 12.3911 3.33147 12.5556C3.22159 12.72 3.06541 12.8482 2.88268 12.9239C2.69996 12.9996 2.49889 13.0194 2.30491 12.9808C2.11093 12.9422 1.93275 12.847 1.79289 12.7071C1.65304 12.5673 1.5578 12.3891 1.51921 12.1951C1.48063 12.0011 1.50043 11.8 1.57612 11.6173C1.65181 11.4346 1.77998 11.2784 1.94443 11.1685C2.10888 11.0586 2.30222 11 2.5 11C2.76522 11 3.01957 11.1054 3.20711 11.2929C3.39464 11.4804 3.5 11.7348 3.5 12ZM1 4V1H4L4.001 4H1Z" fill="#FDB932"/>
                        </svg>
                        Category
                    </button>
                    <button class="ps-serv-btn-sort-m">
                        <svg width="13" height="10" viewBox="0 0 13 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.833008 0.833008H11.4997M2.83301 4.83301H9.49967M5.49967 8.83301H6.83301" stroke="#FDB932" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Sort
                    </button>
                </div>
                <div class="ps-sl-cards__list">
                    <div class="ps-sl-c-box">
                        <div class="ps-sl-c-box__head">
                            <img src="{{asset('images/serv-bg.png')}}" alt="">
                            <span class="ps-sl-c-box__head--cat">Plumber</span>
                        </div>
                        <div class="ps-sl-c-box__body">
                            <h3>Residential Pipe Repair Services</h3>
                            <p class="ps-sl-c-box__body--label">Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis excepturi quia consectetur amet fugit quaerat sint, quos id accusamus voluptatum quae laborum doloribus voluptate optio neque ullam culpa fugiat possimus.</p>
                            <div class="ps-sl-c-box__body--info">
                                <div>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.99984 7.99967C9.84079 7.99967 11.3332 6.50729 11.3332 4.66634C11.3332 2.82539 9.84079 1.33301 7.99984 1.33301C6.15889 1.33301 4.6665 2.82539 4.6665 4.66634C4.6665 6.50729 6.15889 7.99967 7.99984 7.99967Z" stroke="#FFBE42" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M13.7268 14.6667C13.7268 12.0867 11.1601 10 8.0001 10C4.8401 10 2.27344 12.0867 2.27344 14.6667" stroke="#FFBE42" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Provider: Daniella Barcelon
                                </div>
                                <div>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.3335 5.99967V4.66634C1.3335 2.66634 2.66683 1.33301 4.66683 1.33301H11.3335C13.3335 1.33301 14.6668 2.66634 14.6668 4.66634V5.99967" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M1.3335 10V11.3333C1.3335 13.3333 2.66683 14.6667 4.66683 14.6667H11.3335C13.3335 14.6667 14.6668 13.3333 14.6668 11.3333V10" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M4.4668 6.17383L8.00013 8.2205L11.5068 6.18717" stroke="#FFBE42" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M8 11.8472V8.21387" stroke="#FFBE42" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M7.17348 4.19305L5.04015 5.37973C4.56015 5.6464 4.16016 6.31973 4.16016 6.87306V9.13307C4.16016 9.6864 4.55348 10.3597 5.04015 10.6264L7.17348 11.813C7.62682 12.0664 8.37349 12.0664 8.83349 11.813L10.9668 10.6264C11.4468 10.3597 11.8468 9.6864 11.8468 9.13307V6.87306C11.8468 6.31973 11.4535 5.6464 10.9668 5.37973L8.83349 4.19305C8.37349 3.93305 7.62682 3.93305 7.17348 4.19305Z" stroke="#FFBE42" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Specialization: Pipe Repair
                                </div>
                                <div>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8.00016 12.1331C9.47292 12.1331 10.6668 10.9392 10.6668 9.46647C10.6668 7.99371 9.47292 6.7998 8.00016 6.7998C6.5274 6.7998 5.3335 7.99371 5.3335 9.46647C5.3335 10.9392 6.5274 12.1331 8.00016 12.1331Z" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M6.95996 9.53322L7.39329 9.96655C7.51996 10.0932 7.72663 10.0932 7.85329 9.97322L9.03996 8.87988" stroke="#FFBE42" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M5.33338 14.6667H10.6667C13.3467 14.6667 13.8267 13.5933 13.9667 12.2867L14.4667 6.95333C14.6467 5.32667 14.18 4 11.3334 4H4.66671C1.82005 4 1.35338 5.32667 1.53338 6.95333L2.03338 12.2867C2.17338 13.5933 2.65338 14.6667 5.33338 14.6667Z" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M5.3335 3.99967V3.46634C5.3335 2.28634 5.3335 1.33301 7.46683 1.33301H8.5335C10.6668 1.33301 10.6668 2.28634 10.6668 3.46634V3.99967" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14.4333 7.33301C13.28 8.17301 12 8.75967 10.6733 9.09301" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M1.74658 7.51367C2.85992 8.27367 4.07325 8.81367 5.33325 9.12034" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Job Completed: 13
                                </div>
                            </div>
                            <div class="ps-sl-c-box__body--cta">
                                <a href="#">Learn more</a>
                                
                                <p>
                                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.38803 1.09688L6.12137 2.56354C6.22136 2.76771 6.48803 2.96354 6.71303 3.00104L8.0422 3.22187C8.8922 3.36354 9.0922 3.98021 8.4797 4.58854L7.44636 5.62187C7.27136 5.79687 7.17553 6.13437 7.2297 6.37604L7.52553 7.65521C7.75886 8.66771 7.22136 9.05937 6.32553 8.53021L5.0797 7.79271C4.8547 7.65938 4.48387 7.65938 4.2547 7.79271L3.00887 8.53021C2.1172 9.05937 1.57553 8.66354 1.80887 7.65521L2.1047 6.37604C2.15887 6.13437 2.06303 5.79687 1.88803 5.62187L0.854698 4.58854C0.246365 3.98021 0.442199 3.36354 1.2922 3.22187L2.62137 3.00104C2.8422 2.96354 3.10887 2.76771 3.20886 2.56354L3.9422 1.09688C4.3422 0.301042 4.9922 0.301042 5.38803 1.09688Z" fill="#FFBE42" stroke="#FFBE42" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    4.9 <span>(128 reviews)</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="ps-sl-c-box">
                        <div class="ps-sl-c-box__head">
                            <img src="{{asset('images/serv-bg.png')}}" alt="">
                            <span class="ps-sl-c-box__head--cat">Plumber</span>
                        </div>
                        <div class="ps-sl-c-box__body">
                            <h3>Residential Pipe Repair Services</h3>
                            <p class="ps-sl-c-box__body--label">Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis excepturi quia consectetur amet fugit quaerat sint, quos id accusamus voluptatum quae laborum doloribus voluptate optio neque ullam culpa fugiat possimus.</p>
                            <div class="ps-sl-c-box__body--info">
                                <div>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.99984 7.99967C9.84079 7.99967 11.3332 6.50729 11.3332 4.66634C11.3332 2.82539 9.84079 1.33301 7.99984 1.33301C6.15889 1.33301 4.6665 2.82539 4.6665 4.66634C4.6665 6.50729 6.15889 7.99967 7.99984 7.99967Z" stroke="#FFBE42" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M13.7268 14.6667C13.7268 12.0867 11.1601 10 8.0001 10C4.8401 10 2.27344 12.0867 2.27344 14.6667" stroke="#FFBE42" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Provider: Daniella Barcelon
                                </div>
                                <div>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.3335 5.99967V4.66634C1.3335 2.66634 2.66683 1.33301 4.66683 1.33301H11.3335C13.3335 1.33301 14.6668 2.66634 14.6668 4.66634V5.99967" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M1.3335 10V11.3333C1.3335 13.3333 2.66683 14.6667 4.66683 14.6667H11.3335C13.3335 14.6667 14.6668 13.3333 14.6668 11.3333V10" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M4.4668 6.17383L8.00013 8.2205L11.5068 6.18717" stroke="#FFBE42" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M8 11.8472V8.21387" stroke="#FFBE42" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M7.17348 4.19305L5.04015 5.37973C4.56015 5.6464 4.16016 6.31973 4.16016 6.87306V9.13307C4.16016 9.6864 4.55348 10.3597 5.04015 10.6264L7.17348 11.813C7.62682 12.0664 8.37349 12.0664 8.83349 11.813L10.9668 10.6264C11.4468 10.3597 11.8468 9.6864 11.8468 9.13307V6.87306C11.8468 6.31973 11.4535 5.6464 10.9668 5.37973L8.83349 4.19305C8.37349 3.93305 7.62682 3.93305 7.17348 4.19305Z" stroke="#FFBE42" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Specialization: Pipe Repair
                                </div>
                                <div>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8.00016 12.1331C9.47292 12.1331 10.6668 10.9392 10.6668 9.46647C10.6668 7.99371 9.47292 6.7998 8.00016 6.7998C6.5274 6.7998 5.3335 7.99371 5.3335 9.46647C5.3335 10.9392 6.5274 12.1331 8.00016 12.1331Z" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M6.95996 9.53322L7.39329 9.96655C7.51996 10.0932 7.72663 10.0932 7.85329 9.97322L9.03996 8.87988" stroke="#FFBE42" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M5.33338 14.6667H10.6667C13.3467 14.6667 13.8267 13.5933 13.9667 12.2867L14.4667 6.95333C14.6467 5.32667 14.18 4 11.3334 4H4.66671C1.82005 4 1.35338 5.32667 1.53338 6.95333L2.03338 12.2867C2.17338 13.5933 2.65338 14.6667 5.33338 14.6667Z" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M5.3335 3.99967V3.46634C5.3335 2.28634 5.3335 1.33301 7.46683 1.33301H8.5335C10.6668 1.33301 10.6668 2.28634 10.6668 3.46634V3.99967" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14.4333 7.33301C13.28 8.17301 12 8.75967 10.6733 9.09301" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M1.74658 7.51367C2.85992 8.27367 4.07325 8.81367 5.33325 9.12034" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Job Completed: 13
                                </div>
                            </div>
                            <div class="ps-sl-c-box__body--cta">
                                <a href="#">Learn more</a>
                                
                                <p>
                                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.38803 1.09688L6.12137 2.56354C6.22136 2.76771 6.48803 2.96354 6.71303 3.00104L8.0422 3.22187C8.8922 3.36354 9.0922 3.98021 8.4797 4.58854L7.44636 5.62187C7.27136 5.79687 7.17553 6.13437 7.2297 6.37604L7.52553 7.65521C7.75886 8.66771 7.22136 9.05937 6.32553 8.53021L5.0797 7.79271C4.8547 7.65938 4.48387 7.65938 4.2547 7.79271L3.00887 8.53021C2.1172 9.05937 1.57553 8.66354 1.80887 7.65521L2.1047 6.37604C2.15887 6.13437 2.06303 5.79687 1.88803 5.62187L0.854698 4.58854C0.246365 3.98021 0.442199 3.36354 1.2922 3.22187L2.62137 3.00104C2.8422 2.96354 3.10887 2.76771 3.20886 2.56354L3.9422 1.09688C4.3422 0.301042 4.9922 0.301042 5.38803 1.09688Z" fill="#FFBE42" stroke="#FFBE42" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    4.9 <span>(128 reviews)</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="ps-sl-c-box">
                        <div class="ps-sl-c-box__head">
                            <img src="{{asset('images/serv-bg.png')}}" alt="">
                            <span class="ps-sl-c-box__head--cat">Plumber</span>
                        </div>
                        <div class="ps-sl-c-box__body">
                            <h3>Residential Pipe Repair Services</h3>
                            <p class="ps-sl-c-box__body--label">Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis excepturi quia consectetur amet fugit quaerat sint, quos id accusamus voluptatum quae laborum doloribus voluptate optio neque ullam culpa fugiat possimus.</p>
                            <div class="ps-sl-c-box__body--info">
                                <div>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.99984 7.99967C9.84079 7.99967 11.3332 6.50729 11.3332 4.66634C11.3332 2.82539 9.84079 1.33301 7.99984 1.33301C6.15889 1.33301 4.6665 2.82539 4.6665 4.66634C4.6665 6.50729 6.15889 7.99967 7.99984 7.99967Z" stroke="#FFBE42" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M13.7268 14.6667C13.7268 12.0867 11.1601 10 8.0001 10C4.8401 10 2.27344 12.0867 2.27344 14.6667" stroke="#FFBE42" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Provider: Daniella Barcelon
                                </div>
                                <div>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.3335 5.99967V4.66634C1.3335 2.66634 2.66683 1.33301 4.66683 1.33301H11.3335C13.3335 1.33301 14.6668 2.66634 14.6668 4.66634V5.99967" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M1.3335 10V11.3333C1.3335 13.3333 2.66683 14.6667 4.66683 14.6667H11.3335C13.3335 14.6667 14.6668 13.3333 14.6668 11.3333V10" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M4.4668 6.17383L8.00013 8.2205L11.5068 6.18717" stroke="#FFBE42" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M8 11.8472V8.21387" stroke="#FFBE42" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M7.17348 4.19305L5.04015 5.37973C4.56015 5.6464 4.16016 6.31973 4.16016 6.87306V9.13307C4.16016 9.6864 4.55348 10.3597 5.04015 10.6264L7.17348 11.813C7.62682 12.0664 8.37349 12.0664 8.83349 11.813L10.9668 10.6264C11.4468 10.3597 11.8468 9.6864 11.8468 9.13307V6.87306C11.8468 6.31973 11.4535 5.6464 10.9668 5.37973L8.83349 4.19305C8.37349 3.93305 7.62682 3.93305 7.17348 4.19305Z" stroke="#FFBE42" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Specialization: Pipe Repair
                                </div>
                                <div>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8.00016 12.1331C9.47292 12.1331 10.6668 10.9392 10.6668 9.46647C10.6668 7.99371 9.47292 6.7998 8.00016 6.7998C6.5274 6.7998 5.3335 7.99371 5.3335 9.46647C5.3335 10.9392 6.5274 12.1331 8.00016 12.1331Z" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M6.95996 9.53322L7.39329 9.96655C7.51996 10.0932 7.72663 10.0932 7.85329 9.97322L9.03996 8.87988" stroke="#FFBE42" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M5.33338 14.6667H10.6667C13.3467 14.6667 13.8267 13.5933 13.9667 12.2867L14.4667 6.95333C14.6467 5.32667 14.18 4 11.3334 4H4.66671C1.82005 4 1.35338 5.32667 1.53338 6.95333L2.03338 12.2867C2.17338 13.5933 2.65338 14.6667 5.33338 14.6667Z" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M5.3335 3.99967V3.46634C5.3335 2.28634 5.3335 1.33301 7.46683 1.33301H8.5335C10.6668 1.33301 10.6668 2.28634 10.6668 3.46634V3.99967" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14.4333 7.33301C13.28 8.17301 12 8.75967 10.6733 9.09301" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M1.74658 7.51367C2.85992 8.27367 4.07325 8.81367 5.33325 9.12034" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Job Completed: 13
                                </div>
                            </div>
                            <div class="ps-sl-c-box__body--cta">
                                <a href="#">Learn more</a>
                                
                                <p>
                                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.38803 1.09688L6.12137 2.56354C6.22136 2.76771 6.48803 2.96354 6.71303 3.00104L8.0422 3.22187C8.8922 3.36354 9.0922 3.98021 8.4797 4.58854L7.44636 5.62187C7.27136 5.79687 7.17553 6.13437 7.2297 6.37604L7.52553 7.65521C7.75886 8.66771 7.22136 9.05937 6.32553 8.53021L5.0797 7.79271C4.8547 7.65938 4.48387 7.65938 4.2547 7.79271L3.00887 8.53021C2.1172 9.05937 1.57553 8.66354 1.80887 7.65521L2.1047 6.37604C2.15887 6.13437 2.06303 5.79687 1.88803 5.62187L0.854698 4.58854C0.246365 3.98021 0.442199 3.36354 1.2922 3.22187L2.62137 3.00104C2.8422 2.96354 3.10887 2.76771 3.20886 2.56354L3.9422 1.09688C4.3422 0.301042 4.9922 0.301042 5.38803 1.09688Z" fill="#FFBE42" stroke="#FFBE42" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    4.9 <span>(128 reviews)</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="ps-sl-c-box">
                        <div class="ps-sl-c-box__head">
                            <img src="{{asset('images/serv-bg.png')}}" alt="">
                            <span class="ps-sl-c-box__head--cat">Plumber</span>
                        </div>
                        <div class="ps-sl-c-box__body">
                            <h3>Residential Pipe Repair Services</h3>
                            <p class="ps-sl-c-box__body--label">Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis excepturi quia consectetur amet fugit quaerat sint, quos id accusamus voluptatum quae laborum doloribus voluptate optio neque ullam culpa fugiat possimus.</p>
                            <div class="ps-sl-c-box__body--info">
                                <div>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.99984 7.99967C9.84079 7.99967 11.3332 6.50729 11.3332 4.66634C11.3332 2.82539 9.84079 1.33301 7.99984 1.33301C6.15889 1.33301 4.6665 2.82539 4.6665 4.66634C4.6665 6.50729 6.15889 7.99967 7.99984 7.99967Z" stroke="#FFBE42" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M13.7268 14.6667C13.7268 12.0867 11.1601 10 8.0001 10C4.8401 10 2.27344 12.0867 2.27344 14.6667" stroke="#FFBE42" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Provider: Daniella Barcelon
                                </div>
                                <div>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.3335 5.99967V4.66634C1.3335 2.66634 2.66683 1.33301 4.66683 1.33301H11.3335C13.3335 1.33301 14.6668 2.66634 14.6668 4.66634V5.99967" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M1.3335 10V11.3333C1.3335 13.3333 2.66683 14.6667 4.66683 14.6667H11.3335C13.3335 14.6667 14.6668 13.3333 14.6668 11.3333V10" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M4.4668 6.17383L8.00013 8.2205L11.5068 6.18717" stroke="#FFBE42" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M8 11.8472V8.21387" stroke="#FFBE42" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M7.17348 4.19305L5.04015 5.37973C4.56015 5.6464 4.16016 6.31973 4.16016 6.87306V9.13307C4.16016 9.6864 4.55348 10.3597 5.04015 10.6264L7.17348 11.813C7.62682 12.0664 8.37349 12.0664 8.83349 11.813L10.9668 10.6264C11.4468 10.3597 11.8468 9.6864 11.8468 9.13307V6.87306C11.8468 6.31973 11.4535 5.6464 10.9668 5.37973L8.83349 4.19305C8.37349 3.93305 7.62682 3.93305 7.17348 4.19305Z" stroke="#FFBE42" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Specialization: Pipe Repair
                                </div>
                                <div>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8.00016 12.1331C9.47292 12.1331 10.6668 10.9392 10.6668 9.46647C10.6668 7.99371 9.47292 6.7998 8.00016 6.7998C6.5274 6.7998 5.3335 7.99371 5.3335 9.46647C5.3335 10.9392 6.5274 12.1331 8.00016 12.1331Z" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M6.95996 9.53322L7.39329 9.96655C7.51996 10.0932 7.72663 10.0932 7.85329 9.97322L9.03996 8.87988" stroke="#FFBE42" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M5.33338 14.6667H10.6667C13.3467 14.6667 13.8267 13.5933 13.9667 12.2867L14.4667 6.95333C14.6467 5.32667 14.18 4 11.3334 4H4.66671C1.82005 4 1.35338 5.32667 1.53338 6.95333L2.03338 12.2867C2.17338 13.5933 2.65338 14.6667 5.33338 14.6667Z" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M5.3335 3.99967V3.46634C5.3335 2.28634 5.3335 1.33301 7.46683 1.33301H8.5335C10.6668 1.33301 10.6668 2.28634 10.6668 3.46634V3.99967" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14.4333 7.33301C13.28 8.17301 12 8.75967 10.6733 9.09301" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M1.74658 7.51367C2.85992 8.27367 4.07325 8.81367 5.33325 9.12034" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Job Completed: 13
                                </div>
                            </div>
                            <div class="ps-sl-c-box__body--cta">
                                <a href="#">Learn more</a>
                                
                                <p>
                                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.38803 1.09688L6.12137 2.56354C6.22136 2.76771 6.48803 2.96354 6.71303 3.00104L8.0422 3.22187C8.8922 3.36354 9.0922 3.98021 8.4797 4.58854L7.44636 5.62187C7.27136 5.79687 7.17553 6.13437 7.2297 6.37604L7.52553 7.65521C7.75886 8.66771 7.22136 9.05937 6.32553 8.53021L5.0797 7.79271C4.8547 7.65938 4.48387 7.65938 4.2547 7.79271L3.00887 8.53021C2.1172 9.05937 1.57553 8.66354 1.80887 7.65521L2.1047 6.37604C2.15887 6.13437 2.06303 5.79687 1.88803 5.62187L0.854698 4.58854C0.246365 3.98021 0.442199 3.36354 1.2922 3.22187L2.62137 3.00104C2.8422 2.96354 3.10887 2.76771 3.20886 2.56354L3.9422 1.09688C4.3422 0.301042 4.9922 0.301042 5.38803 1.09688Z" fill="#FFBE42" stroke="#FFBE42" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    4.9 <span>(128 reviews)</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="ps-sl-c-box">
                        <div class="ps-sl-c-box__head">
                            <img src="{{asset('images/serv-bg.png')}}" alt="">
                            <span class="ps-sl-c-box__head--cat">Plumber</span>
                        </div>
                        <div class="ps-sl-c-box__body">
                            <h3>Residential Pipe Repair Services</h3>
                            <p class="ps-sl-c-box__body--label">Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis excepturi quia consectetur amet fugit quaerat sint, quos id accusamus voluptatum quae laborum doloribus voluptate optio neque ullam culpa fugiat possimus.</p>
                            <div class="ps-sl-c-box__body--info">
                                <div>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.99984 7.99967C9.84079 7.99967 11.3332 6.50729 11.3332 4.66634C11.3332 2.82539 9.84079 1.33301 7.99984 1.33301C6.15889 1.33301 4.6665 2.82539 4.6665 4.66634C4.6665 6.50729 6.15889 7.99967 7.99984 7.99967Z" stroke="#FFBE42" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M13.7268 14.6667C13.7268 12.0867 11.1601 10 8.0001 10C4.8401 10 2.27344 12.0867 2.27344 14.6667" stroke="#FFBE42" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Provider: Daniella Barcelon
                                </div>
                                <div>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.3335 5.99967V4.66634C1.3335 2.66634 2.66683 1.33301 4.66683 1.33301H11.3335C13.3335 1.33301 14.6668 2.66634 14.6668 4.66634V5.99967" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M1.3335 10V11.3333C1.3335 13.3333 2.66683 14.6667 4.66683 14.6667H11.3335C13.3335 14.6667 14.6668 13.3333 14.6668 11.3333V10" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M4.4668 6.17383L8.00013 8.2205L11.5068 6.18717" stroke="#FFBE42" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M8 11.8472V8.21387" stroke="#FFBE42" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M7.17348 4.19305L5.04015 5.37973C4.56015 5.6464 4.16016 6.31973 4.16016 6.87306V9.13307C4.16016 9.6864 4.55348 10.3597 5.04015 10.6264L7.17348 11.813C7.62682 12.0664 8.37349 12.0664 8.83349 11.813L10.9668 10.6264C11.4468 10.3597 11.8468 9.6864 11.8468 9.13307V6.87306C11.8468 6.31973 11.4535 5.6464 10.9668 5.37973L8.83349 4.19305C8.37349 3.93305 7.62682 3.93305 7.17348 4.19305Z" stroke="#FFBE42" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Specialization: Pipe Repair
                                </div>
                                <div>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8.00016 12.1331C9.47292 12.1331 10.6668 10.9392 10.6668 9.46647C10.6668 7.99371 9.47292 6.7998 8.00016 6.7998C6.5274 6.7998 5.3335 7.99371 5.3335 9.46647C5.3335 10.9392 6.5274 12.1331 8.00016 12.1331Z" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M6.95996 9.53322L7.39329 9.96655C7.51996 10.0932 7.72663 10.0932 7.85329 9.97322L9.03996 8.87988" stroke="#FFBE42" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M5.33338 14.6667H10.6667C13.3467 14.6667 13.8267 13.5933 13.9667 12.2867L14.4667 6.95333C14.6467 5.32667 14.18 4 11.3334 4H4.66671C1.82005 4 1.35338 5.32667 1.53338 6.95333L2.03338 12.2867C2.17338 13.5933 2.65338 14.6667 5.33338 14.6667Z" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M5.3335 3.99967V3.46634C5.3335 2.28634 5.3335 1.33301 7.46683 1.33301H8.5335C10.6668 1.33301 10.6668 2.28634 10.6668 3.46634V3.99967" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14.4333 7.33301C13.28 8.17301 12 8.75967 10.6733 9.09301" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M1.74658 7.51367C2.85992 8.27367 4.07325 8.81367 5.33325 9.12034" stroke="#FFBE42" stroke-width="1.1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Job Completed: 13
                                </div>
                            </div>
                            <div class="ps-sl-c-box__body--cta">
                                <a href="#">Learn more</a>
                                
                                <p>
                                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.38803 1.09688L6.12137 2.56354C6.22136 2.76771 6.48803 2.96354 6.71303 3.00104L8.0422 3.22187C8.8922 3.36354 9.0922 3.98021 8.4797 4.58854L7.44636 5.62187C7.27136 5.79687 7.17553 6.13437 7.2297 6.37604L7.52553 7.65521C7.75886 8.66771 7.22136 9.05937 6.32553 8.53021L5.0797 7.79271C4.8547 7.65938 4.48387 7.65938 4.2547 7.79271L3.00887 8.53021C2.1172 9.05937 1.57553 8.66354 1.80887 7.65521L2.1047 6.37604C2.15887 6.13437 2.06303 5.79687 1.88803 5.62187L0.854698 4.58854C0.246365 3.98021 0.442199 3.36354 1.2922 3.22187L2.62137 3.00104C2.8422 2.96354 3.10887 2.76771 3.20886 2.56354L3.9422 1.09688C4.3422 0.301042 4.9922 0.301042 5.38803 1.09688Z" fill="#FFBE42" stroke="#FFBE42" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    4.9 <span>(128 reviews)</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </main>
@endsection
@push('extrascripts')
    <script>

    </script>
@endpush