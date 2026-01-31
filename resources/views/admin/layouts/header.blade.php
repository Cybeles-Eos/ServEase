<div class="main-headerdash-uix header--dashboard">

    {{-- <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-sm">logout</button>
    </form> --}}
    <button class="hdb-a-menu" id="hdb-a-menu">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M9.75 4.5C9.75 3.257 10.757 2.25 12 2.25C13.243 2.25 14.25 3.257 14.25 4.5C14.25 5.743 13.243 6.75 12 6.75C10.757 6.75 9.75 5.743 9.75 4.5ZM9.75 12C9.75 10.757 10.757 9.75 12 9.75C13.243 9.75 14.25 10.757 14.25 12C14.25 13.243 13.243 14.25 12 14.25C10.757 14.25 9.75 13.243 9.75 12ZM12 21.75C10.757 21.75 9.75 20.743 9.75 19.5C9.75 18.257 10.757 17.25 12 17.25C13.243 17.25 14.25 18.257 14.25 19.5C14.25 20.743 13.243 21.75 12 21.75ZM12 5.25C12.414 5.25 12.75 4.914 12.75 4.5C12.75 4.086 12.414 3.75 12 3.75C11.586 3.75 11.25 4.086 11.25 4.5C11.25 4.914 11.586 5.25 12 5.25ZM12 12.75C12.414 12.75 12.75 12.414 12.75 12C12.75 11.586 12.414 11.25 12 11.25C11.586 11.25 11.25 11.586 11.25 12C11.25 12.414 11.586 12.75 12 12.75ZM11.25 19.5C11.25 19.914 11.586 20.25 12 20.25C12.414 20.25 12.75 19.914 12.75 19.5C12.75 19.086 12.414 18.75 12 18.75C11.586 18.75 11.25 19.086 11.25 19.5Z" fill="currentColor"/>
        </svg>
    </button>
    <div class="header--dashboard__profile">
        <div class="header--dashboard__profile--info">
             <div>
                <button id="phd-inbox">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 6L7.18477 9.13358C9.0962 10.2888 9.9038 10.2888 11.8152 9.13358L17 6" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                        <path d="M2.01183 11.6284C2.06085 13.9727 2.08537 15.1447 2.93372 16.0131C3.78206 16.8813 4.96274 16.9115 7.32412 16.972C8.77947 17.0093 10.2205 17.0093 11.6759 16.972C14.0373 16.9115 15.2179 16.8813 16.0663 16.0131C16.9146 15.1447 16.9392 13.9727 16.9881 11.6284C17.004 10.8746 17.004 10.1254 16.9881 9.3716C16.9392 7.02736 16.9146 5.85525 16.0663 4.98698C15.2179 4.11871 14.0373 4.08846 11.6759 4.02797C10.2205 3.99068 8.77947 3.99068 7.32411 4.02796C4.96274 4.08845 3.78206 4.11869 2.93371 4.98697C2.08536 5.85524 2.06085 7.02736 2.01182 9.3716C1.99606 10.1254 1.99606 10.8746 2.01183 11.6284Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                    </svg>
                </button>
             </div>
             <div>
                <button id="phd-notif">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13 15C13 16.6569 11.6569 18 10 18C8.34314 18 7 16.6569 7 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M15.6242 15H4.37579C3.61596 15 3 14.3868 3 13.6305C3 13.2674 3.14495 12.919 3.40296 12.6622L3.87214 12.1952C4.30972 11.7596 4.55556 11.1688 4.55556 10.5529V8.41935C4.55556 5.42633 6.99312 3 10 3C13.0069 3 15.4444 5.42632 15.4444 8.41935V10.5529C15.4444 11.1688 15.6903 11.7596 16.1279 12.1952L16.597 12.6622C16.855 12.919 17 13.2674 17 13.6305C17 14.3868 16.384 15 15.6242 15Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
             </div>
        </div>
        <div class="header--dashboard__profile--img">
            <img src="{{asset('images/user.png')}}" alt="user_profile">
            <button id="btn-menu">
                <svg class="menu-icon" width="10" height="9" viewBox="0 0 5 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0.449219 0.450195L2.44922 2.4502L4.44922 0.450195" stroke="black" stroke-width="0.9" stroke-linecap="round"/>
                </svg>
            </button>
        </div>
    </div>
</div>
<div id="user-menu">
    <ul>
        {{-- <li><a href="{{ route('admin.profile') }}">Profile</a></li> --}}
        <div>
            <p>{{ auth()->user()->name }}</p>
        </div>

        {{-- <li><a href="">Profile Setting</a></li> --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <svg width="12" height="13" class="mr-1" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.58333 1.66669H5.75992C6.86942 1.66669 7.42417 1.66669 7.76833 2.00852C7.96083 2.19869 8.046 2.45419 8.08333 2.83336M4.58333 11H5.75992C6.86942 11 7.42417 11 7.76833 10.6582C7.96083 10.468 8.046 10.2125 8.08333 9.83336M10.4167 6.33336H6.33333M9.54167 4.87502C9.54167 4.87502 11 5.94836 11 6.33336C11 6.71836 9.54167 7.79169 9.54167 7.79169M0.72925 1.66669C0.5 2.0266 0.5 2.49094 0.5 3.41902V9.24886C0.5 10.1769 0.5 10.6413 0.72925 11C0.770083 11.0642 0.815778 11.1249 0.866333 11.182C1.14808 11.5005 1.59492 11.6283 2.488 11.8832C3.38225 12.1387 3.82967 12.2664 4.154 12.0751C4.21015 12.0418 4.26239 12.0022 4.30975 11.9573C4.58333 11.6977 4.58333 11.2334 4.58333 10.3018V2.36494C4.58333 1.43394 4.58333 0.969022 4.30975 0.710022C4.26239 0.665055 4.21015 0.625531 4.154 0.592188C3.83025 0.400855 3.38225 0.528022 2.48742 0.784105C1.59492 1.03902 1.14808 1.16677 0.86575 1.48527C0.81558 1.54229 0.769941 1.60256 0.72925 1.66669Z" stroke="#D74646" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Logout
            </button>
        </form>

    </ul>
</div>
@push('extrascripts')
    <script>
        $(document).ready(function () {
            $('#btn-menu').on('click', function (e) {
                e.stopPropagation();

                $('#user-menu').toggleClass('is-open');
                $('.menu-icon').toggleClass('is-rotated'); // 👈 rotate SVG
            });

            // click outside to close
            $(document).on('click', function () {
                $('#user-menu').removeClass('is-open');
                $('.menu-icon').removeClass('is-rotated'); // reset rotation
            });

            // prevent closing when clicking inside menu
            $('#user-menu').on('click', function (e) {
                e.stopPropagation();
            });
        });
    </script>
@endpush