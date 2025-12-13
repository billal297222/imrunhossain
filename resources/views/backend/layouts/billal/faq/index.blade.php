@extends('backend.master')

@section('title', 'FAQ Management')

@section('content')
<div class="row">
    <div class="col-lg-12 col-12 mb-4">
        <h3>FAQ Management</h3>
    </div>
</div>

<div class="row">
    <!-- FAQ List -->
    <div class="col-lg-7 col-12">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">FAQ List</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="faqTable" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Question</th>
                                <th>Answer</th>
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
    <div class="col-lg-5 col-12">

        <!-- Add Form -->
        <div id="addForm">
            <form id="addFaqForm">
                @csrf
                <div class="card mb-4">
                    <div class="card-header text-center text-white">
                        <h5 class="mb-0"><i class="bi bi-question-circle"></i> Add FAQ</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Question</label>
                            <input type="text" name="que" class="form-control" placeholder="Enter question">
                            <div class="text-danger error-field" id="error-que"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Answer</label>
                            <textarea name="ans" class="form-control" rows="3" placeholder="Enter answer"></textarea>
                            <div class="text-danger error-field" id="error-ans"></div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-success" id="createFaqBtn">
                                <i class="bi bi-plus-circle"></i> Create
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Edit Form -->
        <div id="editForm" class="d-none">
            <form id="editFaqForm">
                @csrf
                <input type="hidden" name="id" id="editFaqId">
                <div class="card mb-4">
                    <div class="card-header text-center text-white ">
                        <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Edit FAQ</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Question</label>
                            <input type="text" name="que" class="form-control">
                            <div class="text-danger error-field" id="edit-error-que"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Answer</label>
                            <textarea name="ans" class="form-control" rows="3"></textarea>
                            <div class="text-danger error-field" id="edit-error-ans"></div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-outline-success" id="updateFaqBtn">
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
.faq-answer { font-family: 'Arial', sans-serif; font-size: 14px; line-height: 1.6; color: #333; }
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
    $('#editFaqForm')[0].reset();
    clearErrors('edit-');
}

$(document).ready(function() {
    $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });

    // DataTable
    const table = $('#faqTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('faq.index') }}",
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'que' },
            { data: 'ans' },
            { data: 'status', orderable: false, searchable: false },
            { data: 'action', orderable: false, searchable: false }
        ],
        ordering: false
    });

    // Show edit form
    $(document).on('click', '.btn-edit', function() {
        clearErrors();
        const id = $(this).data('id');
        const que = $(this).data('que');
        const ans = $(this).data('ans');

        $('#editFaqId').val(id);
        $('#editFaqForm input[name="que"]').val(que);
        $('#editFaqForm textarea[name="ans"]').val(ans);

        $('#addForm').addClass('d-none');
        $('#editForm').removeClass('d-none');
    });

    // Create FAQ
    $('#createFaqBtn').click(function() {
        clearErrors();
        const formData = new FormData($('#addFaqForm')[0]);
        $(this).prop('disabled', true).text('Saving...');

        $.ajax({
            url: "{{ route('faq.store') }}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                table.ajax.reload();
                $('#addFaqForm')[0].reset();
                toastr.success(response.message || 'FAQ created successfully');
            },
            error: function(xhr) {
                if(xhr.status === 422 && xhr.responseJSON.errors){
                    Object.entries(xhr.responseJSON.errors).forEach(([field, msgs]) => {
                        $(`#error-${field}`).text(msgs[0]);
                    });
                } else {
                    toastr.error('Failed to create FAQ');
                }
            },
            complete: function() {
                $('#createFaqBtn').prop('disabled', false).html('<i class="bi bi-plus-circle"></i> Create');
            }
        });
    });

    // Update FAQ
    $('#updateFaqBtn').click(function() {
        clearErrors('edit-');
        const id = $('#editFaqId').val();
        const formData = new FormData($('#editFaqForm')[0]);
        $(this).prop('disabled', true).text('Updating...');

        $.ajax({
            url: `/faq/update/${id}`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response){
                table.ajax.reload();
                toastr.success(response.message || 'FAQ updated successfully');
                hideEditForm();
            },
            error: function(xhr){
                if(xhr.status === 422 && xhr.responseJSON.errors){
                    Object.entries(xhr.responseJSON.errors).forEach(([field, msgs]) => {
                        $(`#edit-error-${field}`).text(msgs[0]);
                    });
                } else {
                    toastr.error('Failed to update FAQ');
                }
            },
            complete: function() {
                $('#updateFaqBtn').prop('disabled', false).html('<i class="bi bi-check-circle"></i> Update');
            }
        });
    });

    // Toggle Status (Status column + Action column)
    $(document).on('click', '.btn-toggle-status', function() {
        const id = $(this).data('id');
        if(!id) return;
        $.ajax({
            url: `/faq/toggle-status/${id}`,
            type: 'POST',
            data: {_token: $('meta[name="csrf-token"]').attr('content')},
            success: function(response){
                table.ajax.reload(null, false); // reload without resetting pagination
                toastr.success(response.message || 'FAQ status updated');
            },
            error: function(){
                toastr.error('Failed to update status');
            }
        });
    });

    // Delete FAQ
    $(document).on('click', '.btn-delete', function() {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This FAQ will be permanently deleted.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonText: 'Cancel',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    url: `/faq/destroy/${id}`,
                    type: 'POST',
                    data: {_method: 'DELETE', _token: $('meta[name="csrf-token"]').attr('content')},
                    success: function(response) {
                        table.ajax.reload();
                        toastr.success(response.message);
                    },
                    error: function() {
                        toastr.error('Failed to delete FAQ.');
                    }
                });
            }
        });
    });

});
</script>
@endpush
