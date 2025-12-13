@extends('backend.master')

@section('title', 'Create Apartment')

@section('content')

<form action="{{ route('appartment.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">

        <!-- LEFT SIDE: Apartment Details -->
        <div class="col-lg-8">

            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 text-white">Apartment Details</h5>
                </div>
                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label">Apartment Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g., The Tribeca Grand Penthouse">
                        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Short Description</label>
                        <textarea name="short_description" class="form-control" rows="2"></textarea>
                    </div>

                    {{--  <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" class="form-control" placeholder="URL friendly path">
                        @error('slug') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>  --}}

                    <div class="mb-3">
                        <label class="form-label">Long Description</label>
                        <textarea name="description" class="form-control" rows="4"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Price per Night</label>
                            <input type="number" step="0.01" name="price_per_night" class="form-control" placeholder="e.g., ">
                        </div>
                        {{--  <div class="col-md-2 mb-3">
                            <label class="form-label">Currency</label>
                            <input type="text" name="currency" class="form-control" value="USD">
                        </div>  --}}
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Max Guests</label>
                            <input type="number" name="max_guests" class="form-control" value="2">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Bedrooms</label>
                            <input type="number" name="bedrooms" class="form-control" value="1">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Bathrooms</label>
                            <input type="number" step="0.1" name="bathrooms" class="form-control" value="1.0">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Square Footage</label>
                            <input type="number" name="square_feet" class="form-control">
                        </div>
                        {{--  <div class="col-md-3 mb-3">
                            <label class="form-label">Floor Number</label>
                            <input type="number" name="floor_number" class="form-control">
                        </div>  --}}
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Minimum Stay (days)</label>
                            <input type="number" name="min_stay" class="form-control" value="1">
                        </div>
                    </div>

                    {{--  <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pets Allowed?</label>
                            <select name="is_pets_allowed" class="form-control">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Smoking Allowed?</label>
                            <select name="is_smoking_allowed" class="form-control">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                    </div>  --}}

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="under_maintenance">Under Maintenance</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Featured?</label>
                            <select name="is_featured" class="form-control">
                                <option value="no_featured">No</option>
                                <option value="featured">Yes</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Address Card -->
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0 text-white">Address & Location</h5>
                </div>
                <div class="card-body">

                    <div class="mb-3">
                        <div id="map" style="height: 300px; width: 100%;"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Latitude</label>
                            <input type="text" name="latitude" id="latitude" class="form-control" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Longitude</label>
                            <input type="text" name="longitude" id="longitude" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Full Address</label>
                        <input type="text" name="full_address" id="full_address" class="form-control" readonly>
                    </div>

                    {{--  <div class="mb-3">
                        <label class="form-label">City</label>
                        <input type="text" name="city" id="city" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">State</label>
                        <input type="text" name="state" id="state" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Postal Code</label>
                        <input type="text" name="postal_code" id="postal_code" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Country</label>
                        <input type="text" name="country" id="country" class="form-control">
                    </div>  --}}

                </div>
            </div>

        </div>

        <!-- RIGHT SIDE: Images & Amenities -->
        <div class="col-lg-4">

            <!-- UPDATED: Images Card -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0 text-white">Apartment Images</h5>
                </div>

                <div class="card-body">

                    <input type="file" name="images[]" id="imageInput" class="form-control" multiple>

                    <div id="previewContainer" class="mt-3 d-flex flex-wrap gap-2"></div>

                </div>
            </div>

            <!-- Amenities Card -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0 text-white">Select Amenities</h5>
                </div>
                <div class="card-body">
                    @foreach($categories as $category)
                        <div class="mb-3">
                            <label class="form-label fw-bold">{{ $category->name }}</label>
                            <div class="row">
                                @foreach($category->features as $feature)
                                    <div class="col-6 mb-2">
                                        <label class="d-flex align-items-center gap-2 border p-2 rounded">
                                            <input type="checkbox" name="amenities[]" value="{{ $feature->id }}">
                                            @if($feature->icon)
                                                <img src="{{ asset($feature->icon) }}" width="24" height="24">
                                            @endif
                                            <span>{{ $feature->name }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

    <div class="d-flex justify-content-end mt-3">
        <button type="submit" class="btn btn-success btn-lg">
            <i class="bi bi-check-circle"></i> Create Apartment
        </button>
    </div>

</form>

@endsection

@push('styles')
<style>
label.border {
    cursor: pointer;
    transition: 0.2s;
    background: #f9f9f9;
}
label.border:hover {
    background: #f0f0f0;
    border-color: #198754;
}

/* Image preview styles */
.image-preview-box {
    position: relative;
    width: 110px;
    height: 110px;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
}

.image-preview-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.remove-preview-btn {
    position: absolute;
    top: 3px;
    right: 3px;
    background: red;
    color: white;
    border: none;
    border-radius: 50%;
    width: 22px;
    height: 22px;
    font-size: 14px;
    cursor: pointer;
}
</style>
@endpush

@push('scripts')
<script>
let selectedFiles = [];

document.getElementById('imageInput').addEventListener('change', function(e) {
    const files = Array.from(e.target.files);

    files.forEach((file) => {
        selectedFiles.push(file);
        previewImage(file, selectedFiles.length - 1);
    });

    updateFileInput();
});

function previewImage(file, index) {
    let reader = new FileReader();
    reader.onload = function(e) {
        const box = document.createElement("div");
        box.classList.add("image-preview-box");

        box.innerHTML = `
            <img src="${e.target.result}">
            <button class="remove-preview-btn" onclick="removeImage(${index})">&times;</button>
        `;

        document.getElementById("previewContainer").appendChild(box);
    };
    reader.readAsDataURL(file);
}

function removeImage(index) {
    selectedFiles.splice(index, 1);
    refreshPreview();
    updateFileInput();
}

function refreshPreview() {
    const container = document.getElementById("previewContainer");
    container.innerHTML = "";

    selectedFiles.forEach((file, idx) => previewImage(file, idx));
}

function updateFileInput() {
    const dt = new DataTransfer();
    selectedFiles.forEach(file => dt.items.add(file));
    document.getElementById('imageInput').files = dt.files;
}
</script>


{{-- GOOGLE MAP SCRIPT REMAINS SAME --}}
<script>
let map;
let marker;
let geocoder;
let autocomplete;

function initMap() {
    const defaultLocation = { lat: 23.8103, lng: 90.4125 };
    map = new google.maps.Map(document.getElementById("map"), {
        center: defaultLocation,
        zoom: 13,
    });

    marker = new google.maps.Marker({
        position: defaultLocation,
        map: map,
        draggable: true
    });

    geocoder = new google.maps.Geocoder();

    google.maps.event.addListener(marker, 'dragend', function() {
        let position = marker.getPosition();
        fillLocationFields(position);
    });

    google.maps.event.addListener(map, 'click', function(event) {
        let clickedLocation = event.latLng;
        marker.setPosition(clickedLocation);
        fillLocationFields(clickedLocation);
    });
}

function fillLocationFields(pos) {
    document.getElementById('latitude').value = pos.lat();
    document.getElementById('longitude').value = pos.lng();

    geocoder.geocode({ latLng: pos }, function(responses) {
        if (responses && responses.length > 0) {
            document.getElementById('full_address').value = responses[0].formatted_address;
        }
    });
}

window.initMap = initMap;
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBpA-lvejMtaHZJE7zsDNX0MElW9W3CTN0&libraries=places&callback=initMap"></script>
@endpush
