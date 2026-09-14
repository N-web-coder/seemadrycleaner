<?php $__env->startSection('page_title', 'Create Locality'); ?>

<?php $__env->startSection('content'); ?>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Add New Locality</h3>
    </div>
    
    <form action="<?php echo e(route('admin.localities.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
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
                    <input type="text" name="name" class="form-control" placeholder="Enter locality name" value="<?php echo e(old('name')); ?>" required>
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label>City</label>
                    <input type="text" name="city" class="form-control" placeholder="Enter city" value="<?php echo e(old('city', $lastLocality->city ?? '')); ?>" required>
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label>State</label>
                    <input type="text" name="state" class="form-control" placeholder="Enter state" value="<?php echo e(old('state', $lastLocality->state ?? '')); ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 form-group mb-3">
                    <label>Pincode</label>
                    <input type="text" name="pincode" class="form-control" placeholder="Enter pincode" value="<?php echo e(old('pincode', $lastLocality->pincode ?? '')); ?>" required>
                </div>
                <div class="col-md-8 d-flex align-items-center mb-3">
                    <div class="form-check mt-3">
                        <input type="checkbox" name="is_active" class="form-check-input" id="isActive" value="1" <?php echo e(old('is_active', true) ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="isActive">Active</label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?php echo e(route('admin.localities.index')); ?>" class="btn btn-default">Cancel</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/seemadrycleaner/htdocs/seemadrycleaner.in/resources/views/admin/localities/create.blade.php ENDPATH**/ ?>