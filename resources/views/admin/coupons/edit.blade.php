@extends('layouts.admin')

@section('page_title', 'Edit Coupon')

@section('content')
<div class="card card-primary card-outline shadow-sm">
    <div class="card-header text-bg-light border-bottom">
        <h3 class="card-title mb-0">Edit Coupon: {{ $coupon->code }}</h3>
    </div>
    
    <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
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
                    <label>Coupon Code</label>
                    <input type="text" name="code" class="form-control text-uppercase" value="{{ old('code', $coupon->code) }}" required>
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label>Discount Type</label>
                    <select name="type" class="form-control" required>
                        <option value="percent" {{ old('type', $coupon->type) == 'percent' ? 'selected' : '' }}>Percentage (%)</option>
                        <option value="fixed" {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}>Fixed Amount (₹)</option>
                    </select>
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label>Discount Value</label>
                    <input type="number" step="0.01" name="value" class="form-control" value="{{ old('value', $coupon->value) }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 form-group mb-3">
                    <label>Min Order Amount (₹)</label>
                    <input type="number" step="0.01" name="min_order_amount" class="form-control" value="{{ old('min_order_amount', $coupon->min_order_amount) }}" required>
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label>Max Discount Amount (₹, optional)</label>
                    <input type="number" step="0.01" name="max_discount_amount" class="form-control" value="{{ old('max_discount_amount', $coupon->max_discount_amount) }}">
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label>Usage Limit (Total uses, optional)</label>
                    <input type="number" name="usage_limit" class="form-control" value="{{ old('usage_limit', $coupon->usage_limit) }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 form-group mb-3">
                    <label>Valid From (Optional)</label>
                    <input type="date" name="valid_from" class="form-control" value="{{ old('valid_from', $coupon->valid_from) }}">
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label>Valid Until (Optional)</label>
                    <input type="date" name="valid_until" class="form-control" value="{{ old('valid_until', $coupon->valid_until) }}">
                </div>
                <div class="col-md-4 d-flex align-items-center mb-3">
                    <div class="form-check mt-3">
                        <input type="checkbox" name="is_active" class="form-check-input" id="isActive" value="1" {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="isActive">Active</label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-footer text-bg-light border-top">
            <button type="submit" class="btn btn-info">Update Coupon</button>
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-default">Cancel</a>
        </div>
    </form>
</div>
@endsection
