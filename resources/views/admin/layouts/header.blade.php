<div class="header--dashboard">

    {{-- <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-sm">logout</button>
    </form> --}}
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
        </div>
    </div>
</div>