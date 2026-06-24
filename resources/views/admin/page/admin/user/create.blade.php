@extends('admin.layouts.auth')

@section('title', 'Create User')

@push('extrastylesheets')
    <style>
        .admin-user-form-role-panel { display: none; }
        .admin-user-form-role-panel.is-visible { display: block; }

        .provserv-c-head{
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
    </style>
@endpush

@section('content')
    @include('admin.layouts.header')

    <main class="main-dash-uix provider--create dash-sp">
        <div class="provider--create__main">
            <div class="provserv-c-head">
                <h4>Create user</h4>
                <p style="margin: 0; opacity: .65; font-size: 14px;"><a href="{{ route('admin.users') }}">← Back</a></p>
            </div>
            <div class="provserv-c-body">
                <div class="provserv-c-body--fields">
                    <form id="admin-user-create-form" action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        <div class="prg-mm-group">
                            <label>Role <span>*</span></label>
                            <div class="provserv-c-body--fields--dropdowns">
                                <select name="role" id="admin-user-role" class="provserv-c-body--fields--dropdowns--sort" required>
                                    <option value="">— Choose —</option>
                                    <option value="customer" {{ old('role') === 'customer' ? 'selected' : '' }}>Customer</option>
                                    <option value="provider" {{ old('role') === 'provider' ? 'selected' : '' }}>Provider</option>
                                </select>
                                <svg width="7" height="4" viewBox="0 0 7 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.5 0.5L3.5 3.5L6.5 0.5" stroke="#282828" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            @error('role') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                        </div>

                        <div class="prg-mm-group">
                            <label>Account name <span>*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required>
                            @error('name') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                        </div>

                        <div class="prg-mm-group">
                            <label>Email <span>*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required>
                            @error('email') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                        </div>

                        <div class="prg-mm-group">
                            <label>Password <span>*</span></label>
                            <input type="password" name="password" autocomplete="new-password" required>
                            @error('password') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                        </div>

                        <div class="prg-mm-group">
                            <label>Confirm password <span>*</span></label>
                            <input type="password" name="password_confirmation" autocomplete="new-password" required>
                        </div>

                        <div id="panel-customer" class="admin-user-form-role-panel {{ old('role') === 'customer' ? 'is-visible' : '' }}">
                            <h5 style="margin: 1rem 0 .5rem;">Customer profile</h5>
                            <div class="prg-mm-group">
                                <label>First name <span>*</span></label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}">
                                @error('first_name') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>Last name <span>*</span></label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}">
                                @error('last_name') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>Phone</label>
                                <input type="text" name="phone_number" value="{{ old('phone_number') }}">
                                @error('phone_number') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>Gender <span>*</span></label>
                                <div class="provserv-c-body--fields--dropdowns">
                                    <select name="gender" class="provserv-c-body--fields--dropdowns--sort">
                                        <option value="">Choose gender</option>
                                        <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="prefer_not_to_say" {{ old('gender') === 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                                    </select>
                                    <svg width="7" height="4" viewBox="0 0 7 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.5 0.5L3.5 3.5L6.5 0.5" stroke="#282828" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                @error('gender') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>Street address</label>
                                <input type="text" name="street_address" value="{{ old('street_address') }}">
                                @error('street_address') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>City</label>
                                <input type="text" name="city" value="{{ old('city') }}">
                                @error('city') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>Barangay</label>
                                <input type="text" name="barangay" value="{{ old('barangay') }}">
                                @error('barangay') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>Zip code</label>
                                <input type="text" name="zipcode" value="{{ old('zipcode') }}" inputmode="numeric" pattern="[0-9]{4}" maxlength="4" title="ZIP Code must be 4 digits" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4)">
                                @error('zipcode') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div id="panel-provider" class="admin-user-form-role-panel {{ old('role') === 'provider' ? 'is-visible' : '' }}">
                            <h5 style="margin: 1rem 0 .5rem;">Provider profile</h5>
                            <div class="prg-mm-group">
                                <label>First name <span>*</span></label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}">
                                @error('first_name') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>Last name <span>*</span></label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}">
                                @error('last_name') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>Phone <span>*</span></label>
                                <input type="text" name="phone_number" value="{{ old('phone_number') }}">
                                @error('phone_number') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>Gender <span>*</span></label>
                                <div class="provserv-c-body--fields--dropdowns">
                                    <select name="gender" class="provserv-c-body--fields--dropdowns--sort">
                                        <option value="">Choose gender</option>
                                        <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="prefer_not_to_say" {{ old('gender') === 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                                    </select>
                                    <svg width="7" height="4" viewBox="0 0 7 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.5 0.5L3.5 3.5L6.5 0.5" stroke="#282828" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                @error('gender') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>Home address <span>*</span></label>
                                <input type="text" name="home_address" value="{{ old('home_address') }}">
                                @error('home_address') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>City <span>*</span></label>
                                <input type="text" name="city" value="{{ old('city') }}">
                                @error('city') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>Barangay</label>
                                <input type="text" name="barangay" value="{{ old('barangay') }}">
                                @error('barangay') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>Zip code <span>*</span></label>
                                <input type="text" name="zipcode" value="{{ old('zipcode') }}" inputmode="numeric" pattern="[0-9]{4}" maxlength="4" title="ZIP Code must be 4 digits" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4)">
                                @error('zipcode') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>Profession <span>*</span></label>
                                <input type="text" name="profession" value="{{ old('profession') }}">
                                @error('profession') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                            <div class="prg-mm-group">
                                <label>Years experience <span>*</span></label>
                                <input type="number" name="year_exp" min="1" max="100" value="{{ old('year_exp', 1) }}">
                                @error('year_exp') <small style="align-self: flex-end; color: red">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <button type="submit" style="align-self: flex-end; margin-top: 12px;" class="btn btn--primary">Create user</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('extrascripts')
<script>
(function () {
    var form = document.getElementById('admin-user-create-form');
    var role = document.getElementById('admin-user-role');
    var panelCustomer = document.getElementById('panel-customer');
    var panelProvider = document.getElementById('panel-provider');

    function setPanelInputsDisabled(panel, disabled) {
        panel.querySelectorAll('input, select, textarea').forEach(function (el) {
            el.disabled = disabled;
        });
    }

    function sync() {
        var v = role.value;
        panelCustomer.classList.toggle('is-visible', v === 'customer');
        panelProvider.classList.toggle('is-visible', v === 'provider');
        setPanelInputsDisabled(panelCustomer, v !== 'customer');
        setPanelInputsDisabled(panelProvider, v !== 'provider');
    }

    role.addEventListener('change', sync);
    form.addEventListener('submit', sync);
    sync();
})();
</script>
@endpush
