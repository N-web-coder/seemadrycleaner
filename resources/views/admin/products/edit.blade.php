@extends('layouts.admin')

@section('page_title', 'Edit Product')

@section('content')
<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Edit Product: {{ $product->name }}</h3>
    </div>
    
    <form action="{{ route('admin.products.update', $product) }}" method="POST">
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
                    <label>Category</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-8 form-group mb-3">
                    <label>Product Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 form-group mb-3">
                    <label>Base Price</label>
                    <input type="number" step="0.01" name="base_price" class="form-control" value="{{ old('base_price', $product->base_price) }}" required>
                </div>
                <div class="col-md-8 d-flex align-items-center mb-3">
                    <div class="form-check mt-3">
                        <input type="checkbox" name="is_active" class="form-check-input" id="isActive" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="isActive">Active</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
                </div>
            </div>

            <div class="card mt-4 border shadow-sm">
                <div class="card-header text-bg-light">
                    <h3 class="card-title m-0">Product Options</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0" id="options-table">
                        <thead>
                            <tr>
                                <th>Option Name (e.g. Dry Clean)</th>
                                <th style="width: 250px;">Price ₹ (Additional)</th>
                                <th style="width: 60px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($product->options as $idx => $opt)
                            <tr>
                                <td>
                                    <input type="hidden" name="options[{{ $idx }}][id]" value="{{ $opt->id }}">
                                    <input type="text" name="options[{{ $idx }}][name]" class="form-control" value="{{ $opt->name }}" required>
                                </td>
                                <td><input type="number" step="0.01" name="options[{{ $idx }}][price]" class="form-control" value="{{ $opt->price }}" required></td>
                                <td class="text-center align-middle">
                                    <button type="button" class="btn btn-sm btn-danger remove-row"><i class="fas fa-times"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-bg-light">
                    <button type="button" class="btn btn-sm btn-success" id="add-option-btn"><i class="fas fa-plus"></i> Add Option</button>
                </div>
            </div>

        </div>
        
        <div class="card-footer">
            <button type="submit" class="btn btn-info">Update Product</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-default">Cancel</a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let tbody = document.querySelector('#options-table tbody');
        let rowCount = {{ $product->options->count() }};
        
        // Attach click listener to existing remove buttons
        document.querySelectorAll('.remove-row').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.target.closest('tr').remove();
            });
        });

        document.getElementById('add-option-btn').addEventListener('click', function() {
            let tr = document.createElement('tr');
            
            tr.innerHTML = `
                <td><input type="text" name="options[${rowCount}][name]" class="form-control" placeholder="Option Name" required></td>
                <td><input type="number" step="0.01" name="options[${rowCount}][price]" class="form-control" value="0" required></td>
                <td class="text-center align-middle">
                    <button type="button" class="btn btn-sm btn-danger remove-row"><i class="fas fa-times"></i></button>
                </td>
            `;
            tbody.appendChild(tr);
            rowCount++;
            
            tr.querySelector('.remove-row').addEventListener('click', function() {
                tr.remove();
            });
        });
    });
</script>
@endsection
