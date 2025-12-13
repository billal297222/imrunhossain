@extends('backend.master')

@section('title', 'Banner Management')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="mb-5">
                <h3 class="mb-0">Banner Management</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Banner List -->
        <div class="col-lg-7 col-12">
            <div class="card mb-4">
                <div class="card-header d-md-flex border-bottom-0">
                    <div class="flex-grow-1">
                        <a href="#" class="text-bolder">
                            <label class="form-label">Banner List</label>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card p-3">
                        <table id="bannerTable"
                            class="table table-striped table-hover align-middle text-nowrap table-centered p-3">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Type</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- DataTables will populate -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Banner Forms -->
        <div class="col-lg-5 col-12">
            <!-- Add Banner Form -->
            <div id="addBannerForm">
                <form id="addBanner" enctype="multipart/form-data">
                    @csrf
                    <div class="card shadow-sm mb-2">
                        <div class="card-header text-white text-center">
                            <h5 class="mb-0">
                                <i class="bi bi-plus-circle me-2"></i> Add Banner
                            </h5>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">

                            <!-- Banner Type -->
                            <div class="mb-3">
                                <label class="form-label">Banner Type <span class="text-danger">*</span></label>
                                <select name="banner_type" class="form-select" required>
                                    <option value="">-- Select Type --</option>
                                    <option value="home_banner">Home Banner</option>
                                    <option value="apartment_listing">Apartment Listing</option>
                                    <option value="menu">Menu</option>
                                    <option value="faq">FAQ</option>
                                    <option value="about_us">About Us</option>
                                </select>
                                <div class="text-danger error-field mt-1" id="error-banner_type"></div>
                            </div>

                            <!-- Image Upload -->
                            <div class="mb-3">
                                <label class="form-label">Banner Image <span class="text-danger">*</span></label>
                                <input type="file" name="image" class="form-control" accept="image/*"
                                    onchange="previewImage(event)">
                                <div class="text-danger error-field mt-1" id="error-image"></div>

                                <div class="mt-3">
                                    <img id="addImagePreview"
                                        src=""
                                        alt="Preview" class="img-thumbnail"
                                        style="max-width: 200px; display: none;">
                                </div>
                            </div>

                            <!-- Title -->
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control"
                                    placeholder="e.g., Discover Your Dream Apartment">
                                <div class="text-danger error-field mt-1" id="error-title"></div>
                            </div>

                            <!-- Short Description -->
                            <div class="mb-3">
                                <label class="form-label">Short Description</label>
                                <textarea name="short_description" class="form-control" rows="3"
                                    placeholder="A short tagline or highlight..."></textarea>
                                <div class="text-danger error-field mt-1" id="error-short_description"></div>
                            </div>

                            <!-- Create Button -->
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-outline-success mb-4 banner_create">
                                    <i class="bi bi-plus-circle"></i> Create
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Edit Banner Form (hidden by default) -->
            <div id="editBannerForm" class="d-none">
                <form id="editBanner" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="editBannerId">

                    <div class="card shadow-sm mb-2">
                        <div class="card-header text-white text-center bg-warning">
                            <h5 class="mb-0">
                                <i class="bi bi-pencil-square me-2"></i> Edit Banner
                            </h5>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">

                            <!-- Banner Type -->
                            <div class="mb-3">
                                <label class="form-label">Banner Type <span class="text-danger">*</span></label>
                                <select name="banner_type" class="form-select" required>
                                    <option value="">-- Select Type --</option>
                                    <option value="home_banner">Home Banner</option>
                                    <option value="apartment_listing">Apartment Listing</option>
                                    <option value="menu">Menu</option>
                                    <option value="faq">FAQ</option>
                                    <option value="about_us">About Us</option>
                                </select>
                                <div class="text-danger error-field mt-1" id="edit-error-banner_type"></div>
                            </div>

                            <!-- Image Upload -->
                            <div class="mb-3">
                                <label class="form-label">Banner Image</label>
                                <input type="file" name="image" class="form-control" accept="image/*"
                                    onchange="previewEditImage(event)">
                                <div class="text-danger error-field mt-1" id="edit-error-image"></div>

                                <div class="mt-3">
                                    <img id="editImagePreview"
                                        src=""
                                        alt="Preview" class="img-thumbnail"
                                        style="max-width: 200px; display: none;">
                                </div>
                            </div>

                            <!-- Title -->
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control"
                                    placeholder="e.g., Discover Your Dream Apartment">
                                <div class="text-danger error-field mt-1" id="edit-error-title"></div>
                            </div>

                            <!-- Short Description -->
                            <div class="mb-3">
                                <label class="form-label">Short Description</label>
                                <textarea name="short_description" class="form-control" rows="3"
                                    placeholder="A short tagline or highlight..."></textarea>
                                <div class="text-danger error-field mt-1" id="edit-error-short_description"></div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <button type="button" class="btn btn-success banner_update px-4">
                                    <i class="bi bi-check-circle"></i> Update
                                </button>
                                <button type="button" onclick="hideEditForm()" class="btn btn-outline-secondary px-4">
                                    <i class="bi bi-x-circle"></i> Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<!-- Toastr / SweetAlert -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Ensure CSRF meta exists in your master; this duplicates safely if already present -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    // ------------------------
    // Utility: clear field errors
    // prefix: '' for add, 'edit-' for edit fields that use ids like edit-error-<field>
    // ------------------------
    function clearErrors(prefix = '') {
        // clear text messages
        if (prefix) {
            $(`[id^="${prefix}error-"]`).text(''); // e.g., #edit-error-title
        } else {
            $('.error-field').text('');
        }

        // clear border highlights (handles both add and edit)
        $('[name]').css('border', '');
    }

    // ------------------------
    // Image preview functions
    // ------------------------
    function previewImage(event) {
        const file = event.target.files?.[0];
        const preview = document.getElementById('addImagePreview');
        if (!preview) return;

        if (!file) {
            preview.style.display = 'none';
            preview.src = '';
            return;
        }

        // Validation: ensure this is image
        if (!file.type.startsWith('image/')) {
            alert('Please select a valid image (JPG, PNG, WEBP, GIF).');
            event.target.value = '';
            preview.style.display = 'none';
            preview.src = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }

    function previewEditImage(event) {
        const file = event.target.files?.[0];
        const preview = document.getElementById('editImagePreview');
        if (!preview) return;

        if (!file) {
            preview.style.display = 'none';
            preview.src = '';
            return;
        }

        if (!file.type.startsWith('image/')) {
            alert('Please select a valid image (JPG, PNG, WEBP, GIF).');
            event.target.value = '';
            preview.style.display = 'none';
            preview.src = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }

    // ------------------------
    // Hide edit form -> show add form
    // ------------------------
    function hideEditForm() {
        $('#editBannerForm').addClass('d-none');
        $('#addBannerForm').removeClass('d-none');

        // Reset edit form fields & preview
        $('#editBanner')[0].reset();
        $('#editImagePreview').hide().attr('src', '');
        clearErrors('edit-');
    }

    $(document).ready(function () {
        // Setup global ajax headers for csrf
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // ------------------------
        // DataTable
        // ------------------------
        const table = $('#bannerTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('banner.getData') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'banner_type', name: 'banner_type' },
                {
                    data: 'image',
                    name: 'image',


                },
                { data: 'title', name: 'title' },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,

                }
            ],
            language: {
                searchPlaceholder: "Search banners...",
                search: "",
                info: "Showing _START_ to _END_ of _TOTAL_ banners",
                paginate: {
                    previous: "‹",
                    next: "›"
                }
            },
            ordering: false
        });

        // Helper to escape values used in attributes (very small helper)
        function escapeHtml(str) {
            if (!str) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;');
        }

        // ------------------------
        // Edit: show edit form and populate
        // ------------------------
        $(document).on('click', '.btn-edit', function () {
            clearErrors();

            const id = $(this).data('id');
            const title = $(this).data('title') || '';
            const desc = $(this).data('short_description') || '';
            const type = $(this).data('banner_type') || '';
            const imageUrl = $(this).data('image') || '';

            // Toggle forms
            $('#addBannerForm').addClass('d-none');
            $('#editBannerForm').removeClass('d-none');

            // Fill fields
            $('#editBannerId').val(id);
            $('#editBanner select[name="banner_type"]').val(type);
            $('#editBanner input[name="title"]').val(title);
            $('#editBanner textarea[name="short_description"]').val(desc);

            // Show existing image (if any)
            if (imageUrl) {
                $('#editImagePreview').attr('src', imageUrl).show();
            } else {
                $('#editImagePreview').hide().attr('src', '');
            }

            clearErrors('edit-');
        });

        // ------------------------
        // Create Banner (AJAX)
        // ------------------------
        $(document).on('click', '.banner_create', function (e) {
            e.preventDefault();
            clearErrors();

            const form = $('#addBanner')[0];
            const formData = new FormData(form);

            // Client-side minimal validation before sending
            let hasError = false;
            if (!$('select[name="banner_type"]').val()) {
                $('#error-banner_type').text('Banner type is required');
                $('select[name="banner_type"]').css('border', '1px solid red');
                hasError = true;
            }
            if (!$('input[name="image"]')[0].files.length) {
                $('#error-image').text('Banner image is required');
                $('input[name="image"]').css('border', '1px solid red');
                hasError = true;
            }
            if (hasError) return;

            $(this).prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Saving...');

            $.ajax({
                url: "{{ route('banner.store') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success || response.message) {
                        table.ajax.reload();
                        $('#addBanner')[0].reset();
                        $('#addImagePreview').hide().attr('src', '');
                        toastr.success(response.message || 'Banner created successfully.');
                    } else {
                        toastr.error(response.message || 'Failed to create banner.');
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        const errors = xhr.responseJSON.errors;
                        Object.entries(errors).forEach(([field, msgs]) => {
                            $(`#error-${field}`).text(msgs[0]);
                            $(`[name="${field}"]`).css('border', '1px solid red');
                        });
                    } else {
                        toastr.error(xhr.responseJSON?.message || 'An error occurred while creating banner.');
                    }
                },
                complete: function () {
                    $('.banner_create').prop('disabled', false).html('<i class="bi bi-plus-circle"></i> Create');
                }
            });
        });

        // ------------------------
        // Update Banner (AJAX)
        // ------------------------
        $(document).on('click', '.banner_update', function (e) {
            e.preventDefault();
            clearErrors('edit-');

            const id = $('#editBannerId').val();
            if (!id) {
                toastr.error('Invalid banner ID.');
                return;
            }

            const form = $('#editBanner')[0];
            const formData = new FormData(form);
            {{--  formData.append('_method', 'PUT');  --}}

            $('.banner_update').prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Updating...');

            $.ajax({
                url: `/admin/banner/${id}`,
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success || response.message) {
                        table.ajax.reload();
                        hideEditForm();
                        toastr.success(response.message || 'Banner updated successfully.');
                    } else {
                        toastr.error(response.message || 'Failed to update banner.');
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        const errors = xhr.responseJSON.errors;
                        Object.entries(errors).forEach(([field, msgs]) => {
                            $(`#edit-error-${field}`).text(msgs[0]);
                            $(`#editBanner [name="${field}"]`).css('border', '1px solid red');
                        });
                    } else {
                        toastr.error(xhr.responseJSON?.message || 'An error occurred while updating banner.');
                    }
                },
                complete: function () {
                    $('.banner_update').prop('disabled', false).html('<i class="bi bi-check-circle"></i> Update');
                }
            });
        });

        // ------------------------
        // Delete Banner (AJAX) - fixed
        // ------------------------
        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();
            const id = $(this).data('id');
            if (!id) return;

            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/banner/delete/${id}`,
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.success || response.message) {
                                table.ajax.reload();
                                toastr.success(response.message || 'Banner deleted successfully.');
                            } else {
                                toastr.error(response.message || 'Failed to delete banner.');
                            }
                        },
                        error: function () {
                            toastr.error('Failed to delete banner.');
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
