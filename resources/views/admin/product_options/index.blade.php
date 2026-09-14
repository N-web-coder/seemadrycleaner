@extends('layouts.admin')

@section('page_title', $product ? 'Options for ' . $product->name : 'All Product Options')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Manage Options</h3>
        <div class="card-tools">
            <a href="{{ route('admin.product-options.create', $product ? ['product_id' => $product->id] : []) }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add New Option</a>
            @if($product)
                <a href="{{ route('admin.products.index') }}" class="btn btn-default btn-sm ms-2">Back to Products</a>
            @endif
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    @if(!$product) <th>Product</th> @endif
                    <th>Option Name</th>
                    <th>Price Modifier</th>
                    <th style="width: 100px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($options as $option)
                <tr>
                    <td>{{ $option->id }}</td>
                    @if(!$product) <td>{{ $option->product->name ?? 'N/A' }}</td> @endif
                    <td>{{ $option->name }}</td>
                    <td>₹{{ number_format($option->price, 2) }}</td>
                    <td>
                        <a href="{{ route('admin.product-options.edit', $option->id) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.product-options.destroy', $option->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ $product ? 4 : 5 }}" class="text-center">No options found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        {{ $options->appends(request()->query())->links() }}
    </div>
</div>
@endsection
