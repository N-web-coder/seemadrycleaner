@extends('layouts.admin')

@section('page_title', 'Create Locality')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Add New Locality</h3>
    </div>
    
    <form action="{{ route('admin.localities.store') }}" method="POST">
        @csrf
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-md-4 form-group mb-3">
                    <label>Locality Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter locality name" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label>City</label>
                    <input type="text" name="city" class="form-control" placeholder="Enter city" value="{{ old('city', $lastLocality->city ?? '') }}" required>
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label>State</label>
                    <input type="text" name="state" class="form-control" placeholder="Enter state" value="{{ old('state', $lastLocality->state ?? '') }}" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 form-group mb-3">
                    <label>Pincode</label>
                    <input type="text" name="pincode" class="form-control" placeholder="Enter pincode" value="{{ old('pincode', $lastLocality->pincode ?? '') }}" required>
                </div>
                <div class="col-md-8 d-flex align-items-center mb-3">
                    <div class="form-check mt-3">
                        <input type="checkbox" name="is_active" class="form-check-input" id="isActive" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="isActive">Active</label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('admin.localities.index') }}" class="btn btn-default">Cancel</a>
        </div>
    </form>
</div>
@endsection
