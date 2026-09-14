@extends('layouts.admin')

@section('page_title', 'Create Product Option')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Add New Option {{ $product ? 'for ' . $product->name : '' }}</h3>
    </div>
    
    <form action="{{ route('admin.product-options.store') }}" method="POST">
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
                    <label>Product</label>
                    <select name="product_id" class="form-control" required {{ $product ? 'readonly' : '' }}>
                        <option value="">-- Select Product --</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" {{ old('product_id', $product->id ?? '') == $p->id ? 'selected' : '' }}>
                                {{ $p->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5 form-group mb-3">
                    <label>Option Name (e.g. Dry Clean)</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-3 form-group mb-3">
                    <label>Price Override / Additive</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', 0) }}" required>
                </div>
            </div>
        </div>
        
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('admin.product-options.index', $product ? ['product_id' => $product->id] : []) }}" class="btn btn-default">Cancel</a>
        </div>
    </form>
</div>
@endsection
