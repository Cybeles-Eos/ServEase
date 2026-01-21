@extends('admin.layouts.auth')

{{-- Meta Section --}}
@section('title', 'Servease Dashboard')


@section('content')
    <h1>Provider Dashboard</h1>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">logoout</button>
    </form>

    {{-- Only Show When Someone is login --}}
    @auth
        <h2>welcome {{ auth()->user()->name }}</h2>
    @endauth
    
@endsection