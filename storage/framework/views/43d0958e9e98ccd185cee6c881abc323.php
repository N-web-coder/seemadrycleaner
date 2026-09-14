<?php $__env->startSection('meta_title', 'Your Basket - ' . config('app.name')); ?>

<?php $__env->startSection('content'); ?>
<section class="section-padding bg-light">
    <div class="container">
        <h1 class="display-5 fw-bold mb-5 text-dark">Your Service Basket</h1>

        <?php if(count($cart) > 0): ?>
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm p-4">
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle">
                                <thead class="border-bottom">
                                    <tr class="text-muted small fw-bold">
                                        <th colspan="2">SERVICE ITEM</th>
                                        <th class="text-center">PRICE</th>
                                        <th class="text-center">QTY</th>
                                        <th class="text-end">SUBTOTAL</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="border-bottom" data-id="<?php echo e($id); ?>">
                                            <td style="width: 80px;">
                                                <img src="<?php echo e($item['image']); ?>" class="img-fluid rounded-3" alt="<?php echo e($item['name']); ?>">
                                            </td>
                                            <td>
                                                <h6 class="fw-bold mb-1"><?php echo e($item['name']); ?></h6>
                                                <?php if($item['option_name']): ?>
                                                    <span class="badge bg-primary-subtle text-primary small"><?php echo e($item['option_name']); ?></span>
                                                <?php endif; ?>
                                                <?php if($item['remarks']): ?>
                                                    <div class="mt-1 small text-muted italic">Note: <?php echo e($item['remarks']); ?></div>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">₹<?php echo e(number_format($item['price'], 2)); ?></td>
                                            <td class="text-center" style="width: 140px;">
                                                <div class="input-group input-group-sm">
                                                    <button class="btn btn-outline-secondary border update-cart" data-change="-1"><i class="fas fa-minus"></i></button>
                                                    <input type="number" class="form-control text-center cart-qty-input" value="<?php echo e($item['quantity']); ?>" min="1" readonly>
                                                    <button class="btn btn-outline-secondary border update-cart" data-change="1"><i class="fas fa-plus"></i></button>
                                                </div>
                                            </td>
                                            <td class="text-end fw-bold">₹<?php echo e(number_format($item['price'] * $item['quantity'], 2)); ?></td>
                                            <td class="text-end">
                                                <button class="btn btn-sm btn-outline-danger border-0 remove-from-cart"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            <a href="<?php echo e(route('categories.index')); ?>" class="btn btn-link text-decoration-none text-primary fw-bold p-0">
                                <i class="fas fa-arrow-left me-2"></i> Add more services
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm p-4 sticky-top" style="top: 100px;">
                        <h4 class="fw-bold mb-4">Summary</h4>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Total Items</span>
                            <span class="fw-bold"><?php echo e(count($cart)); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Estimated Subtotal</span>
                            <span class="fw-bold h5 mb-0">₹<?php echo e(number_format($total, 2)); ?></span>
                        </div>
                        <hr>
                        <p class="small text-muted mb-4"><i class="fas fa-info-circle me-1"></i> Taxes and delivery fees (if any) will be calculated at checkout.</p>
                        
                        <a href="<?php echo e(route('checkout.index')); ?>" class="btn btn-primary d-block w-100 py-3 fw-bold rounded-pill shadow-sm">
                            Proceed to Checkout <i class="fas fa-credit-card ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <div class="bg-white p-5 rounded-5 shadow-sm border border-dashed">
                    <i class="fas fa-shopping-basket display-1 text-muted mb-4 opacity-25"></i>
                    <h2 class="fw-bold">Your basket is empty</h2>
                    <p class="text-muted lead mb-4">Looks like you haven't added any services yet. Let's freshen up your wardrobe!</p>
                    <a href="<?php echo e(route('categories.index')); ?>" class="btn btn-primary px-5 py-3 fw-bold rounded-pill shadow">Explore Services</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    $('.update-cart').on('click', function() {
        let row = $(this).closest('tr');
        let id = row.data('id');
        let currentQty = parseInt(row.find('.cart-qty-input').val());
        let change = parseInt($(this).data('change'));
        let newQty = currentQty + change;

        if (newQty < 1) return;

        $.ajax({
            url: "<?php echo e(route('cart.update')); ?>",
            method: "POST",
            data: {
                _token: "<?php echo e(csrf_token()); ?>",
                id: id,
                quantity: newQty
            },
            success: function(response) {
                location.reload();
            }
        });
    });

    $('.remove-from-cart').on('click', function() {
        if (!confirm('Remove this service from basket?')) return;
        
        let id = $(this).closest('tr').data('id');

        $.ajax({
            url: "<?php echo e(route('cart.remove')); ?>",
            method: "POST",
            data: {
                _token: "<?php echo e(csrf_token()); ?>",
                id: id
            },
            success: function(response) {
                location.reload();
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/seemadrycleaner/htdocs/seemadrycleaner.in/resources/views/frontend/cart/index.blade.php ENDPATH**/ ?>