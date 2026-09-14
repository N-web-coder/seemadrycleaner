@extends('layouts.admin')

@section('page_title', 'Order Details: ' . $order->order_number)

@section('content')
<div class="row">
    <!-- Left Column: Order Info & Items -->
    <div class="col-md-8">
        <div class="card card-primary card-outline shadow-sm mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h3 class="card-title m-0">Order #{{ $order->order_number }}</h3>
                <div class="btn-group">
                    <a href="{{ route('admin.orders.print-tags', $order) }}" target="_blank" class="btn btn-sm btn-outline-dark">
                        <i class="fas fa-barcode"></i> Print Tags
                    </a>
                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#receiptModal">
                        <i class="fas fa-file-invoice"></i> View Receipt
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <h6 class="text-muted text-uppercase small fw-bold">Customer Detail</h6>
                        @if($order->customer)
                            <p class="mb-0"><strong>{{ $order->customer->name }}</strong></p>
                            <p class="mb-0">{{ $order->customer->phone }}</p>
                            <p class="mb-0 text-muted small">{{ $order->customer->email }}</p>
                        @else
                            <p class="mb-0 text-muted">Walk-in Customer</p>
                        @endif
                    </div>
                    <div class="col-sm-6 text-sm-end">
                        <h6 class="text-muted text-uppercase small fw-bold">Order Info</h6>
                        <p class="mb-0"><strong>Store:</strong> {{ $order->store->name ?? 'N/A' }}</p>
                        <p class="mb-0"><strong>Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
                        <p class="mb-0"><strong>Type:</strong> {{ ucfirst($order->order_type) }}</p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Service/Product</th>
                                <th class="text-center">Rate</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->product_name }}</strong>
                                    @if($item->option_name)
                                        <br><small class="text-muted"><i class="fas fa-caret-right"></i> {{ $item->option_name }}</small>
                                    @endif
                                    @if($item->remarks)
                                        <br><small class="text-info fst-italic">Note: {{ $item->remarks }}</small>
                                    @endif
                                    <br><small class="text-muted small">Tag: {{ $item->tag_auto }}</small>
                                </td>
                                <td class="text-center">₹{{ number_format($item->unit_price, 2) }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end">₹{{ number_format($item->total_price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Sub Total</th>
                                <td class="text-end fw-bold">₹{{ number_format($order->sub_total, 2) }}</td>
                            </tr>
                            @if($order->discount_amount > 0)
                            <tr class="text-danger">
                                <th colspan="3" class="text-end">Discount {{ $order->coupon ? '(' . $order->coupon->code . ')' : '' }}</th>
                                <td class="text-end fw-bold">- ₹{{ number_format($order->discount_amount, 2) }}</td>
                            </tr>
                            @endif
                            <tr class="table-success">
                                <th colspan="3" class="text-end h5 mb-0">Grand Total</th>
                                <td class="text-end h5 mb-0 fw-bold">₹{{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                @if($order->remarks)
                <div class="mt-3 p-3 bg-light border rounded">
                    <strong>Order Remarks:</strong><br>
                    {{ $order->remarks }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Column: Status Update & History -->
    <div class="col-md-4">
        <!-- Payment Card -->
        <div class="card card-purple card-outline shadow-sm mb-4">
            <div class="card-header bg-white">
                <h3 class="card-title m-0">Payment Details</h3>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Current Status:</span>
                    <span class="badge {{ $order->payment_status === 'paid' ? 'text-bg-success' : 'text-bg-danger' }} px-3 py-2">
                        {{ strtoupper($order->payment_status) }}
                    </span>
                </div>
                
                @if($order->payment_status !== 'paid')
                    <div class="d-grid gap-2">
                        <form action="{{ route('admin.payments.link', $order) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary w-100 fw-bold">
                                <i class="fas fa-paper-plane"></i> Generate Razorpay Link
                            </button>
                        </form>
                        <form action="{{ route('admin.payments.mark-paid', $order) }}" method="POST" onsubmit="return confirm('Mark this order as paid manually?')">
                            @csrf
                            <button type="submit" class="btn btn-success w-100 fw-bold">
                                <i class="fas fa-hand-holding-usd"></i> Mark as Paid (Manual)
                            </button>
                        </form>
                    </div>
                @else
                    <div class="alert alert-success py-2 mb-0 small text-center fw-bold">
                        <i class="fas fa-check-circle"></i> Fully Paid
                    </div>
                @endif
            </div>
        </div>

        <!-- Status Update -->
        <div class="card card-info card-outline shadow-sm mb-4">
            <div class="card-header bg-white">
                <h3 class="card-title m-0">Update Status</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Current Stage</label>
                        <select name="status" class="form-select" required>
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Update Notes (Optional)</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="e.g. Sent to wash unit"></textarea>
                    </div>
                    <button type="submit" class="btn btn-info w-100 fw-bold">Update Order Stage</button>
                </form>
            </div>
        </div>

        <!-- Order Timeline -->
        <div class="card card-dark card-outline shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title m-0">Order Timeline</h3>
            </div>
            <div class="card-body p-0" style="max-height: 400px; overflow-y: auto;">
                <ul class="list-group list-group-flush">
                    @foreach($order->statusHistories as $history)
                    <li class="list-group-item p-3 border-left-{{ strtolower($history->status) }}">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="badge text-bg-secondary">{{ $history->status }}</span>
                            <small class="text-muted">{{ $history->created_at->format('d M, h:i A') }}</small>
                        </div>
                        <p class="mb-1 small">{{ $history->notes }}</p>
                        <small class="text-muted small">By: {{ $history->creator->name ?? 'System' }}</small>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
    .border-left-pending { border-left: 4px solid #ffc107 !important; }
    .border-left-pickedup { border-left: 4px solid #17a2b8 !important; }
    .border-left-processing { border-left: 4px solid #007bff !important; }
    .border-left-washed { border-left: 4px solid #6c757d !important; }
    .border-left-ironed { border-left: 4px solid #343a40 !important; }
    .border-left-ready { border-left: 4px solid #28a745 !important; }
    .border-left-delivered { border-left: 4px solid #e9ecef !important; }
</style>
@endsection

<!-- Receipt Modal -->
<div class="modal fade" id="receiptModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-white border-bottom-0">
        <h5 class="modal-title fw-bold">Customer Receipt</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4 pt-0" id="receiptContent">
          @include('admin.orders.partials.receipt', ['order' => $order])
      </div>
      <div class="modal-footer bg-light border-0">
        <button type="button" class="btn btn-secondary px-4 fw-bold" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary px-4 fw-bold" onclick="printReceipt()"><i class="fas fa-print"></i> Print Receipt</button>
      </div>
    </div>
  </div>
</div>

<script>
    function printReceipt() {
        let content = document.getElementById('printableReceipt').innerHTML;
        let printWindow = window.open('', '', 'height=600,width=800');
        printWindow.document.write('<html><head><title>Print Receipt</title>');
        printWindow.document.write('<style>body{margin:20px; font-family: monospace;}</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write(content);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.focus();
        setTimeout(() => {
            printWindow.print();
            printWindow.close();
        }, 250);
    }
</script>
