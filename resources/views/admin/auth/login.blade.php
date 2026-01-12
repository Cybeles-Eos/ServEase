@extends('admin.layouts.auth')

@section('content')
    <main class="login-page">
        <div class="login-page__bg"></div>
        <section class="login-page__main-form">
            {{-- <img src="{{asset('images/auth-logo.svg')}}" class="form-logo" alt="logo"> --}}
            <h3>ServEase Admin</h3>
            <form action="">
                <div class="input-group">
                    <label for="email">Email Address</label>
                    <input type="text" name="email" id="email" placeholder="e. g. name@gmail.com">
                </div>
                <div class="input-group">
                    <label for="email">Password</label>
                    <input type="password" name="password" id="password">
                    <a href="#" class="fp-a">Forgot Password?</a>
                </div>
                <div class="input-cta">
                    <button>Login</button>
                    <p>Don't have account yet? <a href="#">Join Now</a></p>
                </div>
            </form>
        </section>
    </main>
@endsection
@push('extrascripts')
    <script>

    </script>
@endpush