@extends('admin.layouts.auth')

@push('extrastylesheets')
    <style>
        .provider-register .provider-select {
            position: relative;
            width: 100%;
        }

        .provider-register .provider-select select {
            width: 100%;
            height: 42px;
            border: 1px solid #d9dee7;
            border-radius: 7px;
            background: #ffffff;
            padding: 0 34px 0 14px;
            font-size: 13px;
            color: #202124;
            appearance: none;
        }

        .provider-register .provider-select select:focus {
            border-color: #ffb73e;
        }

        .provider-register .provider-select__arrow {
            position: absolute;
            right: 12px;
            top: 46%;
            width: 7px;
            height: 7px;
            border-right: 1.5px solid #656565;
            border-bottom: 1.5px solid #656565;
            transform: translateY(-50%) rotate(45deg);
            pointer-events: none;
        }

        .provider-register .prg-mm-group input[type="date"] {
            width: 100%;
            height: 42px;
            border: 1px solid #d9dee7;
            border-radius: 7px;
            background: #ffffff;
            padding: 0 14px;
            font-size: 13px;
            color: #202124;
        }

        .provider-register .prg-mm-group input[type="date"]:focus {
            border-color: #ffb73e;
        }

        .provider-register .birthdate-error {
            color: #8b95a1;
        }

        .provider-register .auth-form__privacy label {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            margin: 0;
            cursor: pointer;
        }

        .provider-register .auth-form__privacy input[type="checkbox"] {
            width: 15px;
            height: 15px;
            min-width: 15px;
            margin-top: 2px;
            border: 1px solid #c7ced8;
            border-radius: 3px;
            appearance: auto;
        }

        .provider-register .auth-form__privacy span,
        .provider-register__main .provider-register-main-m .provreg-mm-con--fields .auth-form__privacy label span {
            font-size: 12px;
            line-height: 1.5;
            color: #8b95a1 !important;
        }

        .provider-register .auth-form__privacy a {
            color: #6b7280;
            text-decoration: underline;
        }

        @media screen and (max-width: 576px) {
            .provider-register__main .provider-register-main-m {
                padding: 24px 18px;
            }

            .provider-register__main .provider-register-main-m .provreg-mm-con {
                max-width: 100%;
                margin-top: 2rem;
            }

            .provider-register__main .provider-register-main-m .provreg-mm-con--fields {
                margin-top: 2rem;
            }

            .provider-register__main .provider-register-main-m .provreg-mm-con--fields .prg-mm-con {
                flex-direction: column;
                gap: 0;
            }

            .provider-register__main .provider-register-main-m .provreg-mm-con--fields .file-field .file-input-wrapper {
                width: 100%;
                padding-left: 96px;
            }

            .provider-register__main .provider-register-main-m .provreg-mm-con--fields .file-field .file-input-wrapper .file-btn {
                width: 96px;
                padding-inline: 10px;
                white-space: nowrap;
            }

            .provider-register__main .provider-register-main-m .provreg-mm-con--fields .file-field .file-input-wrapper .file-name {
                min-width: 0;
            }

            .provider-register .g-recaptcha {
                transform: scale(0.86);
                transform-origin: left top;
            }

            .provider-register__main .provider-register-main-m .provreg-mm-con--fields .provreg-mmcf-secpage__btns {
                justify-content: stretch;
            }

            .provider-register__main .provider-register-main-m .provreg-mm-con--fields .provreg-mmcf-secpage__btns button {
                flex: 1;
                min-width: 0;
                padding-inline: 16px;
            }
        }

        @media screen and (max-width: 360px) {
            .provider-register__main .provider-register-main-m {
                padding-left: 14px;
                padding-right: 14px;
            }

            .provider-register .g-recaptcha {
                transform: scale(0.8);
            }
        }
    </style>
    <style>
.provider-register .password-strength-minimal {
    width: 100%;
    margin-top: 8px;
}

.provider-register .password-strength-minimal__bar {
    width: 100%;
    height: 4px;
    background: #eef0f3;
    border-radius: 999px;
    overflow: hidden;
}

