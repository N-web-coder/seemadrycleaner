<?php $__env->startSection('page_title', 'Create Store'); ?>

<?php $__env->startSection('content'); ?>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Add New Store</h3>
    </div>
    
    <form action="<?php echo e(route('admin.stores.store')); ?>" method="POST">
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
                <div class="col-md-6 form-group mb-3">
                    <label>Store Name</label>
                    <input type="text" name="name" class="form-control" value="<?php echo e(old('name')); ?>" required>
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label>Locality</label>
                    <select name="locality_id" class="form-control" required>
                        <option value="">-- Select Locality --</option>
                        <?php $__currentLoopData = $localities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($loc->id); ?>" <?php echo e(old('locality_id') == $loc->id ? 'selected' : ''); ?>><?php echo e($loc->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group mb-3">
                    <label>Address</label>
                    <textarea name="address" class="form-control" rows="3" required><?php echo e(old('address')); ?></textarea>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4 form-group mb-3">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" value="<?php echo e(old('phone')); ?>">
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo e(old('email')); ?>">
                </div>
                <div class="col-md-4 d-flex align-items-center mb-3">
                    <div class="form-check mt-3">
                        <input type="checkbox" name="is_active" class="form-check-input" id="isActive" value="1" <?php echo e(old('is_active', true) ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="isActive">Active</label>
                    </div>
                </div>
            </div>

            <hr>
            <h5>Manager Details</h5>
            <div class="row">
                <div class="col-md-6 form-group mb-3">
                    <label>Manager Name</label>
                    <input type="text" name="manager_name" class="form-control" value="<?php echo e(old('manager_name')); ?>" required>
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label>Manager Phone</label>
                    <input type="text" name="manager_phone" class="form-control" value="<?php echo e(old('manager_phone')); ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group mb-3">
                    <label>Manager Email (Username)</label>
                    <input type="email" name="manager_email" class="form-control" value="<?php echo e(old('manager_email')); ?>" required>
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label>Manager Password</label>
                    <input type="password" name="manager_password" class="form-control" required>
                </div>
            </div>

            <h5 class="mt-4 mb-3 text-primary border-bottom pb-2">Payment Settings (Razorpay)</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Razorpay Key (Optional)</label>
                    <input type="text" name="razorpay_key" class="form-control" placeholder="rzp_test_...">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Razorpay Secret (Optional)</label>
                    <input type="password" name="razorpay_secret" class="form-control" placeholder="••••••••">
                </div>
            </div>
        </div>
        
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?php echo e(route('admin.stores.index')); ?>" class="btn btn-default">Cancel</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/seemadrycleaner/htdocs/seemadrycleaner.in/resources/views/admin/stores/create.blade.php ENDPATH**/ ?>