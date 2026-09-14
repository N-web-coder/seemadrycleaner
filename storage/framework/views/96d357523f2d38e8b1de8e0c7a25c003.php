<?php $__env->startSection('meta_title', 'My Dashboard - ' . config('app.name')); ?>

<?php $__env->startSection('content'); ?>
<section class="section-padding bg-light min-vh-100">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-md-6">
                <h1 class="fw-bold text-dark">Welcome back, <?php echo e(auth()->user()->name); ?>!</h1>
                <p class="text-muted m-0">Here's what's happening with your laundry today.</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <a href="<?php echo e(route('categories.index')); ?>" class="btn btn-primary px-4 py-2 fw-bold rounded-pill shadow-sm">
                    <i class="fas fa-plus me-2"></i> New Service Request
                </a>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm p-4 bg-primary text-white h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold text-uppercase opacity-75 small mb-0">Total Orders</h6>
                        <i class="fas fa-list-ul h4 mb-0 opacity-50"></i>
                    </div>
                    <h2 class="display-5 fw-bold m-0"><?php echo e($totalOrders); ?></h2>
                    <p class="mt-2 mb-0 small opacity-75">All time services requested</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold text-uppercase text-muted small mb-0">Active Orders</h6>
                        <i class="fas fa-clock h4 mb-0 text-info opacity-50"></i>
                    </div>
                    <h2 class="display-5 fw-bold m-0 text-dark"><?php echo e($pendingOrders); ?></h2>
                    <p class="mt-2 mb-0 small text-muted">Items currently being processed</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold text-uppercase text-muted small mb-0">Saved Credits</h6>
                        <i class="fas fa-wallet h4 mb-0 text-success opacity-50"></i>
                    </div>
                    <h2 class="display-5 fw-bold m-0 text-dark">₹0.00</h2>
                    <p class="mt-2 mb-0 small text-muted">Wallet balance for quick payments</p>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden mb-4">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center px-4">
                <h5 class="fw-bold m-0">Recent Activity</h5>
                <a href="<?php echo e(route('account.orders')); ?>" class="small text-decoration-none fw-bold">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr class="small fw-bold text-muted">
                                <th class="px-4">ORDER #</th>
                                <th>DATE</th>
                                <th>AMOUNT</th>
                                <th>STATUS</th>
                                <th class="text-end px-4">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="px-4 fw-bold"><?php echo e($order->order_number); ?></td>
                                    <td><?php echo e($order->created_at->format('M d, Y')); ?></td>
                                    <td class="fw-bold text-primary">₹<?php echo e(number_format($order->total_amount, 2)); ?></td>
                                    <td>
                                        <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle px-3 py-1">
                                            <?php echo e($order->status); ?>

                                        </span>
                                    </td>
                                    <td class="text-end px-4">
                                        <a href="<?php echo e(route('account.orders.show', $order->id)); ?>" class="btn btn-sm btn-outline-dark rounded-pill px-3 fw-bold">Details</a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        No recent orders found. <a href="<?php echo e(route('categories.index')); ?>">Start your first wash today!</a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/seemadrycleaner/htdocs/seemadrycleaner.in/resources/views/frontend/account/dashboard.blade.php ENDPATH**/ ?>