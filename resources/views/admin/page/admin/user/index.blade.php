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
            <h4>Users</h4>
            <p class="section__table--label">All Provider and customer accounts.</p>
            
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
                            <div class="prvstble-mctb-date">{{ $user->is_active ? 'Active' : 'Disabled' }}</div>
                            <div class="prvstble-mctb-act">
                                <a href="{{ route('admin.users.edit', $user) }}">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3 13V10.6389L10.3333 3.31944C10.4444 3.21759 10.5672 3.13889 10.7017 3.08333C10.8361 3.02778 10.9772 3 11.125 3C11.2728 3 11.4163 3.02778 11.5556 3.08333C11.6948 3.13889 11.8152 3.22222 11.9167 3.33333L12.6806 4.11111C12.7917 4.21296 12.8728 4.33333 12.9239 4.47222C12.975 4.61111 13.0004 4.75 13 4.88889C13 5.03704 12.9746 5.17833 12.9239 5.31278C12.8731 5.44722 12.792 5.56981 12.6806 5.68056L5.36111 13H3ZM11.1111 5.66667L11.8889 4.88889L11.1111 4.11111L10.3333 4.88889L11.1111 5.66667Z" fill="#535353"/>
                                    </svg>
                                </a>
                                <a href="javascript:void(0);"
                                class="prvstble-mctb-act__remove delete-admin-user-btn"
                                data-delete-url="{{ route('admin.users.destroy', $user) }}"
                                data-id="{{ $user->id }}">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 11.9907L8.49533 8.49533M8.49533 8.49533L11.9907 5M8.49533 8.49533L5 5M8.49533 8.49533L11.9907 11.9907"
                                            stroke="white" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
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