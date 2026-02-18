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

        width: 30px !important;
        height: 10px !important;

        padding: 6px 12px !important;

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
                            <label>Service Name</label>
                            <input type="text" name="title" value="{{ old('title') }}">
                            @error('title') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                        </div>

                        <div class="prg-mm-group">
                            <label>Slug</label>
                            <input type="text" name="slug" value="{{ old('slug') }}" required>
                            @error('slug') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                        </div>

                        <div class="prg-mm-group">
                            <label>Short Description</label>
                            <textarea name="description" rows="3">{{ old('description') }}</textarea>
                        </div>

                        <div class="prg-mm-group">
                            <label>Full Content</label>
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
                            <input type="number" step="0.01" name="price" value="{{ old('price') }}">
                            @error('price') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                        </div>

                        <div class="prg-mm-group">
                            <label>Banner Image</label>
                            <input type="file" name="image" id="serviceImage" accept="image/*" required />
                            @error('image') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
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
            maxFileSize: '2MB',
            labelIdle: '<span style="color: #53a3ed">Upload</span> or Drop your image',
        });
    </script>

@endpush