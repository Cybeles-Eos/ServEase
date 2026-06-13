@extends('admin.layouts.auth')

@section('title', 'Resubmit Provider Application')

@push('extrastylesheets')
<style>
    .provider-resubmit {
        width: 100%;
        min-height: calc(100vh - 64px);
        background: #F5F7FA;
        padding: 20px 18px 32px;
    }

    .provider-resubmit__wrap {
        max-width: 980px;
        margin: 0 auto;
    }

    .provider-resubmit__head,
    .provider-resubmit__form {
        background: #fff;
        border: 1px solid #E0E2E7;
        border-radius: 8px;
    }

    .provider-resubmit__head {
        padding: 22px;
        margin-bottom: 16px;
    }

    .provider-resubmit__head h1 {
        margin: 0;
        color: #202020;
        font-size: 24px;
        font-weight: 800;
    }

    .provider-resubmit__head p {
        margin: 8px 0 0;
        color: #667085;
        font-size: 14px;
        line-height: 1.5;
    }

    .provider-resubmit__remarks {
        margin-top: 16px;
        padding: 12px 14px;
        background: #FFF7E6;
        border: 1px solid #FCDFA4;
        border-radius: 6px;
        color: #7A4B00;
        font-size: 14px;
    }

    .provider-resubmit__form {
        padding: 22px;
    }

    .provider-resubmit__grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .provider-resubmit__field {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .provider-resubmit__field--full {
        grid-column: 1 / -1;
    }

    .provider-resubmit__field label {
        margin: 0;
        color: #202020;
        font-size: 14px;
        font-weight: 600;
    }

    .provider-resubmit__field input {
        width: 100%;
        height: 43px;
        border: 1px solid #DADADA;
        border-radius: 6px;
        padding: 5px 13px;
        background: #fff;
        color: #202020;
        font-size: 14px;
        outline: none;
    }

    .provider-resubmit__field input:focus {
        border-color: #FDB932;
        box-shadow: 0 0 0 3px rgba(253, 185, 50, 0.18);
    }

    .provider-resubmit__file-note {
        margin: 2px 0 0;
        color: #667085;
        font-size: 12px;
    }

    .provider-resubmit .file-field {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .provider-resubmit .file-field label {
        margin: 0;
        color: #202020;
        font-size: 14px;
        font-weight: 600;
    }

    .provider-resubmit .file-input-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
        min-height: 43px;
        border: 1px solid #D9D9D9;
        border-radius: 6px;
        padding: 8px 10px;
        background: #fff;
        overflow: hidden;
    }

    .provider-resubmit .file-btn {
        border: none;
        border-radius: 0;
        padding: 6px 14px;
        background-color: #3A3A3A;
        color: #fff;
        font-size: 13px;
        white-space: nowrap;
        cursor: pointer;
    }

    .provider-resubmit .file-btn:hover {
        background-color: #2b2b2b;
    }

    .provider-resubmit .file-name {
        min-width: 0;
        color: #D9D9D9;
        font-size: 13px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .provider-resubmit__error {
        color: #D74646;
        font-size: 12px;
    }

    .provider-resubmit__actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 20px;
    }

    .provider-resubmit__actions button {
        min-height: 44px;
        border: 0;
        border-radius: 6px;
        padding: 0 22px;
        background: #FDB932;
        color: #202020;
        font-size: 14px;
        font-weight: 800;
        cursor: pointer;
    }

    @media (max-width: 720px) {
        .provider-resubmit {
            padding: 14px 12px 24px;
        }

        .provider-resubmit__head,
        .provider-resubmit__form {
            padding: 16px;
        }

        .provider-resubmit__grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
    @include('admin.layouts.header')
    @include('admin.layouts.sidebar')

    @php
        $requiredDocuments = $provider->resubmission_required_documents ?: ['resume', 'barangay_clearance'];
    @endphp

    <main class="main-dash-uix dash-sp provider-resubmit">
        <div class="provider-resubmit__wrap">
            <section class="provider-resubmit__head">
                <h1>Resubmit Provider Application</h1>
                <p>Your application needs a few updates before admin can approve it. Email and password cannot be changed here.</p>

                @if($provider->application_remarks)
                    <div class="provider-resubmit__remarks">
                        <strong>Admin remarks:</strong> {{ $provider->application_remarks }}
                    </div>
                @endif
            </section>

            <form method="POST" action="{{ route('provider.resubmit.update') }}" enctype="multipart/form-data" class="provider-resubmit__form">
                @csrf

                <div class="provider-resubmit__grid">
                    <div class="provider-resubmit__field">
                        <label>First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $provider->first_name) }}" required>
                        @error('first_name') <span class="provider-resubmit__error">{{ $message }}</span> @enderror
                    </div>

                    <div class="provider-resubmit__field">
                        <label>Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $provider->last_name) }}" required>
                        @error('last_name') <span class="provider-resubmit__error">{{ $message }}</span> @enderror
                    </div>

                    <div class="provider-resubmit__field">
                        <label>Contact Number</label>
                        <input type="text" name="phone_number" value="{{ old('phone_number', $provider->phone_number) }}" required>
                        @error('phone_number') <span class="provider-resubmit__error">{{ $message }}</span> @enderror
                    </div>

                    <div class="provider-resubmit__field">
                        <label>Province</label>
                        <input type="text" name="province" value="{{ old('province', $provider->province) }}" required>
                        @error('province') <span class="provider-resubmit__error">{{ $message }}</span> @enderror
                    </div>

                    <div class="provider-resubmit__field provider-resubmit__field--full">
                        <label>Complete Address</label>
                        <input type="text" name="home_address" value="{{ old('home_address', $provider->home_address) }}" required>
                        @error('home_address') <span class="provider-resubmit__error">{{ $message }}</span> @enderror
                    </div>

                    <div class="provider-resubmit__field">
                        <label>Barangay</label>
                        <input type="text" name="barangay" value="{{ old('barangay', $provider->barangay) }}">
                        @error('barangay') <span class="provider-resubmit__error">{{ $message }}</span> @enderror
                    </div>

                    <div class="provider-resubmit__field">
                        <label>ZIP Code</label>
                        <input type="text" name="zipcode" value="{{ old('zipcode', $provider->zipcode) }}" maxlength="4" required>
                        @error('zipcode') <span class="provider-resubmit__error">{{ $message }}</span> @enderror
                    </div>

                    <div class="provider-resubmit__field">
                        <label>Profession</label>
                        <input type="text" name="profession" value="{{ old('profession', $provider->profession) }}" required>
                        @error('profession') <span class="provider-resubmit__error">{{ $message }}</span> @enderror
                    </div>

                    <div class="provider-resubmit__field">
                        <label>Years of Experience</label>
                        <input type="number" name="year_exp" value="{{ old('year_exp', $provider->year_exp) }}" min="0" required>
                        @error('year_exp') <span class="provider-resubmit__error">{{ $message }}</span> @enderror
                    </div>

                    @if(in_array('barangay_clearance', $requiredDocuments, true))
                        <div class="file-field">
                            <label>Barangay Clearance</label>
                            <div class="file-input-wrapper">
                                <input type="file" id="barangay_clearance" name="barangay_clearance" accept="application/pdf" hidden required>
                                <button type="button" class="file-btn" data-target="barangay_clearance">Choose File</button>
                                <span class="file-name">No file chosen</span>
                            </div>
                            <p class="provider-resubmit__file-note">Upload PDF only, max 5MB.</p>
                            @error('barangay_clearance') <span class="provider-resubmit__error">{{ $message }}</span> @enderror
                        </div>
                    @endif

                    @if(in_array('resume', $requiredDocuments, true))
                        <div class="file-field">
                            <label>Resume</label>
                            <div class="file-input-wrapper">
                                <input type="file" id="resume" name="resume" accept="application/pdf" hidden required>
                                <button type="button" class="file-btn" data-target="resume">Choose File</button>
                                <span class="file-name">No file chosen</span>
                            </div>
                            <p class="provider-resubmit__file-note">Upload PDF only, max 5MB.</p>
                            @error('resume') <span class="provider-resubmit__error">{{ $message }}</span> @enderror
                        </div>
                    @endif
                </div>

                <div class="provider-resubmit__actions">
                    <button type="submit">Send Updated Application</button>
                </div>
            </form>
        </div>
    </main>
@endsection

@push('extrascripts')
<script>
    $(document).ready(function () {
        $('.provider-resubmit .file-btn').on('click', function () {
            $('#' + $(this).data('target')).click();
        });

        $('.provider-resubmit input[type="file"]').on('change', function () {
            const file = this.files.length ? this.files[0] : null;
            const $fileName = $(this).closest('.file-input-wrapper').find('.file-name');

            if (!file) {
                $fileName.text('No file chosen');
                return;
            }

            const isPdf = file.type === 'application/pdf' || file.name.toLowerCase().endsWith('.pdf');

            if (!isPdf) {
                this.value = '';
                $fileName.text('No file chosen');

                Swal.fire({
                    icon: 'error',
                    title: 'Invalid File',
                    text: 'Please upload a PDF file only.',
                    confirmButtonColor: '#FFBE42',
                });

                return;
            }

            $fileName.text(file.name);
        });
    });
</script>
@endpush
