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
    <meta property="og:image" content="{{ asset('public/images/meta-cover.png') }}" />
    <meta property="og:url" content="/" />
    <meta property="og:type" content="website" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="ServEase | Hire Verified Local Services in Brgy. Batasan Hills" />
    <meta name="twitter:description" content="You find trusted local services faster with ServEase. Hire verified workers, post service needs, and manage bookings securely within your barangay." />
    <meta name="twitter:image" content="{{ asset('public/images/meta-cover.png') }}" />

    {{-- Icons --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('public/images/icons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('public/images/icons/web-app-manifest-512x512.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('public/images/icons/web-app-manifest-192x192.png') }}">
    <link rel="manifest" href="{{ asset('public/images/icons/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('public/images/icons/favicon.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script> --}}
    {{-- Css Styles --}}
    <link rel="stylesheet" href="{{ asset('public/css/reset.custom.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/fontawesome-free-5.8.1-web/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/bootstrap/bootstrap.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('public/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/app.css') }}">
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
            {{-- <li><a href="{{ url('/about-us') }}">About Us</a></li>
            <li><a href="{{ url('/contact') }}">Contact</a></li> --}}
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
            {{-- <a href="contact.html " class="a-mnav-m-link">
                Get In Touch
                <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.82287e-06 9C6.82287e-06 4.0293 4.02931 0 9 0C13.9707 0 18 4.0293 18 9C18 13.9707 13.9707 18 9 18H6.82287e-06L2.63611 15.3639C1.79918 14.5291 1.13545 13.5371 0.683068 12.445C0.230682 11.3529 -0.00145088 10.1821 6.82287e-06 9ZM4.34521 16.2H9C10.424 16.2 11.8161 15.7777 13.0001 14.9866C14.1841 14.1954 15.107 13.0709 15.6519 11.7553C16.1969 10.4397 16.3395 8.99201 16.0617 7.59535C15.7838 6.19869 15.0981 4.91577 14.0912 3.90883C13.0842 2.90189 11.8013 2.21616 10.4047 1.93835C9.00799 1.66053 7.56031 1.80312 6.24468 2.34807C4.92906 2.89302 3.80457 3.81586 3.01342 4.99989C2.22228 6.18393 1.80001 7.57597 1.80001 9C1.80001 10.9368 2.56591 12.7485 3.90871 14.0913L5.1813 15.3639L4.34521 16.2ZM5.4 9.9H12.6C12.6 10.8548 12.2207 11.7705 11.5456 12.4456C10.8705 13.1207 9.95478 13.5 9 13.5C8.04522 13.5 7.12955 13.1207 6.45442 12.4456C5.77929 11.7705 5.4 10.8548 5.4 9.9Z" fill="currentColor"/>
                </svg>
            </a> --}}
        </ul>


    </div>
    <!-- Modal -->
    {{-- Scripts --}}
    <script src="https://unpkg.com/lenis@1.3.15/dist/lenis.min.js"></script> 
    {{-- <script src="{{asset('js/modernizr.min.js')}}"></script> --}}
    {{-- <script src="{{ asset('js/modernizr-custom.js') }}"></script> --}}
    <script src="{{ asset('public/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('public/js/slick.min.js') }}"></script>
    {{-- <script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script> --}}
    <script src="{{ asset('public/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('js/popper.min.js') }}"></script> --}}
    <script src="{{ asset('public/js/main.js') }}"></script>
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