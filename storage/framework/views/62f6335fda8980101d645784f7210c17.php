<?php $__env->startSection('meta_title', $category->name . ' Services - ' . config('app.name')); ?>
<?php $__env->startSection('meta_description', 'Browe our premium ' . $category->name . ' products. Get the best rates for high-quality laundry care.'); ?>

<?php $__env->startSection('content'); ?>
<section class="section-padding bg-light">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-white p-3 rounded-pill shadow-sm d-inline-flex px-4 border">
                <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('categories.index')); ?>" class="text-decoration-none text-muted">Services</a></li>
                <li class="breadcrumb-item active fw-bold text-primary" aria-current="page"><?php echo e($category->name); ?></li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <h1 class="display-5 fw-bold m-0 text-dark"><?php echo e($category->name); ?></h1>
                <p class="text-muted mt-2">Discover our specialized care for your <?php echo e(strtolower($category->name)); ?>.</p>
            </div>
        </div>

        <div class="row g-4">
            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card h-100 border-0 shadow-sm product-card-hover overflow-hidden">
                        <div class="position-relative">
                            <img src="https://images.unsplash.com/photo-1517677208171-0bc6725a3e60?auto=format&fit=crop&q=80&w=600" alt="<?php echo e($product->name); ?>" class="card-img-top overflow-hidden" style="height: 200px; object-fit: cover;">
                            <div class="position-absolute top-0 end-0 p-2">
                                <span class="badge bg-white text-primary shadow-sm rounded-pill fw-bold px-3">₹<?php echo e(number_format($product->base_price, 2)); ?></span>
                            </div>
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <h5 class="fw-bold text-dark mb-2"><?php echo e($product->name); ?></h5>
                            <p class="text-muted small flex-grow-1"><?php echo e(Str::limit($product->description, 70)); ?></p>
                            
                            <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="btn btn-primary d-block w-100 mt-3 rounded-pill fw-bold shadow-sm">
                                View Options
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-12 text-center py-5">
                    <div class="bg-white p-5 rounded-4 shadow-sm border border-dashed">
                        <i class="fas fa-box-open display-2 text-muted mb-4"></i>
                        <h3>No products found in this category.</h3>
                        <p class="text-muted">Stay tuned! We're adding new services soon.</p>
                        <a href="<?php echo e(route('categories.index')); ?>" class="btn btn-primary mt-3 px-4 rounded-pill">Explore Other Services</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="mt-5 d-flex justify-content-center">
            <?php echo e($products->links()); ?>

        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .product-card-hover {
        transition: all 0.3s ease;
    }
    .product-card-hover:hover {
        transform: scale(1.03);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/seemadrycleaner/htdocs/seemadrycleaner.in/resources/views/frontend/products/index.blade.php ENDPATH**/ ?>