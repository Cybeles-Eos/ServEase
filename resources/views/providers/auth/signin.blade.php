@extends('providers.layouts.auth')

@section('content')
    <main class="provider-login">
        <section class="provider-login-main">
            <div class="provider-login-main__form">
                <div class="provider-login-main__form--head">
                    <h3>Start your journey </h3>                   
                </div>
                <form class="provider-login-main__form--fields">
                    <div class="plm-ff-group">
                        <label for="">Email Address</label>
                        <input type="text" placeholder="e. g. name@gmail.com" required autocomplete="off">
                    </div>

                    <button class="plm-ff-btn btn btn--tertiary" type="submit">Create Account</button>
                    <p class="plm-ff-cta">Already Have Account? <a href="{{url('provider/login')}}">Sign in</a></p>
                </form>
            </div>
            <div class="provider-login-main__image">
                <img src="{{asset('images/provider-auth-img.png')}}" alt="">
            </div>
        </section>
    </main>
@endsection
@push('extrascripts')
    
@endpush