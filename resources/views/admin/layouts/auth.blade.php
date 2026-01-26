<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Login Your ServEase Account')</title>


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

    {{-- Css Styles --}}
    <link rel="stylesheet" href="{{ asset('css/reset.custom.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome-free-5.8.1-web/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('extrastylesheets')

    {{-- Scripts --}}
    <script src="https://unpkg.com/lenis@1.3.15/dist/lenis.min.js"></script> 
    {{-- <script src="{{asset('js/modernizr.min.js')}}"></script> --}}
    <script src="{{ asset('js/modernizr-custom.js') }}"></script>
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('js/slick.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>
    {{-- @include('admin.layouts.header')
    @include('admin.layouts.sidebar') --}}
    @yield('content')

    @stack('extrascripts')
</body>
</html>