.provider-register .password-strength-minimal__bar span {
    display: block;
    width: 0%;
    height: 100%;
    border-radius: 999px;
    background: #d93025;
    transition: all 0.2s ease;
}

.provider-register .password-strength-minimal__text {
    margin: 6px 0 0;
    font-size: 11px;
    line-height: 1.3;
    color: #98a2b3;
}

.provider-register .password-strength-minimal__text strong {
    font-weight: 600;
}

.provider-register .password-strength-minimal.is-low .password-strength-minimal__bar span {
    width: 33%;
    background: #d93025;
}

.provider-register .password-strength-minimal.is-low .password-strength-minimal__text strong {
    color: #d93025;
}

.provider-register .password-strength-minimal.is-medium .password-strength-minimal__bar span {
    width: 66%;
    background: #f59e0b;
}

.provider-register .password-strength-minimal.is-medium .password-strength-minimal__text strong {
    color: #f59e0b;
}

.provider-register .password-strength-minimal.is-strong .password-strength-minimal__bar span {
    width: 100%;
    background: #16a34a;
}

.provider-register .password-strength-minimal.is-strong .password-strength-minimal__text strong {
    color: #16a34a;
}
    </style>
@endpush

@section('content')
    <div class="form-loading-bar" id="form-loading-bar">
        <div class="form-loading-bar__progress"></div>
    </div>
    <main class="provider-register">
        <div class="provider-register__img">
            <img src="{{asset('images/preg-item.png')}}" alt="item">
            <h4>Start your provider journey </h4>
            <p>Manage services, track bookings and earnings, and connect with customers using ServEase’s provider dashboard.</p>
        </div>
        <div class="provider-register__main">
            <div class="provider-register-main-m">
                <a href="{{url('/')}}" class="provider-register-main-m__back">← Go Back</a>

                <div class="provreg-mm-con">
                    <h4>Provider create account</h4>
                    <p>Fill out Information needed to proceed.</p>
                    <div class="provreg-mm-con__position">
                        <button class="firstpage-icon" disabled>
                            <svg width="12" height="14" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.00033 7.33366C7.84127 7.33366 9.33366 5.84127 9.33366 4.00033C9.33366 2.15938 7.84127 0.666992 6.00033 0.666992C4.15938 0.666992 2.66699 2.15938 2.66699 4.00033C2.66699 5.84127 4.15938 7.33366 6.00033 7.33366Z" stroke="#FFBE42" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M11.3337 12.6673C11.3337 11.2528 10.7718 9.89628 9.77156 8.89608C8.77137 7.89589 7.41481 7.33398 6.00033 7.33398C4.58584 7.33398 3.22928 7.89589 2.22909 8.89608C1.2289 9.89628 0.666992 11.2528 0.666992 12.6673" stroke="#FFBE42" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <svg width="35" height="1" viewBox="0 0 35 1" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <line opacity="0.3" y1="0.5" x2="35" y2="0.5" stroke="black" stroke-dasharray="3 4"/>
                        </svg>
                        <button class="secpage-icon" disabled>
                            <svg width="18" height="16" viewBox="0 0 15 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.88341 3.88281H11.2167M9.88341 6.54948H11.2167M3.33008 7.21615C3.4675 6.82549 3.72281 6.48712 4.06076 6.24776C4.3987 6.00839 4.80262 5.87984 5.21674 5.87984C5.63087 5.87984 6.03479 6.00839 6.37273 6.24776C6.71068 6.48712 6.96598 6.82549 7.10341 7.21615" stroke="#D9D9D9" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M5.21615 5.88346C5.95253 5.88346 6.54948 5.28651 6.54948 4.55013C6.54948 3.81375 5.95253 3.2168 5.21615 3.2168C4.47977 3.2168 3.88281 3.81375 3.88281 4.55013C3.88281 5.28651 4.47977 5.88346 5.21615 5.88346Z" stroke="#D9D9D9" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12.5498 0.549805H1.88314C1.14676 0.549805 0.549805 1.14676 0.549805 1.88314V8.5498C0.549805 9.28618 1.14676 9.88314 1.88314 9.88314H12.5498C13.2862 9.88314 13.8831 9.28618 13.8831 8.5498V1.88314C13.8831 1.14676 13.2862 0.549805 12.5498 0.549805Z" stroke="#D9D9D9" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>

                    <form method="POST" action="{{ url('/provider-signup-c') }}" class="provreg-mm-con--fields" enctype="multipart/form-data" novalidate>
                        @csrf

                        <div class="provreg-mmcf-firstpage">


                            <div class="prg-mm-con">
                                <div class="prg-mm-group">
                                    <label for="name">First Name <span>*</span></label>
                                    <input type="text" placeholder="e. g. Juan" name="fname" value="{{ old('fname') }}" data-one-space required autocomplete="off">
                                    @error('fname') <small>{{ $message }}</small> @enderror
                                </div>
                                <div class="prg-mm-group">
                                    <label for="lname">Last Name <span>*</span></label>
                                    <input type="text" placeholder="e. g. Cruz" name="lname" value="{{ old('lname') }}" data-one-space required autocomplete="off">
                                    @error('lname') <small style="align-self: flex-end">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="prg-mm-con">
                                <div class="prg-mm-group">
                                    <label for="email">Email Address <span>*</span></label>
                                    <input
                                        type="email"
                                        placeholder="e. g. name@gmail.com"
                                        name="email"
                                        value="{{ old('email') }}"
                                        required
                                        maxlength="255"
                                        data-no-space
                                        autocomplete="email"
                                        inputmode="email"
                                    >
                                    @error('email')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="prg-mm-group">
                                    <label for="number">Phone Number <span>*</span></label>
                                    <input
                                        type="text"
                                        placeholder="e. g. 09123456789"
                                        name="number"
                                        value="{{ old('number') }}"
                                        required
                                        data-no-space
                                        maxlength="11"
                                        inputmode="numeric"
                                        autocomplete="tel"
                                        pattern="09[0-9]{9}"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11)"
                                    >
                                    @error('number')
                                        <small style="align-self: flex-end">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="prg-mm-group">
                                <label for="gender">Sex <span>*</span></label>
                                <div class="provider-select">
                                    <select id="gender" name="gender" required>
                                        <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Select gender</option>
                                        <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="prefer_not_to_say" {{ old('gender') === 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                                    </select>
                                    <span class="provider-select__arrow" aria-hidden="true"></span>
                                </div>
                                @error('gender')
                                    <small style="align-self: flex-end">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label for="birthdate">Birthdate <span>*</span></label>
                                <input
                                    type="date"
                                    id="birthdate"
                                    name="birthdate"
                                    value="{{ old('birthdate') }}"
                                    required
                                    autocomplete="off"
                                    data-age-picker
                                    data-min-age="18"
                                    data-max-age="150"
                                    title="Age must be between 18 and 150 years old"
                                >
                                <small class="birthdate-error" style="display:none;"></small>
                                @error('birthdate')
                                    <small style="align-self: flex-end">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label for="address">Personal Home Address <span>*</span></label>
                                <input type="text" placeholder="" name="address" value="{{ old('address') }}" data-one-space required autocomplete="off">
                                @error('address') <small>{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-con">
                                <div class="prg-mm-group">
                                    <label for="city">City <span>*</span></label>
                                    <input type="hidden" name="city" value="{{ old('city') }}" data-ph-city-value>
                                    <div class="location-combobox" data-ph-combobox="city">
                                        <input type="text" placeholder="Search city or municipality" value="{{ old('city') }}" data-one-space required autocomplete="off" data-ph-city>
                                        <span class="location-combobox__arrow" aria-hidden="true"></span>
                                        <div class="location-combobox__menu" data-ph-city-menu></div>
                                    </div>
                                    @error('city') <small>{{ $message }}</small> @enderror
                                </div>
                                <div class="prg-mm-group">
                                    <label for="barangay">Barangay <span>*</span></label>
                                    <input type="hidden" name="barangay" value="{{ old('barangay') }}" data-ph-barangay-value>
                                    <div class="location-combobox" data-ph-combobox="barangay">
                                        <input type="text" placeholder="Select city first" value="{{ old('barangay') }}" data-one-space required autocomplete="off" data-ph-barangay>
                                        <span class="location-combobox__arrow" aria-hidden="true"></span>
                                        <div class="location-combobox__menu" data-ph-barangay-menu></div>
                                    </div>
                                    @error('barangay') <small>{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="prg-mm-group">
                                <label for="zipcode">ZIP Code <span>*</span></label>
                                <input
                                    type="text"
                                    placeholder=""
                                    name="zipcode"
                                    value="{{ old('zipcode') }}"
                                    required
                                    maxlength="4"
                                    data-no-space
                                    inputmode="numeric"
                                    pattern="[0-9]{4}"
                                    autocomplete="off"
                                    title="ZIP Code must be 4 digits"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4)"
                                >
                                @error('zipcode')
                                    <small style="align-self: flex-end">{{ $message }}</small>
                                @enderror
                            </div>

                            <button type="button" id="provreg-next" class="btn btn--primary">Next</button>
                        </div> 
                        
                        <div class="provreg-mmcf-secpage">
                            <div class="file-field">
                                <label>Resume / CV Upload (PDF only)</label>

                                <div class="file-input-wrapper">
                                    <input type="file" id="resume" name="resume" accept="application/pdf" hidden>
                                    <button type="button" class="file-btn" data-target="resume">
                                        Choose File
                                    </button>
                                    <span class="file-name ml-2">No file chosen</span>
                                </div>

                                @error('resume')
                                    <small style="align-self: flex-end; color: red">{{ $message }}</small> 
                                @enderror
                            </div>
                            <div class="file-field">
                                <label>Barangay Clearance Upload (PDF only)</label>

                                <div class="file-input-wrapper">
                                    <input type="file" id="barangay_clearance" name="barangay_clearance" accept="application/pdf" hidden>

                                    <button type="button" class="file-btn" data-target="barangay_clearance">
                                        Choose File
                                    </button>

                                    <span class="file-name ml-2">No file chosen</span>
                                </div>

                                @error('barangay_clearance')
                                    <small style="align-self: flex-end; color: red">{{ $message }}</small> 
                                @enderror
                            </div>
                            <div class="prg-mm-con">
                                <div class="prg-mm-group">
                                    <label for="name">Expertise <span>*</span></label>
                                    <input type="text" placeholder="" name="profession" value="{{ old('profession') }}" data-one-space required autocomplete="off">
                                    @error('profession') <small>{{ $message }}</small> @enderror
                                </div>
                                <div class="prg-mm-group">
                                    <label for="lname">Years of experience <span>*</span></label>
                                    <input type="number" placeholder="" name="experience" value="{{ old('experience') }}" data-no-space min="1" max="100"  maxlength="3" inputmode="numeric" title="Years of experience must be 1 to 3 digits" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3)" required autocomplete="off">
                                    @error('experience') <small style="align-self: flex-end">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            {{-- <div class="prg-mm-group">
                                <label for="password">Password</label>
                                <div class="prg-mm-group-pass">
                                    <input type="password" name="password" id="password" placeholder="" required data-no-space autocomplete="current-password">
                                    <div class="show" id="show-pass">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15.58 11.9999C15.58 13.9799 13.98 15.5799 12 15.5799C10.02 15.5799 8.42004 13.9799 8.42004 11.9999C8.42004 10.0199 10.02 8.41992 12 8.41992C13.98 8.41992 15.58 10.0199 15.58 11.9999Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M12 20.2702C15.53 20.2702 18.82 18.1902 21.11 14.5902C22.01 13.1802 22.01 10.8102 21.11 9.40021C18.82 5.80021 15.53 3.72021 12 3.72021C8.46997 3.72021 5.17997 5.80021 2.88997 9.40021C1.98997 10.8102 1.98997 13.1802 2.88997 14.5902C5.17997 18.1902 8.46997 20.2702 12 20.2702Z" stroke="#1E1E1E" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                </div>
                                @error('password') <small>{{ $message }}</small> @enderror
                            </div> --}}
<div class="prg-mm-group">
    <label for="password">Password</label>

    <div class="prg-mm-group-pass">
        <input
            type="password"
            name="password"
            id="password"
            placeholder=""
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

    <div class="password-strength-minimal" data-password-strength>
        <div class="password-strength-minimal__bar">
            <span></span>
        </div>
        <p class="password-strength-minimal__text">
            Strength: <strong>Required</strong>
        </p>
    </div>

    @error('password') <small>{{ $message }}</small> @enderror
</div>
                            <div class="prg-mm-group">
                                <label for="password">Confirm Password</label>
                                <div class="prg-mm-group-pass">
                                    <input type="password" name="password_confirmation" id="password_conf" placeholder="" data-no-space required autocomplete="current-password">
                                    <div class="show" id="show-pass-conf">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15.58 11.9999C15.58 13.9799 13.98 15.5799 12 15.5799C10.02 15.5799 8.42004 13.9799 8.42004 11.9999C8.42004 10.0199 10.02 8.41992 12 8.41992C13.98 8.41992 15.58 10.0199 15.58 11.9999Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M12 20.2702C15.53 20.2702 18.82 18.1902 21.11 14.5902C22.01 13.1802 22.01 10.8102 21.11 9.40021C18.82 5.80021 15.53 3.72021 12 3.72021C8.46997 3.72021 5.17997 5.80021 2.88997 9.40021C1.98997 10.8102 1.98997 13.1802 2.88997 14.5902C5.17997 18.1902 8.46997 20.2702 12 20.2702Z" stroke="#1E1E1E" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                </div>
                                @error('password_confirmation') <small>{{ $message }}</small> @enderror
                                {{-- <a href="#">Forget Password?</a> --}}
                            </div>
                            <div class="prg-mm-group" style="margin-bottom: 5px !important">
                                <div
                                    class="g-recaptcha"
                                    data-sitekey="{{ config('services.recaptcha.site_key') }}"
                                    data-expired-callback="providerSignupRecaptchaExpired"
                                    data-error-callback="providerSignupRecaptchaExpired"
                                ></div>

                                @error('g-recaptcha-response')
                                    <small style="align-self: flex-end">{{ $message }}</small>
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
                        @error('privacy_accepted')
                            <small style="align-self: flex-end">{{ $message }}</small>
                        @enderror
                    </div>
                            <div class="provreg-mmcf-secpage__btns">
                                <button type="button" id="provreg-prev" class="btn btn--primary">back</button>
                                <button type="submit" class="btn btn--tertiary">Submit</button>
                            </div>
                        </div>


                    </form>

                </div>



            </div>
            {{-- <img src="{{asset('images/vector-preg.svg')}}" class="provider-register-main-img" alt="vector"> --}}
        </div>
    </main>
@endsection
@push('extrascripts')
    <script>    
        window.providerSignupRecaptchaExpired = function () {
            if (window.ServeasePageLoader) {
                window.ServeasePageLoader.reset();
            }
        };

        $(document).ready(function () {
            function getInvalidField(scopeSelector) {
                const fields = document.querySelectorAll(scopeSelector + ' input, ' + scopeSelector + ' select, ' + scopeSelector + ' textarea');

                for (let i = 0; i < fields.length; i++) {
                    if (typeof fields[i].checkValidity === 'function' && !fields[i].checkValidity()) {
                        return fields[i];
                    }
                }

                return null;
            }

            function resetPageLoader() {
                if (window.ServeasePageLoader) {
                    window.ServeasePageLoader.reset();
                }
            }

            function formatDateInput(date) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');

                return `${year}-${month}-${day}`;
            }

            function calculateAge(value) {
                const parts = value.split('-').map(Number);

                if (parts.length !== 3 || parts.some(Number.isNaN)) {
                    return null;
                }

                const [year, month, day] = parts;
                const birthDate = new Date(year, month - 1, day);

                if (
                    birthDate.getFullYear() !== year ||
                    birthDate.getMonth() !== month - 1 ||
                    birthDate.getDate() !== day
                ) {
                    return null;
                }

                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();

                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }

                return age;
            }

            function setupAgePickers() {
                document.querySelectorAll('[data-age-picker]').forEach(function (input) {
                    const minAge = Number(input.dataset.minAge || 18);
                    const maxAge = Number(input.dataset.maxAge || 150);
                    const today = new Date();
                    const oldestAllowed = new Date(today.getFullYear() - maxAge - 1, today.getMonth(), today.getDate() + 1);
                    const youngestAllowed = new Date(today.getFullYear() - minAge, today.getMonth(), today.getDate());
                    const ageFeedback = input.parentElement.querySelector('.birthdate-error');

                    input.min = formatDateInput(oldestAllowed);
                    input.max = formatDateInput(youngestAllowed);

                    function updateAge() {
                        input.setCustomValidity('');

                        if (!input.value) {
                            if (ageFeedback) {
                                ageFeedback.style.display = 'none';
                            }

                            return;
                        }

                        const age = calculateAge(input.value);

                        if (age === null) {
                            input.setCustomValidity('Please select a valid birthdate.');

                            if (ageFeedback) {
                                ageFeedback.textContent = 'Please select a valid birthdate.';
                                ageFeedback.style.color = '#d93025';
                                ageFeedback.style.display = 'block';
                            }

                            return;
                        }

                        if (age < minAge) {
                            input.setCustomValidity(`You must be at least ${minAge} years old.`);
                        } else if (age > maxAge) {
                            input.setCustomValidity(`Age cannot be greater than ${maxAge} years old.`);
                        }

                        if (ageFeedback) {
                            ageFeedback.textContent = input.validationMessage || `Age: ${age}`;
                            ageFeedback.style.color = input.validationMessage ? '#d93025' : '#667085';
                            ageFeedback.style.display = 'block';
                        }
                    }

                    input.addEventListener('input', updateAge);
                    input.addEventListener('change', updateAge);
                    updateAge();
                });
            }

            setupAgePickers();

            $('.provreg-mm-con--fields').on('submit', function (e) {
                const firstPageInvalid = getInvalidField('.provreg-mmcf-firstpage');

                if (firstPageInvalid) {
                    e.preventDefault();
                    resetPageLoader();

                    $('.provreg-mmcf-secpage').hide();
                    $('.provreg-mmcf-firstpage').show();
                    setStep(1);

                    setTimeout(function () {
                        firstPageInvalid.reportValidity();
                        firstPageInvalid.focus();
                    }, 50);

                    return;
                }

                const secondPageInvalid = getInvalidField('.provreg-mmcf-secpage');

                if (secondPageInvalid) {
                    e.preventDefault();
                    resetPageLoader();

                    $('.provreg-mmcf-firstpage').hide();
                    $('.provreg-mmcf-secpage').show();
                    setStep(2);

                    setTimeout(function () {
                        secondPageInvalid.reportValidity();
                        secondPageInvalid.focus();
                    }, 50);

                    return;
                }

                if (typeof grecaptcha === 'undefined' || grecaptcha.getResponse().length === 0) {
                    e.preventDefault();
                    resetPageLoader();

                    Swal.fire({
                        icon: 'warning',
                        title: 'Verify reCAPTCHA',
                        text: 'Please check the reCAPTCHA box again before submitting.',
                        confirmButtonColor: '#FFBE42',
                    });
                }
            });

            const hasStepTwoErrors = @json(
                $errors->has('resume') ||
                $errors->has('barangay_clearance') ||
                $errors->has('profession') ||
                $errors->has('experience') ||
                $errors->has('password') ||
                $errors->has('password_confirmation') ||
                $errors->has('privacy_accepted') ||
                $errors->has('g-recaptcha-response')
            );

            function setStep(step) {
                if (step === 1) {
                    // First step active
                    $('.firstpage-icon svg path').attr('stroke', '#FFBE42');
                    $('.secpage-icon svg path').attr('stroke', '#D9D9D9');
                }

                if (step === 2) {
                    // Second step active
                    $('.firstpage-icon svg path').attr('stroke', '#D9D9D9');
                    $('.secpage-icon svg path').attr('stroke', '#FFBE42');
                }
            }

            // Default state
            setStep(1);

            if (hasStepTwoErrors) {
                $('.provreg-mmcf-firstpage').hide();
                $('.provreg-mmcf-secpage').show();
                setStep(2);
            }

            @if($errors->has('g-recaptcha-response'))
                Swal.fire({
                    icon: 'warning',
                    title: 'Verify reCAPTCHA',
                    text: @json($errors->first('g-recaptcha-response')),
                    confirmButtonColor: '#FFBE42',
                });
            @endif

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

            function renderLocationMenu(menu, records, onSelect) {
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

            function filterLocationRecords(records, term) {
                const normalizedTerm = term.trim().toLowerCase();

                if (!normalizedTerm) {
                    return records;
                }

                return records.filter((record) => recordLabel(record).toLowerCase().includes(normalizedTerm));
            }

            function openLocationCombo(input) {
                input?.closest('.location-combobox')?.classList.add('is-open');
            }

            function closeLocationCombos() {
                document.querySelectorAll('.location-combobox.is-open').forEach((combo) => {
                    combo.classList.remove('is-open');
                });
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
                closeLocationCombos();
                loadBarangays();
            }

            function selectBarangay(record) {
                barangayInput.value = record.name;
                barangayValue.value = record.name;
                closeLocationCombos();
            }

            function loadBarangays() {
                if (!selectedCityCode || !barangayMenu) {
                    barangayRecords = [];
                    renderLocationMenu(barangayMenu, [], selectBarangay);
                    return;
                }

                fetch(`${psgcBaseUrl}/cities-municipalities/${selectedCityCode}/barangays/`)
                    .then((response) => response.ok ? response.json() : [])
                    .then((records) => {
                        barangayRecords = records;
                        renderLocationMenu(barangayMenu, filterLocationRecords(barangayRecords, barangayInput.value), selectBarangay);
                    })
                    .catch(() => {
                        barangayRecords = [];
                        renderLocationMenu(barangayMenu, [], selectBarangay);
                    });
            }

            if (cityInput && cityValue && cityMenu && barangayInput && barangayValue && barangayMenu) {
                fetch(`${psgcBaseUrl}/cities-municipalities/`)
                    .then((response) => response.ok ? response.json() : [])
                    .then((records) => {
                        cityRecords = records;
                        renderLocationMenu(cityMenu, filterLocationRecords(cityRecords, cityInput.value), selectCity);

                        const city = resolveCityFromInput();
                        selectedCityCode = city?.code || null;
                        loadBarangays();
                    })
                    .catch(() => {
                        cityRecords = [];
                        renderLocationMenu(cityMenu, [], selectCity);
                    });

                cityInput.addEventListener('focus', function () {
                    renderLocationMenu(cityMenu, filterLocationRecords(cityRecords, cityInput.value), selectCity);
                    openLocationCombo(cityInput);
                });

                cityInput.addEventListener('input', function () {
                    const exactCity = resolveCityFromInput();
                    selectedCityCode = exactCity?.code || null;
                    cityValue.value = exactCity ? exactCity.name : cityInput.value;
                    renderLocationMenu(cityMenu, filterLocationRecords(cityRecords, cityInput.value), selectCity);
                    openLocationCombo(cityInput);
                    barangayInput.value = '';
                    barangayValue.value = '';

                    if (selectedCityCode) {
                        loadBarangays();
                    } else {
                        barangayRecords = [];
                        renderLocationMenu(barangayMenu, [], selectBarangay);
                    }
                });

                barangayInput.addEventListener('focus', function () {
                    renderLocationMenu(barangayMenu, filterLocationRecords(barangayRecords, barangayInput.value), selectBarangay);
                    openLocationCombo(barangayInput);
                });

                barangayInput.addEventListener('input', function () {
                    barangayValue.value = barangayInput.value;
                    renderLocationMenu(barangayMenu, filterLocationRecords(barangayRecords, barangayInput.value), selectBarangay);
                    openLocationCombo(barangayInput);
                });

                document.addEventListener('click', function (event) {
                    if (!event.target.closest('.location-combobox')) {
                        closeLocationCombos();
                    }
                });
            }

            $('#provreg-next').on('click', function (e) {
                e.preventDefault();

                const firstPageInvalid = getInvalidField('.provreg-mmcf-firstpage');

                if (firstPageInvalid) {
                    firstPageInvalid.reportValidity();
                    firstPageInvalid.focus();
                    return;
                }

                $('.provreg-mmcf-firstpage').hide();
                $('.provreg-mmcf-secpage').fadeIn(200);

                setStep(2);
            });

            // Prev → back to step 1
            $('#provreg-prev').on('click', function (e) {
                e.preventDefault();

                $('.provreg-mmcf-secpage').hide();
                $('.provreg-mmcf-firstpage').fadeIn(200);

                setStep(1);
            });

        });

        $(document).ready(function () {

            $('.file-btn').on('click', function () {
                const target = $(this).data('target');
                $('#' + target).click();
            });

            $('input[type="file"]').on('change', function () {
                const file = this.files.length ? this.files[0] : null;
                const wrapper = $(this).closest('.file-input-wrapper');
                const fileNameText = wrapper.find('.file-name');

                if (!file) {
                    fileNameText.text('No file chosen');
                    return;
                }

                const isPdf = file.type === 'application/pdf' || file.name.toLowerCase().endsWith('.pdf');

                if (!isPdf) {
                    this.value = '';
                    fileNameText.text('No file chosen');

                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid File',
                        text: 'Please upload a PDF file only.',
                        confirmButtonColor: '#FFBE42',
                    });

                    return;
                }

                fileNameText.text(file.name);
            });

        });

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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @if(session('provider_application_submitted'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Application Submitted',
                    text: 'Admin will review your application. Please wait for approval before logging in.',
                    confirmButtonText: 'Go Back',
                    confirmButtonColor: '#FFBE42',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                }).then(() => {
                    window.location.href = "{{ url('/') }}";
                });
            });
        </script>
    @endif

    <script>
