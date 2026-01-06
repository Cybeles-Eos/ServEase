<div class="head-top">
    <section class="m-width m-padding">
        <a href="">
            <svg width="18" height="13" class="mr-1" viewBox="0 0 18 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.659 4.29271C17.7961 4.18776 18 4.28594 18 4.45182V11.375C18 12.2721 17.2441 13 16.3125 13H1.6875C0.755859 13 0 12.2721 0 11.375V4.45521C0 4.28594 0.200391 4.19115 0.341016 4.29609C1.12852 4.88516 2.17266 5.63333 5.75859 8.14193C6.50039 8.66328 7.75195 9.76016 9 9.75339C10.2551 9.76354 11.5312 8.64297 12.2449 8.14193C15.8309 5.63333 16.8715 4.88177 17.659 4.29271ZM9 8.66667C9.81563 8.68021 10.9898 7.67813 11.5805 7.2651C16.2457 4.00495 16.6008 3.72057 17.6766 2.90807C17.8805 2.75573 18 2.51875 18 2.26823V1.625C18 0.727865 17.2441 0 16.3125 0H1.6875C0.755859 0 0 0.727865 0 1.625V2.26823C0 2.51875 0.119531 2.75234 0.323437 2.90807C1.39922 3.71719 1.7543 4.00495 6.41953 7.2651C7.01016 7.67813 8.18437 8.68021 9 8.66667Z" fill="currentColor"/>
            </svg>
            servease@gmail.com
        </a>

        <a href="">
            <span>Support ServEase</span>
            
            <svg width="12" height="11" class="ml-1" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6.00049 0.909594C7.40986 -0.345144 9.58782 -0.303489 10.9454 1.04577C12.3029 2.39502 12.3496 4.5446 11.087 5.94661L5.99983 11L0.91281 5.94661C-0.349765 4.5446 -0.302569 2.39162 1.0544 1.04577C2.4129 -0.301614 4.58703 -0.347007 6.00049 0.909594Z" fill="currentColor"/>
            </svg>
        </a>
    </section>
</div>
<header class="header-desktop">
    <div class="header-main m-padding m-width">
        <div class="h-con-links">
            <a href="{{ url('/') }}"><img src="{{ asset('images/header-logo.svg') }}" alt=""></a>
            <div class="h-con-links__divider"></div>
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/about-us') }}">About us</a></li>
                <li><a href="{{ url('/contact') }}">Contact</a></li>
                <li>
                    <a href="{{ url('services') }}">
                        <svg width="14" height="17" viewBox="0 0 15 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.75 5.625C0.75 3.32725 0.75 2.17756 1.46419 1.46419C2.17756 0.75 3.32725 0.75 5.625 0.75H8.875C11.1728 0.75 12.3224 0.75 13.0358 1.46419C13.75 2.17756 13.75 3.32725 13.75 5.625V12.125C13.75 14.4228 13.75 15.5724 13.0358 16.2858C12.3224 17 11.1728 17 8.875 17H5.625C3.32725 17 2.17756 17 1.46419 16.2858C0.75 15.5724 0.75 14.4228 0.75 12.125V5.625Z" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M13.6671 12.125H3.91712C3.1615 12.125 2.78369 12.125 2.47331 12.2079C2.06 12.3187 1.68315 12.5364 1.38064 12.839C1.07814 13.1417 0.860634 13.5186 0.75 13.932" stroke="currentColor" stroke-width="1"/>
                            <path d="M4 4.8125H10.5M4 7.65625H8.0625" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Local Services
                    </a>
                </li>
            </ul>
        </div>
        <div class="h-cta-btns">
            <a href="{{ url('/login') }}" class="login--btn">Login</a>
            <a href="{{ url('/sign-in') }}" class="btn btn--tertiary">Sign up</a>
        </div>
    </div>
</header>
<header class="header-mobile">
    <div class="text-left">
        <a href="{{ url('/') }}">
            <img src="{{ asset('images/header-logo.svg') }}" alt="Logo">
        </a>
    </div>

    <div class=" text-right">
        <button class="hamburger-menu ">
            <div></div>
        </button>
    </div>
    <div class="main-mobile-menu">
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About us</a></li>
            <li><a href="#">Contact</a></li>
            <li>
                <a href="#">
                    <svg width="14" class="mr-1" height="17" viewBox="0 0 15 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.75 5.625C0.75 3.32725 0.75 2.17756 1.46419 1.46419C2.17756 0.75 3.32725 0.75 5.625 0.75H8.875C11.1728 0.75 12.3224 0.75 13.0358 1.46419C13.75 2.17756 13.75 3.32725 13.75 5.625V12.125C13.75 14.4228 13.75 15.5724 13.0358 16.2858C12.3224 17 11.1728 17 8.875 17H5.625C3.32725 17 2.17756 17 1.46419 16.2858C0.75 15.5724 0.75 14.4228 0.75 12.125V5.625Z" stroke="currentColor" stroke-width="1.5"/>
                        <path d="M13.6671 12.125H3.91712C3.1615 12.125 2.78369 12.125 2.47331 12.2079C2.06 12.3187 1.68315 12.5364 1.38064 12.839C1.07814 13.1417 0.860634 13.5186 0.75 13.932" stroke="currentColor" stroke-width="1"/>
                        <path d="M4 4.8125H10.5M4 7.65625H8.0625" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    Local Services
                </a>
            </li>
            <li>
                <a href="{{url('login')}}" class="btn btn--secondary">Login</a>
            </li>
            <li>
                <a href="#" class="btn btn--tertiary">Sign in</a>
            </li>
        </ul>
    </div>
</header>

@push('extrascripts')
<script>
    $(document).ready(function () {
        
        $('.hamburger-menu').on('click', function () {
            $('.main-mobile-menu').toggleClass('show-mob-men');
            $(this).toggleClass('hamburger-menu-active');
        });
    });
</script>
{{-- <script>
$(window).on('scroll', function () {
    const scrollTop = $(this).scrollTop();

    if (scrollTop >= 20) {
        $('.mobile-menu').css('padding-top', '0');
    } else if (scrollTop === 19) {
        $('.mobile-menu').css('padding-top', '70px');
    }
});
</script> --}}
@endpush