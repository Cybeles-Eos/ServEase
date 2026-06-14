@extends('admin.layouts.auth')

@section('title', 'Edit User')

@push('extrastylesheets')
    <style>
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
        .admin-user-password-fields {
            display: none;
        }
        .admin-user-password-fields.is-visible {
            display: block;
        }
        .provserv-c-head{
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        h5{
            margin-top: 0px !important;
        }
    </style>
    <style>
        .back-adm-edit{
            padding: 3px 8px;
            background-color: #171515;   
            margin: 0;  font-size: 12px;
            font-weight: 700;
            border-radius: 3px;
            text-decoration: none !important;
            color: #fff !important;
        }
        .back-adm-edit:hover{
            opacity: .9;
        }
        .back-adm-edit a{
            color: #fff !important;
            text-decoration: none !important;
        }
    </style>
@endpush

@section('content')
    @include('admin.layouts.header')

    @php
        $profile = $user->role === 'customer' ? $user->customer : $user->provider;
        $showPasswordFields = old('change_password') == '1'
            || $errors->has('password')
            || $errors->has('password_confirmation');
    @endphp

    <main class="main-dash-uix provider--create dash-sp">
        <div class="provider--create__main">
            <div class="provserv-c-head">
                <h4>Edit user — {{ ucfirst($user->role) }}</h4>
                <p class="back-adm-edit"><a href="{{ route('admin.users') }}">Go Back</a></p>
            </div>
            <div class="provserv-c-body">
                <div class="provserv-c-body--fields">
                    <form id="admin-user-edit-form" action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        @if ($user->role === 'customer')
                            <h5 style="margin: 1rem 0 .5rem;">Customer profile</h5>
                            <div class="prg-mm-group">
                                <label>First name <span>*</span></label>
                                <input type="text" name="first_name" value="{{ old('first_name', $profile?->first_name) }}">
                                @error('first_name') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>Last name <span>*</span></label>
                                <input type="text" name="last_name" value="{{ old('last_name', $profile?->last_name) }}">
                                @error('last_name') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>Phone</label>
                                <input type="text" name="phone_number" value="{{ old('phone_number', $profile?->phone_number) }}">
                                @error('phone_number') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>Street address</label>
                                <input type="text" name="street_address" value="{{ old('street_address', $profile?->street_address) }}">
                                @error('street_address') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>City</label>
                                <input type="text" name="city" value="{{ old('city', $profile?->city) }}">
                                @error('city') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>Barangay</label>
                                <input type="text" name="barangay" value="{{ old('barangay', $profile?->barangay) }}">
                                @error('barangay') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>Zip code</label>
                                <input type="text" name="zipcode" value="{{ old('zipcode', $profile?->zipcode) }}" inputmode="numeric" pattern="[0-9]{4}" maxlength="4" title="ZIP Code must be 4 digits" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4)">
                                @error('zipcode') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                        @else
                            <h5 style="margin: 1rem 0 .5rem;">Provider profile</h5>
                            <div class="prg-mm-group">
                                <label>First name <span>*</span></label>
                                <input type="text" name="first_name" value="{{ old('first_name', $profile?->first_name) }}">
                                @error('first_name') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>Last name <span>*</span></label>
                                <input type="text" name="last_name" value="{{ old('last_name', $profile?->last_name) }}">
                                @error('last_name') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>Phone <span>*</span></label>
                                <input type="text" name="phone_number" value="{{ old('phone_number', $profile?->phone_number) }}">
                                @error('phone_number') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>Home address <span>*</span></label>
                                <input type="text" name="home_address" value="{{ old('home_address', $profile?->home_address) }}">
                                @error('home_address') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>City <span>*</span></label>
                                <input type="text" name="city" value="{{ old('city', $profile?->city ?? $profile?->province) }}">
                                @error('city') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>Barangay</label>
                                <input type="text" name="barangay" value="{{ old('barangay', $profile?->barangay) }}">
                                @error('barangay') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>Zip code <span>*</span></label>
                                <input type="text" name="zipcode" value="{{ old('zipcode', $profile?->zipcode) }}" inputmode="numeric" pattern="[0-9]{4}" maxlength="4" title="ZIP Code must be 4 digits" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4)">
                                @error('zipcode') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>Profession <span>*</span></label>
                                <input type="text" name="profession" value="{{ old('profession', $profile?->profession) }}">
                                @error('profession') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>Years experience <span>*</span></label>
                                <input type="number" name="year_exp" min="1" max="100" value="{{ old('year_exp', $profile?->year_exp ?? 1) }}">
                                @error('year_exp') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                        @endif
                            <br>
                        <hr>

                        <div class="prg-mm-group">
                            <label>Role</label>
                            <input type="text" value="{{ ucfirst($user->role) }}" disabled style="opacity: .7;">
                        </div>

                        <div class="prg-mm-group">
                            <label>Account name <span>*</span></label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                        </div>

                        <div class="prg-mm-group">
                            <label>Email <span>*</span></label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                        </div>

                        <div class="prg-mm-group">
                            <label>Account active?</label>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <label class="switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active ? '1' : '0') == '1' ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            @error('is_active')
                                <small style="align-self: flex-end; color: red">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="prg-mm-group">
                            <label>Change password?</label>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <label class="switch">
                                    <input type="hidden" name="change_password" value="0">
                                    <input type="checkbox" name="change_password" value="1" id="admin-user-change-password-toggle" {{ $showPasswordFields ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            @error('change_password')
                                <small style="align-self: flex-end; color: red">{{ $message }}</small>
                            @enderror
                        </div>

                        <div id="admin-user-password-fields" class="admin-user-password-fields {{ $showPasswordFields ? 'is-visible' : '' }}">
                            <div class="prg-mm-group">
                                <label>New password <span>*</span></label>
                                <input type="password" name="password" autocomplete="new-password" placeholder="Minimum 8 characters">
                                @error('password') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>Confirm new password <span>*</span></label>
                                <input type="password" name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>

                        <button type="submit" style="align-self: flex-end; margin-top: 12px;" class="btn btn--primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('extrascripts')
<script>
(function () {
    var form = document.getElementById('admin-user-edit-form');
    var toggle = document.getElementById('admin-user-change-password-toggle');
    var wrap = document.getElementById('admin-user-password-fields');
    if (!form || !toggle || !wrap) return;

    var inputs = wrap.querySelectorAll('input[type="password"]');

    function sync() {
        var on = toggle.checked;
        wrap.classList.toggle('is-visible', on);
        inputs.forEach(function (el) {
            el.disabled = !on;
        });
    }

    toggle.addEventListener('change', sync);
    form.addEventListener('submit', sync);
    sync();
})();
</script>
@endpush
