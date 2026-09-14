<?php $__env->startSection('page_title', 'Contact Inquiries'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card card-primary card-outline shadow-sm">
        <div class="card-header bg-white">
            <form method="GET" action="<?php echo e(route('admin.inquiries.index')); ?>" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="small text-muted fw-bold">Name</label>
                    <input type="text" name="name" class="form-control form-control-sm" placeholder="Search name..."
                        value="<?php echo e(request('name')); ?>">
                </div>
                <div class="col-md-3">
                    <label class="small text-muted fw-bold">Email</label>
                    <input type="text" name="email" class="form-control form-control-sm" placeholder="Search email..."
                        value="<?php echo e(request('email')); ?>">
                </div>
                <div class="col-md-3">
                    <label class="small text-muted fw-bold">Date</label>
                    <input type="date" name="date" class="form-control form-control-sm" value="<?php echo e(request('date')); ?>">
                </div>
                <div class="col-md-3">
                    <div class="d-flex gap-1">
                        <button type="submit" class="btn btn-sm btn-primary w-100 fw-bold"><i class="fas fa-filter"></i>
                            Filter</button>
                        <a href="<?php echo e(route('admin.inquiries.index')); ?>" class="btn btn-sm btn-outline-secondary"><i
                                class="fas fa-redo"></i></a>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body p-0 border shadow-sm">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $inquiries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inquiry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>#<?php echo e($inquiry->id); ?></td>
                                <td class="fw-bold"><?php echo e($inquiry->name); ?></td>
                                <td><?php echo e($inquiry->email); ?></td>
                                <td><?php echo e($inquiry->subject ?? 'No Subject'); ?></td>
                                <td>
                                    <?php
                                        $statusColors = [
                                            'Pending' => 'text-bg-warning',
                                            'Read' => 'text-bg-info',
                                            'Replied' => 'text-bg-success',
                                        ];
                                        $color = $statusColors[$inquiry->status] ?? 'text-bg-light';
                                    ?>
                                    <span class="badge <?php echo e($color); ?>"><?php echo e($inquiry->status); ?></span>
                                </td>
                                <td><?php echo e($inquiry->created_at->format('d M Y, h:i A')); ?></td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="<?php echo e(route('admin.inquiries.show', $inquiry)); ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.inquiries.destroy', $inquiry)); ?>" method="POST" onsubmit="return confirm('Are you sure?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No inquiries found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer clearfix bg-white">
            <?php echo e($inquiries->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/seemadrycleaner/htdocs/seemadrycleaner.in/resources/views/admin/inquiries/index.blade.php ENDPATH**/ ?>