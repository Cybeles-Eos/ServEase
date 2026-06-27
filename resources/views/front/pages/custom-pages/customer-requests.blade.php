@extends('front.layouts.base')

@section('title', 'Customer Requests - Servease')

@section('content')
    <main class="main-page page--customer-requests">
        <section class="section--list m-padding m-width customer-request-market">
            <div class="customer-request-market__header">
                <div class="customer-request-market__intro">
                    <h1>Customer Requests</h1>
                    <p>
                        Browse customer-posted service needs that are not listed as standard services.
                        Providers can apply to open requests; admins can review requests in read-only mode.
                    </p>
                </div>

                <div class="customer-request-market__filters" style="padding-bottom: 0px !important">
                    <div class="ps-sl-category__search">
                        <input type="text" value="{{ $search }}" placeholder="What are you looking for?" data-customer-request-search>
                        <svg width="16" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.3739 11.5129L16.9467 14.8861L15.7669 16L12.1941 12.6268C10.9094 13.5971 9.28022 14.1776 7.50827 14.1776C3.3637 14.1776 0 11.0018 0 7.08881C0 3.17579 3.3637 0 7.50827 0C11.6528 0 15.0165 3.17579 15.0165 7.08881C15.0165 8.76177 14.4017 10.3 13.3739 11.5129ZM11.7001 10.9284C12.7203 9.93584 13.348 8.58187 13.348 7.08881C13.348 4.04259 10.7347 1.57529 7.50827 1.57529C4.2818 1.57529 1.6685 4.04259 1.6685 7.08881C1.6685 10.135 4.2818 12.6023 7.50827 12.6023C9.08968 12.6023 10.5238 12.0096 11.5751 11.0465L11.7001 10.9284Z" fill="#979797" fill-opacity="0.6"/>
                        </svg>
                    </div>

                    <button type="button" class="ps-serv-btn-sort-m customer-request-market__sort" style="padding-right: 10px; min-width: 100px" data-customer-request-sort>
                        <svg width="13" height="10" viewBox="0 0 13 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.833008 0.833008H11.4997M2.83301 4.83301H9.49967M5.49967 8.83301H6.83301" stroke="#FDB932" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="sort-label">Sort to Newest</span>
                    </button>
                </div>
            </div>

            <div class="customer-request-grid">
                @forelse($requests as $request)
                    @php
                        $ownApplication = $provider
                            ? $request->applications->firstWhere('provider_id', $provider->id)
                            : null;

                        $applicationCount = $request->applications->count();
                        $formId = 'customer-request-apply-' . $request->id;

                        $serviceType = $request->service_type ?: 'Service Type';
                        $profileName = trim(($request->customer->first_name ?? '') . ' ' . ($request->customer->last_name ?? ''));
                        $customerName = $request->contact_name ?: ($profileName ?: 'Customer');
                        $customerEmail = $request->contact_email ?: ($request->customer->user->email ?? 'Email not provided');
                        $customerPhone = $request->contact_phone ?: ($request->customer->phone_number ?? 'Phone not provided');
                        $customerAddress = $request->contact_address ?: 'Address not provided';
                        $preferredDate = $request->preferred_date ? $request->preferred_date->format('M d, Y') : null;
                        $preferredTime = $request->preferred_time ? $request->preferred_time->format('g:i A') : null;
                        $preferredSchedule = trim(implode(' ', array_filter([$preferredDate, $preferredTime]))) ?: 'Not specified';
                    @endphp

                    <article class="customer-request-card">
                        <div class="customer-request-card__media">
                            <img
                                src="{{ $request->image_path ? asset($request->image_path) : asset('images/serv-bg.png') }}"
                                alt="{{ $request->title }}"
                                class="customer-request-card__image"
                            >

                            <span class="customer-request-card__badge">
                                {{ $serviceType }}
                            </span>
                        </div>

                        <div class="customer-request-card__body">
                            <h2>{{ $request->title }}</h2>

                            <p class="customer-request-card__description">
                                {{ \Illuminate\Support\Str::limit($request->description, 92) }}
                            </p>

                            <div class="customer-request-card__stats">
                                <div class="customer-request-stat">
                                    <span>Posted</span>
                                    <strong>{{ $request->created_at?->format('M d') ?: 'Jun 27' }}</strong>
                                </div>

                                <div class="customer-request-stat">
                                    <span>Budget</span>
                                    <strong>{{ $request->fixed_price_label ?: '₱ 1,200.00' }}</strong>
                                </div>

                                <div class="customer-request-stat">
                                    <span>Applications</span>
                                    <strong>{{ $applicationCount }}</strong>
                                </div>
                            </div>

                            <div class="customer-request-card__info">
                                <p>
                                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.5 6.5C7.84619 6.5 8.9375 5.40869 8.9375 4.0625C8.9375 2.71631 7.84619 1.625 6.5 1.625C5.15381 1.625 4.0625 2.71631 4.0625 4.0625C4.0625 5.40869 5.15381 6.5 6.5 6.5Z" stroke="#FDB932" stroke-width="1.1"/>
                                        <path d="M2.16675 11.375C2.16675 9.28142 4.10618 7.58325 6.50008 7.58325C8.89398 7.58325 10.8334 9.28142 10.8334 11.375" stroke="#FDB932" stroke-width="1.1" stroke-linecap="round"/>
                                    </svg>
                                    Customer: {{ $customerName }}
                                </p>

                                <p>
                                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.16675 3.25H10.8334V9.75H2.16675V3.25Z" stroke="#FDB932" stroke-width="1.1" stroke-linejoin="round"/>
                                        <path d="M2.16675 3.25L6.50008 6.77083L10.8334 3.25" stroke="#FDB932" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    {{ $customerEmail }}
                                </p>

                                <p>
                                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.10398 2.10327L4.78648 3.6391C4.9269 3.95535 4.8554 4.32685 4.60898 4.57327L3.86732 5.31493C4.4744 6.6116 5.5149 7.65156 6.81098 8.2586L7.55265 7.51693C7.79907 7.27052 8.17057 7.19902 8.48682 7.33943L10.0227 8.02193C10.4046 8.19152 10.6169 8.60768 10.5264 9.01518L10.3103 9.98885C10.2226 10.3833 9.87332 10.6666 9.46932 10.6666C5.52398 10.6666 2.3334 7.47602 2.3334 3.53068C2.3334 3.12668 2.61673 2.77743 3.01115 2.68977L3.98482 2.4736C4.39232 2.3831 4.80848 2.59543 4.97807 2.97735L4.10398 2.10327Z" stroke="#FDB932" stroke-width="1.1" stroke-linejoin="round"/>
                                    </svg>
                                    {{ $customerPhone }}
                                </p>

                                <p>
                                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.5 11.375C6.5 11.375 10.0208 8.125 10.0208 5.41667C10.0208 3.47266 8.44401 1.89583 6.5 1.89583C4.55599 1.89583 2.97917 3.47266 2.97917 5.41667C2.97917 8.125 6.5 11.375 6.5 11.375Z" stroke="#FDB932" stroke-width="1.1"/>
                                        <path d="M6.5 6.5C7.09831 6.5 7.58333 6.01498 7.58333 5.41667C7.58333 4.81836 7.09831 4.33333 6.5 4.33333C5.90169 4.33333 5.41667 4.81836 5.41667 5.41667C5.41667 6.01498 5.90169 6.5 6.5 6.5Z" stroke="#FDB932" stroke-width="1.1"/>
                                    </svg>
                                    Address: {{ $customerAddress }}
                                </p>

                                <p>
                                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.5 11.375C6.5 11.375 10.0208 8.125 10.0208 5.41667C10.0208 3.47266 8.44401 1.89583 6.5 1.89583C4.55599 1.89583 2.97917 3.47266 2.97917 5.41667C2.97917 8.125 6.5 11.375 6.5 11.375Z" stroke="#FDB932" stroke-width="1.1"/>
                                        <path d="M6.5 6.5C7.09831 6.5 7.58333 6.01498 7.58333 5.41667C7.58333 4.81836 7.09831 4.33333 6.5 4.33333C5.90169 4.33333 5.41667 4.81836 5.41667 5.41667C5.41667 6.01498 5.90169 6.5 6.5 6.5Z" stroke="#FDB932" stroke-width="1.1"/>
                                    </svg>
                                    Preferred: {{ $preferredSchedule }}
                                </p>
                            </div>

                            <div class="customer-request-card__action">
                                @if(auth()->user()?->isProvider())
                                    @if($request->status === 'open' && !$ownApplication)
                                        <form method="POST" action="{{ route('customer-requests.apply', $request) }}" id="{{ $formId }}">
                                            @csrf
                                            <input type="hidden" name="notes" value="">

                                            <button
                                                type="button"
                                                class="customer-request-btn js-customer-request-apply"
                                                data-form-id="{{ $formId }}"
                                                data-title="{{ $request->title }}"
                                            >
                                                Apply to Request
                                            </button>
                                        </form>
                                    @elseif($ownApplication)
                                        <span class="customer-request-applied">
                                            Application {{ ucfirst($ownApplication->status) }}
                                        </span>
                                    @else
                                        <span class="customer-request-applied">
                                            Closed for applications
                                        </span>
                                    @endif
                                @else
                                    <span class="customer-request-applied">
                                        Admin read-only view
                                    </span>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="customer-request-empty">
                        No customer requests available.
                    </div>
                @endforelse
            </div>

            <div class="customer-request-pagination">
                {{ $requests->appends(request()->query())->links() }}
            </div>
        </section>
    </main>
