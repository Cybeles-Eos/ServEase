@extends('admin.layouts.auth')

{{-- Meta Section --}}
@section('title', 'Servease Forgot Password - ')

@push('extrastylesheets')
    <style>
        .forgot-password-recaptcha {
            margin-top: 4px;
        }

        @media screen and (max-width: 576px) {
            .forgot-password-recaptcha .g-recaptcha {
                transform: scale(0.88);
                transform-origin: left top;
            }
        }
        .main-sidebar-uix{
            display: none;
        }
    </style>
@endpush
@section('content')
@include('front.layouts.sections.header')
    <main class="provider-login">
        <section class="provider-login-main" style="margin-bottom: 0rem">
            <div class="provider-login-main__form">
                <div class="provider-login-main__form--head">
                    <h3>Forgot Password</h3>
                    <p>Enter your email address and we will send you an OTP code.</p>
                </div>

                <form method="POST" action="{{ route('password.forgot.send') }}" class="provider-login-main__form--fields">
                    @csrf

                    <div class="plm-ff-group">
                        <label for="email">Email Address</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            placeholder="e. g. name@gmail.com"
                            value="{{ old('email') }}"
                            required
                            data-no-space
                            autocomplete="email"
                        >
                        @error('email') <small>{{ $message }}</small> @enderror
                    </div>
                    <div class="plm-ff-group forgot-password-recaptcha">
                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}" required></div>

                        @error('g-recaptcha-response')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>
                    <button class="plm-ff-btn btn btn--tertiary" type="submit">
                        Send OTP
                    </button>

                    <p class="plm-ff-cta">
                        Remember your password? <a href="{{ route('login') }}">Sign in</a>
                    </p>
                </form>
            </div>

            <div class="provider-login-main__image">
                <img src="{{ asset('images/provider-auth-img.webp') }}" alt="">
            </div>
        </section>
    </main>
@endsection
@push('extrascripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endpush