@extends('admin.layouts.auth')

{{-- Meta Section --}}
@section('title', 'Customer Servease Dashboard')
@push('extrastylesheets')
    <style>
        .filepond--root {
            font-family: inherit;
        }

        .filepond--panel-root {
            background-color: #ffffff !important;
            border: 2px dashed #ddd;
        }

        .filepond--drop-label {
            color: #666;
        }

        .filepond--file {
            background: #f9f9f9 !important;
        }

        .filepond--file-action-button {
            background-color: #ff4d4f !important;
            color: #fff !important;
        }

        .filepond--image-preview-overlay {
            background: transparent !important;
        }
        /* Remove weird red oval background */
        .filepond--file-action-button {
            background: transparent !important;
            box-shadow: none !important;
        }

        /* Style remove button */
        /* Remove default circular look */
        .filepond--file-action-button {
            background: none !important;
            box-shadow: none !important;
        }

        /* Style remove as real button */
        .filepond--action-remove-item {
            position: absolute !important;
            top: 10px !important;
            right: 10px !important;

            width: 20px !important;
            height: 3px !important;

            padding: 1.5px 6px !important;

            background-color: #ff0004 !important;
            color: #fff !important;

            border-radius: 6px !important;
            border: none !important;

            font-size: 13px !important;
            font-weight: 500 !important;
        }

        /* Hide default icon */
        .filepond--action-remove-item svg {
            display: none !important;
        }

        /* Add text instead */
        .filepond--action-remove-item::after {
            content: "Remove";
        }

    </style>
@endpush
{{-- Page Content --}}
@section('content')
    @include('admin.layouts.header')
    {{-- @include('admin.layouts.sidebar') --}}

    <main class="main-dash-uix dash-sp customer--setting">
        <div class="customer--setting--main">
            <div class="csm-left">
                <h4>Edit personal information</h4>
                <p class="csm-left__p">Information that was taken from your resume is noted with a tag pulled from resume. The rest fo the information is already part of your profile.</p>
            </div>
            <div class="csm-right">
                <form action="{{ route('customer.setting.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- <div style="width: 100%; height: 150px;"></div> --}}

                    {{-- <div class="position-relative d-inline-block">
                        <!-- Avatar Preview -->
                        <div id="avatarPreview"
                            class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                            style="width:120px;height:120px;font-size:40px;
                            background-color:#f39c12;overflow:hidden;">

                            @if($user->image)
                                <img src="{{ asset($user->image) }}"
                                    class="w-100 h-100 object-fit-cover rounded-circle">
                            @else
                                {{ strtoupper(substr($user->first_name,0,1)) }}
                                {{ strtoupper(substr($user->last_name,0,1)) }}
                            @endif
                        </div>

                        <!-- Upload Button -->
                        <label for="imageUpload"
                            class="position-absolute bottom-0 end-0 bg-white rounded-circle p-2 shadow"
                            style="cursor:pointer;">
                            <i class="fa fa-pen text-dark"></i>
                        </label>

                        <input type="file" id="imageUpload" name="image" class="d-none" accept="image/*">
                    </div> --}}
                    <div class="">
                        <label>Profile Image<small>(2MB max)</small></label>
                        @push('extrastylesheets')
                            <style>
                                #profile{
                                    width: 160px !important; 
                                    /* height: 160px !important; */
                                    /* width: 150px !important; 
                                    border-radius: 50% !important;
                                    border: 2px solid #ddd !important; */
                                }
                                .filepond--drop-label label{
                                    font-size: 12px !important;
                                    opacity: 0.7 !important;
                                }
                            </style>
                        @endpush
                        <input type="hidden" name="remove_profile_image" id="remove_profile_image" value="0">
                        <input type="file" name="profile_image" id="profile" accept="image/*"/>
                        @error('profile_image') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                    </div>

                    <div class="cms-mm-group-con">
                        <div class="cms-mm-group">
                            <label>First Name <span>*</span></label>
                            <input type="text" name="first_name" value="{{ old('first_name', $user->customer->first_name ?? '') }}" required>
                            @error('first_name') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                        </div>

                        <div class="cms-mm-group">
                            <label>Last Name <span>*</span></label>
                            <input type="text" name="last_name" value="{{ old('last_name', $user->customer->last_name ?? '') }}" required>
                            @error('last_name') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="cms-mm-group">
                        <label>Phone Number <span>*</span></label>
                        <input type="number" name="phone_number" value="{{ old('phone_number', $user->customer->phone_number ?? '') }}" required>
                        @error('phone_number') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                    </div>
                    <div class="cms-mm-group">
                        <label>Your Email Address <span>*</span></label>
                        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
                        @error('email') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                    </div>
                    <br>
                    <h5>Permanent home address</h5>
                    <div class="cms-mm-group-con">
                        <div class="cms-mm-group">
                            <label>Street Address <span>*</span></label>
                            <input type="text" name="street_address" value="{{ old('street_address', $user->customer->street_address ?? '') }}" required>
                            @error('street_address') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                        </div>

                        <div class="cms-mm-group">
                            <label>City <span>*</span></label>
                            <input type="text" name="city" value="{{ old('city', $user->customer->city ?? '') }}" required>
                            @error('city') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="cms-mm-group-con">
                        <div class="cms-mm-group">
                            <label>Barangay <span>*</span></label>
                            <input type="text" name="barangay" value="{{ old('barangay', $user->customer->barangay ?? '') }}" required>
                            @error('barangay') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                        </div>

                        <div class="cms-mm-group">
                            <label>Zipcode <span>*</span></label>
                            <input type="text" name="zipcode" value="{{ old('zipcode', $user->customer->zipcode ?? '') }}" required>
                            @error('zipcode') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                        </div>
                    </div>



                    <button type="submit" style="align-self: flex-end;" class="btn btn--primary">Save</button>
                </form>
            </div>
        </div>



    </main>


    {{-- Only Show When Someone is login --}}

    
@endsection
@push('extrascripts')

    <script>
        // FilePond.registerPlugin(
        //     FilePondPluginImagePreview,
        //     FilePondPluginFileValidateType,
        //     FilePondPluginFileValidateSize
        // );

        // const pond = FilePond.create(document.querySelector('#profile'), {
        //     allowMultiple: false,
        //     maxFiles: 1,
        //     storeAsFile: true, 
        //     acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp'],
        //     maxFileSize: '2MB',
        //     labelIdle: '<i class="fas fa-edit"></i>',
        // });
        const existingImage = @json(!empty($user->customer->profile_image) 
            ? asset($user->customer->profile_image) 
            : null);

        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginFileValidateType,
            FilePondPluginFileValidateSize
        );

        const pond = FilePond.create(document.querySelector('#profile'), {
            allowMultiple: false,
            maxFiles: 1,
            storeAsFile: true,
            acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp'],
            maxFileSize: '2MB',
            labelIdle: '<i class="fas fa-edit"></i>',
            files: existingImage ? [
                {
                    source: existingImage,
                    options: { type: 'remote' }
                }
            ] : []
        });

        // 👇 Detect removal
        pond.on('removefile', function () {
            document.getElementById('remove_profile_image').value = "1";
        });
    </script>

@endpush