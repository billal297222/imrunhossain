@extends('backend.master')

@section('title', 'Amenities Category Management')

@section('content')
<div class="row">
    <div class="col-lg-12 col-12 mb-4">
        <h3>Amenities Category Management</h3>
    </div>
</div>

<div class="row">
    <!-- Category List -->
    <div class="col-lg-7 col-12">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Amenities Category List</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="categoryTable" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Forms -->
    <div class="col-lg-5 col-12">
        <!-- Add Form -->
        <div id="addForm">
            <form id="addCategoryForm">
                @csrf
                <div class="card mb-4">
                    <div class="card-header  text-white text-center">
                        <h5 class="mb-0 "><i class="bi bi-plus-circle"></i> Add Category</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g., Swimming Pool">
                            <div class="text-danger error-field" id="error-name"></div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-success" id="createCategoryBtn">
                                <i class="bi bi-plus-circle"></i> Create
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Edit Form -->
        <div id="editForm" class="d-none">
            <form id="editCategoryForm">
                @csrf
                <input type="hidden" name="id" id="editCategoryId">
                <div class="card mb-4">
                    <div class="card-header bg-warning text-center text-white">
                        <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Category</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" name="name" class="form-control">
                            <div class="text-danger error-field" id="edit-error-name"></div>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-success" id="updateCategoryBtn">
                                <i class="bi bi-check-circle"></i> Update
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="hideEditForm()">
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function clearErrors(prefix = '') {
    if(prefix) {
        $(`[id^="${prefix}error-"]`).text('');
    } else {
        $('.error-field').text('');
    }
}

function hideEditForm() {
    $('#editForm').addClass('d-none');
    $('#addForm').removeClass('d-none');
    $('#editCategoryForm')[0].reset();
    clearErrors('edit-');
}

$(document).ready(function() {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });

    // DataTable
    const table = $('#categoryTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('AmenitiesCategory.getData') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        ordering: false
    });

    // Show edit form
    $(document).on('click', '.btn-edit', function() {
        clearErrors();
        const id = $(this).data('id');
        const name = $(this).data('title');

        $('#addForm').addClass('d-none');
        $('#editForm').removeClass('d-none');
        $('#editCategoryId').val(id);
        $('#editCategoryForm input[name="name"]').val(name);
    });

    // Create Category
    $('#createCategoryBtn').click(function() {
        clearErrors();
        const formData = new FormData($('#addCategoryForm')[0]);

        $(this).prop('disabled', true).text('Saving...');

        $.ajax({
            url: "{{ route('amenities.category.store') }}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                table.ajax.reload();
                $('#addCategoryForm')[0].reset();
                toastr.success(response.message || 'Category created successfully.');
            },
            error: function(xhr) {
                if(xhr.status === 422 && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    Object.entries(errors).forEach(([field, msgs]) => {
                        $(`#error-${field}`).text(msgs[0]);
                        $(`[name="${field}"]`).css('border','1px solid red');
                    });
                } else {
                    toastr.error(xhr.responseJSON?.message || 'Failed to create category.');
                }
            },
            complete: function() {
                $('#createCategoryBtn').prop('disabled', false).html('<i class="bi bi-plus-circle"></i> Create');
            }
        });
    });

    // Update Category
    $('#updateCategoryBtn').click(function() {
        clearErrors('edit-');
        const id = $('#editCategoryId').val();
        if(!id) return toastr.error('Invalid category ID.');

        const formData = new FormData($('#editCategoryForm')[0]);

        $(this).prop('disabled', true).text('Updating...');

        $.ajax({
            url: `/admin/amenities-category/${id}`,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {

                table.ajax.reload();
                hideEditForm();
                toastr.success(response.message || 'Category updated successfully.');
            },
            error: function(xhr) {
                if(xhr.status === 422 && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    Object.entries(errors).forEach(([field, msgs]) => {
                        $(`#edit-error-${field}`).text(msgs[0]);
                        $(`#editCategoryForm [name="${field}"]`).css('border','1px solid red');
                    });
                } else {
                    toastr.error(xhr.responseJSON?.message || 'Failed to update category.');
                }
            },
            complete: function() {
                $('#updateCategoryBtn').prop('disabled', false).html('<i class="bi bi-check-circle"></i> Update');
            }
        });
    });


  $(document).on('click', '.btn-toggle-status', function() {
        const id = $(this).data('id');
        if(!id) return;

        $.ajax({
            url: `/admin/amenities-category/toggle_status/${id}`,
            method: 'POST',
            success: function(response) {
                table.ajax.reload();
                toastr.success(response.message || 'Category status updated successfully.');
            },
            error: function() {
                toastr.error('Failed to update category status.');
            }
        });
    });














    // Delete Category
    $(document).on('click', '.btn-delete', function() {
        const id = $(this).data('id');
        if(!id) return;

        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if(result.isConfirmed) {
                $.ajax({
                    url: `/admin/amenities-category/delete/${id}`,
                    method: 'POST',
                    success: function(response) {
                        table.ajax.reload();
                        toastr.success(response.message || 'Category deleted successfully.');
                    },
                    error: function() {
                        toastr.error('Failed to delete category.');
                    }
                });
            }
        });
    });
});
</script>
@endpush
