@extends('front.layouts.base')

@section('content')
    <main class="main-page page--services-detail">
        <section class="section--list m-padding">
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
                    <div class="psdslcr-box">
                        <div class="psdslcr-box__head">

                        </div>
                        <div class="psdslcr-box__text">

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
@push('extrascripts')

@endpush