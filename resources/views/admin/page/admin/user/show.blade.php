@extends('admin.layouts.auth')

@section('title', 'User profile')

@push('extrastylesheets')
    <style>
        .admin-user-show {
            max-width: 920px;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
            position: relative;
            padding: 24px 16px 40px;
        }
        .admin-user-show__back {
            display: inline-block;
            margin-bottom: 20px;
            font-size: 14px;
            /* color: #282828; */
            opacity: .7;
            position: absolute;
            left: 16px;
            top: 0
            
        }
        .admin-user-show__avatar {
            
            width: 140px;
            height: 140px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #E0E2E7;
            margin: 0 auto 16px;
            display: block;
            background: #f5f5f5;

            margin-top: 25px;
        }
        .admin-user-show__avatar--initials {
            user-select: none;
            background-color: #FDB932;
            border-color: #E0E2E7;
            display: flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
        }
        .admin-user-show__avatar--initials span {
            color: #fff;
            margin: 0;
            font-size: 52px;
            font-weight: 600;
            line-height: 1;
            letter-spacing: 0.03em;
        }
        .admin-user-show__name {
            font-size: 1.5rem;
            font-weight: 600;
            color: #282828;
            margin: 0 0 6px;
        }
        .admin-user-show__role {
            display: inline-block;
            font-size: 13px;
            font-weight: 500;
            padding: 4px 12px;
            border-radius: 999px;
            background: #FFBE42;
            color: #282828;
            margin-bottom: 20px;
        }
        .admin-user-show__card {
            text-align: left;
            background: #fff;
            border: 1px solid #E0E2E7;
            border-radius: 8px;
            padding: 20px 22px;
            margin-top: 12px;
        }
        .admin-user-show__card h5 {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: #535353;
            margin: 0 0 14px;
            padding-bottom: 10px;
            border-bottom: 1px solid #EEF0F3;
        }
        .admin-user-show__row {
            display: grid;
            grid-template-columns: 140px 1fr;
            gap: 8px 16px;
            font-size: 13px;
            padding: 8px 0;
            border-bottom: 1px solid #F5F7FA;
        }
        .admin-user-show__row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
        .admin-user-show__label {
            color: #888;
            font-weight: 500;
        }
        .admin-user-show__value {
            color: #282828;
            word-break: break-word;
        }
        .admin-user-show__actions {
            margin-top: 24px;
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }
        @media (max-width: 520px) {
            .admin-user-show {
                padding-inline: 0;
            }
            .admin-user-show__row {
                grid-template-columns: 1fr;
                gap: 4px;
            }
            .admin-user-show__label {
                font-size: 11px;
            }
        }
        .show-user-d-main{
            widows: 100%;
            display: flex;
            /* align-items: center; */
            justify-content: center;
            gap: 20px;
        }
        @media (max-width: 992px){
            .admin-user-show {
                max-width: 620px;
            }
            .show-user-d-main{
                flex-direction: column;
            }
        }
    </style>
@endpush

