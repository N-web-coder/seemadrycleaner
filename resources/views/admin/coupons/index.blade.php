@extends('layouts.admin')

@section('page_title', 'Manage Coupons')

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Coupons</h3>
        <div class="card-tools">
            <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add New Coupon</a>
        </div>
    </div>
    <div class="card-body p-0 border shadow-sm">
        <table class="table table-striped table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Type</th>
                    <th>Value</th>
                    <th>Min Order</th>
                    <th>Valid From - Until</th>
                    <th>Status</th>
                    <th style="width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($coupons as $coupon)
                <tr>
                    <td>{{ $coupon->id }}</td>
                    <td><strong>{{ $coupon->code }}</strong></td>
                    <td>{{ ucfirst($coupon->type) }}</td>
                    <td>{{ $coupon->type == 'percent' ? $coupon->value . '%' : '₹' . $coupon->value }}</td>
                    <td>₹{{ $coupon->min_order_amount }}</td>
                    <td>
                        {{ $coupon->valid_from ? \Carbon\Carbon::parse($coupon->valid_from)->format('d M Y') : 'Any' }} 
                        &rarr; 
                        {{ $coupon->valid_until ? \Carbon\Carbon::parse($coupon->valid_until)->format('d M Y') : 'Any' }}
                    </td>
                    <td>
                        <span class="badge {{ $coupon->is_active ? 'text-bg-success' : 'text-bg-danger' }}">
                            {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4 text-muted">No coupons found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        {{ $coupons->links() }}
    </div>
</div>
@endsection
