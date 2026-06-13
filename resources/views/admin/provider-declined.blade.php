@extends('admin.layouts.auth')

@section('title', 'Provider Application Declined')

@push('extrastylesheets')
<style>
    .provider-declined {
        width: 100%;
        min-height: calc(100vh - 64px);
        background: #F5F7FA;
        padding: 22px 18px 32px;
    }

    .provider-declined__wrap {
        max-width: 760px;
        margin: 0 auto;
    }

    .provider-declined__card {
        background: #fff;
        border: 1px solid #E0E2E7;
        border-radius: 8px;
        padding: 28px;
    }

    .provider-declined__icon {
        width: 54px;
        height: 54px;
        border-radius: 999px;
        background: #FEE2E2;
        color: #B42318;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
    }

    .provider-declined__card h1 {
        margin: 0;
        color: #202020;
        font-size: 26px;
        font-weight: 800;
        line-height: 1.15;
    }

    .provider-declined__card p {
        margin: 10px 0 0;
        color: #667085;
        font-size: 14px;
        line-height: 1.55;
    }

    .provider-declined__remarks {
        margin-top: 18px;
        padding: 13px 14px;
        border: 1px solid #FECACA;
        border-radius: 6px;
        background: #FFF5F5;
        color: #7F1D1D;
        font-size: 14px;
    }

    .provider-declined__footer-text {
        margin-top: 18px;
        padding-top: 16px;
        border-top: 1px solid #EEF0F3;
    }

    .provider-declined__actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 22px;
    }

    .provider-declined__btn {
        min-height: 42px;
        border: 0;
        border-radius: 6px;
        padding: 0 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 14px;
        font-weight: 800;
        cursor: pointer;
    }

    .provider-declined__btn--home {
        background: #FDB932;
        color: #202020;
    }

    .provider-declined__btn--delete {
        background: #FEE2E2;
        color: #991B1B;
    }

    @media (max-width: 640px) {
        .provider-declined {
            padding: 14px 12px 24px;
        }

        .provider-declined__card {
            padding: 20px;
        }

        .provider-declined__actions,
        .provider-declined__actions form,
        .provider-declined__btn {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
    @include('admin.layouts.header')
    @include('admin.layouts.sidebar')

    <main class="main-dash-uix dash-sp provider-declined">
        <div class="provider-declined__wrap">
            <section class="provider-declined__card">
                <div class="provider-declined__icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none">
                        <path d="M12 3L22 20H2L12 3Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                        <path d="M12 9V13" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M12 16.5H12.01" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                    </svg>
                </div>

                <h1>Your provider application was declined by admin.</h1>
                <p>Thank you for your interest in joining ServEase. After review, your current provider application was not approved.</p>

                @if($provider->application_remarks)
                    <div class="provider-declined__remarks">
                        <strong>Admin note:</strong> {{ $provider->application_remarks }}
                    </div>
                @endif

                <p class="provider-declined__footer-text">
                    You may return to the home page to continue browsing ServEase, or delete your provider application records from this system.
                </p>

                <div class="provider-declined__actions">
                    <a href="{{ url('/') }}" class="provider-declined__btn provider-declined__btn--home">Home Page</a>

                    <form method="POST" action="{{ route('provider.declined.records.delete') }}" class="provider-delete-records-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="provider-declined__btn provider-declined__btn--delete">Delete my records</button>
                    </form>
                </div>
            </section>
        </div>
    </main>
@endsection

@push('extrascripts')
<script>
    $(document).on('submit', '.provider-delete-records-form', function (e) {
        e.preventDefault();

        const form = this;

        Swal.fire({
            title: 'Delete your records?',
            text: 'This will permanently delete your declined provider application records.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#DF4545',
            cancelButtonColor: '#6B7280',
            reverseButtons: true,
        }).then(function (result) {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>
@endpush
