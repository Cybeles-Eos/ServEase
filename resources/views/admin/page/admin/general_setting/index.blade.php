@extends('admin.layouts.auth')

{{-- Meta Section --}}
@section('title', 'Admin Users Page')

{{-- Page Content --}}
@section('content')
    @include('admin.layouts.header')
    {{-- @include('admin.layouts.sidebar') --}}

    <main class="main-dash-uix page-admin-setting dash-sp">
        <p>General Setting</p>
        <hr>
        <section class="p-a-gs-card section service-category">
            <div class="p-a-gs-card-header">
                <h5>Service Category</h5>

                <form
                    action="{{ route('admin.setting.service-categories.store') }}"
                    method="POST"
                    class="mct-inline-create-form"
                >
                    @csrf

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Add category name here..."
                        required
                    >

                    <button type="submit">
                        Add Category
                    </button>
                </form>
            </div>

            @error('name')
                <small class="mct-form-error">{{ $message }}</small>
            @enderror

            <hr>

            {{-- Minimal Table Here --}}
            <div class="mct-table-wrapper">
                <table class="mct-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Created At</th>
                            <th class="mct-text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($serviceCategories as $category)
                            <tr>
                                <td>
                                    <div class="mct-name-with-status">
                                        <span>{{ $category->name }}</span>

                                        @if ($category->is_active)
                                            <small class="mct-status mct-status-active">Active</small>
                                        @else
                                            <small class="mct-status mct-status-disabled">Disabled</small>
                                        @endif
                                    </div>
                                </td>

                                <td>
                                    {{ $category->created_at->format('M d, Y') }}
                                </td>

                                <td>
                                    <div class="mct-actions">
                                        <button
                                            type="button"
                                            class="mct-action-btn"
                                            title="View"
                                            onclick="openViewCategoryModal(this)"
                                            data-name="{{ $category->name }}"
                                            data-status="{{ $category->is_active ? 'Active' : 'Disabled' }}"
                                            data-created="{{ $category->created_at->format('M d, Y h:i A') }}"
                                        >
                                            <i class="fa fa-eye"></i>
                                        </button>

                                        <button
                                            type="button"
                                            class="mct-action-btn"
                                            title="Edit"
                                            onclick="openEditCategoryModal(this)"
                                            data-name="{{ $category->name }}"
                                            data-active="{{ $category->is_active ? 1 : 0 }}"
                                            data-update-url="{{ route('admin.setting.service-categories.update', $category) }}"
                                        >
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3 13V10.6389L10.3333 3.31944C10.4444 3.21759 10.5672 3.13889 10.7017 3.08333C10.8361 3.02778 10.9772 3 11.125 3C11.2728 3 11.4163 3.02778 11.5556 3.08333C11.6948 3.13889 11.8152 3.22222 11.9167 3.33333L12.6806 4.11111C12.7917 4.21296 12.8728 4.33333 12.9239 4.47222C12.975 4.61111 13.0004 4.75 13 4.88889C13 5.03704 12.9746 5.17833 12.9239 5.31278C12.8731 5.44722 12.792 5.56981 12.6806 5.68056L5.36111 13H3ZM11.1111 5.66667L11.8889 4.88889L11.1111 4.11111L10.3333 4.88889L11.1111 5.66667Z" fill="#535353"/>
                                        </svg>
                                        </button>

                                        <form
                                            action="{{ route('admin.setting.service-categories.destroy', $category) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this category?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="mct-action-btn mct-action-delete" title="Delete">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="mct-empty">
                                    No service categories found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    {{-- Modals For Service Category --}}
    <div class="mct-modal" id="editCategoryModal">
        <div class="mct-modal-backdrop" onclick="closeEditCategoryModal()"></div>

        <div class="mct-modal-box">
            <div class="mct-modal-header">
                <h5>Edit Service Category</h5>

                <button type="button" onclick="closeEditCategoryModal()">
                    &times;
                </button>
            </div>

            <form method="POST" id="editCategoryForm">
                @csrf
                @method('PUT')

                <div class="mct-modal-body">
                    <div class="mct-form-group">
                        <label>Category Name</label>
                        <input
                            type="text"
                            name="name"
                            id="editCategoryName"
                            required
                        >
                    </div>

                    <div class="mct-toggle-row">
                        <div>
                            <label>Enable Category</label>
                            <small>Turn off to disable this category.</small>
                        </div>

                        <label class="mct-switch">
                            <input
                                type="checkbox"
                                name="is_active"
                                value="1"
                                id="editCategoryStatus"
                            >
                            <span></span>
                        </label>
                    </div>
                </div>

                <div class="mct-modal-footer">
                    <button type="button" class="mct-btn-light" onclick="closeEditCategoryModal()">
                        Cancel
                    </button>

                    <button type="submit" class="mct-btn-dark">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="mct-modal" id="viewCategoryModal">
        <div class="mct-modal-backdrop" onclick="closeViewCategoryModal()"></div>

        <div class="mct-modal-box">
            <div class="mct-modal-header">
                <h5>View Service Category</h5>

                <button type="button" onclick="closeViewCategoryModal()">
                    &times;
                </button>
            </div>

            <div class="mct-modal-body">
                <div class="mct-view-row">
                    <span>Name</span>
                    <strong id="viewCategoryName"></strong>
                </div>

                <div class="mct-view-row">
                    <span>Status</span>
                    <strong id="viewCategoryStatus"></strong>
                </div>

                <div class="mct-view-row">
                    <span>Created At</span>
                    <strong id="viewCategoryCreated"></strong>
                </div>
            </div>

            <div class="mct-modal-footer">
                <button type="button" class="mct-btn-light" onclick="closeViewCategoryModal()">
                    Close
                </button>
            </div>
        </div>
    </div>


    {{-- Only Show When Someone is login --}}
@endsection
@push('extrascripts')
    {{-- For ServiceCategory --}}
    <script>
        function openEditCategoryModal(button) {
            const modal = document.getElementById('editCategoryModal');
            const form = document.getElementById('editCategoryForm');
            const nameInput = document.getElementById('editCategoryName');
            const statusInput = document.getElementById('editCategoryStatus');

            form.action = button.dataset.updateUrl;
            nameInput.value = button.dataset.name;
            statusInput.checked = button.dataset.active === '1';

            modal.classList.add('show');
        }

        function closeEditCategoryModal() {
            document.getElementById('editCategoryModal').classList.remove('show');
        }

        function openViewCategoryModal(button) {
            document.getElementById('viewCategoryName').innerText = button.dataset.name;
            document.getElementById('viewCategoryStatus').innerText = button.dataset.status;
            document.getElementById('viewCategoryCreated').innerText = button.dataset.created;

            document.getElementById('viewCategoryModal').classList.add('show');
        }

        function closeViewCategoryModal() {
            document.getElementById('viewCategoryModal').classList.remove('show');
        }
    </script>
@endpush