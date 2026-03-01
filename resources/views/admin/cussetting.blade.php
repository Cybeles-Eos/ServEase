@extends('admin.layouts.auth')

{{-- Meta Section --}}
@section('title', 'Customer Servease Dashboard')

{{-- Page Content --}}
@section('content')
    @include('admin.layouts.header')
    @include('admin.layouts.sidebar')

    <main class="main-dash-uix dash-sp customer--setting">
        <div class="customer--setting--main">
            <div class="csm-left">
                <h4>Edit personal information</h4>
                <p class="csm-left__p">Information that was taken from your resume is noted with a tag pulled from resume. The rest fo the information is already part of your profile.</p>
            </div>
            <div class="csm-right">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div style="width: 100%; height: 150px;"></div>

                     

                        <div class="cms-mm-group-con">
                            <div class="cms-mm-group">
                                <label>First Name</label>
                                <input type="text" name="fname" value="{{ old('fname') }}">
                                @error('fname') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>

                            <div class="cms-mm-group">
                                <label>Last Name</label>
                                <input type="text" name="lname" value="{{ old('lname') }}" required>
                                @error('lname') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="cms-mm-group">
                            <label>Phone Number</label>
                            <input type="number" name="phone" value="{{ old('phone') }}">
                            @error('phone') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                        </div>

                        <div class="cms-mm-group">
                            <label>Your Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}">
                            @error('email') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                        </div>


                        <button type="submit" style="align-self: flex-end;" class="btn btn--primary">Save</button>
                    </form>
            </div>
        </div>



    </main>


    {{-- Only Show When Someone is login --}}

    
@endsection
@push('extrascripts')

@endpush