@extends('backend.master')

@section('title', 'Amenities Feature Management')

@section('content')

<div class="row">
    <div class="col-lg-12 mb-4">
        <h3>Amenities Feature Management</h3>
    </div>
</div>

<div class="row">
    <!-- Feature List -->
    <div class="col-lg-7 col-12">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Amenities Feature List</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="featureTable" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Icon</th>
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

    <!-- ADD + EDIT Form -->
    <div class="col-lg-5 col-12">

        <!-- Add Form -->
        <div id="addForm">
            <form id="addFeatureForm" enctype="multipart/form-data">
                @csrf
                <div class="card mb-4">
                    <div class="card-header  text-white text-center">
                        <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Add Feature</h5>
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label">Feature Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Such as Free Wifi">
                            <div class="text-danger error-field" id="error-name"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-control">
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <div class="text-danger error-field" id="error-category_id"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Icon Image</label>
                            <input type="file" name="icon" class="form-control" accept="image/*">
                            <div class="text-danger error-field" id="error-icon"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Preview</label>
                            <img id="iconPreviewImg" style="width:50px; height:50px; display:none;">
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" id="createFeatureBtn" class="btn btn-success">
                                <i class="bi bi-plus-circle"></i> Create
                            </button>
                        </div>

                    </div>
                </div>
            </form>
        </div>

        <!-- Edit Form -->
        <div id="editForm" class="d-none">
            <form id="editFeatureForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="editFeatureId" name="id">

                <div class="card mb-4">
                    <div class="card-header bg-warning text-white text-center">
                        <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Feature</h5>
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label">Feature Name</label>
                            <input type="text" name="name" class="form-control">
                            <div class="text-danger error-field" id="edit-error-name"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-control">
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <div class="text-danger error-field" id="edit-error-category_id"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Icon Image</label>
                            <input type="file" name="icon" class="form-control">
                            <div class="text-danger error-field" id="edit-error-icon"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Preview</label>
                            <img id="editIconPreviewImg" style="width:50px; height:50px; display:none;">
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" id="updateFeatureBtn" class="btn btn-success">
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

// ========================
// COMMON FUNCTIONS
// ========================
function clearErrors(prefix = '') {
    if(prefix) $(`[id^="${prefix}error-"]`).text('');
    else $('.error-field').text('');
}

function hideEditForm() {
    $('#editForm').addClass('d-none');
    $('#addForm').removeClass('d-none');
    $('#editFeatureForm')[0].reset();
    $('#editIconPreviewImg').hide();
}

// Image preview
$(document).on('change', 'input[name="icon"]', function(e) {
    let img = $(this).closest('form').find("img");
    let rd = new FileReader();
    rd.onload = e => img.attr('src', e.target.result).show();
    rd.readAsDataURL(this.files[0]);
});

// ========================
// DATATABLE
// ========================
$(document).ready(function() {

    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    let table = $('#featureTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('amenities.features.getData') }}",
        columns: [
            { data: 'DT_RowIndex', orderable:false, searchable:false },
            { data: 'name' },
            { data: 'category_name' },
            { data: 'icon' },
            { data: 'status' },
            { data: 'action', orderable:false, searchable:false }
        ]
    });

    // ======================
    // CREATE FEATURE
    // ======================
    $(document).on('click', '#createFeatureBtn', function() {

        clearErrors();
        let formData = new FormData($('#addFeatureForm')[0]);

        $.ajax({
            url: "{{ route('amenities.feature.store') }}",
            type: "POST",
            data: formData,
            contentType:false,
            processData:false,
            success: res => {
                table.ajax.reload();
                $('#addFeatureForm')[0].reset();
                $('#iconPreviewImg').hide();
                toastr.success(res.message);
            },
            error: xhr => {
                if(xhr.status === 422){
                    $.each(xhr.responseJSON.errors, (k,v) => {
                        $('#error-'+k).text(v[0]);
                    });
                }
            }
        });

    });

    // ======================
    // EDIT FEATURE
    // ======================
    $(document).on('click', '.editBtn', function() {

        let row = $(this);

        $('#editFeatureId').val(row.data('id'));
        $('#editFeatureForm input[name="name"]').val(row.data('name'));
        $('#editFeatureForm select[name="category_id"]').val(row.data('category_id'));

        if(row.data('icon')){
            $('#editIconPreviewImg').attr('src',row.data('icon')).show();
        }

        $('#addForm').addClass('d-none');
        $('#editForm').removeClass('d-none');
    });

    // ======================
    // UPDATE FEATURE
    // ======================
    $(document).on('click', '#updateFeatureBtn', function() {

        clearErrors();
        let id = $('#editFeatureId').val();
        let fd = new FormData($('#editFeatureForm')[0]);

        $.ajax({
            url: `/admin/amenities-feature/${id}`,
            type: "POST",
            data: fd,
            contentType:false,
            processData:false,
            success: res => {
                table.ajax.reload();
                hideEditForm();
                toastr.success(res.message);
            },
            error: xhr => {
                if(xhr.status === 422){
                    $.each(xhr.responseJSON.errors, (k,v) => {
                        $('#edit-error-'+k).text(v[0]);
                    });
                }
            }
        });

    });


    $(document).on('click', '.deleteBtn', function() {

        let featureId = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: `/admin/amenities-feature/delete/${featureId}`,
                    type: "post",
                    success: res => {
                        table.ajax.reload();
                        toastr.success(res.message);
                    }
                });

            }
        });

    });

    // ======================
    // TOGGLE STATUS
    // ======================
    $(document).on('click', '.btn-toggle-status', function(){

        let featureId = $(this).data('id');

        $.post(`/admin/amenities-feature/toggle-status/${featureId}`, {}, res => {
            table.ajax.reload();
            toastr.success(res.message);
        });
    });

});

</script>
@endpush
