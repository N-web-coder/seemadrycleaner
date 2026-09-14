<?php $__env->startSection('page_title', 'Orders Tracker'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card card-primary card-outline shadow-sm">
        <div class="card-header bg-white">
            <form method="GET" action="<?php echo e(route('admin.orders.index')); ?>" class="row g-2 align-items-end">
                <div class="col-md-2">
                    <label class="small text-muted fw-bold">From Date</label>
                    <input type="date" name="from" class="form-control form-control-sm" value="<?php echo e(request('from')); ?>">
                </div>
                <div class="col-md-2">
                    <label class="small text-muted fw-bold">To Date</label>
                    <input type="date" name="to" class="form-control form-control-sm" value="<?php echo e(request('to')); ?>">
                </div>
                <div class="col-md-2">
                    <label class="small text-muted fw-bold">Mobile</label>
                    <input type="text" name="mobile" class="form-control form-control-sm" placeholder="Search phone..."
                        value="<?php echo e(request('mobile')); ?>">
                </div>
                <div class="col-md-2">
                    <label class="small text-muted fw-bold">Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All Status</option>
                        <?php $__currentLoopData = ['Pending', 'Pickedup', 'Processing', 'Washed', 'Ironed', 'Ready', 'Delivered']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($st); ?>" <?php echo e(request('status') == $st ? 'selected' : ''); ?>><?php echo e($st); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="small text-muted fw-bold">Type</label>
                    <select name="type" class="form-select form-select-sm">
                        <option value="">All Types</option>
                        <?php $__currentLoopData = ['instore', 'phone', 'whatsapp', 'online']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($tp); ?>" <?php echo e(request('type') == $tp ? 'selected' : ''); ?>><?php echo e(ucfirst($tp)); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="d-flex gap-1">
                        <button type="submit" class="btn btn-sm btn-primary w-100 fw-bold"><i class="fas fa-filter"></i>
                            Filter</button>
                        <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-sm btn-outline-secondary"><i
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
                        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="fw-bold text-primary">
                                        <?php echo e($order->order_number); ?>

                                    </a>
                                </td>
                                <td>
                                    <?php if($order->customer): ?>
                                        <?php echo e($order->customer->name); ?><br>
                                        <small class="text-muted"><?php echo e($order->customer->phone); ?></small>
                                    <?php else: ?>
                                        <span class="text-muted">Guest / Walk-in</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($order->store->name ?? 'N/A'); ?></td>
                                <td>
                                    <span class="badge text-bg-secondary"><?php echo e(ucfirst($order->order_type)); ?></span>
                                </td>
                                <td>
                                    <?php
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
                                    ?>
                                    <span class="badge <?php echo e($color); ?>"><?php echo e($order->status); ?></span>
                                </td>
                                <td class="fw-bold">₹<?php echo e(number_format($order->total_amount, 2)); ?></td>
                                <td><?php echo e($order->created_at->format('d M Y, h:i A')); ?></td>
                                <td>
                                    <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">No orders found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer clearfix bg-white">
            <?php echo e($orders->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/seemadrycleaner/htdocs/seemadrycleaner.in/resources/views/admin/orders/index.blade.php ENDPATH**/ ?>