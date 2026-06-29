@extends('admin.layouts.auth')

@section('content')
@include('front.layouts.sections.header')
    <style>
        .provider-login .password-strength-minimal {
            width: 100%;
            margin-top: 8px;
        }

        .provider-login .password-strength-minimal__bar {
            width: 100%;
            height: 4px;
            background: #eef0f3;
            border-radius: 999px;
            overflow: hidden;
        }

        .provider-login .password-strength-minimal__bar span {
            display: block;
            width: 0%;
            height: 100%;
            border-radius: 999px;
            background: #d93025;
            transition: all 0.2s ease;
        }

        .provider-login .password-strength-minimal__text {
            margin: 6px 0 0;
            font-size: 11px;
            line-height: 1.3;
            color: #98a2b3;
        }

        .provider-login .password-strength-minimal__text strong {
            font-weight: 600;
        }

        .provider-login .password-strength-minimal.is-low .password-strength-minimal__bar span {
            width: 33%;
            background: #d93025;
        }

        .provider-login .password-strength-minimal.is-low .password-strength-minimal__text strong {
            color: #d93025;
        }

        .provider-login .password-strength-minimal.is-medium .password-strength-minimal__bar span {
            width: 66%;
            background: #f59e0b;
        }

        .provider-login .password-strength-minimal.is-medium .password-strength-minimal__text strong {
            color: #f59e0b;
        }

        .provider-login .password-strength-minimal.is-strong .password-strength-minimal__bar span {
            width: 100%;
            background: #16a34a;
        }

        .provider-login .password-strength-minimal.is-strong .password-strength-minimal__text strong {
            color: #16a34a;
        }
    </style>
    <style>
        .provider-login .plm-ff-group-pass {
            width: 100%;
            position: relative;
        }

        .provider-login .plm-ff-group-pass input {
            padding-right: 42px;
        }

        .provider-login .plm-ff-group-pass .show {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .main-sidebar-uix{
            display: none;
        }
    </style>

    <main class="provider-login">
        <section class="provider-login-main" style="margin-bottom: 0rem">
            <div class="provider-login-main__form">
                <div class="provider-login-main__form--head">
                    <h3>Create New Password</h3>
                    <p>Your new password must be strong and secure.</p>
                </div>

                <form method="POST" action="{{ route('password.reset.update') }}" class="provider-login-main__form--fields">
                    @csrf

                    <div class="plm-ff-group">
                        <label for="password">New Password</label>

                        <div class="plm-ff-group-pass">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                placeholder="Enter new password"
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

                    <div class="plm-ff-group">
                        <label for="password_conf">Confirm New Password</label>

                        <div class="plm-ff-group-pass">
                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_conf"
                                placeholder="Confirm new password"
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

                    <button class="plm-ff-btn btn btn--tertiary" type="submit">
                        Update Password
                    </button>
                </form>
            </div>

            <div class="provider-login-main__image">
                <img src="{{ asset('images/provider-auth-img.webp') }}" alt="">
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
        });
    </script>
    <script>
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

        function setupPasswordToggle(buttonId, inputId) {
            const button = document.getElementById(buttonId);
            const input = document.getElementById(inputId);

            if (!button || !input) return;

            button.addEventListener('click', function () {
                if (input.type === 'password') {
                    input.type = 'text';
                    button.innerHTML = showSvg;
                } else {
                    input.type = 'password';
                    button.innerHTML = hideSvg;
                }
            });
        }

        setupPasswordToggle('show-pass', 'password');
        setupPasswordToggle('show-pass-conf', 'password_conf');
    </script>
@endsection