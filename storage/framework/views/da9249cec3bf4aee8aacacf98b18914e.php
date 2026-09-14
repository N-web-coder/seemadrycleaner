<?php $__env->startSection('meta_title', 'My Orders - ' . config('app.name')); ?>

<?php $__env->startSection('content'); ?>
<section class="section-padding bg-light min-vh-100">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('account.dashboard')); ?>" class="text-decoration-none">Dashboard</a></li>
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
                            <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="bg-white">
                                    <td class="px-4 fw-bold text-dark"><?php echo e($order->order_number); ?></td>
                                    <td><?php echo e($order->created_at->format('M d, Y, h:i A')); ?></td>
                                    <td><span class="text-muted small"><i class="fas fa-store me-1"></i> <?php echo e($order->store->name ?? 'Main'); ?></span></td>
                                    <td><span class="badge bg-light text-dark border"><?php echo e(ucfirst($order->order_type)); ?></span></td>
                                    <td class="fw-bold text-primary">₹<?php echo e(number_format($order->total_amount, 2)); ?></td>
                                    <td>
                                        <?php
                                            $color = match($order->status) {
                                                'Pending' => 'warning',
                                                'Processing' => 'info',
                                                'Ready' => 'success',
                                                'Delivered' => 'secondary',
                                                default => 'primary'
                                            };
                                        ?>
                                        <span class="badge rounded-pill bg-<?php echo e($color); ?>-subtle text-<?php echo e($color); ?> border border-<?php echo e($color); ?>-subtle px-3 py-1 fw-bold">
                                            <?php echo e($order->status); ?>

                                        </span>
                                    </td>
                                    <td class="text-end px-4">
                                        <a href="<?php echo e(route('account.orders.show', $order->id)); ?>" class="btn btn-sm btn-primary rounded-pill px-4 fw-bold shadow-sm">View Status</a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        You haven't placed any orders yet.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if($orders->hasPages()): ?>
                <div class="card-footer bg-white border-top py-3 d-flex justify-content-center">
                    <?php echo e($orders->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/seemadrycleaner/htdocs/seemadrycleaner.in/resources/views/frontend/account/orders/index.blade.php ENDPATH**/ ?>