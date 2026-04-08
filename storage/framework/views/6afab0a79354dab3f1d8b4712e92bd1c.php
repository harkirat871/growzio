<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="app-timezone" content="<?php echo e(config('app.timezone')); ?>">
    <title><?php echo $__env->yieldContent('title', 'Create account'); ?> — <?php echo e(config('app.name', 'Store')); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&display=swap" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <style>
        body { font-family: 'DM Sans', system-ui, sans-serif; }
        .guest-wrap { min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; background: linear-gradient(160deg, #f8fafc 0%, #f1f5f9 50%, #e2e8f0 100%); padding: 2rem 1rem; }
        .guest-card { width: 100%; max-width: 420px; background: #fff; border-radius: 20px; box-shadow: 0 4px 24px rgba(15, 23, 42, 0.08), 0 1px 3px rgba(15, 23, 42, 0.06); padding: 2.5rem; }
        .guest-logo { display: block; text-align: center; margin-bottom: 1.5rem; font-size: 1.5rem; font-weight: 700; color: #0f172a; text-decoration: none; letter-spacing: -0.02em; }
        .guest-logo:hover { color: #334155; }
    </style>
</head>
<body class="antialiased text-gray-900">
    <div class="guest-wrap">
        <a href="<?php echo e(url('/')); ?>" class="guest-logo"><?php echo e(config('app.name', 'Store')); ?></a>
        <div class="guest-card">
            <?php echo e($slot); ?>

        </div>
    </div>
    <?php echo $__env->make('partials.toast', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html>
<?php /**PATH C:\Users\Admin\clean\growzio\resources\views/layouts/guest.blade.php ENDPATH**/ ?>