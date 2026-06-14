@extends('admin.layouts.auth')

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
                                    <input type="text" placeholder="e. g. Juan" name="fname" value="{{ old('fname') }}" required autocomplete="off">
                                    @error('fname') <small>{{ $message }}</small> @enderror
                                </div>
                                <div class="prg-mm-group">
                                    <label for="lname">Last Name <span>*</span></label>
                                    <input type="text" placeholder="e. g. Cruz" name="lname" value="{{ old('lname') }}" required autocomplete="off">
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
                                <label for="address">Personal Home Address <span>*</span></label>
                                <input type="text" placeholder="" name="address" value="{{ old('address') }}" required autocomplete="off">
                                @error('address') <small>{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-con">
                                <div class="prg-mm-group">
                                    <label for="province">Province <span>*</span></label>
                                    <input type="text" placeholder="" name="province" value="{{ old('province') }}" required autocomplete="off">
                                    @error('province') <small>{{ $message }}</small> @enderror
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
                                    <span class="file-name">No file chosen</span>
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

                                    <span class="file-name">No file chosen</span>
                                </div>

                                @error('barangay_clearance')
                                    <small style="align-self: flex-end; color: red">{{ $message }}</small> 
                                @enderror
                            </div>
                            <div class="prg-mm-con">
                                <div class="prg-mm-group">
                                    <label for="name">Expertise <span>*</span></label>
                                    <input type="text" placeholder="" name="profession" value="{{ old('profession') }}" required autocomplete="off">
                                    @error('profession') <small>{{ $message }}</small> @enderror
                                </div>
                                <div class="prg-mm-group">
                                    <label for="lname">Years of experience <span>*</span></label>
                                    <input type="number" placeholder="" name="experience" value="{{ old('experience') }}" required autocomplete="off">
                                    @error('experience') <small style="align-self: flex-end">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="prg-mm-group">
                                <label for="password">Password</label>
                                <div class="prg-mm-group-pass">
                                    <input type="password" name="password" id="password" placeholder="" required autocomplete="current-password">
                                    <div class="show" id="show-pass">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15.58 11.9999C15.58 13.9799 13.98 15.5799 12 15.5799C10.02 15.5799 8.42004 13.9799 8.42004 11.9999C8.42004 10.0199 10.02 8.41992 12 8.41992C13.98 8.41992 15.58 10.0199 15.58 11.9999Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M12 20.2702C15.53 20.2702 18.82 18.1902 21.11 14.5902C22.01 13.1802 22.01 10.8102 21.11 9.40021C18.82 5.80021 15.53 3.72021 12 3.72021C8.46997 3.72021 5.17997 5.80021 2.88997 9.40021C1.98997 10.8102 1.98997 13.1802 2.88997 14.5902C5.17997 18.1902 8.46997 20.2702 12 20.2702Z" stroke="#1E1E1E" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                </div>
                                @error('password') <small>{{ $message }}</small> @enderror
                                {{-- <a href="#">Forget Password?</a> --}}
                            </div>
                            <div class="prg-mm-group">
                                <label for="password">Confirm Password</label>
                                <div class="prg-mm-group-pass">
                                    <input type="password" name="password_confirmation" id="password_conf" placeholder="" required autocomplete="current-password">
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
                        <p>
                            By signing up, you agree to our
                            <a href="{{ url('/privacy-policy') }}" target="_blank">Privacy Policy</a>.
                        </p>
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

            // Next → go to step 2
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
@endpush
