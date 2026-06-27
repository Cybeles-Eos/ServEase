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
                padding: 35px 20px 35px !important;
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
                grid-template-columns: repeat(3, 1fr) !important;
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

            .customer-register-page .plm-ff-group input,
            .customer-register-page .plm-ff-group select {
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

            .customer-register-page .plm-ff-group input:focus,
            .customer-register-page .plm-ff-group select:focus {
                border-color: #ffb73e !important;
            }

            .customer-register-page .register-select {
                position: relative !important;
                width: 100% !important;
            }

            .customer-register-page .register-select select {
                appearance: none !important;
                padding-right: 34px !important;
            }

            .customer-register-page .register-select__arrow {
                position: absolute !important;
                right: 12px !important;
                top: 46% !important;
                width: 7px !important;
                height: 7px !important;
                border-right: 1.5px solid #656565 !important;
                border-bottom: 1.5px solid #656565 !important;
                transform: translateY(-50%) rotate(45deg) !important;
                pointer-events: none !important;
            }

            .customer-register-page .location-combobox {
                position: relative !important;
                width: 100% !important;
            }

            .customer-register-page .location-combobox input {
                padding-right: 34px !important;
            }

            .customer-register-page .location-combobox__arrow {
                position: absolute !important;
                right: 12px !important;
                top: 46% !important;
                width: 7px !important;
                height: 7px !important;
                border-right: 1.5px solid #656565 !important;
                border-bottom: 1.5px solid #656565 !important;
                transform: translateY(-50%) rotate(45deg) !important;
                pointer-events: none !important;
            }

            .customer-register-page .location-combobox__menu {
                display: none !important;
                position: absolute !important;
                top: calc(100% + 5px) !important;
                left: 0 !important;
                right: 0 !important;
                max-height: 210px !important;
                overflow-y: auto !important;
                background: #ffffff !important;
                border: 1px solid #d9dee7 !important;
                border-radius: 7px !important;
                box-shadow: 0 12px 28px rgba(15, 23, 42, 0.14) !important;
                z-index: 40 !important;
                padding: 6px !important;
            }

            .customer-register-page .location-combobox.is-open .location-combobox__menu {
                display: block !important;
            }

            .customer-register-page .location-combobox__option {
                width: 100% !important;
                border: 0 !important;
                background: transparent !important;
                border-radius: 5px !important;
                padding: 8px 9px !important;
                text-align: left !important;
                font-size: 13px !important;
                color: #202124 !important;
                cursor: pointer !important;
            }

            .customer-register-page .location-combobox__option:hover {
                background: #fff6e3 !important;
            }

            .customer-register-page .location-combobox__empty {
                padding: 8px 9px !important;
                font-size: 12px !important;
                color: #8b95a1 !important;
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

            .customer-register-page .auth-form__privacy label {
                display: flex !important;
                align-items: flex-start !important;
                gap: 6px !important;
                margin: 0 !important;
                cursor: pointer !important;
            }

            .customer-register-page .auth-form__privacy input[type="checkbox"] {
                width: 12px !important;
                height: 12px !important;
                min-width: 12px !important;
                margin-top: 4px !important;
                border: 1px solid #c7ced8 !important;
                border-radius: 3px !important;
                appearance: auto !important;
            }

            .customer-register-page .auth-form__privacy span {
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
                    padding-top: 85px !important;
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

    <main class="provider-login reg-signin customer-register-page">
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
                                data-one-space
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
                                data-one-space
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
                                data-no-space
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
                                data-no-space
                                inputmode="numeric"
                                autocomplete="tel"
                                pattern="09[0-9]{9}"
                                title="Phone number must start with 09 and must be exactly 11 digits"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11)"
                            >
                            @error('phone_number') <small>{{ $message }}</small> @enderror
                        </div>

                        <div class="plm-ff-group">
                            <label for="gender">Gender <span class="required">*</span></label>
                            <div class="register-select">
                                <select id="gender" name="gender" required>
                                    <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Select gender</option>
                                    <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="prefer_not_to_say" {{ old('gender') === 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                                </select>
                                <span class="register-select__arrow" aria-hidden="true"></span>
                            </div>
                            @error('gender') <small>{{ $message }}</small> @enderror
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
                                data-no-space
                                inputmode="numeric"
                                pattern="[0-9]{4}"
                                autocomplete="off"
                                title="ZIP code must be 4 digits"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4)"
                            >
                            @error('zipcode') <small>{{ $message }}</small> @enderror
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
                                data-one-space
                                autocomplete="off"
                            >
                            @error('street_address') <small>{{ $message }}</small> @enderror
                        </div>

                        <div class="plm-ff-group">
                            <label for="city">City <span class="required">*</span></label>
                            <input type="hidden" id="city" name="city" value="{{ old('city') }}" data-ph-city-value>
                            <div class="location-combobox" data-ph-combobox="city">
                                <input
                                    type="text"
                                    id="city_search"
                                    placeholder="Search city or municipality"
                                    value="{{ old('city') }}"
                                    required
                                    data-ph-city
                                    autocomplete="new-password"
                                    autocorrect="off"
                                    autocapitalize="off"
                                    spellcheck="false"
                                    data-one-space
                                    autocomplete="off"
                                >
                                <span class="location-combobox__arrow" aria-hidden="true"></span>
                                <div class="location-combobox__menu" data-ph-city-menu></div>
                            </div>
                            @error('city') <small>{{ $message }}</small> @enderror
                        </div>

                        <div class="plm-ff-group">
                            <label for="barangay">Barangay <span class="required">*</span></label>
                            <input type="hidden" id="barangay" name="barangay" value="{{ old('barangay') }}" data-ph-barangay-value>
                            <div class="location-combobox" data-ph-combobox="barangay">
                                <input
                                    type="text"
                                    id="barangay_search"
                                    placeholder="Select city first"
                                    value="{{ old('barangay') }}"
                                    required
                                    data-ph-barangay
                                    data-one-space
                                    autocomplete="new-password"
                                    autocorrect="off"
                                    autocapitalize="off"
                                    spellcheck="false"
                                    autocomplete="off"
                                >
                                <span class="location-combobox__arrow" aria-hidden="true"></span>
                                <div class="location-combobox__menu" data-ph-barangay-menu></div>
                            </div>
                            @error('barangay') <small>{{ $message }}</small> @enderror
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
                                    data-no-space
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
                                    data-no-space
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
                        <label for="privacy_accepted">
                            <input
                                type="checkbox"
                                id="privacy_accepted"
                                name="privacy_accepted"
                                value="1"
                                required
                                {{ old('privacy_accepted') ? 'checked' : '' }}
                            >
                            <span>
                                By signing up, you agree to our
                                <a href="{{ url('/privacy-policy') }}" target="_blank">Privacy Policy</a>.
                            </span>
                        </label>
                        @error('privacy_accepted') <small>{{ $message }}</small> @enderror
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

            const cityInput = document.querySelector('[data-ph-city]');
            const cityValue = document.querySelector('[data-ph-city-value]');
            const cityMenu = document.querySelector('[data-ph-city-menu]');
            const barangayInput = document.querySelector('[data-ph-barangay]');
            const barangayValue = document.querySelector('[data-ph-barangay-value]');
            const barangayMenu = document.querySelector('[data-ph-barangay-menu]');
            const psgcBaseUrl = 'https://psgc.gitlab.io/api';
            let cityRecords = [];
            let barangayRecords = [];
            let selectedCityCode = null;

            function recordLabel(record) {
                return [record.name, record.provinceName || record.districtName || record.regionName]
                    .filter(Boolean)
                    .join(', ');
            }

            function renderMenu(menu, records, onSelect) {
                if (!menu) {
                    return;
                }

                menu.innerHTML = '';

                if (!records.length) {
                    const empty = document.createElement('div');
                    empty.className = 'location-combobox__empty';
                    empty.textContent = 'No results found';
                    menu.appendChild(empty);
                    return;
                }

                records.slice(0, 80).forEach((record) => {
                    const option = document.createElement('button');
                    option.type = 'button';
                    option.className = 'location-combobox__option';
                    option.textContent = recordLabel(record);
                    option.addEventListener('click', function () {
                        onSelect(record);
                    });
                    menu.appendChild(option);
                });
            }

            function openCombo(input) {
                input?.closest('.location-combobox')?.classList.add('is-open');
            }

            function closeCombos() {
                document.querySelectorAll('.location-combobox.is-open').forEach((combo) => {
                    combo.classList.remove('is-open');
                });
            }

            function filterRecords(records, term) {
                const normalizedTerm = term.trim().toLowerCase();

                if (!normalizedTerm) {
                    return records;
                }

                return records.filter((record) => recordLabel(record).toLowerCase().includes(normalizedTerm));
            }

            function resolveCityFromInput() {
                const typedCity = cityInput.value.trim().toLowerCase();

                if (!typedCity) {
                    return null;
                }

                const exactLabel = cityRecords.find((record) => recordLabel(record).toLowerCase() === typedCity);

                if (exactLabel) {
                    return exactLabel;
                }

                const exactNameMatches = cityRecords.filter((record) => record.name.toLowerCase() === typedCity);

                return exactNameMatches.length === 1 ? exactNameMatches[0] : null;
            }

            function selectCity(record) {
                selectedCityCode = record.code;
                cityInput.value = recordLabel(record);
                cityValue.value = record.name;
                barangayInput.value = '';
                barangayValue.value = '';
                closeCombos();
                loadBarangays();
            }

            function selectBarangay(record) {
                barangayInput.value = record.name;
                barangayValue.value = record.name;
                closeCombos();
            }

            function loadBarangays() {
                if (!selectedCityCode || !barangayMenu) {
                    barangayRecords = [];
                    renderMenu(barangayMenu, [], selectBarangay);
                    return;
                }

                fetch(`${psgcBaseUrl}/cities-municipalities/${selectedCityCode}/barangays/`)
                    .then((response) => response.ok ? response.json() : [])
                    .then((records) => {
                        barangayRecords = records;
                        renderMenu(barangayMenu, filterRecords(barangayRecords, barangayInput.value), selectBarangay);
                    })
                    .catch(() => {
                        barangayRecords = [];
                        renderMenu(barangayMenu, [], selectBarangay);
                    });
            }

            if (cityInput && cityValue && cityMenu && barangayInput && barangayValue && barangayMenu) {
                fetch(`${psgcBaseUrl}/cities-municipalities/`)
                    .then((response) => response.ok ? response.json() : [])
                    .then((records) => {
                        cityRecords = records;
                        renderMenu(cityMenu, filterRecords(cityRecords, cityInput.value), selectCity);

                        const city = resolveCityFromInput();
                        selectedCityCode = city?.code || null;
                        loadBarangays();
                    })
                    .catch(() => {
                        cityRecords = [];
                        renderMenu(cityMenu, [], selectCity);
                    });

                cityInput.addEventListener('focus', function () {
                    renderMenu(cityMenu, filterRecords(cityRecords, cityInput.value), selectCity);
                    openCombo(cityInput);
                });

                cityInput.addEventListener('input', function () {
                    const exactCity = resolveCityFromInput();
                    selectedCityCode = exactCity?.code || null;
                    cityValue.value = exactCity ? exactCity.name : cityInput.value;
                    renderMenu(cityMenu, filterRecords(cityRecords, cityInput.value), selectCity);
                    openCombo(cityInput);
                    barangayInput.value = '';
                    barangayValue.value = '';

                    if (selectedCityCode) {
                        loadBarangays();
                    } else {
                        barangayRecords = [];
                        renderMenu(barangayMenu, [], selectBarangay);
                    }
                });

                barangayInput.addEventListener('focus', function () {
                    renderMenu(barangayMenu, filterRecords(barangayRecords, barangayInput.value), selectBarangay);
                    openCombo(barangayInput);
                });

                barangayInput.addEventListener('input', function () {
                    barangayValue.value = barangayInput.value;
                    renderMenu(barangayMenu, filterRecords(barangayRecords, barangayInput.value), selectBarangay);
                    openCombo(barangayInput);
                });

                document.addEventListener('click', function (event) {
                    if (!event.target.closest('.location-combobox')) {
                        closeCombos();
                    }
                });
            }
        });
    </script>
@endpush