@endsection

@push('extrascripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.querySelector('[data-customer-request-search]');
        const sortButton = document.querySelector('[data-customer-request-sort]');
        const sortLabel = sortButton ? sortButton.querySelector('.sort-label') : null;
        const listUrl = @json(route('customer-requests.index'));
        const hasSortQuery = new URLSearchParams(window.location.search).has('sort');
        let activeSort = @json($sort);
        let nextSort = hasSortQuery && activeSort === 'newest' ? 'oldest' : 'newest';
        let requestController = null;
        let searchTimer = null;

        function bindApplyButtons() {
            document.querySelectorAll('.js-customer-request-apply').forEach((button) => {
                if (button.dataset.boundCustomerRequestApply === 'true') {
                    return;
                }

                button.dataset.boundCustomerRequestApply = 'true';
                button.addEventListener('click', () => {
                    const form = document.getElementById(button.dataset.formId);
                    const title = button.dataset.title || 'this request';

                    if (!form) {
                        return;
                    }

                    Swal.fire({
                        title: 'Apply to request',
                        text: title,
                        input: 'textarea',
                        inputPlaceholder: 'Add optional notes for the customer...',
                        inputAttributes: {
                            maxlength: 500,
                        },
                        customClass: {
                            input: 'customer-request-swal-notes',
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Apply',
                        cancelButtonText: 'Cancel',
                        confirmButtonColor: '#FDB932',
                        cancelButtonColor: '#6B7280',
                        reverseButtons: true,
                        preConfirm: (notes) => {
                            if (notes && notes.length > 500) {
                                Swal.showValidationMessage('Notes must not be longer than 500 characters.');
                                return false;
                            }

                            return notes || '';
                        },
                    }).then((result) => {
                        if (!result.isConfirmed) {
                            return;
                        }

                        const notesInput = form.querySelector('input[name="notes"]');

                        if (notesInput) {
                            notesInput.value = result.value || '';
                        }

                        form.submit();
                    });
                });
            });
        }

        function updateSortLabel() {
            if (!sortLabel) {
                return;
            }

            sortLabel.textContent = nextSort === 'newest' ? 'Sort to Newest' : 'Sort to Oldest';
        }

        function buildUrl(pageUrl = null) {
            const url = new URL(pageUrl || listUrl, window.location.origin);
            const query = searchInput ? searchInput.value.trim() : '';

            if (query) {
                url.searchParams.set('q', query);
            } else {
                url.searchParams.delete('q');
            }

            url.searchParams.set('sort', activeSort);
            return url;
        }

        function replaceRequestList(html) {
            const nextDocument = new DOMParser().parseFromString(html, 'text/html');
            const nextGrid = nextDocument.querySelector('.customer-request-grid');
            const nextPagination = nextDocument.querySelector('.customer-request-pagination');
            const currentGrid = document.querySelector('.customer-request-grid');
            const currentPagination = document.querySelector('.customer-request-pagination');

            if (nextGrid && currentGrid) {
                currentGrid.innerHTML = nextGrid.innerHTML;
            }

            if (nextPagination && currentPagination) {
                currentPagination.innerHTML = nextPagination.innerHTML;
            }

            bindApplyButtons();
        }

        function loadRequests(pageUrl = null) {
            const url = buildUrl(pageUrl);

            if (requestController) {
                requestController.abort();
            }

            requestController = new AbortController();

            fetch(url.toString(), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                signal: requestController.signal,
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error('Request failed.');
                    }

                    return response.text();
                })
                .then((html) => {
                    replaceRequestList(html);
                    window.history.replaceState({}, '', url.toString());
                })
                .catch((error) => {
                    if (error.name === 'AbortError') {
                        return;
                    }

                    window.location.href = url.toString();
                });
        }

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                window.clearTimeout(searchTimer);
                searchTimer = window.setTimeout(() => loadRequests(), 250);
            });
        }

        if (sortButton) {
            sortButton.addEventListener('click', function () {
                activeSort = nextSort;
                nextSort = activeSort === 'newest' ? 'oldest' : 'newest';
                updateSortLabel();
                loadRequests();
            });
        }

        document.addEventListener('click', function (event) {
            const paginationLink = event.target.closest('.customer-request-pagination a');

            if (!paginationLink) {
                return;
            }

            event.preventDefault();
            loadRequests(paginationLink.href);
        });

        updateSortLabel();
        bindApplyButtons();
    });
</script>
@endpush
