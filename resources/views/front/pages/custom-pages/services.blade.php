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
                                15 Providerss
                            </p>
                        </div>

                    </div>
                </div>
                <hr>
                <a href="{{ url('sign-in') }}" class="join-now-cta"><img src="{{ asset('images/cta-join.png') }}" alt=""></a>
            </div>
            <div class="ps-sl-cards">

            </div>
        </section>
    </main>
@endsection
@push('extrascripts')
    <script>

    </script>
@endpush