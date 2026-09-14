<?php $__env->startSection('meta_title', $product->name . ' - Professional Service - ' . config('app.name')); ?>
<?php $__env->startSection('meta_description', $product->description); ?>

<?php $__env->startSection('content'); ?>
<section class="section-padding bg-light">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-5">
            <ol class="breadcrumb bg-white p-3 rounded-pill shadow-sm d-inline-flex px-4 border">
                <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('categories.index')); ?>" class="text-decoration-none text-muted">Services</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('categories.show', $product->category->slug)); ?>" class="text-decoration-none text-muted"><?php echo e($product->category->name); ?></a></li>
                <li class="breadcrumb-item active fw-bold text-primary" aria-current="page"><?php echo e($product->name); ?></li>
            </ol>
        </nav>

        <div class="row g-5">
            <div class="col-lg-6">
                <div class="bg-white p-2 rounded-5 shadow-sm border overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1545173153-5ddf466baf58?auto=format&fit=crop&q=80&w=800" alt="<?php echo e($product->name); ?>" class="img-fluid rounded-5 w-100" style="max-height: 500px; object-fit: cover;">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ps-lg-4">
                    <span class="badge bg-primary-subtle text-primary mb-3 px-3 py-2 rounded-pill fw-bold"><?php echo e($product->category->name); ?></span>
                    <h1 class="display-4 fw-bold mb-3 text-dark"><?php echo e($product->name); ?></h1>
                    <p class="text-muted lead mb-4"><?php echo e($product->description); ?></p>
                    
                    <div class="pricing mb-5">
                        <input type="hidden" id="base-price-val" value="<?php echo e($product->base_price); ?>">
                        <span class="h2 fw-bold text-dark me-2">₹<span id="display-price"><?php echo e(number_format($product->base_price, 2)); ?></span></span>
                        <span class="text-muted small">/ per item</span>
                    </div>

                    <form id="add-to-cart-form">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                        
                        <?php if($product->options->count() > 0): ?>
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark mb-3">Choose Service Type <span class="text-danger">*</span></label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="radio" class="btn-check" name="option_id" id="opt-base" value="" data-price="0" checked>
                                        <label class="btn btn-outline-primary w-100 py-3 rounded-3 fw-bold option-label" for="opt-base">
                                            <span class="d-block">Standard</span>
                                            <span class="small opacity-75">Included</span>
                                        </label>
                                    </div>
                                    <?php $__currentLoopData = $product->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-6">
                                            <input type="radio" class="btn-check" name="option_id" id="opt-<?php echo e($option->id); ?>" value="<?php echo e($option->id); ?>" data-price="<?php echo e($option->price); ?>">
                                            <label class="btn btn-outline-primary w-100 py-3 rounded-3 fw-bold option-label" for="opt-<?php echo e($option->id); ?>">
                                                <span class="d-block"><?php echo e($option->name); ?></span>
                                                <span class="small opacity-75">+₹<?php echo e(number_format($option->price, 2)); ?></span>
                                            </label>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="row g-3 mb-5 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Quantity</label>
                                <div class="input-group">
                                    <button class="btn btn-outline-dark border" type="button" onclick="changeQty(-1)"><i class="fas fa-minus small"></i></button>
                                    <input type="number" name="quantity" id="quantity" class="form-control text-center border-dark border-start-0 border-end-0" value="1" min="1">
                                    <button class="btn btn-outline-dark border" type="button" onclick="changeQty(1)"><i class="fas fa-plus small"></i></button>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-pill shadow btn-add-cart">
                                    <i class="fas fa-shopping-basket me-2"></i> Add to Basket
                                </button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Special Instructions (Optional)</label>
                            <textarea name="remarks" class="form-control bg-white border rounded-3 p-3" rows="3" placeholder="E.g. Remove coffee stain on collar, careful with buttons..."></textarea>
                        </div>
                    </form>

                    <!-- Features list -->
                    <div class="border-top pt-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center small text-muted">
                                    <i class="fas fa-check-circle text-success me-2"></i> Professional Cleaning
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center small text-muted">
                                    <i class="fas fa-check-circle text-success me-2"></i> Quality Assurance
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center small text-muted">
                                    <i class="fas fa-check-circle text-success me-2"></i> Expert Hand Finish
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center small text-muted">
                                    <i class="fas fa-check-circle text-success me-2"></i> Safe on Fabrics
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if($relatedProducts->count() > 0): ?>
            <div class="mt-5 pt-5">
                <h3 class="fw-bold mb-4">You might also need</h3>
                <div class="row g-4">
                    <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-3 col-md-6">
                            <a href="<?php echo e(route('products.show', $rel->slug)); ?>" class="text-decoration-none">
                                <div class="card border-0 shadow-sm p-3 shadow-hover">
                                    <h6 class="fw-bold text-dark mb-1"><?php echo e($rel->name); ?></h6>
                                    <span class="text-primary small fw-bold">₹<?php echo e(number_format($rel->base_price, 2)); ?></span>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function changeQty(n) {
        let input = document.getElementById('quantity');
        let val = parseInt(input.value) + n;
        if (val >= 1) input.value = val;
    }

    // Update display price based on selection
    $('input[name="option_id"]').on('change', function() {
        let basePrice = parseFloat($('#base-price-val').val());
        let extraPrice = parseFloat($(this).data('price'));
        let totalPrice = basePrice + extraPrice;
        $('#display-price').text(totalPrice.toLocaleString('en-IN', { minimumFractionDigits: 2 }));
    });

    $('#add-to-cart-form').on('submit', function(e) {
        e.preventDefault();
        let btn = $('.btn-add-cart');
        let originalHtml = btn.html();
        
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i> Adding...');

        $.ajax({
            url: "<?php echo e(route('cart.add')); ?>",
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    window.updateCartCount(response.cart_count);
                    let msg = response.product_name + (response.option_name ? ' (' + response.option_name + ')' : '') + ' has been added to your basket.';
                    window.showToast('Added to Basket!', msg);
                }
            },
            error: function(err) {
                window.showToast('Oops!', 'Error adding to basket. Please try again.', 'error');
            },
            complete: function() {
                btn.prop('disabled', false).html(originalHtml);
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/seemadrycleaner/htdocs/seemadrycleaner.in/resources/views/frontend/products/show.blade.php ENDPATH**/ ?>