function setupPasswordStrength() {
    const passwordInput = document.getElementById('password');
    const strengthBox = document.querySelector('[data-password-strength]');

    if (!passwordInput || !strengthBox) return;

    const text = strengthBox.querySelector('.password-strength-minimal__text strong');

    function updatePasswordStrength() {
        const value = passwordInput.value;

        const checks = {
            length: value.length >= 8,
            uppercase: /[A-Z]/.test(value),
            lowercase: /[a-z]/.test(value),
            number: /[0-9]/.test(value),
            symbol: /[^A-Za-z0-9]/.test(value),
        };

        const score = Object.values(checks).filter(Boolean).length;

        strengthBox.classList.remove('is-low', 'is-medium', 'is-strong');

        if (!value) {
            text.textContent = 'Required';
            passwordInput.setCustomValidity('');
            return;
        }

        if (score <= 2) {
            text.textContent = 'Low';
            strengthBox.classList.add('is-low');
            passwordInput.setCustomValidity('Password must be strong.');
            return;
        }

        if (score <= 4) {
            text.textContent = 'Medium';
            strengthBox.classList.add('is-medium');
            passwordInput.setCustomValidity('Password must be strong.');
            return;
        }

        text.textContent = 'Strong';
        strengthBox.classList.add('is-strong');
        passwordInput.setCustomValidity('');
    }

    passwordInput.addEventListener('input', updatePasswordStrength);
    passwordInput.addEventListener('change', updatePasswordStrength);

    updatePasswordStrength();
}

setupPasswordStrength();
    </script>
@endpush
