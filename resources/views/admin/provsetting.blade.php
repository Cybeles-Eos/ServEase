@extends('admin.layouts.auth')

{{-- Meta Section --}}
@section('title', 'Provider Servease Dashboard')
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
    @include('admin.layouts.sidebar')

    <main class="main-dash-uix dash-sp provider--setting">
        <form action="{{ route('provider.setting.update') }}" class="provider--setting--main" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="csm-left">
                <h4>Edit personal information</h4>
                <p class="csm-left__p">Information that was taken from your resume is noted with a tag pulled from resume. The rest fo the information is already part of your profile.</p>
                
                <br>
                <div class="cms-mm-group-con">
                    <div class="cms-mm-group">
                        <label>Professions</label>
                        <input type="text" name="profession" value="{{ old('profession', $user->provider->profession ?? '') }}" required>
                        @error('profession') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                    </div>

                    <div class="cms-mm-group">
                        <label>Years of Experience</label>
                        <input type="text" name="year_exp" value="{{ old('year_exp', $user->provider->year_exp ?? '') }}" required>
                        @error('year_exp') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>
            <div class="csm-right">
                <div class="">
                        <label>Profile Image <span>*</span> <small>(2MB max)</small></label>
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
                        <input type="file" name="profile_image" id="profile" accept="image/*" required/>
                        @error('profile_image') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                </div>

                <div class="cms-mm-group-con">
                    <div class="cms-mm-group">
                        <label>First Name <span>*</span></label>
                        <input type="text" name="first_name" value="{{ old('first_name', $user->provider->first_name ?? '') }}" required>
                        @error('first_name') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                    </div>

                    <div class="cms-mm-group">
                        <label>Last Name <span>*</span></label>
                        <input type="text" name="last_name" value="{{ old('last_name', $user->provider->last_name ?? '') }}" required>
                        @error('last_name') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="cms-mm-group">
                    <label>Phone Number <span>*</span></label>
                    <input type="number" name="phone_number" value="{{ old('phone_number', $user->provider->phone_number ?? '') }}" required>
                    @error('phone_number') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                </div>
                <div class="cms-mm-group">
                    <label>Your Email Address <span>*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
                    @error('email') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                </div>
                <div class="cms-mm-group">
                    <label>Personal Email Address For Booking</label>
                    <input type="email" name="personal_email" value="{{ old('personal_email', $user->provider->personal_email ?? '') }}">
                    @error('personal_email') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                </div>
                <br>
                <h5>Personal Home Address</h5>
                <div class="cms-mm-group-con">
                    <div class="cms-mm-group">
                        <label>Home Address <span>*</span></label>
                        <input type="text" name="home_address" value="{{ old('home_address', $user->provider->home_address ?? '') }}">
                        @error('home_address') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                    </div>

                    <div class="cms-mm-group">
                        <label>Province <span>*</span></label>
                        <input type="text" name="province" value="{{ old('province', $user->provider->province ?? '') }}" required>
                        @error('province') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="cms-mm-group-con">
                    <div class="cms-mm-group">
                        <label>Barangay <span>*</span></label>
                        <input type="text" name="barangay" value="{{ old('barangay', $user->provider->barangay ?? '') }}" required>
                        @error('barangay') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                    </div>

                    <div class="cms-mm-group">
                        <label>Zipcode <span>*</span></label>
                        <input type="text" name="zipcode" value="{{ old('zipcode', $user->provider->zipcode ?? '') }}" required>
                        @error('zipcode') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                    </div>
                </div>



                <button type="submit" style="align-self: flex-end;" class="btn btn--primary">Save</button>
            </div>
        </form>
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
        const existingImage = @json(!empty($user->provider->profile_image) ? asset($user->provider->profile_image) : null);

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