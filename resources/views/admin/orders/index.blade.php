@extends('layouts.admin')

@section('page_title', 'Orders Tracker')

@section('content')
    <div class="card card-primary card-outline shadow-sm">
        <div class="card-header bg-white">
            <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-2 align-items-end">
                <div class="col-md-2">
                    <label class="small text-muted fw-bold">From Date</label>
                    <input type="date" name="from" class="form-control form-control-sm" value="{{ request('from') }}">
                </div>
                <div class="col-md-2">
                    <label class="small text-muted fw-bold">To Date</label>
                    <input type="date" name="to" class="form-control form-control-sm" value="{{ request('to') }}">
                </div>
                <div class="col-md-2">
                    <label class="small text-muted fw-bold">Mobile</label>
                    <input type="text" name="mobile" class="form-control form-control-sm" placeholder="Search phone..."
                        value="{{ request('mobile') }}">
                </div>
                <div class="col-md-2">
                    <label class="small text-muted fw-bold">Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All Status</option>
                        @foreach(['Pending', 'Pickedup', 'Processing', 'Washed', 'Ironed', 'Ready', 'Delivered'] as $st)
                            <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="small text-muted fw-bold">Type</label>
                    <select name="type" class="form-select form-select-sm">
                        <option value="">All Types</option>
                        @foreach(['instore', 'phone', 'whatsapp', 'online'] as $tp)
                            <option value="{{ $tp }}" {{ request('type') == $tp ? 'selected' : '' }}>{{ ucfirst($tp) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="d-flex gap-1">
                        <button type="submit" class="btn btn-sm btn-primary w-100 fw-bold"><i class="fas fa-filter"></i>
                            Filter</button>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary"><i
                                class="fas fa-redo"></i></a>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body p-0 border shadow-sm">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Store</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Total Amount</th>
                            <th>Date</th>
                            <th style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="fw-bold text-primary">
                                        {{ $order->order_number }}
                                    </a>
                                </td>
                                <td>
                                    @if($order->customer)
                                        {{ $order->customer->name }}<br>
                                        <small class="text-muted">{{ $order->customer->phone }}</small>
                                    @else
                                        <span class="text-muted">Guest / Walk-in</span>
                                    @endif
                                </td>
                                <td>{{ $order->store->name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge text-bg-secondary">{{ ucfirst($order->order_type) }}</span>
                                </td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'Pending' => 'text-bg-warning',
                                            'Pickedup' => 'text-bg-info',
                                            'Processing' => 'text-bg-primary',
                                            'Washed' => 'text-bg-secondary',
                                            'Ironed' => 'text-bg-dark',
                                            'Ready' => 'text-bg-success',
                                            'Delivered' => 'text-bg-light border'
                                        ];
                                        $color = $statusColors[$order->status] ?? 'text-bg-light';
                                    @endphp
                                    <span class="badge {{ $color }}">{{ $order->status }}</span>
                                </td>
                                <td class="fw-bold">₹{{ number_format($order->total_amount, 2) }}</td>
                                <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer clearfix bg-white">
            {{ $orders->links() }}
        </div>
    </div>
@endsection