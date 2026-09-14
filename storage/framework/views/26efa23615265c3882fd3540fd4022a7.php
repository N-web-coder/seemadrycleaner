<?php $__env->startSection('page_title', 'Edit Store'); ?>

<?php $__env->startSection('content'); ?>
<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Edit Store: <?php echo e($store->name); ?></h3>
    </div>
    
    <form action="<?php echo e(route('admin.stores.update', $store)); ?>" method="POST">
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
                <div class="col-md-6 form-group mb-3">
                    <label>Store Name</label>
                    <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $store->name)); ?>" required>
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label>Locality</label>
                    <select name="locality_id" class="form-control" required>
                        <option value="">-- Select Locality --</option>
                        <?php $__currentLoopData = $localities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($loc->id); ?>" <?php echo e(old('locality_id', $store->locality_id) == $loc->id ? 'selected' : ''); ?>><?php echo e($loc->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group mb-3">
                    <label>Address</label>
                    <textarea name="address" class="form-control" rows="3" required><?php echo e(old('address', $store->address)); ?></textarea>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4 form-group mb-3">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" value="<?php echo e(old('phone', $store->phone)); ?>">
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo e(old('email', $store->email)); ?>">
                </div>
                <div class="col-md-4 d-flex align-items-center mb-3">
                    <div class="form-check mt-3">
                        <input type="checkbox" name="is_active" class="form-check-input" id="isActive" value="1" <?php echo e(old('is_active', $store->is_active) ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="isActive">Active</label>
                    </div>
                </div>
            </div>

            <hr>
            <h5>Manager Details <?php if(!$manager): ?><small class="text-danger">(No manager assigned)</small><?php endif; ?></h5>
            <div class="row">
                <div class="col-md-6 form-group mb-3">
                    <label>Manager Name</label>
                    <input type="text" name="manager_name" class="form-control" value="<?php echo e(old('manager_name', $manager->name ?? '')); ?>" required>
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label>Manager Phone</label>
                    <input type="text" name="manager_phone" class="form-control" value="<?php echo e(old('manager_phone', $manager->phone ?? '')); ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group mb-3">
                    <label>Manager Email (Username)</label>
                    <input type="email" name="manager_email" class="form-control" value="<?php echo e(old('manager_email', $manager->email ?? '')); ?>" required>
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label>Manager Password <small class="text-muted">(Leave blank to keep current)</small></label>
                    <input type="password" name="manager_password" class="form-control">
                </div>
            </div>

            <h5 class="mt-4 mb-3 text-primary border-bottom pb-2">Payment Settings (Razorpay)</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Razorpay Key (Optional)</label>
                    <input type="text" name="razorpay_key" class="form-control" value="<?php echo e(old('razorpay_key', $store->razorpay_key)); ?>" placeholder="rzp_test_...">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Razorpay Secret (Optional)</label>
                    <input type="password" name="razorpay_secret" class="form-control" placeholder="Leave blank to keep current">
                </div>
            </div>
        </div>
        
        <div class="card-footer">
            <button type="submit" class="btn btn-info">Update</button>
            <a href="<?php echo e(route('admin.stores.index')); ?>" class="btn btn-default">Cancel</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/seemadrycleaner/htdocs/seemadrycleaner.in/resources/views/admin/stores/edit.blade.php ENDPATH**/ ?>