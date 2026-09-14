<?php $__env->startSection('meta_title', 'Checkout - ' . config('app.name')); ?>

<?php $__env->startSection('content'); ?>
<section class="section-padding bg-light">
    <div class="container">
        <h1 class="display-5 fw-bold mb-5 text-dark">Checkout</h1>

        <form action="<?php echo e(route('checkout.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="row g-5">
                <!-- Left Side: Order Form -->
                <div class="col-lg-7">
                    <!-- Delivery Details -->
                    <div class="card border-0 shadow-sm p-4 mb-4 rounded-4">
                        <h4 class="fw-bold mb-4 border-bottom pb-3"><i class="fas fa-truck text-primary me-2"></i> Delivery Details</h4>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-600">Complete Address</label>
                                <textarea name="address" class="form-control" rows="3" placeholder="Flat No, Building, Area..." required><?php echo e(auth()->user()->address ?? ''); ?></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">City</label>
                                <input type="text" name="city" class="form-control" placeholder="City" value="Clean City" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Contact Phone</label>
                                <input type="text" name="phone" class="form-control" placeholder="Phone" value="<?php echo e(auth()->user()->phone ?? ''); ?>" required>
                            </div>
                        </div>
                    </div>

                    <!-- Store Selection -->
                    <div class="card border-0 shadow-sm p-4 mb-4 rounded-4">
                        <h4 class="fw-bold mb-4 border-bottom pb-3"><i class="fas fa-store text-primary me-2"></i> Select Store Hook</h4>
                        <p class="text-muted small mb-4">Please choose which of our locations you would like to handle your laundry.</p>
                        <div class="row g-3">
                            <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-6">
                                    <input type="radio" class="btn-check" name="store_id" id="store-<?php echo e($store->id); ?>" value="<?php echo e($store->id); ?>" required>
                                    <label class="btn btn-outline-primary w-100 p-3 text-start" for="store-<?php echo e($store->id); ?>">
                                        <span class="d-block fw-bold"><?php echo e($store->name); ?></span>
                                        <span class="small opacity-75"><?php echo e($store->address); ?></span>
                                    </label>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="card border-0 shadow-sm p-4 rounded-4">
                        <h4 class="fw-bold mb-4 border-bottom pb-3"><i class="fas fa-money-bill-wave text-primary me-2"></i> Payment Method</h4>
                        <div class="d-flex flex-column gap-3">
                            <div class="form-check p-3 border rounded-3 bg-white">
                                <input class="form-check-input ms-0 me-3" type="radio" name="payment_method" id="pay-cod" value="cod" checked>
                                <label class="form-check-label fw-bold" for="pay-cod">
                                    Cash on Delivery / Pickup
                                </label>
                                <p class="text-muted small mb-0 ms-4 mt-1">Pay comfortably after we collect or deliver your laundry.</p>
                            </div>
                            <div class="form-check p-3 border rounded-3 bg-white">
                                <input class="form-check-input ms-0 me-3" type="radio" name="payment_method" id="pay-online" value="online">
                                <label class="form-check-label fw-bold" for="pay-online">
                                    Online Payment (Razorpay)
                                </label>
                                <p class="text-muted small mb-0 ms-4 mt-1">Safe and secure digital payment via Credit Card, UPI, or Net Banking.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Sticky Summary -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm p-4 rounded-4 sticky-top" style="top: 100px;">
                        <h4 class="fw-bold mb-4">Order Summary</h4>
                        <div class="summary-items mb-4" style="max-height: 250px; overflow-y: auto;">
                            <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                                    <div class="pe-3">
                                        <h6 class="fw-bold mb-0 small"><?php echo e($item['name']); ?></h6>
                                        <span class="text-muted" style="font-size: 0.75rem;"><?php echo e($item['option_name'] ?? 'Standard'); ?> x <?php echo e($item['quantity']); ?></span>
                                    </div>
                                    <span class="fw-bold small">₹<?php echo e(number_format($item['price'] * $item['quantity'], 2)); ?></span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-bold">₹<?php echo e(number_format($total, 2)); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Delivery Charges</span>
                            <span class="text-success small fw-bold">FREE</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4 mt-3 pt-3 border-top">
                            <span class="h5 fw-bold">Total Payable</span>
                            <span class="h5 fw-bold text-primary">₹<?php echo e(number_format($total, 2)); ?></span>
                        </div>

                        <button type="submit" class="btn btn-primary d-block w-100 py-3 fw-bold rounded-pill shadow">
                            Place Order & Schedule Pickup <i class="fas fa-check-circle ms-2"></i>
                        </button>
                        <p class="text-center mt-3 small text-muted">By placing an order, you agree to our Terms of Service.</p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/seemadrycleaner/htdocs/seemadrycleaner.in/resources/views/frontend/checkout/index.blade.php ENDPATH**/ ?>