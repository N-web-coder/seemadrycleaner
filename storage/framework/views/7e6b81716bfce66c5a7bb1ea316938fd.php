<?php $__env->startSection('meta_title', 'Our Services - ' . config('app.name')); ?>
<?php $__env->startSection('meta_description', 'Discover our wide range of professional laundry and dry cleaning services. From steam ironing to delicate wash, we handle it all.'); ?>

<?php $__env->startSection('content'); ?>
<section class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold">Explore Our Services</h1>
            <p class="text-muted lead">Choose a category to see our tailored care solutions for your garments.</p>
        </div>

        <div class="row g-4">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm custom-card overflow-hidden">
                        <div class="card-body p-4 text-center">
                            <div class="mb-4 d-inline-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary" style="width: 80px; height: 80px; font-size: 2rem;">
                                <i class="fas fa-soap"></i>
                            </div>
                            <h3 class="fw-bold mb-3"><?php echo e($category->name); ?></h3>
                            <p class="text-muted mb-4">Dedicated and professsional <?php echo e(strtolower($category->name)); ?> for your everyday and special occasion wear.</p>
                            
                            <div class="d-flex justify-content-center align-items-center mb-4">
                                <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill fw-bold">
                                    <?php echo e($category->products_count); ?> Products Available
                                </span>
                            </div>

                            <a href="<?php echo e(route('categories.show', $category->slug)); ?>" class="btn btn-outline-primary d-block py-2 fw-bold rounded-pill shadow-sm">
                                Browse Items <i class="fas fa-chevron-right ms-2 small"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .custom-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .custom-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/seemadrycleaner/htdocs/seemadrycleaner.in/resources/views/frontend/categories/index.blade.php ENDPATH**/ ?>