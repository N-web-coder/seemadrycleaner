<?php $__env->startSection('page_title', 'Stores'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Manage Stores</h3>
            <div class="card-tools">
                <a href="<?php echo e(route('admin.stores.create')); ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add
                    New</a>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Name</th>
                        <th>Locality</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th style="width: 150px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($store->id); ?></td>
                            <td><?php echo e($store->name); ?></td>
                            <td><?php echo e($store->locality->name ?? 'N/A'); ?></td>
                            <td><?php echo e(\Str::limit($store->address, 30)); ?></td>
                            <td><?php echo e($store->phone); ?></td>
                            <td>
                                <span class="badge <?php echo e($store->is_active ? 'text-bg-success' : 'text-bg-danger'); ?>">
                                    <?php echo e($store->is_active ? 'Active' : 'Inactive'); ?>

                                </span>
                            </td>
                            <td>
                                <a href="<?php echo e(route('admin.stores.edit', $store)); ?>" class="btn btn-sm btn-info"><i
                                        class="fas fa-edit"></i></a>
                                <form action="<?php echo e(route('admin.stores.destroy', $store)); ?>" method="POST"
                                    style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center">No stores found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            <?php echo e($stores->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/seemadrycleaner/htdocs/seemadrycleaner.in/resources/views/admin/stores/index.blade.php ENDPATH**/ ?>