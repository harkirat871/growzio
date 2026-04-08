<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Growzio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* =============================================
           GROWZIO — DESIGN SYSTEM (same as index)
           ============================================= */
        :root {
            --g-bg:         #222831;
            --g-bg2:        #393E46;
            --g-accent:     #FFD369;
            --g-light:      #EEEEEE;
            --g-text:       #EEEEEE;
            --g-text-muted: rgba(238,238,238,0.55);
            --g-border:     rgba(238,238,238,0.10);
            --g-border-hover: rgba(255,211,105,0.35);
            --g-card-bg:    #2d3340;
            --g-radius:     4px;
            --g-radius-lg:  10px;
            --font-head:    'Syne', sans-serif;
            --font-body:    'DM Sans', sans-serif;
            --font-mono:    'JetBrains Mono', monospace;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--g-bg);
            font-family: var(--font-body);
            font-size: 16px;
            line-height: 1.5;
            color: var(--g-text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        /* Form container */
        .g-register-container {
            max-width: 560px;
            width: 100%;
            background: var(--g-card-bg);
            border: 1px solid var(--g-border);
            border-radius: var(--g-radius-lg);
            padding: 2rem 1.5rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }

        @media (min-width: 640px) {
            .g-register-container {
                padding: 2.5rem;
            }
        }

        /* Headings */
        .g-register-title {
            font-family: var(--font-head);
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--g-light);
            margin-bottom: 0.25rem;
        }

        .g-register-subtitle {
            font-size: 0.9375rem;
            color: var(--g-text-muted);
            margin-bottom: 1.75rem;
            border-left: 3px solid var(--g-accent);
            padding-left: 0.75rem;
        }

        /* Form elements */
        .g-form-group {
            margin-bottom: 1.25rem;
        }

        .g-label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 500;
            color: var(--g-text-muted);
            margin-bottom: 0.5rem;
            font-family: var(--font-mono);
            letter-spacing: 0.02em;
        }

        .g-label span {
            color: rgba(238,238,238,0.45);
            font-weight: normal;
        }

        .g-input {
            width: 100%;
            background: var(--g-bg);
            border: 1px solid var(--g-border);
            border-radius: var(--g-radius);
            padding: 0.75rem 1rem;
            font-size: 0.9375rem;
            font-family: var(--font-body);
            color: var(--g-text);
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .g-input:focus {
            outline: none;
            border-color: var(--g-accent);
            box-shadow: 0 0 0 3px rgba(255,211,105,0.12);
        }

        .g-input::placeholder {
            color: rgba(238,238,238,0.3);
        }

        /* Error message */
        .g-error {
            font-size: 0.75rem;
            color: #f87171;
            margin-top: 0.375rem;
            font-family: var(--font-mono);
        }

        /* Button & link row */
        .g-form-actions {
            margin-top: 1.75rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        @media (min-width: 480px) {
            .g-form-actions {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
        }

        .g-link {
            font-size: 0.875rem;
            color: var(--g-text-muted);
            text-decoration: none;
            transition: color 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .g-link:hover {
            color: var(--g-accent);
        }

        .g-btn {
            background: var(--g-accent);
            color: var(--g-bg);
            border: none;
            border-radius: var(--g-radius);
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            font-family: var(--font-body);
            cursor: pointer;
            transition: transform 0.2s, background 0.2s;
            width: 100%;
        }

        @media (min-width: 480px) {
            .g-btn {
                width: auto;
            }
        }

        .g-btn:hover {
            background: #e8bc52;
            transform: translateY(-1px);
        }

        .g-btn:active {
            transform: translateY(0);
        }

        /* Small helper */
        .g-text-muted {
            color: var(--g-text-muted);
            font-size: 0.75rem;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="g-register-container">
        <h1 class="g-register-title">Create your account</h1>
        <div class="g-register-subtitle">Join us — it only takes a minute.</div>

        <form method="POST" action="<?php echo e(route('register')); ?>">
            <?php echo csrf_field(); ?>

            <!-- Name -->
            <div class="g-form-group">
                <label for="name" class="g-label">Name</label>
                <input id="name" type="text" name="name" value="<?php echo e(old('name')); ?>" required autofocus autocomplete="name"
                    placeholder="e.g. John Doe"
                    class="g-input">
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="g-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Business name -->
            <div class="g-form-group">
                <label for="business_name" class="g-label">Business name</label>
                <input id="business_name" type="text" name="business_name" value="<?php echo e(old('business_name')); ?>" autocomplete="organization"
                    placeholder="e.g. ABC Traders"
                    class="g-input">
                <?php $__errorArgs = ['business_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="g-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- GST number (optional) -->
            <div class="g-form-group">
                <label for="gst_number" class="g-label">GST number <span>(optional, 15-character GSTIN)</span></label>
                <input id="gst_number" type="text" name="gst_number" value="<?php echo e(old('gst_number')); ?>"
                    placeholder="e.g. 22AABCU9603R1Z5"
                    pattern="[0-9]{2}[A-Za-z]{5}[0-9]{4}[A-Za-z][1-9A-Za-z]Z[0-9A-Za-z]"
                    title="15-character GSTIN: 2 digits + 5 letters + 4 digits + 1 letter + 1 char + Z + 1 char (e.g. 22AABCU9603R1Z5)"
                    maxlength="20"
                    class="g-input">
                <?php $__errorArgs = ['gst_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="g-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Contact number -->
            <div class="g-form-group">
                <label for="contact_number" class="g-label">Phone number</label>
                <input id="contact_number" type="tel" name="contact_number" value="<?php echo e(old('contact_number')); ?>" required autocomplete="tel"
                    placeholder="e.g. 9876543210 or +91 9876543210"
                    pattern="(\+91)?[6-9][0-9]{9}"
                    title="10-digit Indian mobile number (starting with 6, 7, 8 or 9)"
                    maxlength="14"
                    class="g-input">
                <?php $__errorArgs = ['contact_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="g-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Station / Area -->
            <div class="g-form-group">
                <label for="station" class="g-label">Station / Area</label>
                <input id="station" type="text" name="station" value="<?php echo e(old('station')); ?>" required autocomplete="address-level2"
                    placeholder="e.g. Andheri, Mumbai"
                    class="g-input">
                <?php $__errorArgs = ['station'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="g-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Email -->
            <div class="g-form-group">
                <label for="email" class="g-label">Email</label>
                <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="username"
                    placeholder="e.g. you@example.com"
                    class="g-input">
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="g-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Password -->
            <div class="g-form-group">
                <label for="password" class="g-label">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    placeholder="Min. 8 characters"
                    class="g-input">
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="g-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Confirm Password -->
            <div class="g-form-group">
                <label for="password_confirmation" class="g-label">Confirm password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    placeholder="Re-enter password"
                    class="g-input">
            </div>

            <!-- Referred by (optional) -->
            <div class="g-form-group">
                <label for="referred_by" class="g-label">Referred by <span>(optional)</span></label>
                <input id="referred_by" type="text" name="referred_by" value="<?php echo e(old('referred_by')); ?>"
                    placeholder="Name or code of referrer"
                    class="g-input">
                <?php $__errorArgs = ['referred_by'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="g-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="g-form-actions">
                <a href="<?php echo e(route('login')); ?>" class="g-link">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                    Already have an account? Sign in
                </a>
                <button type="submit" class="g-btn">Create account</button>
            </div>
        </form>
    </div>

    <script>
        // GST number auto-uppercase and strip spaces
        document.getElementById('gst_number')?.addEventListener('input', function() {
            this.value = this.value.toUpperCase().replace(/\s/g, '');
        });
    </script>
</body>
</html><?php /**PATH C:\Users\Admin\clean\growzio\resources\views/auth/register.blade.php ENDPATH**/ ?>