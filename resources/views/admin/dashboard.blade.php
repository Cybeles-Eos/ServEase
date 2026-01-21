@extends('admin.layouts.auth')

{{-- Meta Section --}}
@section('title', 'Servease Dashboard')


@section('content')
    <h1>Admin Dashboard</h1>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">logoout</button>
    </form>
@endsection