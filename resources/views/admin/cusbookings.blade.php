@extends('admin.layouts.auth')

{{-- Meta Section --}}
@section('title', 'Customer Servease Bookings')

{{-- Page Content --}}
@section('content')
    @include('admin.layouts.header')
    @include('admin.layouts.sidebar')

    <main class="main-dash-uix dash-sp customer--bookings">
        <h1>Customer Bookings</h1>

        @auth
            <h2>welcome {{ auth()->user()->name }}</h2>
        @endauth
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">logoout</button>
        </form>
    </main>

    
@endsection
@push('extrascripts')

@endpush