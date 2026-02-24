<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank you — Order confirmed</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DM Sans', system-ui, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(165deg, #fefce8 0%, #fef9c3 20%, #fef3c7 40%, #fffbeb 70%, #fef3c7 100%);
            color: #1c1917;
            padding: 2rem 1rem;
        }
        .confirmation {
            max-width: 440px;
            width: 100%;
            text-align: center;
        }
        .confirmation-icon {
            width: 72px;
            height: 72px;
            margin: 0 auto 1.5rem;
            background: #22c55e;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(34, 197, 94, 0.35);
        }
        .confirmation-icon svg {
            width: 36px;
            height: 36px;
            stroke: white;
        }
        .confirmation h1 {
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            margin-bottom: 0.5rem;
            color: #1c1917;
        }
        .confirmation .lead {
            font-size: 1rem;
            color: #57534e;
            margin-bottom: 2rem;
            line-height: 1.5;
        }
        .order-box {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(8px);
            border-radius: 16px;
            padding: 1.5rem 1.25rem;
            margin-bottom: 2rem;
            text-align: left;
            border: 1px solid rgba(0,0,0,0.06);
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        }
        .order-box .order-id {
            font-size: 0.8125rem;
            font-weight: 600;
            color: #78716c;
            margin-bottom: 1rem;
        }
        .order-box .order-id span { color: #1c1917; }
        .order-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            font-size: 0.9375rem;
            color: #44403c;
        }
        .order-row.total {
            font-weight: 700;
            font-size: 1rem;
            color: #1c1917;
            border-top: 1px solid #e7e5e4;
            margin-top: 0.75rem;
            padding-top: 1rem;
        }
        .confirmation-note {
            font-size: 0.875rem;
            color: #78716c;
            line-height: 1.5;
            margin-bottom: 2rem;
        }
        .confirmation-actions {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        .confirmation-actions a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 48px;
            padding: 0 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9375rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .btn-primary {
            background: #1c1917;
            color: #fefce8;
        }
        .btn-primary:hover {
            background: #292524;
            color: #fefce8;
        }
        .btn-secondary {
            background: transparent;
            color: #57534e;
            border: 1px solid #d6d3d1;
        }
        .btn-secondary:hover {
            background: #f5f5f4;
            color: #1c1917;
        }
    </style>
</head>
<body>
    <div class="confirmation">
        <div class="confirmation-icon">
            <svg fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M20 6L9 17l-5-5"/>
            </svg>
        </div>
        <h1>Thank you</h1>
        <p class="lead">Your order is confirmed. We're glad you chose us.</p>

        <?php if($order): ?>
            <div class="order-box">
                <div class="order-id">Order <span>#<?php echo e($order->id); ?></span></div>
                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="order-row">
                        <span><?php echo e($item->product->name); ?> × <?php echo e($item->quantity); ?></span>
                        <span>₹<?php echo e(number_format($item->subtotal, 2)); ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($order->loyalty_discount_amount > 0): ?>
                    <div class="order-row" style="color: #16a34a;">
                        <span>Loyalty discount</span>
                        <span>-₹<?php echo e(number_format($order->loyalty_discount_amount, 2)); ?></span>
                    </div>
                <?php endif; ?>
                <div class="order-row total">
                    <span>Total</span>
                    <span>₹<?php echo e(number_format($order->total, 2)); ?></span>
                </div>
            </div>
            <p class="confirmation-note">We've sent the order details to your email. If you have any questions, just reach out — we're here to help.</p>
        <?php else: ?>
            <p class="confirmation-note">No recent order found. If you just placed an order, it may still be processing.</p>
        <?php endif; ?>

        <div class="confirmation-actions">
            <a href="<?php echo e(route('home')); ?>" class="btn-primary">Continue shopping</a>
            <?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(route('dashboard')); ?>" class="btn-secondary">My account</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\Admin\clean\complete ecom before mass upload - Copy\resources\views/checkout/confirmation.blade.php ENDPATH**/ ?>