<?php $__env->startSection('page_title', $product ? 'Options for ' . $product->name : 'All Product Options'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Manage Options</h3>
        <div class="card-tools">
            <a href="<?php echo e(route('admin.product-options.create', $product ? ['product_id' => $product->id] : [])); ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add New Option</a>
            <?php if($product): ?>
                <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-default btn-sm ms-2">Back to Products</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <?php if(!$product): ?> <th>Product</th> <?php endif; ?>
                    <th>Option Name</th>
                    <th>Price Modifier</th>
                    <th style="width: 100px">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($option->id); ?></td>
                    <?php if(!$product): ?> <td><?php echo e($option->product->name ?? 'N/A'); ?></td> <?php endif; ?>
                    <td><?php echo e($option->name); ?></td>
                    <td>₹<?php echo e(number_format($option->price, 2)); ?></td>
                    <td>
                        <a href="<?php echo e(route('admin.product-options.edit', $option->id)); ?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                        <form action="<?php echo e(route('admin.product-options.destroy', $option->id)); ?>" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="<?php echo e($product ? 4 : 5); ?>" class="text-center">No options found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        <?php echo e($options->appends(request()->query())->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/seemadrycleaner/htdocs/seemadrycleaner.in/resources/views/admin/product_options/index.blade.php ENDPATH**/ ?>