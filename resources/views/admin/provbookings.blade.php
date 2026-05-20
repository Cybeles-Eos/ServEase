@extends('admin.layouts.auth')

{{-- Meta Section --}}
@section('title', 'Provider Bookings - Servease')

{{-- Page Content --}}
@section('content')
    @include('admin.layouts.header')
    

    <main class="main-dash-uix provider--bookings dash-sp">
        <div class="provider--bookings__head">
            <h3>Pending Site Bookings</h3>
            <p>Review and manage your booking request</p>
        </div>

        <livewire:provider-bookings-board />
    </main>     
    <script>
        console.log(@json($bookRequests));
    </script>
    <script>console.log({{ auth()->user()->provider->id }});</script>
@endsection
@push('extrascripts')

@endpush