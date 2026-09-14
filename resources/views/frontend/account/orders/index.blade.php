@extends('layouts.app')

@section('meta_title', 'My Orders - ' . config('app.name'))

@section('content')
<section class="section-padding bg-light min-vh-100">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('account.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active fw-bold" aria-current="page">My Orders</li>
            </ol>
        </nav>

        <h1 class="display-6 fw-bold mb-5">Order History</h1>

        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-white border-bottom">
                            <tr class="small fw-bold text-muted">
                                <th class="px-4 py-3">ORDER #</th>
                                <th>DATE</th>
                                <th>STORE</th>
                                <th>TYPE</th>
                                <th>AMOUNT</th>
                                <th>STATUS</th>
                                <th class="text-end px-4">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr class="bg-white">
                                    <td class="px-4 fw-bold text-dark">{{ $order->order_number }}</td>
                                    <td>{{ $order->created_at->format('M d, Y, h:i A') }}</td>
                                    <td><span class="text-muted small"><i class="fas fa-store me-1"></i> {{ $order->store->name ?? 'Main' }}</span></td>
                                    <td><span class="badge bg-light text-dark border">{{ ucfirst($order->order_type) }}</span></td>
                                    <td class="fw-bold text-primary">₹{{ number_format($order->total_amount, 2) }}</td>
                                    <td>
                                        @php
                                            $color = match($order->status) {
                                                'Pending' => 'warning',
                                                'Processing' => 'info',
                                                'Ready' => 'success',
                                                'Delivered' => 'secondary',
                                                default => 'primary'
                                            };
                                        @endphp
                                        <span class="badge rounded-pill bg-{{ $color }}-subtle text-{{ $color }} border border-{{ $color }}-subtle px-3 py-1 fw-bold">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="text-end px-4">
                                        <a href="{{ route('account.orders.show', $order->id) }}" class="btn btn-sm btn-primary rounded-pill px-4 fw-bold shadow-sm">View Status</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        You haven't placed any orders yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($orders->hasPages())
                <div class="card-footer bg-white border-top py-3 d-flex justify-content-center">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
