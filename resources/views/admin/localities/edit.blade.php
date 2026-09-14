@extends('layouts.admin')

@section('page_title', 'Edit Locality')

@section('content')
<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Edit Locality: {{ $locality->name }}</h3>
    </div>
    
    <form action="{{ route('admin.localities.update', $locality) }}" method="POST">
        @csrf
        @method('PUT')
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
                    <input type="text" name="name" class="form-control" value="{{ old('name', $locality->name) }}" required>
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label>City</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city', $locality->city) }}" required>
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label>State</label>
                    <input type="text" name="state" class="form-control" value="{{ old('state', $locality->state) }}" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 form-group mb-3">
                    <label>Pincode</label>
                    <input type="text" name="pincode" class="form-control" value="{{ old('pincode', $locality->pincode) }}" required>
                </div>
                <div class="col-md-8 d-flex align-items-center mb-3">
                    <div class="form-check mt-3">
                        <input type="checkbox" name="is_active" class="form-check-input" id="isActive" value="1" {{ old('is_active', $locality->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="isActive">Active</label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-footer">
            <button type="submit" class="btn btn-info">Update</button>
            <a href="{{ route('admin.localities.index') }}" class="btn btn-default">Cancel</a>
        </div>
    </form>
</div>
@endsection
