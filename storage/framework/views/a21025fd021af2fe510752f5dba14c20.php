<?php $__env->startSection('page_title', 'Manage Coupons'); ?>

<?php $__env->startSection('content'); ?>
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Coupons</h3>
        <div class="card-tools">
            <a href="<?php echo e(route('admin.coupons.create')); ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add New Coupon</a>
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
                <?php $__empty_1 = true; $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($coupon->id); ?></td>
                    <td><strong><?php echo e($coupon->code); ?></strong></td>
                    <td><?php echo e(ucfirst($coupon->type)); ?></td>
                    <td><?php echo e($coupon->type == 'percent' ? $coupon->value . '%' : '₹' . $coupon->value); ?></td>
                    <td>₹<?php echo e($coupon->min_order_amount); ?></td>
                    <td>
                        <?php echo e($coupon->valid_from ? \Carbon\Carbon::parse($coupon->valid_from)->format('d M Y') : 'Any'); ?> 
                        &rarr; 
                        <?php echo e($coupon->valid_until ? \Carbon\Carbon::parse($coupon->valid_until)->format('d M Y') : 'Any'); ?>

                    </td>
                    <td>
                        <span class="badge <?php echo e($coupon->is_active ? 'text-bg-success' : 'text-bg-danger'); ?>">
                            <?php echo e($coupon->is_active ? 'Active' : 'Inactive'); ?>

                        </span>
                    </td>
                    <td>
                        <a href="<?php echo e(route('admin.coupons.edit', $coupon)); ?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                        <form action="<?php echo e(route('admin.coupons.destroy', $coupon)); ?>" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="text-center py-4 text-muted">No coupons found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        <?php echo e($coupons->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/seemadrycleaner/htdocs/seemadrycleaner.in/resources/views/admin/coupons/index.blade.php ENDPATH**/ ?>