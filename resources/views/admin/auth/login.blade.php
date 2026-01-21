@extends('admin.layouts.auth')

{{-- Meta Section --}}
@section('title', 'Servease Login Page - ')


@section('content')
    <main class="provider-login">
        <section class="provider-login-main">
            <div class="provider-login-main__form">
                <img src="{{asset('images/new-logo-d.png')}}" class="provider-login-main__form__logo" alt="logo">
                <div class="provider-login-main__form--head">
                    <h3>Let’s Get You Back In</h3>
                    <p>Enter your credentials to access your account</p>                    
                </div>
                <form method="POST" action="{{route('login.post')}}" class="provider-login-main__form--fields">
                    @csrf
                    <div class="plm-ff-group">
                        <label for="">Email Address</label>
                        <input type="text" name="email" placeholder="e. g. name@gmail.com" value="{{ old('email') }}" required autocomplete="off">
                        @error('email') <small>{{ $message }}</small> @enderror
                    </div>
                    <div class="plm-ff-group">
                        <label for="">Password</label>
                        <div class="plm-ff-group-pass">
                            <input type="password" name="password" id="password" placeholder="e. g. name@gmail.com" required autocomplete="current-password">
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
                    <button class="plm-ff-btn btn btn--tertiary" type="submit">Login</button>
                    <p class="plm-ff-cta">Don't have account yet? <a href="{{url('signup')}}">Join now</a></p>
                </form>
            </div>
            <div class="provider-login-main__image">
                <img src="{{asset('images/provider-auth-img.png')}}" alt="">
            </div>
        </section>
    </main>
@endsection
@push('extrascripts')
    <script>
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

        });
    </script>
 
    
@endpush