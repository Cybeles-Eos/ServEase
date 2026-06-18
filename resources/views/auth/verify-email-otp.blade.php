<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verify Email OTP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Meta's --}}
    <meta property="og:title" content="ServEase | Hire Verified Local Services in Brgy. Batasan Hills" />
    <meta property="og:description" content="ServEase helps you find and hire verified local service providers in Barangay Batasan Hills. You post requests, review services, and connect with trusted workers in one secure platform." />
    <meta property="og:image" content="{{ asset('images/meta-cover.png') }}" />
    <meta property="og:url" content="/" />
    <meta property="og:type" content="website" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="ServEase | Hire Verified Local Services in Brgy. Batasan Hills" />
    <meta name="twitter:description" content="You find trusted local services faster with ServEase. Hire verified workers, post service needs, and manage bookings securely within your barangay." />
    <meta name="twitter:image" content="{{ asset('images/meta-cover.png') }}" />

    {{-- Icons --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/icons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/icons/web-app-manifest-512x512.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/icons/web-app-manifest-192x192.png') }}">
    <link rel="manifest" href="{{ asset('images/icons/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('images/icons/favicon.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #FFBE42;
            --primary-dark: #e5a72f;
            --text: #1f2933;
            --muted: #6b7280;
            --border: #e5e7eb;
            --bg: #f7f4ec;
            --white: #ffffff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        .otp-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .otp-shell {
            width: 100%;
            max-width: 1040px;
            min-height: 620px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: var(--white);
            border-radius: 26px;
            overflow: hidden;
            box-shadow: 0 24px 70px rgba(31, 41, 51, 0.12);
        }

        .otp-visual {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
            background:
                radial-gradient(circle at 20% 20%, rgba(255, 190, 66, 0.35), transparent 30%),
                linear-gradient(135deg, #fff8e8 0%, #f9eed2 100%);
        }

        .otp-visual__image {
            width: 100%;
            max-width: 380px;
            min-height: 420px;
            border: 2px dashed rgba(31, 41, 51, 0.16);
            border-radius: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(31, 41, 51, 0.45);
            font-size: 14px;
            text-align: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.45);
        }

        .otp-visual__caption {
            position: absolute;
            left: 48px;
            right: 48px;
            bottom: 42px;
            text-align: center;
        }

        .otp-visual__caption h2 {
            margin: 0 0 8px;
            font-size: 22px;
            line-height: 1.25;
        }

        .otp-visual__caption p {
            margin: 0;
            font-size: 14px;
            line-height: 1.6;
            color: var(--muted);
        }

        .otp-content {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 56px;
        }

        .otp-card {
            width: 100%;
            max-width: 420px;
        }

        .otp-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 38px;
            font-weight: 700;
            font-size: 22px;
            color: var(--text);
        }
        .otp-logo img{
            max-width: 110px;
        }

        .otp-logo__mark {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #111827;
            font-weight: 800;
        }

        .otp-card h1 {
            margin: 0 0 12px;
            font-size: 28px;
            line-height: 1.2;
            color: var(--text);
        }

        .otp-card p {
            margin: 0;
            color: var(--muted);
            line-height: 1.6;
            font-size: 15px;
        }

        .otp-email {
            margin-top: 10px;
            color: var(--text);
            font-weight: 700;
            font-size: 14px;
        }

        .otp-form {
            margin-top: 30px;
        }

        .otp-boxes {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 10px;
            margin-bottom: 18px;
        }

        .otp-box {
            width: 100%;
            height: 54px;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            text-align: center;
            font-size: 22px;
            font-weight: 700;
            color: var(--text);
            outline: none;
            background: #ffffff;
            transition: 0.2s ease;
        }

        .otp-box:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(255, 190, 66, 0.22);
        }

        .otp-btn {
            width: 100%;
            height: 45px;
            margin-top: 8px;
            border: 0;
            border-radius: 12px;
            background: var(--primary);
            color: #111827;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .otp-btn:hover {
            background: var(--primary-dark);
        }

        .otp-resend {
            margin-top: 18px;
            text-align: center;
            font-size: 14px;
            color: var(--muted);
        }

        .otp-resend form {
            display: inline;
        }

        .otp-link-btn {
            border: 0;
            background: transparent;
            color: #111827;
            cursor: pointer;
            font-size: 14px;
            font-weight: 700;
            padding: 0;
            text-decoration: underline;
            text-decoration-color: var(--primary);
            text-underline-offset: 4px;
        }

        .alert-error {
            background: #fff1f1;
            color: #b00020;
            padding: 12px 14px;
            border-radius: 12px;
            margin: 20px 0 0;
            font-size: 14px;
            border: 1px solid #ffd4d4;
        }

        .alert-success {
            background: #ecfdf3;
            color: #166534;
            padding: 12px 14px;
            border-radius: 12px;
            margin: 20px 0 0;
            font-size: 14px;
            border: 1px solid #bbf7d0;
        }

        @media (max-width: 900px) {
            .otp-shell {
                grid-template-columns: 1fr;
                max-width: 520px;
            }

            .otp-visual {
                min-height: 280px;
                padding: 32px;
            }

            .otp-visual__image {
                min-height: 180px;
                max-width: 100%;
            }

            .otp-visual__caption {
                position: static;
                margin-top: 24px;
            }

            .otp-content {
                padding: 36px 24px;
            }
        }

        @media (max-width: 480px) {
            .otp-page {
                padding: 14px;
            }

            .otp-shell {
                border-radius: 18px;
            }

            .otp-card h1 {
                font-size: 26px;
            }

            .otp-boxes {
                gap: 7px;
            }

            .otp-box {
                height: 48px;
                border-radius: 10px;
                font-size: 18px;
            }

            .otp-logo {
                margin-bottom: 26px;
            }
        }
    </style>
