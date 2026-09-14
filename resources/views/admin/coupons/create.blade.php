@extends('layouts.admin')

@section('page_title', 'Create Coupon')

@section('content')
<div class="card card-primary card-outline shadow-sm">
    <div class="card-header text-bg-light border-bottom">
        <h3 class="card-title mb-0">Add New Coupon</h3>
    </div>
    
    <form action="{{ route('admin.coupons.store') }}" method="POST">
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
                    <label>Coupon Code</label>
                    <input type="text" name="code" class="form-control text-uppercase" placeholder="e.g. SUMMER50" value="{{ old('code') }}" required>
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label>Discount Type</label>
                    <select name="type" class="form-control" required>
                        <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>Percentage (%)</option>
                        <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed Amount (₹)</option>
                    </select>
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label>Discount Value</label>
                    <input type="number" step="0.01" name="value" class="form-control" placeholder="10.00" value="{{ old('value') }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 form-group mb-3">
                    <label>Min Order Amount (₹)</label>
                    <input type="number" step="0.01" name="min_order_amount" class="form-control" value="{{ old('min_order_amount', 0) }}" required>
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label>Max Discount Amount (₹, optional)</label>
                    <input type="number" step="0.01" name="max_discount_amount" class="form-control" value="{{ old('max_discount_amount') }}" placeholder="For % type">
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label>Usage Limit (Total uses, optional)</label>
                    <input type="number" name="usage_limit" class="form-control" value="{{ old('usage_limit') }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 form-group mb-3">
                    <label>Valid From (Optional)</label>
                    <input type="date" name="valid_from" class="form-control" value="{{ old('valid_from') }}">
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label>Valid Until (Optional)</label>
                    <input type="date" name="valid_until" class="form-control" value="{{ old('valid_until') }}">
                </div>
                <div class="col-md-4 d-flex align-items-center mb-3">
                    <div class="form-check mt-3">
                        <input type="checkbox" name="is_active" class="form-check-input" id="isActive" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="isActive">Active</label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-footer text-bg-light border-top">
            <button type="submit" class="btn btn-primary">Save Coupon</button>
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-default">Cancel</a>
        </div>
    </form>
</div>
@endsection
