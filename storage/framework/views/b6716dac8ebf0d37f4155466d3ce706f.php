<?php $__env->startSection('page_title', 'Edit Locality'); ?>

<?php $__env->startSection('content'); ?>
<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Edit Locality: <?php echo e($locality->name); ?></h3>
    </div>
    
    <form action="<?php echo e(route('admin.localities.update', $locality)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="card-body">
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-4 form-group mb-3">
                    <label>Locality Name</label>
                    <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $locality->name)); ?>" required>
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label>City</label>
                    <input type="text" name="city" class="form-control" value="<?php echo e(old('city', $locality->city)); ?>" required>
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label>State</label>
                    <input type="text" name="state" class="form-control" value="<?php echo e(old('state', $locality->state)); ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 form-group mb-3">
                    <label>Pincode</label>
                    <input type="text" name="pincode" class="form-control" value="<?php echo e(old('pincode', $locality->pincode)); ?>" required>
                </div>
                <div class="col-md-8 d-flex align-items-center mb-3">
                    <div class="form-check mt-3">
                        <input type="checkbox" name="is_active" class="form-check-input" id="isActive" value="1" <?php echo e(old('is_active', $locality->is_active) ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="isActive">Active</label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-footer">
            <button type="submit" class="btn btn-info">Update</button>
            <a href="<?php echo e(route('admin.localities.index')); ?>" class="btn btn-default">Cancel</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/seemadrycleaner/htdocs/seemadrycleaner.in/resources/views/admin/localities/edit.blade.php ENDPATH**/ ?>