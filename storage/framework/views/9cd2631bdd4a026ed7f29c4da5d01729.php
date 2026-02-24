<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Required - Premium Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --dark-gradient: linear-gradient(135deg, #0c0c0c 0%, #1a1a1a 100%);
            --card-gradient: linear-gradient(145deg, #1e1e1e 0%, #2d2d2d 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--dark-gradient);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-required-card {
            background: var(--card-gradient);
            border-radius: 25px;
            padding: 60px 40px;
            text-align: center;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .login-required-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--primary-gradient);
            opacity: 0.03;
            border-radius: 25px;
            z-index: 1;
        }

        .card-content {
            position: relative;
            z-index: 2;
        }

        .icon-container {
            width: 120px;
            height: 120px;
            background: var(--primary-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.3);
        }

        .icon-container i {
            font-size: 3rem;
            color: white;
        }

        .title {
            font-size: 2.5rem;
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 20px;
        }

        .subtitle {
            font-size: 1.2rem;
            color: #b0b0b0;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .benefits {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 40px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .benefits h4 {
            font-size: 1.3rem;
            margin-bottom: 20px;
            color: #ffffff;
        }

        .benefit-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            color: #b0b0b0;
        }

        .benefit-item i {
            color: #667eea;
            margin-right: 15px;
            font-size: 1.1rem;
        }

        .benefit-item:last-child {
            margin-bottom: 0;
        }

        .action-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-login {
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 15px 40px;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-register {
            background: transparent;
            border: 2px solid #667eea;
            color: #667eea;
            padding: 15px 40px;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-register:hover {
            background: #667eea;
            color: white;
            transform: translateY(-3px);
        }

        .back-link {
            margin-top: 30px;
        }

        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .back-link a:hover {
            color: #8b94ff;
        }

        @media (max-width: 768px) {
            .login-required-card {
                padding: 40px 20px;
                margin: 20px;
            }
            
            .title {
                font-size: 2rem;
            }
            
            .action-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .btn-login, .btn-register {
                width: 100%;
                max-width: 300px;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="login-required-card">
        <div class="card-content">
            <div class="icon-container">
                <i class="fas fa-lock"></i>
            </div>
            
            <h1 class="title">Login Required</h1>
            <p class="subtitle">
                To complete your purchase and access exclusive features, please login to your account or create a new one.
            </p>
            
            <div class="benefits">
                <h4><i class="fas fa-star me-2"></i>Benefits of Creating an Account</h4>
                <div class="benefit-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Save your cart for later</span>
                </div>
                <div class="benefit-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Track your order history</span>
                </div>
                <div class="benefit-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Faster checkout process</span>
                </div>
                <div class="benefit-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Exclusive member discounts</span>
                </div>
                <div class="benefit-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Personalized recommendations</span>
                </div>
            </div>
            
            <div class="action-buttons">
                <a href="<?php echo e(route('login')); ?>" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i>
                    Login
                </a>
                <a href="<?php echo e(route('register')); ?>" class="btn-register">
                    <i class="fas fa-user-plus"></i>
                    Create Account
                </a>
            </div>
            
            <div class="back-link">
                <a href="<?php echo e(route('cart.view')); ?>">
                    <i class="fas fa-arrow-left me-1"></i>
                    Back to Cart
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\Users\Admin\clean\complete ecom before mass upload - Copy\resources\views/checkout/login-required.blade.php ENDPATH**/ ?>