<?php $__env->startSection('page_title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-primary">
            <div class="inner">
                <h3><?php echo e($newOrders); ?></h3>
                <p>New Orders (Pending)</p>
            </div>
            <div class="small-box-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="<?php echo e(route('admin.orders.index')); ?>" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                View Orders <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-success">
            <div class="inner">
                <h3>₹<?php echo e(number_format($totalRevenue, 2)); ?></h3>
                <p>Total Revenue</p>
            </div>
            <div class="small-box-icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                Detailed Report <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-info">
            <div class="inner">
                <h3><?php echo e($totalOrders); ?></h3>
                <p>Total Orders</p>
            </div>
            <div class="small-box-icon">
                <i class="fas fa-list"></i>
            </div>
            <a href="<?php echo e(route('admin.orders.index')); ?>" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                View History <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-warning">
            <div class="inner">
                <h3><?php echo e($completedOrders); ?></h3>
                <p>Ready/Delivered</p>
            </div>
            <div class="small-box-icon">
                <i class="fas fa-check-double"></i>
            </div>
            <a href="<?php echo e(route('admin.orders.index')); ?>" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/seemadrycleaner/htdocs/seemadrycleaner.in/resources/views/dashboard.blade.php ENDPATH**/ ?>