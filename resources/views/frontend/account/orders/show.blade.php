@extends('layouts.app')

@section('meta_title', 'Order details - ' . $order->order_number)

@section('content')
<section class="section-padding bg-light min-vh-100">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('account.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('account.orders') }}" class="text-decoration-none">My Orders</a></li>
                <li class="breadcrumb-item active fw-bold" aria-current="page">{{ $order->order_number }}</li>
            </ol>
        </nav>

        <div class="row g-4">
            <div class="col-lg-8">
                <!-- Order Details Card -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold m-0">Order #{{ $order->order_number }}</h5>
                            <span class="text-muted small">Placed on {{ $order->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                        <span class="badge rounded-pill bg-primary px-3 py-2 fw-bold">{{ $order->status }}</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle mb-0">
                                <thead class="border-bottom">
                                    <tr class="small fw-bold text-muted">
                                        <th>SERVICE ITEM</th>
                                        <th class="text-center">QTY</th>
                                        <th class="text-center">PRICE</th>
                                        <th class="text-end">SUBTOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                        <tr class="border-bottom">
                                            <td class="py-3">
                                                <h6 class="fw-bold mb-1 m-0 text-dark">{{ $item->product->name }}</h6>
                                                @if($item->productOption)
                                                    <span class="text-primary small fw-bold">{{ $item->productOption->name }}</span>
                                                @endif
                                                @if($item->remarks)
                                                    <p class="mb-0 small text-muted mt-1 italic">Note: {{ $item->remarks }}</p>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-center">₹{{ number_format($item->unit_price, 2) }}</td>
                                            <td class="text-end fw-bold">₹{{ number_format($item->total_price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-light border-top p-4">
                        <div class="row justify-content-end">
                            <div class="col-md-5">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal</span>
                                    <span class="fw-bold">₹{{ number_format($order->sub_total, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Delivery Charges</span>
                                    <span class="text-success small fw-bold">FREE</span>
                                </div>
                                <div class="d-flex justify-content-between mt-3 pt-3 border-top">
                                    <span class="h5 fw-bold m-0">Total Paid</span>
                                    <span class="h5 fw-bold text-primary m-0">₹{{ number_format($order->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timeline / Status History -->
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold mb-4 border-bottom pb-3">Service Timeline</h5>
                    <div class="timeline-wrapper ms-4 mt-3">
                        @foreach($order->statusHistories as $history)
                            <div class="timeline-item position-relative ps-4 pb-4 border-start" style="border-color: #dee2e6 !important;">
                                <div class="timeline-dot position-absolute bg-primary rounded-circle" style="width: 12px; height: 12px; left: -7px; top: 5px;"></div>
                                <div class="timeline-content">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h6 class="fw-bold m-0 text-dark">{{ $history->status }}</h6>
                                        <span class="small text-muted">{{ $history->created_at->format('M d, h:i A') }}</span>
                                    </div>
                                    <p class="text-muted small mb-0">{{ $history->notes }}</p>
                                    <span class="text-muted" style="font-size: 0.7rem;">Updated by: {{ $history->creator->name ?? 'System' }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h5 class="fw-bold mb-4 border-bottom pb-3">Store Information</h5>
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary-subtle text-primary rounded-3 p-3 me-3">
                            <i class="fas fa-store"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">{{ $order->store->name ?? 'Main Branch' }}</h6>
                            <p class="text-muted small mb-0"><i class="fas fa-map-marker-alt me-1"></i> {{ $order->store->address ?? 'N/A' }}</p>
                        </div>
                    </div>
                    @if($order->store->phone)
                        <a href="tel:{{ $order->store->phone }}" class="btn btn-outline-primary d-block rounded-pill fw-bold btn-sm mt-2">
                            <i class="fas fa-phone-alt me-2"></i> Call Store
                        </a>
                    @endif
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold mb-4 border-bottom pb-3">Payment Details</h5>
                    <div class="d-flex justify-content-between mb-3 align-items-center">
                        <span class="text-muted small">Method</span>
                        <span class="badge bg-light text-dark border fw-bold text-uppercase">{{ $order->payment_method }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Status</span>
                        <span class="h6 fw-bold mb-0 {{ $order->payment_status == 'paid' ? 'text-success' : 'text-warning' }}">
                            {{ strtoupper($order->payment_status) }}
                        </span>
                    </div>
                    @if($order->payment_status !== 'paid' && $order->total_amount > 0)
                        <hr>
                        <p class="small text-muted mb-3">Your payment is currently pending. Please proceed to pay online or pay at delivery.</p>
                        <button class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-sm">
                            Pay Securely Now
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .timeline-item:last-child {
        border-start-color: transparent !important;
    }
</style>
@endpush
