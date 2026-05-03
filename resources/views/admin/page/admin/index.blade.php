@extends('admin.layouts.auth')

{{-- Meta Section --}}
@section('title', 'Customer Servease Dashboard')

{{-- Page Content --}}
@section('content')
    @include('admin.layouts.header')
    {{-- @include('admin.layouts.sidebar') --}}

    <main class="main-dash-uix dash-sp customer--dash">

        <h1>Admin</h1>
    </main>


    {{-- Only Show When Someone is login --}}
@endsection
@push('extrascripts')

@endpush