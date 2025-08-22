<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Premium Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
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
            overflow-x: hidden;
        }

        /* Custom Navbar */
        .custom-navbar {
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1050;
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-link {
            color: #ffffff !important;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            color: #667eea !important;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background: var(--primary-gradient);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 100%;
        }

        /* Main Content */
        .main-content {
            margin-top: 76px;
            min-height: calc(100vh - 76px);
            padding: 60px 0;
        }

        /* Breadcrumb */
        .custom-breadcrumb {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 15px 25px;
            margin-bottom: 40px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .breadcrumb-item a {
            color: #667eea;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb-item a:hover {
            color: #8b94ff;
        }

        .breadcrumb-item.active {
            color: #ffffff;
        }

        /* Product Detail Card */
        .product-detail-card {
            background: var(--card-gradient);
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .product-detail-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--primary-gradient);
            opacity: 0.03;
            z-index: 1;
        }

        .product-content {
            position: relative;
            z-index: 2;
            padding: 40px;
        }

        /* Product Image */
        .product-image-container {
            height: 500px;
            background: linear-gradient(45deg, #2d2d2d, #404040);
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }

        .product-image-container::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--primary-gradient);
            opacity: 0.1;
            z-index: 1;
        }

        .product-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: relative;
            z-index: 2;
            transition: transform 0.4s ease;
        }

        .product-image-container:hover img {
            transform: scale(1.05);
        }

        .no-image-placeholder {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: #666;
            position: relative;
            z-index: 2;
        }

        /* Product Info */
        .product-title {
            font-size: 2.5rem;
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .product-description {
            font-size: 1.1rem;
            color: #b0b0b0;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .product-price {
            background: var(--secondary-gradient);
            color: white;
            padding: 15px 30px;
            border-radius: 50px;
            font-size: 2rem;
            font-weight: 700;
            display: inline-block;
            margin-bottom: 25px;
            box-shadow: 0 10px 30px rgba(240, 147, 251, 0.3);
            position: relative;
        }

        .product-price::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: var(--secondary-gradient);
            border-radius: 50px;
            z-index: -1;
            filter: blur(8px);
            opacity: 0.7;
        }

        /* Stock Badge */
        .stock-info {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .stock-badge {
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .stock-badge.in-stock {
            background: var(--success-gradient);
            color: white;
        }

        .stock-badge.low-stock {
            background: var(--warning-gradient);
            color: white;
        }

        .stock-badge.out-of-stock {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            color: white;
        }

        /* Add to Cart Form */
        .cart-form {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .quantity-selector {
            margin-bottom: 25px;
        }

        .quantity-selector label {
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 10px;
            display: block;
        }

        .quantity-input {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 15px;
            padding: 12px 20px;
            font-size: 1.1rem;
            width: 100px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .quantity-input:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #667eea;
            outline: none;
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.3);
        }

        .btn-add-cart {
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 15px 40px;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .btn-add-cart::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-add-cart:hover::before {
            left: 100%;
        }

        .btn-add-cart:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
        }

        .btn-add-cart:disabled {
            background: #666;
            cursor: not-allowed;
        }

        /* Features List */
        .features-section {
            margin-top: 40px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 20px;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .features-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: #ffffff;
        }

        .feature-item {
            display: flex;
            align-items: center;
            padding: 12px 0;
            color: #b0b0b0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .feature-item:last-child {
            border-bottom: none;
        }

        .feature-item i {
            color: #667eea;
            margin-right: 15px;
            font-size: 1.2rem;
        }

        /* Description Section */
        .description-section {
            margin-top: 60px;
            background: var(--card-gradient);
            border-radius: 25px;
            padding: 40px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .description-title {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 20px;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .description-text {
            font-size: 1.1rem;
            color: #b0b0b0;
            line-height: 1.8;
        }

        /* Out of Stock Alert */
        .out-of-stock-alert {
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(238, 90, 36, 0.1));
            border: 1px solid rgba(255, 107, 107, 0.3);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            color: #ff6b6b;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .product-title {
                font-size: 2rem;
            }
            
            .product-price {
                font-size: 1.5rem;
                padding: 12px 25px;
            }
            
            .product-content {
                padding: 20px;
            }
            
            .cart-form {
                padding: 20px;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .product-detail-card {
            animation: fadeInUp 0.6s ease forwards;
        }

        .description-section {
            animation: fadeInUp 0.8s ease forwards;
        }
    </style>
</head>
<body>
    <!-- Custom Navbar -->
    <nav class="navbar navbar-expand-lg custom-navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('products.index') }}">
                <i class="fas fa-gem me-2"></i>Premium Store
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#cart">
                            <i class="fas fa-shopping-cart me-1"></i>Cart
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#account">
                            <i class="fas fa-user me-1"></i>Account
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb custom-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('products.index') }}">
                            <i class="fas fa-home me-1"></i>Products
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $product->name }}
                    </li>
                </ol>
            </nav>

            <!-- Product Detail Card -->
            <div class="product-detail-card">
                <div class="product-content">
                    <div class="row g-5">
                        <!-- Product Image -->
                        <div class="col-lg-6">
                            <div class="product-image-container">
                                @if ($product->image_path)
                                    <img src="{{ asset('storage/products/' . $product->image_path) }}" 
                                         alt="{{ $product->name }}">
                                @else
                                    <div class="no-image-placeholder">
                                        <i class="fas fa-image fa-4x mb-3"></i>
                                        <p class="fs-5">No image available</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Product Details -->
                        <div class="col-lg-6">
                            <h1 class="product-title">{{ $product->name }}</h1>
                            
                            @if($product->description)
                                <p class="product-description">{{ $product->description }}</p>
                            @endif
                            
                            <!-- Price -->
                            <div class="product-price">
                                ${{ number_format((float) $product->price, 2) }}
                            </div>
                            
                            <!-- Stock Information -->
                            <div class="stock-info">
                                @if($product->stock > 10)
                                    <span class="stock-badge in-stock">
                                        <i class="fas fa-check-circle"></i>
                                        In Stock ({{ $product->stock }} available)
                                    </span>
                                @elseif($product->stock > 0)
                                    <span class="stock-badge low-stock">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Limited Stock ({{ $product->stock }} left)
                                    </span>
                                @else
                                    <span class="stock-badge out-of-stock">
                                        <i class="fas fa-times-circle"></i>
                                        Out of Stock
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Add to Cart Form -->
                            @if($product->stock > 0)
                                <div class="cart-form">
                                    <form method="POST" action="{{ route('cart.add', $product) }}">
                                        @csrf
                                        <div class="quantity-selector">
                                            <label for="quantity">Quantity:</label>
                                            <input type="number" 
                                                   id="quantity"
                                                   name="quantity" 
                                                   value="1" 
                                                   min="1" 
                                                   max="{{ $product->stock }}"
                                                   class="quantity-input">
                                        </div>
                                        <button type="submit" class="btn btn-add-cart">
                                            <i class="fas fa-shopping-cart me-2"></i>
                                            Add to Cart
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="out-of-stock-alert">
                                    <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                                    <h4>Out of Stock</h4>
                                    <p class="mb-0">This product is currently unavailable. Please check back later!</p>
                                </div>
                            @endif
                            
                            <!-- Features -->
                            <div class="features-section">
                                <h3 class="features-title">
                                    <i class="fas fa-star me-2"></i>Product Features
                                </h3>
                                <div class="feature-item">
                                    <i class="fas fa-shipping-fast"></i>
                                    <span>Free shipping on orders over $50</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-undo"></i>
                                    <span>30-day hassle-free returns</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>1-year manufacturer warranty</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-headset"></i>
                                    <span>24/7 customer support</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-lock"></i>
                                    <span>Secure payment processing</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Product Description Section -->
            @if($product->description)
                <div class="description-section">
                    <h2 class="description-title">
                        <i class="fas fa-info-circle me-3"></i>Detailed Description
                    </h2>
                    <div class="description-text">
                        <p>{{ $product->description }}</p>
                        <p>This premium product is carefully crafted to meet the highest standards of quality and performance. Whether you're looking for functionality, style, or durability, this product delivers on all fronts.</p>
                        <p>Key highlights include superior materials, innovative design, and exceptional value for money. Perfect for both professional and personal use, this product will exceed your expectations.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Smooth scrolling for navbar links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Quantity input validation
        const quantityInput = document.getElementById('quantity');
        if (quantityInput) {
            quantityInput.addEventListener('input', function() {
                const max = parseInt(this.getAttribute('max'));
                const min = parseInt(this.getAttribute('min'));
                let value = parseInt(this.value);
                
                if (value > max) this.value = max;
                if (value < min) this.value = min;
            });
        }

        // Add to cart button animation
        const addToCartBtn = document.querySelector('.btn-add-cart');
        if (addToCartBtn) {
            addToCartBtn.addEventListener('click', function() {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Adding...';
                this.disabled = true;
                
                // Re-enable after form submission (you can remove this in production)
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                }, 2000);
            });
        }

        // Navbar background change on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.custom-navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(0, 0, 0, 0.98)';
            } else {
                navbar.style.background = 'rgba(0, 0, 0, 0.95)';
            }
        });
    </script>
</body>
</html>