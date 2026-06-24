@extends('admin.layouts.auth')

@section('title', 'Contact Messages')

@push('extrastylesheets')
<style>
    .page-admin-contacts__pagination {
        margin-top: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        border-top: 1px solid #EEF0F3;
        padding-top: 12px;
    }

    .page-admin-contacts__pagination p {
        margin: 0;
        color: #374151;
        font-size: 12px;
        line-height: 1.4;
    }

    .page-admin-contacts__pagination-actions {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .page-admin-contacts__page-btn,
    .page-admin-contacts__page-info {
        min-width: 30px;
        height: 30px;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        text-decoration: none;
    }

    .page-admin-contacts__page-btn {
        border: 1px solid #E5E7EB;
        background: #FFFFFF;
        color: #374151;
    }

    .page-admin-contacts__page-btn--active,
    .page-admin-contacts__page-btn:hover {
        border-color: #111827;
        background: #111827;
        color: #FFFFFF;
    }

    .page-admin-contacts__page-btn.is-disabled {
        background: #F9FAFB;
        color: #9CA3AF;
        cursor: not-allowed;
    }

    .page-admin-contacts__page-btn svg {
        display: block;
    }

    .page-admin-contacts__page-info {
        border: 1px solid #E5E7EB;
        background: #FFFFFF;
        color: #6B7280;
        padding: 0 9px;
        white-space: nowrap;
    }

    @media (max-width: 592px) {
        .page-admin-contacts__pagination {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
@include('admin.layouts.header')

<main class="main-dash-uix page-admin-contacts dash-sp">
    <p style="margin: 0; font-size: 14px; opacity: .6">
        View contact messages, booking questions, provider concerns, and platform suggestions.
    </p>
    <hr style="margin-top: 10px">

    <section class="section__table">
        <div class="page-admin-contacts__table-head">
            <div class="page-admin-contacts__table-title">
                <h4>Contact Messages</h4>
                <p class="section__table--label">
                    Review messages sent from the Servease contact page.
                </p>
            </div>

            <form method="GET" action="{{ route('admin.contacts.index') }}" class="page-admin-contacts__filters" data-contact-filter-form>
                <div class="page-admin-contacts__search">
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
                        placeholder="Search contacts..."
                        autocomplete="off"
                        aria-label="Search contacts"
                        data-contact-search>
                </div>
            </form>
        </div>

        <div class="admin-ustbl-main">
            <div class="admin-ustbl-main-c admin-ustbl-main-c--contacts">
                <div class="admin-ustbl-main-c__head">
                    <div>ID</div>
                    <div>Name</div>
                    <div>Email</div>
                    <div>Phone</div>
                    <div>Subject</div>
                    <div>Actions</div>
                </div>

                @forelse ($contacts as $contact)
                    <div class="admin-ustbl-main-c__tbody">
                        <div class="prvstble-mctb-id">
                            {{ $contact->id }}
                        </div>

                        <div class="prvstble-mctb-name">
                            {{ $contact->fullname ?? 'No name' }}
                        </div>

                        <div class="prvstble-mctb-serv">
                            {{ $contact->email ?? 'No email' }}
                        </div>

                        <div class="prvstble-mctb-date">
                            {{ $contact->phone ?? 'No phone' }}
                        </div>

                        <div class="prvstble-mctb-date">
                            {{ \Illuminate\Support\Str::limit($contact->subject ?? 'No subject', 45) }}
                        </div>

                        <div class="prvstble-mctb-act">
                            <a href="{{ route('admin.contacts.show', $contact->id) }}"
                                title="View contact message"
                                class="applicant-action applicant-action--view">
                                <svg width="14" height="14" viewBox="0 0 16 16" fill="none">
                                    <path d="M8 3C4.5 3 1.73 5.11 1 8c.73 2.89 3.5 5 7 5s6.27-2.11 7-5c-.73-2.89-3.5-5-7-5Zm0 8.33a3.33 3.33 0 1 1 0-6.66 3.33 3.33 0 0 1 0 6.66Zm0-5.33a1.67 1.67 0 1 0 0 3.33 1.67 1.67 0 0 0 0-3.33Z"
                                        fill="currentColor"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="admin-ustbl-main-c__tbody admin-ustbl-main-c__tbody--empty">
                        {{ request('search') ? 'No contact messages match your search' : 'No contact messages yet' }}
                    </div>
                @endforelse
            </div>
        </div>

        <div class="page-admin-contacts__pagination">
            <p style="margin: 0">
                Showing {{ $contacts->total() ? $contacts->firstItem() : 0 }} to {{ $contacts->total() ? $contacts->lastItem() : 0 }} of {{ $contacts->total() }} results
            </p>

            @if ($contacts->hasPages())
                <div class="page-admin-contacts__pagination-actions">
                    @if ($contacts->onFirstPage())
                        <span class="page-admin-contacts__page-btn is-disabled" aria-disabled="true">
                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none">
                                <path d="M12.5 15L7.5 10L12.5 5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    @else
                        <a href="{{ $contacts->previousPageUrl() }}" class="page-admin-contacts__page-btn" aria-label="Previous page">
                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none">
                                <path d="M12.5 15L7.5 10L12.5 5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    @endif

                    <span class="page-admin-contacts__page-info">
                        {{ $contacts->currentPage() }} / {{ $contacts->lastPage() }}
                    </span>

                    @if ($contacts->hasMorePages())
                        <a href="{{ $contacts->nextPageUrl() }}" class="page-admin-contacts__page-btn page-admin-contacts__page-btn--active" aria-label="Next page">
                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none">
                                <path d="M7.5 5L12.5 10L7.5 15" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    @else
                        <span class="page-admin-contacts__page-btn is-disabled" aria-disabled="true">
                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none">
                                <path d="M7.5 5L12.5 10L7.5 15" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    @endif
                </div>
            @endif
        </div>
    </section>
</main>
@endsection

@push('extrascripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('[data-contact-filter-form]');

        if (!form) {
            return;
        }

        const searchInput = form.querySelector('[data-contact-search]');
        let searchTimer;

        searchInput.addEventListener('input', function () {
            window.clearTimeout(searchTimer);

            searchTimer = window.setTimeout(function () {
                const params = new URLSearchParams(new FormData(form));
                const search = searchInput.value.trim();

                params.delete('page');

                if (!search) {
                    params.delete('search');
                } else {
                    params.set('search', search);
                }

                const queryString = params.toString();
                window.location.href = queryString ? `${form.action}?${queryString}` : form.action;
            }, 450);
        });
    });
</script>
@endpush
