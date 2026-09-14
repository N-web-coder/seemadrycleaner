<?php $__env->startSection('page_title', 'Products'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Manage Products</h3>
        <div class="card-tools">
            <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add New</a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Base Price</th>
                    <th>Status</th>
                    <th style="width: 180px">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($product->id); ?></td>
                    <td><?php echo e($product->name); ?></td>
                    <td><?php echo e($product->category->name ?? 'N/A'); ?></td>
                    <td>₹<?php echo e(number_format($product->base_price, 2)); ?></td>
                    <td>
                        <span class="badge <?php echo e($product->is_active ? 'text-bg-success' : 'text-bg-danger'); ?>">
                            <?php echo e($product->is_active ? 'Active' : 'Inactive'); ?>

                        </span>
                    </td>
                    <td>
                        <a href="<?php echo e(route('admin.product-options.index', ['product_id' => $product->id])); ?>" class="btn btn-sm btn-warning" title="Manage Options"><i class="fas fa-list"></i></a>
                        <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                        <form action="<?php echo e(route('admin.products.destroy', $product)); ?>" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center">No products found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        <?php echo e($products->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/seemadrycleaner/htdocs/seemadrycleaner.in/resources/views/admin/products/index.blade.php ENDPATH**/ ?>