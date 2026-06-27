<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'ServEase | Hire Verified Local Services in Brgy. Batasan Hills')</title>

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
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script> --}}
    {{-- Css Styles --}}
    <link rel="stylesheet" href="{{ asset('css/reset.custom.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome-free-5.8.1-web/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('extrastylesheets')
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    @include('front.layouts.sections.header')

    @yield('content')

    @include('front.layouts.sections.footer')

    <script>
        var sBaseURI = '{{ url('/') }}';
    </script>
    <script>
        // Initialize Lenis
        // const lenis = new Lenis({
        //     autoRaf: true,
        // });
        
    </script>
    <!-- Modal -->
    <div class="modal-mobile-nav g-padding">
        <ul>
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/about-us') }}">About Us</a></li>
            <li><a href="{{ url('/contact') }}">Contact</a></li>
            <li>
                <a href="{{ url('/services') }}">
                    <svg width="14" class="me-1" height="17" viewBox="0 0 15 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.75 5.625C0.75 3.32725 0.75 2.17756 1.46419 1.46419C2.17756 0.75 3.32725 0.75 5.625 0.75H8.875C11.1728 0.75 12.3224 0.75 13.0358 1.46419C13.75 2.17756 13.75 3.32725 13.75 5.625V12.125C13.75 14.4228 13.75 15.5724 13.0358 16.2858C12.3224 17 11.1728 17 8.875 17H5.625C3.32725 17 2.17756 17 1.46419 16.2858C0.75 15.5724 0.75 14.4228 0.75 12.125V5.625Z" stroke="currentColor" stroke-width="1.5"/>
                        <path d="M13.6671 12.125H3.91712C3.1615 12.125 2.78369 12.125 2.47331 12.2079C2.06 12.3187 1.68315 12.5364 1.38064 12.839C1.07814 13.1417 0.860634 13.5186 0.75 13.932" stroke="currentColor" stroke-width="1"/>
                        <path d="M4 4.8125H10.5M4 7.65625H8.0625" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    Local Services
                </a>
            </li>
            @auth
                @if(auth()->user()->isAdmin() || (auth()->user()->isProvider() && auth()->user()->provider?->application_status === 'accepted'))
                    <li><a href="{{ route('customer-requests.index') }}">Customer Request</a></li>
                @endif
            @endauth

            @guest
                <a href="{{ route('login') }}" class="a-mnav-m-link">
                    Login
                </a>
                <a href="{{ route('signup') }}" class="a-mnav-m-link a-mnav-m-link__bg">
                    Sign up
                </a>
            @endguest
            @auth
                @if(auth()->user()->isProvider())
                    {{-- {{ route('provider.dashboard') }} --}}
                    <a href="{{url('provider/dashboard')}}" class="a-mnav-m-link">
                        Dashboard
                    </a>

                    <form method="POST" action="{{ route('logout') }}" style="width: 100% !important ">
                        @csrf
                        <button type="submit" class="btn btn--tertiary mt-2" style="width: 100% !important; border-radius: 66px; color: #171515;">
                            Logout
                        </button>
                    </form>
                @endif
            @endauth
            @auth
                @if(auth()->user()->isCustomer())
                    {{-- {{ route('customer.dashboard') }} --}}
                    <a href="{{url('/customer/dashboard')}}" class="a-mnav-m-link">
                        Dashboard
                    </a>

                    <form method="POST" action="{{ route('logout') }}" style="width: 100% !important ">
                        @csrf
                        <button type="submit" class="btn btn--tertiary mt-2" style="width: 100% !important; border-radius: 66px; color: #171515;">
                            Logout
                        </button>
                    </form>
                @endif
            @endauth
            @auth
                @if(auth()->user()->isAdmin())
                    {{-- {{ route('customer.dashboard') }} --}}
                    <a href="{{url('/admin/dashboard')}}" class="a-mnav-m-link">
                        Dashboard
                    </a>

                    <form method="POST" action="{{ route('logout') }}" style="width: 100% !important ">
                        @csrf
                        <button type="submit" class="btn btn--tertiary mt-2" style="width: 100% !important; border-radius: 66px; color: #171515;">
                            Logout
                        </button>
                    </form>
                @endif
            @endauth
        </ul>


    </div>
    <!-- Modal -->
    {{-- Scripts --}}
    <script src="https://unpkg.com/lenis@1.3.15/dist/lenis.min.js"></script> 
    {{-- <script src="{{asset('js/modernizr.min.js')}}"></script> --}}
    {{-- <script src="{{ asset('js/modernizr-custom.js') }}"></script> --}}
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('js/slick.min.js') }}"></script>
    {{-- <script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script> --}}
    <script src="{{ asset('js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('js/popper.min.js') }}"></script> --}}
    <script src="{{ asset('js/main.js') }}"></script>
    @stack('extrascripts')
    @if(session('flash_message'))
        <script>
            Swal.fire({
                icon: '{{ session("flash_message.type") }}',
                title: '{{ session("flash_message.title") }}',
                text: '{{ session("flash_message.message") }}',
                confirmButtonColor: '#FDB932'
            });
        </script>
    @endif
</body>
</html>
