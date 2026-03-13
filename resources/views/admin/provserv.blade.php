@extends('admin.layouts.auth')

{{-- Meta Section --}}
@section('title', 'Provider Bookings - Servease')

{{-- Page Content --}}
@section('content')
    @include('admin.layouts.header')
    @include('admin.layouts.sidebar')

    <main class="main-dash-uix provider--service dash-sp">
        <a href="{{route('create-service')}}" class="provider--service__btn">
            <div>
                Add New Service
            </div>
            <div>
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.5 10H10V17.5H7.5V10H0V7.5H7.5V0H10V7.5H17.5V10Z" fill="black"/>
                </svg>
            </div>
        </a>
        <section class="provider--service__table">
            <h4>Services</h4>
            <p class="provider--service__table--label">Service creation is limited to 5. Please manage or remove existing services before adding new ones.</p>
            
            <div class="provider-stbl-main">
                <div class="provider-stbl-main-c">
                    <div class="provider-stbl-main-c__head">
                        <div>Service ID</div>
                        <div>Name
                        </div>
                        <div>Service Category</div>
                        <div>Slug</div>
                        <div>Date Created</div>
                        <div>Actions</div>
                    </div>
                    @if ($services->isEmpty())
                        <div class="provider-stbl-main-c__tbody" style="height: 55px; font-size: 14px; text-align:center; margin: 0; display: flex; align-items: center; justify-content:center;">
                            No Services
                        </div>
                    @else
                        @foreach ($services as $service)
                            <div class="provider-stbl-main-c__tbody">
                                <div class="prvstble-mctb-id">{{$service->service_id}}</div>
                                <div class="prvstble-mctb-name">{{ Str::limit($service->title, 60) }}</div>
                                <div class="prvstble-mctb-serv">{{$service->category}}</div>
                                <div class="prvstble-mctb-slug"><a href="{{url('services/'. $service->slug)}}">{{url('services/'.$service->slug)}}</a></div>
                                <div class="prvstble-mctb-date">{{ $service->created_at->format('M j, Y') }}</div>
                                <div class="prvstble-mctb-act">
                                    {{-- <a href="#">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M1.93992 7.896C2.5953 7.187 3.58971 6.375 4.86663 5.822C4.17256 6.5561 3.78891 7.51062 3.79026 8.5C3.79026 9.53 4.19765 10.469 4.86663 11.178C3.59006 10.625 2.5953 9.813 1.93992 9.104C1.78389 8.93816 1.69756 8.72302 1.69756 8.5C1.69756 8.27698 1.78389 8.06184 1.93992 7.896ZM1.41708 7.45467C2.60577 6.16867 4.86489 4.531 7.91368 4.50033L7.97576 4.5H8.00018C11.0926 4.5 13.3831 6.15667 14.5829 7.45467C14.8515 7.74235 15 8.11443 15 8.5C15 8.88557 14.8515 9.25766 14.5829 9.54533C13.3831 10.8433 11.0926 12.5 8.00018 12.5H7.97576L7.91368 12.4997C4.86524 12.469 2.60577 10.8313 1.41708 9.54533C1.14846 9.25766 1 8.88557 1 8.5C1 8.11443 1.14846 7.74235 1.41708 7.45467ZM7.98553 5.16667L7.92239 5.167C6.02043 5.19433 4.48784 6.676 4.48784 8.5C4.48784 10.324 6.02078 11.8057 7.92239 11.833L7.98553 11.8333C9.90737 11.8283 11.4637 10.3377 11.4637 8.5C11.4637 6.66233 9.90737 5.17167 7.98553 5.16667ZM12.1613 8.5C12.1613 9.54667 11.7403 10.5 11.0514 11.213C12.3677 10.6597 13.3907 9.828 14.0601 9.104C14.2161 8.93816 14.3024 8.72302 14.3024 8.5C14.3024 8.27698 14.2161 8.06184 14.0601 7.896C13.3907 7.172 12.3677 6.34033 11.0514 5.787C11.7662 6.52517 12.1626 7.49425 12.1613 8.5ZM8.00018 10.5C8.35377 10.5001 8.70163 10.4145 9.01126 10.2513C9.3209 10.0882 9.58222 9.85265 9.77083 9.56681C9.95944 9.28097 10.0692 8.95412 10.0898 8.61677C10.1105 8.27942 10.0413 7.94257 9.88888 7.63767C9.82453 7.70134 9.74756 7.75213 9.66245 7.78707C9.57734 7.82201 9.4858 7.8404 9.39318 7.84117C9.30055 7.84194 9.2087 7.82507 9.12297 7.79155C9.03724 7.75803 8.95935 7.70853 8.89385 7.64593C8.82835 7.58333 8.77656 7.5089 8.74148 7.42697C8.70641 7.34504 8.68876 7.25725 8.68956 7.16873C8.69037 7.08021 8.70961 6.99273 8.74617 6.9114C8.78273 6.83006 8.83587 6.7565 8.9025 6.695C8.61908 6.56574 8.30885 6.4991 7.99481 6.50001C7.68077 6.50092 7.37098 6.56937 7.08838 6.70027C6.80579 6.83117 6.55765 7.02118 6.36234 7.25621C6.16704 7.49123 6.02959 7.76525 5.96018 8.05795C5.89077 8.35065 5.89118 8.65452 5.96138 8.94705C6.03157 9.23958 6.16976 9.51326 6.36569 9.7478C6.56162 9.98235 6.81027 10.1717 7.09321 10.302C7.37615 10.4322 7.68614 10.4999 8.00018 10.5Z" fill="#535353"/>
                                        </svg>
                                    </a> --}}
                                    <a href="{{ route('edit-service', $service->id) }}">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3 13V10.6389L10.3333 3.31944C10.4444 3.21759 10.5672 3.13889 10.7017 3.08333C10.8361 3.02778 10.9772 3 11.125 3C11.2728 3 11.4163 3.02778 11.5556 3.08333C11.6948 3.13889 11.8152 3.22222 11.9167 3.33333L12.6806 4.11111C12.7917 4.21296 12.8728 4.33333 12.9239 4.47222C12.975 4.61111 13.0004 4.75 13 4.88889C13 5.03704 12.9746 5.17833 12.9239 5.31278C12.8731 5.44722 12.792 5.56981 12.6806 5.68056L5.36111 13H3ZM11.1111 5.66667L11.8889 4.88889L11.1111 4.11111L10.3333 4.88889L11.1111 5.66667Z" fill="#535353"/>
                                        </svg>
                                    </a>
                                    <a href="javascript:void(0);"
                                    class="prvstble-mctb-act__remove delete-service-btn"
                                    data-id="{{ $service->id }}">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5 11.9907L8.49533 8.49533M8.49533 8.49533L11.9907 5M8.49533 8.49533L5 5M8.49533 8.49533L11.9907 11.9907"
                                                stroke="white" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endif


                </div>
            </div>
        </section>

    </main>

@endsection
@push('extrascripts')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click', '.delete-service-btn', function (e) {
        e.preventDefault();

        const serviceId = $(this).data('id');
        const button = $(this);

        Swal.fire({
            title: 'Delete Service?',
            text: 'Are you sure you want to delete this service?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it',
            confirmButtonColor: '#FFBE42',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/provider/service/delete/' + serviceId,
                    type: 'POST',
                    data: {
                        _method: 'DELETE'
                    },
                    success: function (response) {
                        button.closest('tr').fadeOut(300, function () {
                            $(this).remove();
                        });

                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message || 'Service deleted successfully.',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: xhr.responseJSON?.message || 'Something went wrong while deleting the service.'
                        });
                    }
                });
            }
        });
    });
</script>
@endpush