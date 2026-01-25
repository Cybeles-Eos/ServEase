@extends('admin.layouts.auth')

{{-- Meta Section --}}
@section('title', 'Servease Dashboard')


@section('content')
    @include('admin.layouts.header')
    @include('admin.layouts.sidebar')

    <main class="provider--dashboard dash-sp">
        <div class="provider--dashboard__head">
            @auth
                <p>Hello {{ auth()->user()->name }}, manage you bookings today!</p>
            @endauth
        </div>
        {{-- <h3>Provider Dashboard</h3> --}}

        {{-- Only Show When Someone is login --}}

    </main>

    
@endsection