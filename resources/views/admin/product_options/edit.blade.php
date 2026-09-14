@extends('layouts.admin')

@section('page_title', 'Edit Product Option')

@section('content')
<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Edit Option: {{ $productOption->name }}</h3>
    </div>
    
    <form action="{{ route('admin.product-options.update', $productOption->id) }}" method="POST">
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
                    <label>Product</label>
                    <select name="product_id" class="form-control" required>
                        <option value="">-- Select Product --</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" {{ old('product_id', $productOption->product_id) == $p->id ? 'selected' : '' }}>
                                {{ $p->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5 form-group mb-3">
                    <label>Option Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $productOption->name) }}" required>
                </div>
                <div class="col-md-3 form-group mb-3">
                    <label>Price</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $productOption->price) }}" required>
                </div>
            </div>
        </div>
        
        <div class="card-footer">
            <button type="submit" class="btn btn-info">Update</button>
            <a href="{{ route('admin.product-options.index', ['product_id' => $productOption->product_id]) }}" class="btn btn-default">Cancel</a>
        </div>
    </form>
</div>
@endsection
