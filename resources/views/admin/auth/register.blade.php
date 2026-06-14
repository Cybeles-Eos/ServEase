@extends('admin.layouts.auth')

@section('content')
    @push('extrastylesheets')
        <style>
            .login--btn {
                margin-right: 15px;
            }

            .customer-register-page {
                background: #f4f6f9 !important;
                min-height: calc(100vh - 80px) !important;
                padding: 85px 20px 70px !important;
            }

            .customer-register-page .provider-login-main {
                width: 100% !important;
                max-width: 980px !important;
                margin: 0 auto !important;
                display: block !important;
                background: transparent !important;
                box-shadow: none !important;
            }

            .customer-register-page .provider-login-main__form {
                width: 100% !important;
                max-width: 100% !important;
                padding: 0 !important;
                background: transparent !important;
            }

            .customer-register-page .provider-login-main__form--head {
                margin-bottom: 18px !important;
            }

            .customer-register-page .provider-login-main__form--head h3 {
                font-size: 28px !important;
                line-height: 1.2 !important;
                font-weight: 700 !important;
                color: #202124 !important;
                margin-bottom: 10px !important;
            }

            .customer-register-page .register-tagline {
                max-width: 560px !important;
                font-size: 14px !important;
                line-height: 1.6 !important;
                color: #8b95a1 !important;
                margin: 0 !important;
            }

            .customer-register-page .provider-login-main__form--fields {
                width: 100% !important;
                display: flex !important;
                flex-direction: column !important;
                gap: 22px !important;
            }

            .customer-register-page .register-grid {
                display: grid !important;
                grid-template-columns: repeat(4, 1fr) !important;
                gap: 22px 14px !important;
                width: 100% !important;
            }

            .customer-register-page .register-grid--two {
                grid-template-columns: repeat(2, 1fr) !important;
            }

            .customer-register-page .plm-ff-group {
                width: 100% !important;
                margin: 0 !important;
                display: flex !important;
                flex-direction: column !important;
                gap: 8px !important;
            }

            .customer-register-page .plm-ff-group label {
                font-size: 12px !important;
                line-height: 1.2 !important;
                font-weight: 600 !important;
                color: #202124 !important;
                margin: 0 !important;
            }

            .customer-register-page .plm-ff-group label .required {
                color: #ff3b30 !important;
            }

            .customer-register-page .plm-ff-group input {
                width: 100% !important;
                height: 42px !important;
                border: 1px solid #d9dee7 !important;
                border-radius: 7px !important;
                background: #ffffff !important;
                padding: 0 14px !important;
                font-size: 13px !important;
                color: #202124 !important;
                box-shadow: none !important;
                outline: none !important;
            }

            .customer-register-page .plm-ff-group input::placeholder {
                color: #b3bac5 !important;
            }

            .customer-register-page .plm-ff-group input:focus {
                border-color: #ffb73e !important;
            }

            .customer-register-page .plm-ff-group-pass {
                width: 100% !important;
                position: relative !important;
            }

            .customer-register-page .plm-ff-group-pass input {
                padding-right: 42px !important;
            }

            .customer-register-page .plm-ff-group-pass .show {
                position: absolute !important;
                right: 14px !important;
                top: 50% !important;
                transform: translateY(-50%) !important;
                cursor: pointer !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
            }

            .customer-register-page .plm-ff-group small {
                display: block !important;
                width: 100% !important;
                position: static !important;
                transform: none !important;
                align-self: flex-start !important;
                color: #dc3545 !important;
                font-size: 12px !important;
                line-height: 1.3 !important;
                margin-top: 0px !important;
            }

            .customer-register-page .register-recaptcha {
                margin-top: 2px !important;
            }

            .customer-register-page .auth-form__privacy p {
                font-size: 12px !important;
                line-height: 1.5 !important;
                color: #8b95a1 !important;
                margin: 0 !important;
            }

            .customer-register-page .auth-form__privacy a {
                color: #6b7280 !important;
                text-decoration: underline !important;
            }

            .customer-register-page .plm-ff-btn {
                width: 100% !important;
                height: 46px !important;
                border-radius: 7px !important;
                background: #ffb73e !important;
                border: 1px solid #ffb73e !important;
                color: #ffffff !important;
                font-size: 13px !important;
                font-weight: 600 !important;
                margin-top: 4px !important;
            }

            .customer-register-page .plm-ff-cta {
                text-align: center !important;
                font-size: 13px !important;
                color: #40444c !important;
                margin: 0 !important;
            }

            .customer-register-page .plm-ff-cta a {
                color: #ffb73e !important;
                text-decoration: none !important;
            }

            .customer-register-page .provider-login-main__image {
                display: none !important;
            }

            @media screen and (max-width: 992px) {
                .reg-signin {
                    padding-top: 120px !important;
                }

                .customer-register-page .register-grid {
                    grid-template-columns: repeat(2, 1fr) !important;
                }
            }

            @media screen and (max-width: 576px) {
                .customer-register-page {
                    padding-left: 16px !important;
                    padding-right: 16px !important;
                }

                .customer-register-page .register-grid,
                .customer-register-page .register-grid--two {
                    grid-template-columns: 1fr !important;
                }

                .customer-register-page .provider-login-main__form--head h3 {
                    font-size: 24px !important;
                }

                .customer-register-page .g-recaptcha {
                    transform: scale(0.88) !important;
                    transform-origin: left top !important;
                }
            }
        </style>
    @endpush

    @include('front.layouts.sections.header')

    <main class="provider-login reg-signin customer-register-page" style="padding-top: 35px !important;padding-bottom: 15px !important;">
        <section class="provider-login-main" style="margin-bottom: 5px !important; height: fit-content !important;">
            <div class="provider-login-main__form">
                <div class="provider-login-main__form--head">
                    <h3>Start your journey</h3>
                    <p class="register-tagline">
                        Fill out the form below to create your account. Make sure your details are correct before submitting your registration.
                    </p>
                </div>

                <form method="POST" action="{{ route('signup.post') }}" class="provider-login-main__form--fields">
                    @csrf

                    <div class="register-grid">
                        <div class="plm-ff-group">
                            <label for="fname">First Name <span class="required">*</span></label>
                            <input
                                type="text"
                                id="fname"
                                name="fname"
                                placeholder="Enter your first name"
                                value="{{ old('fname') }}"
                                required
                                autocomplete="off"
                            >
                            @error('fname') <small>{{ $message }}</small> @enderror
                        </div>

                        <div class="plm-ff-group">
                            <label for="lname">Last Name <span class="required">*</span></label>
                            <input
                                type="text"
                                id="lname"
                                name="lname"
                                placeholder="Enter your last name"
                                value="{{ old('lname') }}"
                                required
                                autocomplete="off"
                            >
                            @error('lname') <small>{{ $message }}</small> @enderror
                        </div>

                        <div class="plm-ff-group">
                            <label for="email">Email Address <span class="required">*</span></label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                placeholder="e. g. name@gmail.com"
                                value="{{ old('email') }}"
                                required
                                maxlength="255"
                                autocomplete="email"
                                inputmode="email"
                            >
                            @error('email') <small>{{ $message }}</small> @enderror
                        </div>

                        <div class="plm-ff-group">
                            <label for="phone_number">Phone Number <span class="required">*</span></label>
                            <input
                                type="text"
                                id="phone_number"
                                name="phone_number"
                                placeholder="e. g. 09123456789"
                                value="{{ old('phone_number') }}"
                                required
                                maxlength="11"
                                inputmode="numeric"
                                autocomplete="tel"
                                pattern="09[0-9]{9}"
                                title="Phone number must start with 09 and must be exactly 11 digits"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11)"
                            >
                            @error('phone_number') <small>{{ $message }}</small> @enderror
                        </div>

                        <div class="plm-ff-group">
                            <label for="street_address">Street Address <span class="required">*</span></label>
                            <input
                                type="text"
                                id="street_address"
                                name="street_address"
                                placeholder="Enter your street address"
                                value="{{ old('street_address') }}"
                                required
                                autocomplete="off"
                            >
                            @error('street_address') <small>{{ $message }}</small> @enderror
                        </div>

                        <div class="plm-ff-group">
                            <label for="city">City <span class="required">*</span></label>
                            <input
                                type="text"
                                id="city"
                                name="city"
                                placeholder="Enter your city"
                                value="{{ old('city') }}"
                                required
                                autocomplete="off"
                            >
                            @error('city') <small>{{ $message }}</small> @enderror
                        </div>

                        <div class="plm-ff-group">
                            <label for="barangay">Barangay <span class="required">*</span></label>
                            <input
                                type="text"
                                id="barangay"
                                name="barangay"
                                placeholder="Enter your barangay"
                                value="{{ old('barangay') }}"
                                required
                                autocomplete="off"
                            >
                            @error('barangay') <small>{{ $message }}</small> @enderror
                        </div>

                        <div class="plm-ff-group">
                            <label for="zipcode">Zipcode <span class="required">*</span></label>
                            <input
                                type="text"
                                id="zipcode"
                                name="zipcode"
                                placeholder="Enter your zipcode"
                                value="{{ old('zipcode') }}"
                                required
                                maxlength="4"
                                inputmode="numeric"
                                pattern="[0-9]{4}"
                                autocomplete="off"
                                title="ZIP code must be 4 digits"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4)"
                            >
                            @error('zipcode') <small>{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="register-grid register-grid--two">
                        <div class="plm-ff-group">
                            <label for="password">Password <span class="required">*</span></label>
                            <div class="plm-ff-group-pass">
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    placeholder="Enter your password"
                                    required
                                    autocomplete="new-password"
                                >
                                <div class="show" id="show-pass">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15.58 11.9999C15.58 13.9799 13.98 15.5799 12 15.5799C10.02 15.5799 8.42004 13.9799 8.42004 11.9999C8.42004 10.0199 10.02 8.41992 12 8.41992C13.98 8.41992 15.58 10.0199 15.58 11.9999Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12 20.2702C15.53 20.2702 18.82 18.1902 21.11 14.5902C22.01 13.1802 22.01 10.8102 21.11 9.40021C18.82 5.80021 15.53 3.72021 12 3.72021C8.46997 3.72021 5.17997 5.80021 2.88997 9.40021C1.98997 10.8102 1.98997 13.1802 2.88997 14.5902C5.17997 18.1902 8.46997 20.2702 12 20.2702Z" stroke="#1E1E1E" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>
                            @error('password') <small>{{ $message }}</small> @enderror
                        </div>

                        <div class="plm-ff-group">
                            <label for="password_conf">Confirm Password <span class="required">*</span></label>
                            <div class="plm-ff-group-pass">
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    id="password_conf"
                                    placeholder="Confirm your password"
                                    required
                                    autocomplete="new-password"
                                >
                                <div class="show" id="show-pass-conf">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15.58 11.9999C15.58 13.9799 13.98 15.5799 12 15.5799C10.02 15.5799 8.42004 13.9799 8.42004 11.9999C8.42004 10.0199 10.02 8.41992 12 8.41992C13.98 8.41992 15.58 10.0199 15.58 11.9999Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12 20.2702C15.53 20.2702 18.82 18.1902 21.11 14.5902C22.01 13.1802 22.01 10.8102 21.11 9.40021C18.82 5.80021 15.53 3.72021 12 3.72021C8.46997 3.72021 5.17997 5.80021 2.88997 9.40021C1.98997 10.8102 1.98997 13.1802 2.88997 14.5902C5.17997 18.1902 8.46997 20.2702 12 20.2702Z" stroke="#1E1E1E" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>
                            @error('password_confirmation') <small>{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="plm-ff-group register-recaptcha">
                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>

                        @error('g-recaptcha-response')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="auth-form__privacy">
                        <p>
                            By signing up, you agree to our
                            <a href="{{ url('/privacy-policy') }}" target="_blank">Privacy Policy</a>.
                        </p>
                    </div>

                    <button class="plm-ff-btn btn btn--tertiary" type="submit">
                        Create Account
                    </button>

                    <p class="plm-ff-cta">
                        Already Have Account? <a href="{{ url('/login') }}">Sign in</a>
                    </p>
                </form>
            </div>
        </section>
    </main>
@endsection

@push('extrascripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script>
        $(document).ready(function () {
            const showSvg = `
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.53 9.46992L9.47004 14.5299C8.82004 13.8799 8.42004 12.9899 8.42004 11.9999C8.42004 10.0199 10.02 8.41992 12 8.41992C12.99 8.41992 13.88 8.81992 14.53 9.46992Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M17.82 5.76998C16.07 4.44998 14.07 3.72998 12 3.72998C8.46997 3.72998 5.17997 5.80998 2.88997 9.40998C1.98997 10.82 1.98997 13.19 2.88997 14.6C3.67997 15.84 4.59997 16.91 5.59997 17.77" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M8.42004 19.5302C9.56004 20.0102 10.77 20.2702 12 20.2702C15.53 20.2702 18.82 18.1902 21.11 14.5902C22.01 13.1802 22.01 10.8102 21.11 9.40018C20.78 8.88018 20.42 8.39018 20.05 7.93018" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M15.5099 12.7002C15.2499 14.1102 14.0999 15.2602 12.6899 15.5202" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9.47 14.5298L2 21.9998" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M22 2L14.53 9.47" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            `;

            const hideSvg = `
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.58 11.9999C15.58 13.9799 13.98 15.5799 12 15.5799C10.02 15.5799 8.42004 13.9799 8.42004 11.9999C8.42004 10.0199 10.02 8.41992 12 8.41992C13.98 8.41992 15.58 10.0199 15.58 11.9999Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 20.2702C15.53 20.2702 18.82 18.1902 21.11 14.5902C22.01 13.1802 22.01 10.8102 21.11 9.40021C18.82 5.80021 15.53 3.72021 12 3.72021C8.46997 3.72021 5.17997 5.80021 2.88997 9.40021C1.98997 10.8102 1.98997 13.1802 2.88997 14.5902C5.17997 18.1902 8.46997 20.2702 12 20.2702Z" stroke="#1E1E1E" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            `;

            $('#show-pass').on('click', function () {
                const input = $('#password');

                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    $(this).html(showSvg);
                } else {
                    input.attr('type', 'password');
                    $(this).html(hideSvg);
                }
            });

            $('#show-pass-conf').on('click', function () {
                const input = $('#password_conf');

                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    $(this).html(showSvg);
                } else {
                    input.attr('type', 'password');
                    $(this).html(hideSvg);
                }
            });
        });
    </script>
@endpush