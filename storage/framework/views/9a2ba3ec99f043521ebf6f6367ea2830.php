<?php $__env->startSection('page_title', 'Order Details: ' . $order->order_number); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- Left Column: Order Info & Items -->
    <div class="col-md-8">
        <div class="card card-primary card-outline shadow-sm mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h3 class="card-title m-0">Order #<?php echo e($order->order_number); ?></h3>
                <div class="btn-group">
                    <a href="<?php echo e(route('admin.orders.print-tags', $order)); ?>" target="_blank" class="btn btn-sm btn-outline-dark">
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
                        <?php if($order->customer): ?>
                            <p class="mb-0"><strong><?php echo e($order->customer->name); ?></strong></p>
                            <p class="mb-0"><?php echo e($order->customer->phone); ?></p>
                            <p class="mb-0 text-muted small"><?php echo e($order->customer->email); ?></p>
                        <?php else: ?>
                            <p class="mb-0 text-muted">Walk-in Customer</p>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-6 text-sm-end">
                        <h6 class="text-muted text-uppercase small fw-bold">Order Info</h6>
                        <p class="mb-0"><strong>Store:</strong> <?php echo e($order->store->name ?? 'N/A'); ?></p>
                        <p class="mb-0"><strong>Date:</strong> <?php echo e($order->created_at->format('d M Y, h:i A')); ?></p>
                        <p class="mb-0"><strong>Type:</strong> <?php echo e(ucfirst($order->order_type)); ?></p>
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
                            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($item->product_name); ?></strong>
                                    <?php if($item->option_name): ?>
                                        <br><small class="text-muted"><i class="fas fa-caret-right"></i> <?php echo e($item->option_name); ?></small>
                                    <?php endif; ?>
                                    <?php if($item->remarks): ?>
                                        <br><small class="text-info fst-italic">Note: <?php echo e($item->remarks); ?></small>
                                    <?php endif; ?>
                                    <br><small class="text-muted small">Tag: <?php echo e($item->tag_auto); ?></small>
                                </td>
                                <td class="text-center">₹<?php echo e(number_format($item->unit_price, 2)); ?></td>
                                <td class="text-center"><?php echo e($item->quantity); ?></td>
                                <td class="text-end">₹<?php echo e(number_format($item->total_price, 2)); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Sub Total</th>
                                <td class="text-end fw-bold">₹<?php echo e(number_format($order->sub_total, 2)); ?></td>
                            </tr>
                            <?php if($order->discount_amount > 0): ?>
                            <tr class="text-danger">
                                <th colspan="3" class="text-end">Discount <?php echo e($order->coupon ? '(' . $order->coupon->code . ')' : ''); ?></th>
                                <td class="text-end fw-bold">- ₹<?php echo e(number_format($order->discount_amount, 2)); ?></td>
                            </tr>
                            <?php endif; ?>
                            <tr class="table-success">
                                <th colspan="3" class="text-end h5 mb-0">Grand Total</th>
                                <td class="text-end h5 mb-0 fw-bold">₹<?php echo e(number_format($order->total_amount, 2)); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <?php if($order->remarks): ?>
                <div class="mt-3 p-3 bg-light border rounded">
                    <strong>Order Remarks:</strong><br>
                    <?php echo e($order->remarks); ?>

                </div>
                <?php endif; ?>
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
                    <span class="badge <?php echo e($order->payment_status === 'paid' ? 'text-bg-success' : 'text-bg-danger'); ?> px-3 py-2">
                        <?php echo e(strtoupper($order->payment_status)); ?>

                    </span>
                </div>
                
                <?php if($order->payment_status !== 'paid'): ?>
                    <div class="d-grid gap-2">
                        <form action="<?php echo e(route('admin.payments.link', $order)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-outline-primary w-100 fw-bold">
                                <i class="fas fa-paper-plane"></i> Generate Razorpay Link
                            </button>
                        </form>
                        <form action="<?php echo e(route('admin.payments.mark-paid', $order)); ?>" method="POST" onsubmit="return confirm('Mark this order as paid manually?')">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-success w-100 fw-bold">
                                <i class="fas fa-hand-holding-usd"></i> Mark as Paid (Manual)
                            </button>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="alert alert-success py-2 mb-0 small text-center fw-bold">
                        <i class="fas fa-check-circle"></i> Fully Paid
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Status Update -->
        <div class="card card-info card-outline shadow-sm mb-4">
            <div class="card-header bg-white">
                <h3 class="card-title m-0">Update Status</h3>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.orders.update-status', $order)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label class="form-label">Current Stage</label>
                        <select name="status" class="form-select" required>
                            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($status); ?>" <?php echo e($order->status == $status ? 'selected' : ''); ?>>
                                    <?php echo e($status); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <?php $__currentLoopData = $order->statusHistories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="list-group-item p-3 border-left-<?php echo e(strtolower($history->status)); ?>">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="badge text-bg-secondary"><?php echo e($history->status); ?></span>
                            <small class="text-muted"><?php echo e($history->created_at->format('d M, h:i A')); ?></small>
                        </div>
                        <p class="mb-1 small"><?php echo e($history->notes); ?></p>
                        <small class="text-muted small">By: <?php echo e($history->creator->name ?? 'System'); ?></small>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php $__env->stopSection(); ?>

<!-- Receipt Modal -->
<div class="modal fade" id="receiptModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-white border-bottom-0">
        <h5 class="modal-title fw-bold">Customer Receipt</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4 pt-0" id="receiptContent">
          <?php echo $__env->make('admin.orders.partials.receipt', ['order' => $order], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/seemadrycleaner/htdocs/seemadrycleaner.in/resources/views/admin/orders/show.blade.php ENDPATH**/ ?>