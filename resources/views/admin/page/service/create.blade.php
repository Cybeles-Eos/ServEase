@extends('admin.layouts.auth')

{{-- Meta Section --}}
@section('title', 'Servease Dashboard')


@section('content')
    @include('admin.layouts.header')
    @include('admin.layouts.sidebar')

    <main class="main-dash-uix provider--create dash-sp">
        <div class="provider--create__main">
            <div class="provserv-c-head">
                <h4>Service Create</h4>
            </div>
            <div class="provserv-c-body">
                <div class="provserv-c-body--fields">

                    <div class="prg-mm-group">
                        <label for="lname">Service Name</label>
                        <input type="text" placeholder="e. g. Cruz" name="lname" value="{{ old('lname') }}" required autocomplete="off">
                        @error('lname') <small style="align-self: flex-end">{{ $message }}</small> @enderror
                    </div>
                    <div class="prg-mm-group">
                        <label for="lname">Slug</label>
                        <input type="text" placeholder="e. g. Cruz" name="lname" value="{{ old('lname') }}" required autocomplete="off">
                        @error('lname') <small style="align-self: flex-end">{{ $message }}</small> @enderror
                    </div>
                    <div class="prg-mm-group">
                        <label for="lname">Slug</label>
                        <input type="text" placeholder="e. g. Cruz" name="lname" value="{{ old('lname') }}" required autocomplete="off">
                        @error('lname') <small style="align-self: flex-end">{{ $message }}</small> @enderror
                    </div>

                    <div class="prg-mm-group">
                        <label for="lname">Service Category</label>
                        <div class="provserv-c-body--fields--dropdowns">
                            <select name="" class="provserv-c-body--fields--dropdowns--sort" id="">
                                <option value="" style="color: red !important">Status</option>
                                <option value="">Pending</option>
                                <option value="">Confirmed</option>
                                <option value="">Cancelled</option>
                            </select>
                            <svg width="7" height="4" viewBox="0 0 7 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.5 0.5L3.5 3.5L6.5 0.5" stroke="#282828" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
    
@endsection
@push('extrascripts')


@endpush