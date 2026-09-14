<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('meta_title', config('app.name', 'Laravel')); ?> - Premium Laundry Service</title>
    <meta name="description"
        content="<?php echo $__env->yieldContent('meta_description', 'Professional laundry and dry cleaning services delivered to your doorstep. Best in class quality with eco-friendly washing.'); ?>">
    <meta name="keywords"
        content="<?php echo $__env->yieldContent('meta_keywords', 'laundry, dry cleaning, steam iron, washing, seema laundry'); ?>">

    <!-- Open Graph / SEO -->
    <meta property="og:title" content="<?php echo $__env->yieldContent('meta_title', config('app.name', 'Laravel')); ?>">
    <meta property="og:description"
        content="<?php echo $__env->yieldContent('meta_description', 'Professional laundry and dry cleaning services.'); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo e(url()->current()); ?>">

    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --accent-color: #0dcaf0;
            --dark-color: #1e293b;
            --light-color: #f8fafc;
            --text-main: #334155;
            --font-family: 'Outfit', sans-serif;
        }

        body {
            font-family: var(--font-family);
            color: var(--text-main);
            background-color: #ffffff;
            overflow-x: hidden;
        }

        .navbar {
            padding: 1rem 0;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
        }

        .nav-link {
            font-weight: 500;
            color: var(--dark-color) !important;
            margin: 0 10px;
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.6rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
        }

        footer {
            background-color: var(--dark-color);
            color: #ffffff;
            padding: 4rem 0 2rem;
        }

        .footer-link {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.3s ease;
            display: block;
            margin-bottom: 10px;
        }

        .footer-link:hover {
            color: #ffffff;
        }

        .section-padding {
            padding: 80px 0;
        }

        .card {
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border-radius: 15px;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body>

    <!-- Sticky Header -->
    <nav class="navbar navbar-expand-lg sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                <img src="logo.png" alt="<?php echo e(config('app.name')); ?> logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMain">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('/')); ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('categories.index')); ?>">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('about')); ?>">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('contact')); ?>">Contact</a></li>
                </ul>
                <div class="d-flex align-items-center">
                    <a href="<?php echo e(route('cart.index')); ?>"
                        class="btn btn-outline-dark position-relative me-3 rounded-pill">
                        <i class="fas fa-shopping-basket"></i>
                        <span id="cart-count"
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?php echo e(session('cart') ? count(session('cart')) : 0); ?>

                        </span>
                    </a>
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(auth()->user()->role === 'admin' || auth()->user()->role === 'manager'): ?>
                            <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-primary rounded-pill">Admin</a>
                        <?php elseif(auth()->user()->role === 'customer'): ?>
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle rounded-pill" type="button"
                                    data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle me-1"></i> Account
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                    <li><a class="dropdown-item" href="<?php echo e(route('account.dashboard')); ?>">Dashboard</a></li>
                                    <li><a class="dropdown-item" href="<?php echo e(route('account.orders')); ?>">My Orders</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="dropdown-item text-danger">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if(auth()->guard()->guest()): ?>
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-primary rounded-pill">Login / Signup</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <h4 class="fw-bold mb-4">
                        <img src="logo.png" alt="<?php echo e(config('app.name')); ?> logo">
                    </h4>
                    <p class="text-muted-foreground" style="color: #cbd5e1;">Providing premium laundry and dry cleaning
                        services with a focus on quality, convenience, and eco-friendly care for your garments.</p>
                    <div class="social-links mt-4">
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle me-2"><i
                                class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle me-2"><i
                                class="fab fa-instagram"></i></a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle me-2"><i
                                class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5 class="fw-bold mb-4 text-white">Quick Links</h5>
                    <a href="<?php echo e(url('/')); ?>" class="footer-link">Home</a>
                    <a href="<?php echo e(route('categories.index')); ?>" class="footer-link">Our Services</a>
                    <a href="<?php echo e(route('about')); ?>" class="footer-link">About Us</a>
                    <a href="<?php echo e(route('contact')); ?>" class="footer-link">Support</a>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5 class="fw-bold mb-4 text-white">Services</h5>
                    <a href="#" class="footer-link">Dry Cleaning</a>
                    <a href="#" class="footer-link">Steam Ironing</a>
                    <a href="#" class="footer-link">Wash & Fold</a>
                    <a href="#" class="footer-link">Stain Removal</a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h5 class="fw-bold mb-4 text-white">Contact Us</h5>
                    <p class="mb-2" style="color: #cbd5e1;"><i class="fas fa-map-marker-alt me-2 text-primary"></i>
                        <?php echo e(env('COMPANY_ADDRESS')); ?></p>
                    <p class="mb-2" style="color: #cbd5e1;"><i class="fas fa-phone-alt me-2 text-primary"></i>
                        <?php echo e(env('COMPANY_PHONE')); ?></p>
                    <p class="mb-0" style="color: #cbd5e1;"><i class="fas fa-envelope me-2 text-primary"></i>
                        <?php echo e(env('COMPANY_EMAIL')); ?></p>
                </div>
            </div>
            <hr class="my-5" style="border-color: #334155;">
            <div class="text-center text-muted small">
                &copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name', 'Laundry')); ?>. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-4" style="z-index: 9999;">
        <div id="statusToast" class="toast border-0 shadow-lg rounded-4 overflow-hidden" role="alert"
            aria-live="assertive" aria-atomic="true" data-bs-delay="8000">
            <div class="d-flex align-items-center p-3 bg-white border-start border-5" id="toast-border">
                <div class="toast-icon-bg me-3 rounded-circle d-flex align-items-center justify-content-center text-white"
                    style="width: 40px; height: 40px; min-width: 40px;">
                    <i class="fas fa-check"></i>
                </div>
                <div class="toast-body p-0 pe-4">
                    <h6 class="fw-bold mb-1 text-dark" id="toast-title">Success!</h6>
                    <p class="mb-0 small text-muted" id="toast-message">Item added to your basket.</p>
                </div>
                <button type="button" class="btn-close ms-auto me-1" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
            <div class="toast-progress-bar h-1 bg-primary"
                style="height: 4px; width: 100%; transition: width 8s linear;"></div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        // Global Toast helper
        window.showToast = function (title, message, type = 'success') {
            const toastEl = document.getElementById('statusToast');
            const titleEl = document.getElementById('toast-title');
            const msgEl = document.getElementById('toast-message');
            const iconBg = document.querySelector('.toast-icon-bg');
            const progressBar = document.querySelector('.toast-progress-bar');
            const toastBorder = document.getElementById('toast-border');

            titleEl.innerText = title;
            msgEl.innerText = message;

            if (type === 'success') {
                iconBg.style.backgroundColor = '#10b981';
                progressBar.style.backgroundColor = '#10b981';
                toastBorder.style.borderColor = '#10b981';
                iconBg.innerHTML = '<i class="fas fa-check"></i>';
            } else if (type === 'error') {
                iconBg.style.backgroundColor = '#ef4444';
                progressBar.style.backgroundColor = '#ef4444';
                toastBorder.style.borderColor = '#ef4444';
                iconBg.innerHTML = '<i class="fas fa-exclamation-triangle"></i>';
            }

            const toast = new bootstrap.Toast(toastEl);

            // Reset Progress Bar
            progressBar.style.transition = 'none';
            progressBar.style.width = '100%';

            toastEl.addEventListener('show.bs.toast', () => {
                setTimeout(() => {
                    progressBar.style.transition = 'width 8s linear';
                    progressBar.style.width = '0%';
                }, 10);
            });

            toast.show();
        };

        // Global Cart Counter update helper
        window.updateCartCount = function (count) {
            $('#cart-count').text(count);
        };

        // Handle Session Flash Messages
        $(document).ready(function () {
            <?php if(session('success')): ?>
                window.showToast('Success!', "<?php echo e(session('success')); ?>", 'success');
            <?php endif; ?>

            <?php if(session('error')): ?>
                window.showToast('Error!', "<?php echo e(session('error')); ?>", 'error');
            <?php endif; ?>

            <?php if(session('warning')): ?>
                window.showToast('Warning!', "<?php echo e(session('warning')); ?>", 'error');
            <?php endif; ?>

            <?php if(session('info')): ?>
                window.showToast('Info', "<?php echo e(session('info')); ?>", 'success');
            <?php endif; ?>
        });
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH D:\DKINFOTECH\seemadrycleaner.in\resources\views/layouts/app.blade.php ENDPATH**/ ?>