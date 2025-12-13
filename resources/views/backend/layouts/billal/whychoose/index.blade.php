@extends('backend.master')

@section('title', 'Why Choose Management')

@section('content')
<div class="row">
    <div class="col-lg-12 col-12 mb-4">
        <h3>Why Choose Management</h3>
    </div>
</div>

<div class="row">
    <!-- Why Choose List -->
    <div class="col-lg-8 col-12">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Why Choose List</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="whyChooseTable" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Overlay Text</th>
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

    <!-- Forms: Add + Edit -->
    <div class="col-lg-4 col-12">

        <!-- Add Form -->
        <div id="addForm">
            <form id="addWhyChooseForm" enctype="multipart/form-data">
                @csrf
                <div class="card mb-4">
                    <div class="card-header text-center text-white">
                        <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Add Why Choose</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Overlay Text</label>
                            <textarea name="overlay_text" class="form-control" rows="3" placeholder="Enter overlay text"></textarea>
                            <div class="text-danger error-field" id="error-overlay_text"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Image <span class="text-danger">*</span></label>
                            <input type="file" name="image" class="form-control" accept="image/*">

                            <div class="text-danger error-field" id="error-image"></div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-success" id="createWhyChooseBtn">
                                <i class="bi bi-plus-circle"></i> Create
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Edit Form -->
        <div id="editForm" class="d-none">
            <form id="editWhyChooseForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="editWhyChooseId">
                <div class="card mb-4">
                    <div class="card-header text-center text-white">
                        <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Why Choose</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Overlay Text</label>
                            <textarea name="overlay_text" id="editOverlayText" class="form-control" rows="3"></textarea>
                            <div class="text-danger error-field" id="edit-error-overlay_text"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Current Image</label>
                            <div id="currentImageContainer" class="mb-2 text-center">
                                <img id="currentImagePreview" src="" class="square-img mb-2" style="display: none; max-width: 100%; height: auto; border-radius: 8px;">
                                <div id="noImageMessage" class="text-muted">No image uploaded</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Change Image (Optional)</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <div class="text-danger error-field" id="edit-error-image"></div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-outline-success" id="updateWhyChooseBtn">
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

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
<style>
.error-field { min-height: 20px; }
.square-img {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #dee2e6;
}
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function clearErrors(prefix = '') {
    if (prefix) {
        $(`[id^="${prefix}error-"]`).text('');
    } else {
        $('.error-field').text('');
    }
}

function hideEditForm() {
    $('#editForm').addClass('d-none');
    $('#addForm').removeClass('d-none');
    $('#editWhyChooseForm')[0].reset();
    clearErrors('edit-');
    $('#currentImagePreview').hide();
    $('#noImageMessage').show();
}

$(document).ready(function() {
    $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });

    // DataTable
    const table = $('#whyChooseTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('whychoose.index') }}",
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'image', orderable: false, searchable: false },
            { data: 'overlay_text' },
            { data: 'status', orderable: false, searchable: false },
            { data: 'action', orderable: false, searchable: false }
        ],
        ordering: false
    });

    // Show edit form
    $(document).on('click', '.btn-edit', function() {
        clearErrors();
        const id = $(this).data('id');
        const overlay_text = $(this).data('overlay_text');
        const image = $(this).data('image');

        $('#editWhyChooseId').val(id);
        $('#editOverlayText').val(overlay_text);

        if (image) {
            $('#currentImagePreview').attr('src', image).show();
            $('#noImageMessage').hide();
        } else {
            $('#currentImagePreview').hide();
            $('#noImageMessage').show();
        }

        $('#addForm').addClass('d-none');
        $('#editForm').removeClass('d-none');
    });

    // Create Why Choose
    $('#createWhyChooseBtn').click(function() {
        clearErrors();
        const formData = new FormData($('#addWhyChooseForm')[0]);
        $(this).prop('disabled', true).text('Saving...');

        $.ajax({
            url: "{{ route('whychoose.store') }}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                table.ajax.reload();
                $('#addWhyChooseForm')[0].reset();
                toastr.success(response.message || 'Entry created successfully');
            },
            error: function(xhr) {
                if(xhr.status === 422 && xhr.responseJSON.errors){
                    Object.entries(xhr.responseJSON.errors).forEach(([field, msgs]) => {
                        $(`#error-${field}`).text(msgs[0]);
                    });
                } else {
                    toastr.error('Failed to create entry');
                }
            },
            complete: function() {
                $('#createWhyChooseBtn').prop('disabled', false).html('<i class="bi bi-plus-circle"></i> Create');
            }
        });
    });

    // Update Why Choose
    $('#updateWhyChooseBtn').click(function() {
        clearErrors('edit-');
        const id = $('#editWhyChooseId').val();
        const formData = new FormData($('#editWhyChooseForm')[0]);
        $(this).prop('disabled', true).text('Updating...');

        $.ajax({
            url: `/why-choose/update/${id}`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response){
                table.ajax.reload();
                toastr.success(response.message || 'Entry updated successfully');
                hideEditForm();
            },
            error: function(xhr){
                if(xhr.status === 422 && xhr.responseJSON.errors){
                    Object.entries(xhr.responseJSON.errors).forEach(([field, msgs]) => {
                        $(`#edit-error-${field}`).text(msgs[0]);
                    });
                } else {
                    toastr.error('Failed to update entry');
                }
            },
            complete: function() {
                $('#updateWhyChooseBtn').prop('disabled', false).html('<i class="bi bi-check-circle"></i> Update');
            }
        });
    });

    // Toggle Status
    $(document).on('click', '.btn-toggle-status', function() {
        const id = $(this).data('id');
        if(!id) return;
        $.ajax({
            url: `/why-choose/toggle-status/${id}`,
            type: 'POST',
            data: {_token: $('meta[name="csrf-token"]').attr('content')},
            success: function(response){
                table.ajax.reload(null, false);
                toastr.success(response.message || 'Status updated');
            },
            error: function(){
                toastr.error('Failed to update status');
            }
        });
    });

    // Delete Entry
    $(document).on('click', '.btn-delete', function() {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This entry will be permanently deleted.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonText: 'Cancel',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    url: `/why-choose/destroy/${id}`,
                    type: 'POST',
                    data: {_method: 'DELETE', _token: $('meta[name="csrf-token"]').attr('content')},
                    success: function(response) {
                        table.ajax.reload();
                        toastr.success(response.message);
                    },
                    error: function() {
                        toastr.error('Failed to delete entry.');
                    }
                });
            }
        });
    });

});
</script>
@endpush
