<?php $__env->startSection('page_title', 'Localities'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Manage Localities</h3>
        <div class="card-tools">
            <a href="<?php echo e(route('admin.localities.create')); ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add New</a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Name</th>
                    <th>City / State</th>
                    <th>Pincode</th>
                    <th>Status</th>
                    <th style="width: 150px">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $localities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $locality): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($locality->id); ?></td>
                    <td><?php echo e($locality->name); ?></td>
                    <td><?php echo e($locality->city); ?>, <?php echo e($locality->state); ?></td>
                    <td><?php echo e($locality->pincode); ?></td>
                    <td>
                        <span class="badge <?php echo e($locality->is_active ? 'text-bg-success' : 'text-bg-danger'); ?>">
                            <?php echo e($locality->is_active ? 'Active' : 'Inactive'); ?>

                        </span>
                    </td>
                    <td>
                        <a href="<?php echo e(route('admin.localities.edit', $locality)); ?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                        <form action="<?php echo e(route('admin.localities.destroy', $locality)); ?>" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center">No localities found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        <?php echo e($localities->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/seemadrycleaner/htdocs/seemadrycleaner.in/resources/views/admin/localities/index.blade.php ENDPATH**/ ?>