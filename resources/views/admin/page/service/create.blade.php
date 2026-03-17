@extends('admin.layouts.auth')

{{-- Meta Section --}}
@section('title', 'Servease Dashboard')

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


        .switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
            position: absolute;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            inset: 0;
            background-color: #ccc;
            transition: .3s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            top: 3px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
        }

        .switch input:checked + .slider {
            background-color: #FFBE42;
        }

        .switch input:checked + .slider:before {
            transform: translateX(24px);
        }


    </style>
@endpush

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
                    <form action="{{ route('provider.service.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="prg-mm-group">
                            <label>Service Name <span>*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}">
                            @error('title') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                        </div>

                        <div class="prg-mm-group">
                            <label>Slug <span>*</span></label>
                            <input type="text" name="slug" id="slug" value="{{ old('slug') }}" required>
                            @error('slug') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                        </div>

                        <div class="prg-mm-group">
                            <label>Short Description <span>*</span></label>
                            <textarea name="description" rows="3">{{ old('description') }}</textarea>
                        </div>

                        <div class="prg-mm-group">
                            <label>Full Content <span>*</span></label>
                            <textarea name="content" rows="6">{{ old('content') }}</textarea>
                        </div>

                        <div class="prg-mm-group">
                            <label for="lname">Service Category</label>
                            <div class="provserv-c-body--fields--dropdowns">
                                <select name="category" class="provserv-c-body--fields--dropdowns--sort" id="">
                                    <option value="">-- Choose Category --</option>
                                    <option value="Plumber">Plumber</option>
                                    <option value="Electrician">Electrician</option>
                                    <option value="Vendor">Vendor</option>
                                </select>
                                <svg width="7" height="4" viewBox="0 0 7 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.5 0.5L3.5 3.5L6.5 0.5" stroke="#282828" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            @error('category') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                        </div>

                        <div class="prg-mm-group">
                            <label>Specialization</label>
                            <input type="text" name="specialization" value="{{ old('specialization') }}">
                        </div>

                        <div class="prg-mm-group">
                            <label>Price</label>
                            <input type="number" step="0.01" min="0" max="100000" name="price" value="{{ old('price') }}">
                            @error('price') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                        </div>

                        <div class="prg-mm-group">
                            <label>Banner Image<small>(5MB max)</small></label>
                            <input type="file" name="image" id="serviceImage" accept="image/*" />
                            @error('image') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                        </div>


                        <div class="prg-mm-group">
                            <label>Is Active?</label>

                            <div style="display: flex; align-items: center; gap: 12px;">
                                <label class="switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) == 1 ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </div>

                            @error('is_active')
                                <small style="align-self: flex-end; color: red">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" style="align-self: flex-end;" class="btn btn--primary">Create Service</button>
                    </form>


                </div>
            </div>
        </div>
    </main>
    
@endsection
@push('extrascripts')

    <script>
        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginFileValidateType,
            FilePondPluginFileValidateSize
        );

        const pond = FilePond.create(document.querySelector('#serviceImage'), {
            allowMultiple: false,
            maxFiles: 1,
            storeAsFile: true, 
            acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp'],
            maxFileSize: '5MB',
            labelIdle: '<span style="color: #53a3ed">Upload</span> or Drop your image',
        });

        
    </script>

    <script>
        (function() {
            var titleInput = document.getElementById('title');
            var slugInput = document.getElementById('slug');

            if (!titleInput || !slugInput) {
                return;
            }

            var slugTouched = slugInput.value.trim() !== '';

            function slugify(text) {
                return text.toString().toLowerCase().trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
            }

            slugInput.addEventListener('input', function() {
                slugTouched = slugInput.value.trim() !== '';
            });

            titleInput.addEventListener('input', function() {
                if (!slugTouched || slugInput.value.trim() === '') {
                    slugInput.value = slugify(titleInput.value);
                }
            });
        })();
    </script>

@endpush