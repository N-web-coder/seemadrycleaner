<div id="printableReceipt" style="width: 100%; font-family: 'Courier New', Courier, monospace; font-size: 13px; color: #000; padding: 10px; background: #fff;">
    <div style="text-align: center; border-bottom: 2px solid #000; padding-bottom: 15px; margin-bottom: 15px;">
        <h3 style="margin: 0; font-size: 20px;"><?php echo e(strtoupper(config('app.name'))); ?></h3>
        <p style="margin: 5px 0;"><?php echo e($order->store->name ?? 'Main Branch'); ?></p>
        <div style="font-size: 11px; margin-top: 5px;">
            ORDER: <strong>#<?php echo e($order->order_number); ?></strong><br>
            DATE: <?php echo e($order->created_at->format('d/m/Y h:i A')); ?>

        </div>
    </div>

    <div style="margin-bottom: 15px;">
        <p style="margin: 0;">CUSTOMER: <?php echo e($order->customer->name ?? 'Walk-in'); ?> (<?php echo e($order->customer->phone ?? $order->customer_phone ?? 'N/A'); ?>)</p>
    </div>

    <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px;">
        <thead>
            <tr style="border-bottom: 1px solid #000;">
                <th style="text-align: left; padding: 5px 0;">Item</th>
                <th style="text-align: center; padding: 5px 0;">Qty</th>
                <th style="text-align: right; padding: 5px 0;">Price</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="padding: 5px 0;">
                        <?php echo e($item->product_name); ?>

                        <?php if($item->option_name): ?>
                            <br><small style="color:#555;">+ <?php echo e($item->option_name); ?></small>
                        <?php endif; ?>
                    </td>
                    <td style="text-align: center; padding: 5px 0;"><?php echo e($item->quantity); ?></td>
                    <td style="text-align: right; padding: 5px 0;">₹<?php echo e(number_format($item->total_price, 2)); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <div style="border-top: 1px solid #000; padding-top: 10px;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
            <span>Subtotal:</span>
            <span>₹<?php echo e(number_format($order->sub_total, 2)); ?></span>
        </div>
        <?php if($order->discount_amount > 0): ?>
            <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                <span>Discount:</span>
                <span>-₹<?php echo e(number_format($order->discount_amount, 2)); ?></span>
            </div>
        <?php endif; ?>
        <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 16px; margin-top: 10px; border-top: 2px solid #000; padding-top: 5px;">
            <span>TOTAL:</span>
            <span>₹<?php echo e(number_format($order->total_amount, 2)); ?></span>
        </div>
    </div>

    <div style="text-align: center; margin-top: 30px; border-top: 1px dashed #555; padding-top: 15px;">
        <p style="margin: 0; font-size: 11px;">Thank you for your choice!</p>
        <p style="margin: 5px 0 0; font-size: 10px;">Please keep this receipt for pickup.</p>
        <div style="margin-top: 10px;">
            <?php echo DNS1D::getBarcodeHTML($order->order_number, 'C128', 1, 30); ?>

        </div>
    </div>
</div>
<?php /**PATH /home/seemadrycleaner/htdocs/seemadrycleaner.in/resources/views/admin/orders/partials/receipt.blade.php ENDPATH**/ ?>