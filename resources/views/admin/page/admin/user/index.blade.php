    @extends('admin.layouts.auth')

    {{-- Meta Section --}}
    @section('title', 'Admin Users Page')

    {{-- Page Content --}}
    @section('content')
        @include('admin.layouts.header')
        {{-- @include('admin.layouts.sidebar') --}}

        <main class="main-dash-uix page-admin-users dash-sp">
            <a href="{{ route('admin.users.create') }}" class="page-admin-users__btn">
                <div>
                    Add New User
                </div>
                <div>
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.5 10H10V17.5H7.5V10H0V7.5H7.5V0H10V7.5H17.5V10Z" fill="black"/>
                    </svg>
                </div>
            </a>

        <section class="section__table">
<div class="page-admin-users__table-head">
    <div class="page-admin-users__table-title">
        <h4>Users</h4>
        <p class="section__table--label">All Provider and customer accounts.</p>
    </div>

    <form method="GET" action="{{ route('admin.users') }}" class="page-admin-users__filters">
        <div class="page-admin-users__search">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>
                <path d="M21 21L16.65 16.65"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>

            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Search users...">
        </div>

        <div class="page-admin-users__filter-group">
            <select name="role" class="page-admin-users__select">
                <option value="">All Roles</option>
                <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Customer</option>
                <option value="provider" {{ request('role') === 'provider' ? 'selected' : '' }}>Provider</option>
            </select>

            <select name="status" class="page-admin-users__select">
                <option value="">All Status</option>
                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Disabled</option>
            </select>
        </div>

        <div class="page-admin-users__filter-actions">
            <button type="submit" class="page-admin-users__filter-btn">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                    <path d="M22 3H2L10 12.46V19L14 21V12.46L22 3Z"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                          stroke-linejoin="round"/>
                </svg>
                Filter
            </button>

            @if(request()->hasAny(['search', 'role', 'status']))
                <a href="{{ route('admin.users') }}" class="page-admin-users__clear-btn">
                    Clear
                </a>
            @endif
        </div>
    </form>
</div>

            <div class="admin-ustbl-main">
                    <div class="admin-ustbl-main-c">
                        <div class="admin-ustbl-main-c__head">
                            <div>Name</div>
                            <div>Email</div>
                            <div>Barangay</div>
                            <div>Phone Number</div>
                            <div>User Roles</div>
                            <div>Status</div>
                            <div>Actions</div>
                        </div>
                        @forelse ($users as $user)
                            @php
                                $profile = $user->role === 'customer' ? $user->customer : $user->provider;
                                $displayName = $profile
                                    ? trim(implode(' ', array_filter([$profile->first_name ?? null, $profile->last_name ?? null])))
                                    : '';
                                $displayName = $displayName !== '' ? $displayName : $user->name;
                                $barangay = $profile?->barangay ?? '—';
                                $phone = $profile?->phone_number ?? '—';
                            @endphp
                            <div class="admin-ustbl-main-c__tbody">
                                <div class="prvstble-mctb-name">{{ $displayName }}</div>
                                <div class="prvstble-mctb-serv">{{ $user->email }}</div>
                                <div class="prvstble-mctb-date">{{ $barangay }}</div>
                                <div class="prvstble-mctb-date">{{ $phone }}</div>
                                <div class="prvstble-mctb-date">{{ ucfirst($user->role) }}</div>
                                <div class="prvstble-mctb-date">{!! $user->is_active ? '<span class="badge bg-success text-white" style="font-size: 11px">Active</span>' : '<span class="badge bg-danger text-white" style="font-size: 11px">Disabled</span>' !!}</div>
                                <div class="prvstble-mctb-act">
                                    <a href="{{ route('admin.users.show', $user) }}" title="View profile">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path d="M8 3C4.5 3 1.73 5.11 1 8c.73 2.89 3.5 5 7 5s6.27-2.11 7-5c-.73-2.89-3.5-5-7-5Zm0 8.33a3.33 3.33 0 1 1 0-6.66 3.33 3.33 0 0 1 0 6.66Zm0-5.33a1.67 1.67 0 1 0 0 3.33 1.67 1.67 0 0 0 0-3.33Z" fill="#535353"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" title="Edit">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3 13V10.6389L10.3333 3.31944C10.4444 3.21759 10.5672 3.13889 10.7017 3.08333C10.8361 3.02778 10.9772 3 11.125 3C11.2728 3 11.4163 3.02778 11.5556 3.08333C11.6948 3.13889 11.8152 3.22222 11.9167 3.33333L12.6806 4.11111C12.7917 4.21296 12.8728 4.33333 12.9239 4.47222C12.975 4.61111 13.0004 4.75 13 4.88889C13 5.03704 12.9746 5.17833 12.9239 5.31278C12.8731 5.44722 12.792 5.56981 12.6806 5.68056L5.36111 13H3ZM11.1111 5.66667L11.8889 4.88889L11.1111 4.11111L10.3333 4.88889L11.1111 5.66667Z" fill="#535353"/>
                                        </svg>
                                    </a>
                                    <a href="javascript:void(0);"
                                    class="prvstble-mctb-act__remove delete-admin-user-btn"
                                    data-delete-url="{{ route('admin.users.destroy', $user) }}"
                                    data-id="{{ $user->id }}">
                                        <i class="fa fa-times" style="color: #fff"></i>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="admin-ustbl-main-c__tbody" style="height: 55px; font-size: 14px; text-align:center; margin: 0; display: flex; align-items: center; justify-content:center;">
                                No users found
                            </div>
                        @endforelse


                    </div>
                </div>
            </section>
        </main>


        {{-- Only Show When Someone is login --}}
    @endsection
    @push('extrascripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.delete-admin-user-btn', function (e) {
            e.preventDefault();

            var url = $(this).data('delete-url');
            var button = $(this);

            Swal.fire({
                title: 'Delete user?',
                text: 'This removes the account and related profile data.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete',
                confirmButtonColor: '#FFBE42',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then(function (result) {
                if (!result.isConfirmed) return;

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: { _method: 'DELETE' },
                    success: function (response) {
                        button.closest('.admin-ustbl-main-c__tbody').fadeOut(300, function () {
                            $(this).remove();
                        });
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                            text: response.message || 'User deleted successfully.',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    },
                    error: function (xhr) {
                        var msg = (xhr.responseJSON && xhr.responseJSON.message)
                            ? xhr.responseJSON.message
                            : 'Could not delete user.';
                        Swal.fire({ icon: 'error', title: 'Error', text: msg });
                    }
                });
            });
        });
    </script>
    @endpush
