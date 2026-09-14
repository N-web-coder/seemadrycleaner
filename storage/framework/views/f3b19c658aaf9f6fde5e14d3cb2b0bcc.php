<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Tags - <?php echo e($order->order_number); ?></title>
    <style>
        @page {
            size: auto;
            margin: 10mm;
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            margin: 0;
            padding: 0;
            background: #fff;
            font-size: 10px;
        }
        .tags-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .tag-card {
            width: 60mm;
            height: 40mm;
            border: 1px solid #ddd;
            padding: 2mm;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            page-break-inside: avoid;
        }
        .customer-name {
            font-weight: bold;
            font-size: 11px;
            margin-bottom: 2px;
        }
        .order-meta {
            margin-bottom: 4px;
        }
        .barcode {
            margin-bottom: 4px;
        }
        .barcode-text {
            font-size: 8px;
            margin-top: 2px;
        }
        .product-info {
            font-weight: bold;
            text-transform: uppercase;
        }
        .no-print {
            background: #f4f4f4;
            padding: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            text-align: center;
        }
        @media print {
            .no-print { display: none; }
            .tag-card { border: 1px solid #000; }
        }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer; background: #28a745; color: white; border: none; font-weight: bold;">PRINT ALL TAGS</button>
        <p>Instructions: Use 4x6 or thermal printer if possible. Scale to fit.</p>
    </div>

    <div class="tags-container">
        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php for($i = 0; $i < $item->quantity; $i++): ?>
                <div class="tag-card">
                    <div class="customer-name"><?php echo e($order->customer->name ?? 'Walk-in'); ?></div>
                    <div class="order-meta">#<?php echo e($order->order_number); ?> | <?php echo e(date('d/m/y')); ?></div>
                    
                    <div class="barcode">
                        <?php echo DNS1D::getBarcodeHTML($item->tag_auto, 'C128', 1.5, 33); ?>

                        <div class="barcode-text"><?php echo e($item->tag_auto); ?></div>
                    </div>

                    <div class="product-info">
                        <?php echo e($item->product_name); ?> 
                        <?php if($item->option_name): ?>
                            (<?php echo e($item->option_name); ?>)
                        <?php endif; ?>
                    </div>
                </div>
            <?php endfor; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <script>
        // Auto print prompt optional
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
<?php /**PATH /home/seemadrycleaner/htdocs/seemadrycleaner.in/resources/views/admin/orders/print_tags.blade.php ENDPATH**/ ?>