@section('content')
    @include('admin.layouts.header')

    @php
        $profile = $user->role === 'customer' ? $user->customer : $user->provider;
        $displayName = $profile
            ? trim(implode(' ', array_filter([$profile->first_name ?? null, $profile->last_name ?? null])))
            : '';
        $displayName = $displayName !== '' ? $displayName : $user->name;

        // Same initials logic as admin header (customer/provider vs account name)
        if ($user->role === 'customer' && $user->customer) {
            $fname = explode(' ', (string) ($user->customer->first_name ?? ''))[0] ?? '';
            $lname = explode(' ', (string) ($user->customer->last_name ?? ''))[0] ?? '';
        } elseif ($user->role === 'provider' && $user->provider) {
            $fname = explode(' ', (string) ($user->provider->first_name ?? ''))[0] ?? '';
            $lname = explode(' ', (string) ($user->provider->last_name ?? ''))[0] ?? '';
        } else {
            $fullname = explode(' ', $user->name);
            $fname = $fullname[0] ?? '';
            $lname = $fullname[1] ?? '';
        }

        $avatarInitials = strtoupper(substr($fname, 0, 1) . substr($lname, 0, 1));

        $profileImage = $profile?->profile_image ?? null;
        $avatarImgSrc = null;
        if ($profileImage) {
            if (str_starts_with($profileImage, 'http://') || str_starts_with($profileImage, 'https://')) {
                $avatarImgSrc = $profileImage;
            } else {
                $avatarImgSrc = asset(ltrim($profileImage, '/'));
            }
        }

        $detail = function (?string $value): string {
            return ($value !== null && trim($value) !== '') ? trim($value) : '—';
        };
    @endphp

    <main class="main-dash-uix page-admin-users dash-sp">
        <div class="admin-user-show">
            {{-- <a href="{{ route('admin.users') }}" class="admin-user-show__back">← Go back</a> --}}
            {{-- <a href="{{ route('admin.users') }}" class="service-review-admin__back">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M15 18L9 12L15 6"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"/>
                </svg>
                Go Back
            </a> --}}
            @if ($avatarImgSrc)
                <img src="{{ $avatarImgSrc }}" alt="" class="admin-user-show__avatar" width="140" height="140">
            @else
                <div class="admin-user-show__avatar admin-user-show__avatar--initials" role="img" aria-label="{{ $displayName }}">
                    <span>{{ $avatarInitials !== '' ? $avatarInitials : strtoupper(substr((string) $user->name, 0, 2)) }}</span>
                </div>
            @endif

            <h1 class="admin-user-show__name">{{ $displayName }}</h1>
            <span class="admin-user-show__role">{{ ucfirst($user->role) }}</span>
            <div class="show-user-d-main">

                <div class="admin-user-show__card">
                    <h5>Account</h5>
                    <div class="admin-user-show__row">
                        <span class="admin-user-show__label">Login email</span>
                        <span class="admin-user-show__value">{{ $detail($user->email) }}</span>
                    </div>
                    <div class="admin-user-show__row">
                        <span class="admin-user-show__label">Account name</span>
                        <span class="admin-user-show__value">{{ $detail($user->name) }}</span>
                    </div>
                    <div class="admin-user-show__row">
                        <span class="admin-user-show__label">Status</span>
                        <span class="admin-user-show__value">{{ $user->is_active ? 'Active' : 'Disabled' }}</span>
                    </div>
                    <div class="admin-user-show__row">
                        <span class="admin-user-show__label">Joined</span>
                        <span class="admin-user-show__value">{{ $user->created_at?->format('M j, Y \a\t g:i A') ?? '—' }}</span>
                    </div>
                    <div class="admin-user-show__row">
                        <span class="admin-user-show__label">Last updated</span>
                        <span class="admin-user-show__value">{{ $user->updated_at?->format('M j, Y \a\t g:i A') ?? '—' }}</span>
                    </div>
                </div>

                @if ($user->role === 'customer' && $profile)
                    <div class="admin-user-show__card">
                        <h5>Customer profile</h5>
                        <div class="admin-user-show__row">
                            <span class="admin-user-show__label">First name</span>
                            <span class="admin-user-show__value">{{ $detail($profile->first_name) }}</span>
                        </div>
                        <div class="admin-user-show__row">
                            <span class="admin-user-show__label">Last name</span>
                            <span class="admin-user-show__value">{{ $detail($profile->last_name) }}</span>
                        </div>
                        <div class="admin-user-show__row">
                            <span class="admin-user-show__label">Phone</span>
                            <span class="admin-user-show__value">{{ $detail($profile->phone_number) }}</span>
                        </div>
                        <div class="admin-user-show__row">
                            <span class="admin-user-show__label">Personal email</span>
                            <span class="admin-user-show__value">{{ $detail($profile->personal_email) }}</span>
                        </div>
                        <div class="admin-user-show__row">
                            <span class="admin-user-show__label">Street address</span>
                            <span class="admin-user-show__value">{{ $detail($profile->street_address) }}</span>
                        </div>
                        <div class="admin-user-show__row">
                            <span class="admin-user-show__label">City</span>
                            <span class="admin-user-show__value">{{ $detail($profile->city) }}</span>
                        </div>
                        <div class="admin-user-show__row">
                            <span class="admin-user-show__label">Barangay</span>
                            <span class="admin-user-show__value">{{ $detail($profile->barangay) }}</span>
                        </div>
                        <div class="admin-user-show__row">
                            <span class="admin-user-show__label">Zip code</span>
                            <span class="admin-user-show__value">{{ $detail($profile->zipcode) }}</span>
                        </div>
                    </div>
                @elseif ($user->role === 'provider' && $profile)
                    <div class="admin-user-show__card">
                        <h5>Provider profile</h5>
                        <div class="admin-user-show__row">
                            <span class="admin-user-show__label">First name</span>
                            <span class="admin-user-show__value">{{ $detail($profile->first_name) }}</span>
                        </div>
                        <div class="admin-user-show__row">
                            <span class="admin-user-show__label">Last name</span>
                            <span class="admin-user-show__value">{{ $detail($profile->last_name) }}</span>
                        </div>
                        <div class="admin-user-show__row">
                            <span class="admin-user-show__label">Phone</span>
                            <span class="admin-user-show__value">{{ $detail($profile->phone_number) }}</span>
                        </div>
                        <div class="admin-user-show__row">
                            <span class="admin-user-show__label">Personal email</span>
                            <span class="admin-user-show__value">{{ $detail($profile->personal_email) }}</span>
                        </div>
                        <div class="admin-user-show__row">
                            <span class="admin-user-show__label">Home address</span>
                            <span class="admin-user-show__value">{{ $detail($profile->home_address) }}</span>
                        </div>
                        <div class="admin-user-show__row">
                            <span class="admin-user-show__label">Province</span>
                            <span class="admin-user-show__value">{{ $detail($profile->province) }}</span>
                        </div>
                        <div class="admin-user-show__row">
                            <span class="admin-user-show__label">Barangay</span>
                            <span class="admin-user-show__value">{{ $detail($profile->barangay) }}</span>
                        </div>
                        <div class="admin-user-show__row">
                            <span class="admin-user-show__label">Zip code</span>
                            <span class="admin-user-show__value">{{ $detail($profile->zipcode) }}</span>
                        </div>
                        <div class="admin-user-show__row">
                            <span class="admin-user-show__label">Profession</span>
                            <span class="admin-user-show__value">{{ $detail($profile->profession) }}</span>
                        </div>
                        <div class="admin-user-show__row">
                            <span class="admin-user-show__label">Years experience</span>
                            <span class="admin-user-show__value">{{ $profile->year_exp !== null ? (int) $profile->year_exp : '—' }}</span>
                        </div>
                        @if (! empty($profile->verified_at))
                            <div class="admin-user-show__row">
                                <span class="admin-user-show__label">Verified</span>
                                <span class="admin-user-show__value">{{ \Carbon\Carbon::parse($profile->verified_at)->format('M j, Y') }}</span>
                            </div>
                        @endif
                    </div>
                @elseif (!$profile)
                    <div class="admin-user-show__card">
                        <h5>Profile</h5>
                        <p style="margin:0;font-size:14px;color:#888;">No profile record for this user yet.</p>
                    </div>
                @endif

            </div>


            <div class="admin-user-show__actions">
                {{-- <a href="{{ route('admin.users') }}" class="service-review-admin__back">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M15 18L9 12L15 6"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"/>
                    </svg>
                    Go Back
                </a> --}}
                <a href="{{ route('admin.users') }}" style="background-color: transparent !important; color: #171515 !important" class="btn btn--primary">Cancel</a>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn--primary">Edit user</a>
            </div>
        </div>
    </main>
@endsection
