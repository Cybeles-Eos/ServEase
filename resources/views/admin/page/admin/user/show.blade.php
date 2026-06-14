@extends('admin.layouts.auth')

@section('title', 'User profile')

@push('extrastylesheets')
    <style>
        .admin-user-show {
            width: 100%;
            max-width: 1180px;
            margin: 0 auto;
            padding: 20px 16px 40px;
            text-align: left;
        }

        .admin-user-show__hero {
            background: #fff;
            border: 1px solid #E0E2E7;
            border-radius: 14px;
            padding: 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 18px;
        }

        .admin-user-show__identity {
            display: flex;
            align-items: center;
            gap: 16px;
            min-width: 0;
        }

        .admin-user-show__avatar {
            width: 82px;
            height: 82px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #E0E2E7;
            display: block;
            background: #f5f5f5;
            flex: 0 0 82px;
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
            font-size: 28px;
            font-weight: 800;
            line-height: 1;
            letter-spacing: 0.03em;
        }

        .admin-user-show__name {
            font-size: 24px;
            font-weight: 800;
            color: #202020;
            margin: 0 0 6px;
            line-height: 1.15;
        }

        .admin-user-show__sub {
            margin: 0;
            color: #6B7280;
            font-size: 13px;
            line-height: 1.5;
        }

        .admin-user-show__role {
            display: inline-flex;
            align-items: center;
            width: fit-content;
            font-size: 12px;
            font-weight: 800;
            padding: 5px 11px;
            border-radius: 999px;
            background: #FFF4D8;
            color: #9A6100;
            margin-top: 8px;
        }

        .admin-user-show__hero-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .admin-user-show__btn {
            min-height: 34px;
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid transparent;
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: .2s ease;
        }

        .admin-user-show__btn--light {
            background: #fff;
            border-color: #D1D5DB;
            color: #374151;
        }

        .admin-user-show__btn--light:hover {
            background: #FFF7E6;
            border-color: #FFBE42;
            color: #202020;
        }

        .admin-user-show__btn--primary {
            background: #FFBE42;
            color: #202020;
        }

        .admin-user-show__btn--primary:hover {
            background: #F5AD1F;
            color: #202020;
        }

        .admin-user-show__grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            align-items: start;
        }

        .admin-user-show__card {
            background: #fff;
            border: 1px solid #E0E2E7;
            border-radius: 14px;
            padding: 18px;
            min-height: 100%;
        }

        .admin-user-show__card h5,
        .admin-user-show__documents-card h5 {
            font-size: 12px;
            font-weight: 800;
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
            padding: 9px 0;
            border-bottom: 1px solid #F5F7FA;
        }

        .admin-user-show__row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .admin-user-show__label {
            color: #858688;
            font-weight: 600;
        }

        .admin-user-show__value {
            color: #202020;
            font-weight: 600;
            word-break: break-word;
        }

        .admin-user-show__status {
            display: inline-flex;
            align-items: center;
            width: fit-content;
            padding: 4px 9px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 800;
        }

        .admin-user-show__status--active {
            background: #DCFCE7;
            color: #166534;
        }

        .admin-user-show__status--disabled {
            background: #FEE2E2;
            color: #991B1B;
        }

        .admin-user-show__documents {
            margin-top: 18px;
        }

        .admin-user-show__documents-card {
            background: #fff;
            border: 1px solid #E0E2E7;
            border-radius: 14px;
            padding: 18px;
        }

        .admin-user-show__documents-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .admin-user-show__document-block {
            border: 1px solid #E0E2E7;
            border-radius: 12px;
            overflow: hidden;
            background: #F9FAFB;
        }

        .admin-user-show__document-head {
            background: #fff;
            border-bottom: 1px solid #E0E2E7;
            padding: 12px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .admin-user-show__document-title {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 0;
        }

        .admin-user-show__document-title span {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: #FFF4D8;
            color: #9A6100;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 30px;
        }

        .admin-user-show__document-title h6 {
            margin: 0;
            font-size: 13px;
            font-weight: 800;
            color: #202020;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .admin-user-show__document-head a {
            font-size: 12px;
            font-weight: 800;
            color: #2563EB;
            text-decoration: none;
            white-space: nowrap;
        }

        .admin-user-show__document-head a:hover {
            text-decoration: underline;
        }

        .admin-user-show__document-viewer {
            width: 100%;
            height: 520px;
            overflow: hidden;
            background: #F5F7FA;
        }

        .admin-user-show__document-viewer iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .admin-user-show__empty-card {
            background: #fff;
            border: 1px dashed #D1D5DB;
            border-radius: 12px;
            padding: 18px;
            color: #6B7280;
            font-size: 13px;
            text-align: center;
        }

        @media (max-width: 1100px) {
            .admin-user-show {
                max-width: 760px;
            }

            .admin-user-show__grid,
            .admin-user-show__documents-grid {
                grid-template-columns: 1fr;
            }

            .admin-user-show__document-viewer {
                height: 480px;
            }
        }

        @media (max-width: 640px) {
            .admin-user-show {
                padding: 14px 10px 28px;
            }

            .admin-user-show__hero {
                flex-direction: column;
                align-items: flex-start;
            }

            .admin-user-show__hero-actions {
                justify-content: flex-start;
                width: 100%;
            }

            .admin-user-show__identity {
                align-items: flex-start;
            }

            .admin-user-show__avatar {
                width: 64px;
                height: 64px;
                flex-basis: 64px;
            }

            .admin-user-show__avatar--initials span {
                font-size: 22px;
            }

            .admin-user-show__name {
                font-size: 20px;
            }

            .admin-user-show__row {
                grid-template-columns: 1fr;
                gap: 4px;
            }

            .admin-user-show__label {
                font-size: 11px;
            }

            .admin-user-show__document-head {
                flex-direction: column;
                align-items: flex-start;
            }

            .admin-user-show__document-viewer {
                height: 380px;
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
    @php
        $resumeUrl = null;
        $barangayClearanceUrl = null;

        if ($user->role === 'provider' && $profile) {
            $resumeUrl = !empty($profile->resume_path)
                ? route('admin.applicants.document', [$profile, 'resume'])
                : null;

            $barangayClearanceUrl = !empty($profile->barangay_clearance_path)
                ? route('admin.applicants.document', [$profile, 'barangay-clearance'])
                : null;
        }
    @endphp
    <main class="main-dash-uix page-admin-users dash-sp">
        <div class="admin-user-show">
            <section class="admin-user-show__hero">
                <div class="admin-user-show__identity">
                    @if ($avatarImgSrc)
                        <img src="{{ $avatarImgSrc }}" alt="{{ $displayName }}" class="admin-user-show__avatar">
                    @else
                        <div class="admin-user-show__avatar admin-user-show__avatar--initials" role="img" aria-label="{{ $displayName }}">
                            <span>{{ $avatarInitials !== '' ? $avatarInitials : strtoupper(substr((string) $user->name, 0, 2)) }}</span>
                        </div>
                    @endif

                    <div>
                        <h1 class="admin-user-show__name">{{ $displayName }}</h1>
                        <p class="admin-user-show__sub">{{ $detail($user->email) }}</p>
                        <span class="admin-user-show__role">{{ ucfirst($user->role) }}</span>
                    </div>
                </div>

                <div class="admin-user-show__hero-actions">
                    <a href="{{ route('admin.users') }}" class="admin-user-show__btn admin-user-show__btn--light">
                        Cancel
                    </a>

                    <a href="{{ route('admin.users.edit', $user) }}" class="admin-user-show__btn admin-user-show__btn--primary">
                        Edit user
                    </a>
                </div>
            </section>


            <div class="admin-user-show__grid">

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
                        <span class="admin-user-show__value">
                            <span class="admin-user-show__status {{ $user->is_active ? 'admin-user-show__status--active' : 'admin-user-show__status--disabled' }}">
                                {{ $user->is_active ? 'Active' : 'Disabled' }}
                            </span>
                        </span>
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
                            <span class="admin-user-show__label">Home address</span>
                            <span class="admin-user-show__value">{{ $detail($profile->home_address) }}</span>
                        </div>
                        <div class="admin-user-show__row">
                            <span class="admin-user-show__label">City</span>
                            <span class="admin-user-show__value">{{ $detail($profile->city ?? $profile->province) }}</span>
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

            @if ($user->role === 'provider' && $profile && ($resumeUrl || $barangayClearanceUrl))
                <section class="admin-user-show__documents">
                    <div class="admin-user-show__documents-card">
                        <h5>Provider Documents</h5>

                        <div class="admin-user-show__documents-grid">
                            @if ($barangayClearanceUrl)
                                <div class="admin-user-show__document-block">
                                    <div class="admin-user-show__document-head">
                                        <div class="admin-user-show__document-title">
                                            <span>
                                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                                                    <path d="M14 2H6C5.45 2 4.98 2.2 4.59 2.59C4.2 2.98 4 3.45 4 4V20C4 20.55 4.2 21.02 4.59 21.41C4.98 21.8 5.45 22 6 22H18C18.55 22 19.02 21.8 19.41 21.41C19.8 21.02 20 20.55 20 20V8L14 2Z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M14 2V8H20" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M9 13H15M9 17H15" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                                                </svg>
                                            </span>
                                            <h6>Barangay Clearance</h6>
                                        </div>

                                        <a href="{{ $barangayClearanceUrl }}" target="_blank">
                                            Open in new tab
                                        </a>
                                    </div>

                                    <div class="admin-user-show__document-viewer">
                                        <iframe src="{{ $barangayClearanceUrl }}"></iframe>
                                    </div>
                                </div>
                            @endif

                            @if ($resumeUrl)
                                <div class="admin-user-show__document-block">
                                    <div class="admin-user-show__document-head">
                                        <div class="admin-user-show__document-title">
                                            <span>
                                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                                                    <path d="M14 2H6C5.45 2 4.98 2.2 4.59 2.59C4.2 2.98 4 3.45 4 4V20C4 20.55 4.2 21.02 4.59 21.41C4.98 21.8 5.45 22 6 22H18C18.55 22 19.02 21.8 19.41 21.41C19.8 21.02 20 20.55 20 20V8L14 2Z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M14 2V8H20" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M9 13H15M9 17H15" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                                                </svg>
                                            </span>
                                            <h6>Resume / CV</h6>
                                        </div>

                                        <a href="{{ $resumeUrl }}" target="_blank">
                                            Open in new tab
                                        </a>
                                    </div>

                                    <div class="admin-user-show__document-viewer">
                                        <iframe src="{{ $resumeUrl }}"></iframe>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </section>
            @endif
            {{-- <div class="admin-user-show__actions">
                <a href="{{ route('admin.users') }}" style="background-color: transparent !important; color: #171515 !important" class="btn btn--primary">Cancel</a>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn--primary">Edit user</a>
            </div> --}}
        </div>
    </main>
@endsection
