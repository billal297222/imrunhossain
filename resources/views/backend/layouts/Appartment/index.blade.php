@extends('backend.master')

@section('title', 'Apartments List')

@section('content')

<div class="row mb-4">
    <div class="col-md-6">
        <h3>Apartments</h3>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('appartment.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Add New Apartment
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>City</th>
                    <th>Price/Night</th>
                    <th>Guests</th>
                    <th>Status</th>
                    <th>Featured</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
               
            </tbody>
        </table>
    </div>
</div>

@endsection
