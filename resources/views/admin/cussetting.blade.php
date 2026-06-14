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
                        <input type="text"
                            name="phone_number"
                            value="{{ old('phone_number', $user->customer->phone_number ?? '') }}"
                            required
                            maxlength="11"
                            inputmode="numeric"
                            pattern="[0-9]{11}"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11)">
                        @error('phone_number') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                    </div>
                    {{-- <div class="cms-mm-group">
                        <label>Your Email Address <span>*</span></label>
                        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
                        @error('email') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                    </div> --}}
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
                            <input type="hidden" name="city" value="{{ old('city', $user->customer->city ?? '') }}" data-ph-city-value>
                            <div class="location-combobox" data-ph-combobox="city">
                                <input type="text" value="{{ old('city', $user->customer->city ?? '') }}" required autocomplete="off" data-ph-city>
                                <span class="location-combobox__arrow" aria-hidden="true"></span>
                                <div class="location-combobox__menu" data-ph-city-menu></div>
                            </div>
                            @error('city') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="cms-mm-group-con">
                        <div class="cms-mm-group">
                            <label>Barangay <span>*</span></label>
                            <input type="hidden" name="barangay" value="{{ old('barangay', $user->customer->barangay ?? '') }}" data-ph-barangay-value>
                            <div class="location-combobox" data-ph-combobox="barangay">
                                <input type="text" value="{{ old('barangay', $user->customer->barangay ?? '') }}" required autocomplete="off" data-ph-barangay>
                                <span class="location-combobox__arrow" aria-hidden="true"></span>
                                <div class="location-combobox__menu" data-ph-barangay-menu></div>
                            </div>
                            @error('barangay') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                        </div>

                        <div class="cms-mm-group">
                            <label>Zipcode <span>*</span></label>
                            <input 
                                type="text"
                                name="zipcode"
                                value="{{ old('zipcode', $user->customer->zipcode ?? '') }}"
                                required
                                maxlength="4"
                                inputmode="numeric"
                                pattern="[0-9]{4}"
                                title="ZIP Code must be 4 digits"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4)"
                            >
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
        document.addEventListener('DOMContentLoaded', function () {
            const cityInput = document.querySelector('[data-ph-city]');
            const cityValue = document.querySelector('[data-ph-city-value]');
            const cityMenu = document.querySelector('[data-ph-city-menu]');
            const barangayInput = document.querySelector('[data-ph-barangay]');
            const barangayValue = document.querySelector('[data-ph-barangay-value]');
            const barangayMenu = document.querySelector('[data-ph-barangay-menu]');
            const psgcBaseUrl = 'https://psgc.gitlab.io/api';
            let cityRecords = [];
            let barangayRecords = [];
            let selectedCityCode = null;

            function recordLabel(record) {
                return [record.name, record.provinceName || record.districtName || record.regionName].filter(Boolean).join(', ');
            }

            function renderMenu(menu, records, onSelect) {
                if (!menu) return;
                menu.innerHTML = '';

                if (!records.length) {
                    const empty = document.createElement('div');
                    empty.className = 'location-combobox__empty';
                    empty.textContent = 'No results found';
                    menu.appendChild(empty);
                    return;
                }

                records.slice(0, 80).forEach((record) => {
                    const option = document.createElement('button');
                    option.type = 'button';
                    option.className = 'location-combobox__option';
                    option.textContent = recordLabel(record);
                    option.addEventListener('click', function () {
                        onSelect(record);
                    });
                    menu.appendChild(option);
                });
            }

            function filterRecords(records, term) {
                const normalizedTerm = term.trim().toLowerCase();
                return normalizedTerm
                    ? records.filter((record) => recordLabel(record).toLowerCase().includes(normalizedTerm))
                    : records;
            }

            function openCombo(input) {
                input?.closest('.location-combobox')?.classList.add('is-open');
            }

            function closeCombos() {
                document.querySelectorAll('.location-combobox.is-open').forEach((combo) => combo.classList.remove('is-open'));
            }

            function resolveCityFromInput() {
                const typedCity = cityInput.value.trim().toLowerCase();
                if (!typedCity) return null;

                const exactLabel = cityRecords.find((record) => recordLabel(record).toLowerCase() === typedCity);
                if (exactLabel) return exactLabel;

                const exactNameMatches = cityRecords.filter((record) => record.name.toLowerCase() === typedCity);
                return exactNameMatches.length === 1 ? exactNameMatches[0] : null;
            }

            function selectCity(record) {
                selectedCityCode = record.code;
                cityInput.value = recordLabel(record);
                cityValue.value = record.name;
                barangayInput.value = '';
                barangayValue.value = '';
                closeCombos();
                loadBarangays();
            }

            function selectBarangay(record) {
                barangayInput.value = record.name;
                barangayValue.value = record.name;
                closeCombos();
            }

            function loadBarangays() {
                if (!selectedCityCode || !barangayMenu) {
                    barangayRecords = [];
                    renderMenu(barangayMenu, [], selectBarangay);
                    return;
                }

                fetch(`${psgcBaseUrl}/cities-municipalities/${selectedCityCode}/barangays/`)
                    .then((response) => response.ok ? response.json() : [])
                    .then((records) => {
                        barangayRecords = records;
                        renderMenu(barangayMenu, filterRecords(barangayRecords, barangayInput.value), selectBarangay);
                    })
                    .catch(() => {
                        barangayRecords = [];
                        renderMenu(barangayMenu, [], selectBarangay);
                    });
            }

            if (cityInput && cityValue && cityMenu && barangayInput && barangayValue && barangayMenu) {
                fetch(`${psgcBaseUrl}/cities-municipalities/`)
                    .then((response) => response.ok ? response.json() : [])
                    .then((records) => {
                        cityRecords = records;
                        renderMenu(cityMenu, filterRecords(cityRecords, cityInput.value), selectCity);
                        const city = resolveCityFromInput();
                        selectedCityCode = city?.code || null;
                        loadBarangays();
                    })
                    .catch(() => {
                        cityRecords = [];
                        renderMenu(cityMenu, [], selectCity);
                    });

                cityInput.addEventListener('focus', function () {
                    renderMenu(cityMenu, filterRecords(cityRecords, cityInput.value), selectCity);
                    openCombo(cityInput);
                });

                cityInput.addEventListener('input', function () {
                    const exactCity = resolveCityFromInput();
                    selectedCityCode = exactCity?.code || null;
                    cityValue.value = exactCity ? exactCity.name : cityInput.value;
                    renderMenu(cityMenu, filterRecords(cityRecords, cityInput.value), selectCity);
                    openCombo(cityInput);
                    barangayInput.value = '';
                    barangayValue.value = '';

                    if (selectedCityCode) {
                        loadBarangays();
                    } else {
                        barangayRecords = [];
                        renderMenu(barangayMenu, [], selectBarangay);
                    }
                });

                barangayInput.addEventListener('focus', function () {
                    renderMenu(barangayMenu, filterRecords(barangayRecords, barangayInput.value), selectBarangay);
                    openCombo(barangayInput);
                });

                barangayInput.addEventListener('input', function () {
                    barangayValue.value = barangayInput.value;
                    renderMenu(barangayMenu, filterRecords(barangayRecords, barangayInput.value), selectBarangay);
                    openCombo(barangayInput);
                });

                document.addEventListener('click', function (event) {
                    if (!event.target.closest('.location-combobox')) {
                        closeCombos();
                    }
                });
            }
        });

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
