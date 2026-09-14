<?php $__env->startSection('meta_title', 'Best Laundry & Dry Cleaning Service - ' . config('app.name')); ?>
<?php $__env->startSection('meta_description', 'Experience the most reliable and premium laundry service. We handle your clothes with care, offering dry cleaning, steam ironing, and door-to-door delivery.'); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<section class="hero-section position-relative overflow-hidden" style="background: linear-gradient(rgba(13, 110, 253, 0.05), rgba(255, 255, 255, 1)); padding: 100px 0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <span class="badge bg-primary-subtle text-primary mb-3 px-3 py-2 rounded-pill fw-bold">PREMIUM CARE FOR YOUR CLOTHES</span>
                <h1 class="display-3 fw-bold mb-4 text-dark" style="line-height: 1.1;">Freshness Delivered to Your <span class="text-primary">Doorstep.</span></h1>
                <p class="lead text-muted mb-5">Experience professional laundry care that fits your lifestyle. High-quality washing, detailed pressing, and scrupulous dry cleaning for every garment.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="<?php echo e(route('categories.index')); ?>" class="btn btn-primary btn-lg px-5 py-3 shadow">Explore Services</a>
                    <a href="<?php echo e(route('about')); ?>" class="btn btn-outline-dark btn-lg px-5 py-3">Our Process</a>
                </div>
                <div class="mt-5 d-flex align-items-center">
                    <div class="d-flex me-3">
                        <i class="fas fa-star text-warning small me-1"></i>
                        <i class="fas fa-star text-warning small me-1"></i>
                        <i class="fas fa-star text-warning small me-1"></i>
                        <i class="fas fa-star text-warning small me-1"></i>
                        <i class="fas fa-star text-warning small"></i>
                    </div>
                    <span class="small fw-500 text-muted">Trusted by 5,000+ satisfied customers</span>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative">
                    <div class="hero-image-wrapper p-3 bg-white shadow-lg rounded-4 overflow-hidden rotate-1">
                        <img src="<?php echo e(asset('images/site/hero.png')); ?>" alt="Laundry Hero" class="img-fluid rounded-3">
                    </div>
                    <!-- Stats overlay elements -->
                    <div class="position-absolute bg-white p-3 rounded-3 shadow-sm d-none d-md-block" style="bottom: 20px; left: -20px;">
                        <span class="d-block h4 fw-bold mb-0 text-primary">24H</span>
                        <span class="small text-muted">Express Delivery</span>
                    </div>
                    <div class="position-absolute bg-white p-3 rounded-3 shadow-sm d-none d-md-block" style="top: 40px; right: -20px;">
                        <span class="d-block h4 fw-bold mb-0 text-success">100%</span>
                        <span class="small text-muted">Eco-Friendly</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h5 class="text-primary fw-bold text-uppercase ls-1">Our Expertise</h5>
            <h2 class="display-5 fw-bold">Wide Range of Services</h2>
            <div class="mx-auto" style="width: 80px; height: 3px; background: var(--primary-color);"></div>
        </div>
        <div class="row g-4 justify-content-center">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6">
                    <a href="<?php echo e(route('categories.show', $category->slug)); ?>" class="text-decoration-none">
                        <div class="card h-100 p-4 border-0 shadow-hover">
                            <div class="category-icon mb-4 d-inline-flex align-items-center justify-content-center rounded-3 bg-primary-subtle text-primary" style="width: 60px; height: 60px; font-size: 1.5rem;">
                                <i class="fas fa-tags"></i>
                            </div>
                            <h4 class="fw-bold text-dark"><?php echo e($category->name); ?></h4>
                            <p class="text-muted small">Professional <?php echo e(strtolower($category->name)); ?> services with attention to detail and fabric-specific care.</p>
                            <span class="text-primary fw-bold small mt-auto d-flex align-items-center">
                                View Products <i class="fas fa-arrow-right ms-2 small"></i>
                            </span>
                        </div>
                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="text-center mt-5">
            <a href="<?php echo e(route('categories.index')); ?>" class="btn btn-outline-primary px-4 fw-bold">View All Services</a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="section-padding">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5 order-2 order-lg-1">
                <h5 class="text-primary fw-bold text-uppercase">Why Us</h5>
                <h2 class="display-6 fw-bold mb-4">Dedicated to the Art of Cleaning</h2>
                <p class="text-muted mb-5">We go beyond just washing. Our artisanal approach ensures that your delicate fabrics, everyday wear, and household linens receive the exact care they deserve.</p>
                
                <div class="d-flex mb-4">
                    <div class="flex-shrink-0">
                        <div class="bg-primary-subtle text-primary rounded-circle p-3">
                            <i class="fas fa-truck"></i>
                        </div>
                    </div>
                    <div class="ms-4">
                        <h5 class="fw-bold">Free Pickup & Delivery</h5>
                        <p class="small text-muted">We come to you. Schedule a pickup through our dashboard and we'll handle the rest.</p>
                    </div>
                </div>

                <div class="d-flex mb-4">
                    <div class="flex-shrink-0">
                        <div class="bg-info-subtle text-info rounded-circle p-3">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                    </div>
                    <div class="ms-4">
                        <h5 class="fw-bold">Garment Insurance</h5>
                        <p class="small text-muted">Your items are safe with us. We provide full protection against any unforeseen damages.</p>
                    </div>
                </div>

                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <div class="bg-success-subtle text-success rounded-circle p-3">
                            <i class="fas fa-leaf"></i>
                        </div>
                    </div>
                    <div class="ms-4">
                        <h5 class="fw-bold">Chemical Free</h5>
                        <p class="small text-muted">We use bio-degradable, hypoallergenic detergents that are gentle on skin and the planet.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 order-1 order-lg-2">
                <div class="row g-3">
                    <div class="col-6">
                        <img src="https://images.unsplash.com/photo-1545173153-5ddf466baf58?auto=format&fit=crop&q=80&w=600" alt="Process 1" class="img-fluid rounded-4 shadow-sm mb-3">
                        <img src="https://images.unsplash.com/photo-1517677208171-0bc6725a3e60?auto=format&fit=crop&q=80&w=600" alt="Process 2" class="img-fluid rounded-4 shadow-sm">
                    </div>
                    <div class="col-6 pt-5">
                        <img src="https://images.unsplash.com/photo-1521656693064-1ec5a811848a?auto=format&fit=crop&q=80&w=600" alt="Process 3" class="img-fluid rounded-4 shadow-sm mb-3">
                        <img src="https://images.unsplash.com/photo-1582735689369-4fe89db7114c?auto=format&fit=crop&q=80&w=600" alt="Process 4" class="img-fluid rounded-4 shadow-sm">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="section-padding bg-dark text-white overflow-hidden">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <h5 class="text-primary fw-bold text-uppercase">Popular Choice</h5>
                <h2 class="display-6 fw-bold m-0">Our Best Sellers</h2>
            </div>
            <a href="<?php echo e(route('categories.index')); ?>" class="btn btn-outline-light d-none d-md-block">View Full Catalog</a>
        </div>
        <div class="row g-4">
            <?php $__currentLoopData = $featuredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 bg-white bg-opacity-10 border-0 text-white backdrop-blur">
                        <div class="card-body p-4 d-flex flex-column">
                            <span class="badge bg-primary mb-2 align-self-start"><?php echo e($item->category->name); ?></span>
                            <h5 class="fw-bold mb-3"><?php echo e($item->name); ?></h5>
                            <p class="small text-white-50 flex-grow-1"><?php echo e(Str::limit($item->description, 60)); ?></p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="h5 fw-bold mb-0 text-primary">₹<?php echo e(number_format($item->base_price, 2)); ?></span>
                                <a href="<?php echo e(route('products.show', $item->slug)); ?>" class="btn btn-sm btn-light rounded-circle"><i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section-padding">
    <div class="container">
        <div class="bg-primary rounded-5 p-5 text-center text-white shadow-lg">
            <h2 class="display-5 fw-bold mb-3">Ready to look your best?</h2>
            <p class="lead mb-5 opacity-75">Join thousands of customers who trust us with their garments every single day.</p>
            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="<?php echo e(route('login')); ?>" class="btn btn-light btn-lg px-5 py-3 fw-bold text-primary shadow">Schedule First Pickup</a>
                <a href="<?php echo e(route('contact')); ?>" class="btn btn-outline-light btn-lg px-5 py-3 fw-bold">Request a Quote</a>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .rotate-1 { transform: rotate(1deg); }
    .ls-1 { letter-spacing: 2px; }
    .shadow-hover { transition: all 0.3s ease; }
    .shadow-hover:hover { box-shadow: 0 15px 45px rgba(13, 110, 253, 0.15) !important; transform: translateY(-3px); }
    .backdrop-blur { backdrop-filter: blur(10px); }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\DKINFOTECH\seemadrycleaner.in\resources\views/frontend/home.blade.php ENDPATH**/ ?>