</head>
<body>

<div class="otp-page">
    <div class="otp-shell">

        <div class="otp-visual">
            <div>
                {{-- <div class="otp-visual__image">
                    <img src="" alt="">
                </div> --}}

                <div class="otp-visual__caption">
                    <h2>Book local services with confidence</h2>
                    <p>
                        Verify your email to complete your Servease registration.
                    </p>
                </div>
            </div>
        </div>

        <div class="otp-content">
            <div class="otp-card">
                <div class="otp-logo">
                    <img src="{{ asset('images/new-logo-d.png') }}" alt="">
                </div>

                <h1>Enter OTP Code</h1>

                <p>
                    Please enter the 6-digit code sent to your registered email address.
                </p>

                @if (session('otp_email'))
                    <div class="otp-email">
                        {{ session('otp_email') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert-error">
                        {{ $errors->first() }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('otp.verify') }}" class="otp-form" id="otpForm">
                    @csrf

                    <div class="otp-boxes">
                        <input type="text" class="otp-box" maxlength="1" inputmode="numeric" autocomplete="one-time-code">
                        <input type="text" class="otp-box" maxlength="1" inputmode="numeric">
                        <input type="text" class="otp-box" maxlength="1" inputmode="numeric">
                        <input type="text" class="otp-box" maxlength="1" inputmode="numeric">
                        <input type="text" class="otp-box" maxlength="1" inputmode="numeric">
                        <input type="text" class="otp-box" maxlength="1" inputmode="numeric">
                    </div>

                    <input type="hidden" name="otp" id="otpValue">

                    <button type="submit" class="otp-btn">
                        Verify OTP
                    </button>
                </form>

                <div class="otp-resend">
                    Didn't receive it?
                    <form method="POST" action="{{ route('otp.resend') }}">
                        @csrf
                        <button type="submit" class="otp-link-btn">
                            Resend OTP
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    const otpBoxes = document.querySelectorAll('.otp-box');
    const otpValue = document.getElementById('otpValue');
    const otpForm = document.getElementById('otpForm');

    function updateOtpValue() {
        otpValue.value = Array.from(otpBoxes).map(input => input.value).join('');
    }

    function fillOtp(value) {
        const digits = value.replace(/\D/g, '').slice(0, otpBoxes.length);

        otpBoxes.forEach((input, index) => {
            input.value = digits[index] || '';
        });

        updateOtpValue();

        const nextIndex = Math.min(digits.length, otpBoxes.length - 1);
        otpBoxes[nextIndex].focus();
    }

    otpBoxes.forEach((input, index) => {
        input.addEventListener('input', (event) => {
            const value = event.target.value.replace(/\D/g, '');

            if (value.length > 1) {
                fillOtp(value);
                return;
            }

            event.target.value = value;
            updateOtpValue();

            if (value && index < otpBoxes.length - 1) {
                otpBoxes[index + 1].focus();
            }
        });

        input.addEventListener('keydown', (event) => {
            if (event.key === 'Backspace' && !input.value && index > 0) {
                otpBoxes[index - 1].focus();
            }
        });

        input.addEventListener('paste', (event) => {
            event.preventDefault();

            const pastedValue = event.clipboardData.getData('text');
            fillOtp(pastedValue);
        });
    });

    otpForm.addEventListener('submit', () => {
        updateOtpValue();
    });

    if (otpBoxes.length) {
        otpBoxes[0].focus();
    }
</script>

</body>
</html>