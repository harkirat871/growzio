<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Premium Store</title>
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
            transition: all 0.3s ease;
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

        /* Hero Carousel */
        .hero-carousel {
            margin-top: 76px;
            height: 500px;
            overflow: hidden;
        }

     /* Carousel image handling */
.hero-carousel {
  margin-top: 76px;
  min-height: 420px; /* falls back for small screens */
}

.carousel-item {
  position: relative;
  overflow: hidden;
  min-height: 420px;
}

.carousel-img {
  width: 100%;
  height: 500px;           /* desktop */
  object-fit: cover;       /* keeps image nicely cropped */
  display: block;
  transition: transform .6s ease;
}

.carousel-item:hover .carousel-img { transform: scale(1.03); }

/* keep your dark overlay + caption readable */
.carousel-item::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(0deg, rgba(0,0,0,0.45), rgba(0,0,0,0.15));
  z-index: 1;
}

.carousel-content {
  position: relative;
  z-index: 2;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  padding: 2rem;
  color: #fff;
}

.carousel-caption .carousel-title { font-size: 3rem; font-weight:700; }
.carousel-caption .carousel-subtitle { font-size: 1.1rem; opacity: .9; max-width:640px; margin: 0 auto; }

/* responsive */
@media (max-width: 768px) {
  .carousel-img { height: 320px; }
  .carousel-caption .carousel-title { font-size: 2rem; }
}


        /* Products Section */
        .products-section {
            padding: 80px 0;
            background: linear-gradient(180deg, #0c0c0c 0%, #1a1a1a 100%);
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 3rem;
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
        }

        .section-subtitle {
            color: #a0a0a0;
            font-size: 1.2rem;
        }

        /* Product Cards */
        .product-card {
            background: var(--card-gradient);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s ease;
            border: 1px solid rgba(255, 255, 255, 0.05);
            position: relative;
            height: 100%;
        }

        .product-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--primary-gradient);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1;
            border-radius: 20px;
        }

        .product-card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
        }

        .product-card:hover::before {
            opacity: 0.1;
        }

        .product-image {
            height: 250px;
            background: linear-gradient(45deg, #2d2d2d, #404040);
            position: relative;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.1);
        }

        .product-body {
            padding: 25px;
            position: relative;
            z-index: 2;
        }

        .product-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 15px;
            line-height: 1.4;
        }

        .product-price {
            background: var(--secondary-gradient);
            color: white;
            padding: 8px 16px;
            border-radius: 25px;
            font-weight: 700;
            font-size: 1.1rem;
            display: inline-block;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(240, 147, 251, 0.3);
        }

        .product-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-view {
            background: transparent;
            border: 2px solid #667eea;
            color: #667eea;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            flex: 1;
        }

        .btn-view:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        .btn-cart {
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            flex: 2;
        }

        .btn-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        /* No Products */
        .no-products {
            text-align: center;
            padding: 100px 0;
        }

        .no-products i {
            font-size: 4rem;
            color: #667eea;
            margin-bottom: 30px;
        }

        .no-products h3 {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        /* Pagination */
        .custom-pagination {
            justify-content: center;
            margin-top: 60px;
        }

        .page-link {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff;
            margin: 0 5px;
            border-radius: 10px;
            padding: 12px 18px;
            transition: all 0.3s ease;
        }

        .page-link:hover {
            background: var(--primary-gradient);
            border-color: transparent;
            color: white;
            transform: translateY(-2px);
        }

        .page-item.active .page-link {
            background: var(--primary-gradient);
            border-color: transparent;
        }

        /* Animations */
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

        .product-card {
            animation: fadeInUp 0.6s ease forwards;
        }

        .product-card:nth-child(2) { animation-delay: 0.1s; }
        .product-card:nth-child(3) { animation-delay: 0.2s; }
        .product-card:nth-child(4) { animation-delay: 0.3s; }

        /* Responsive */
        @media (max-width: 768px) {
            .carousel-title {
                font-size: 2.5rem;
            }
            
            .section-title h2 {
                font-size: 2rem;
            }
            
            .product-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Custom Navbar -->
<nav class="navbar navbar-expand-lg custom-navbar">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="fas fa-gem me-2"></i>Kirat's Store
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
                    <a class="nav-link active" href="#products">Products</a>
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
                    <a class="nav-link" href="{{ route('cart.view') }}">
                        <i class="fas fa-shopping-cart me-1"></i>Cart
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user me-1"></i> Become a Seller
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                {{ __('Profile') }}
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>


    <!-- Hero Carousel -->
    <div id="heroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>
        
        <!-- hero carousel (replace existing block) -->
<div id="heroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
  </div>

  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="{{ asset('storage/carousel/slide1.jpg') }}" class="d-block w-100 carousel-img" alt="Premium products">
      <div class="carousel-content carousel-caption d-md-block">
        <h1 class="carousel-title">Premium Products</h1>
        <p class="carousel-subtitle">Discover our curated collection of high-quality products designed for the modern lifestyle</p>
      </div>
    </div>

    <div class="carousel-item">
      <img src="{{ asset('storage/carousel/slide2.jpg') }}" class="d-block w-100 carousel-img" alt="Latest technology">
      <div class="carousel-content carousel-caption d-md-block">
        <h1 class="carousel-title">Latest Technology</h1>
        <p class="carousel-subtitle">Experience cutting-edge innovation with our state-of-the-art devices</p>
      </div>
    </div>

    <div class="carousel-item">
      <img src="{{ asset('storage/carousel/slide3.jpg') }}" class="d-block w-100 carousel-img" alt="Unbeatable quality">
      <div class="carousel-content carousel-caption d-md-block">
        <h1 class="carousel-title">Unbeatable Quality</h1>
        <p class="carousel-subtitle">Premium materials and craftsmanship in every product we offer</p>
      </div>
    </div>
  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

        
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- Products Section -->
    <section class="products-section" id="products">
        <div class="container">
            <div class="section-title">
                <h2>Our Products</h2>
                <p class="section-subtitle">Explore our premium collection</p>
            </div>

            @if ($products->count())
                <div class="row g-4">
                    @foreach ($products as $product)
                        <div class="col-lg-4 col-md-6">
                            <div class="product-card">
                                <div class="product-image">
                                    @if ($product->image_path)
                                        <img src="{{ asset('storage/product/headphone')}}" alt="{{ $product->name }}">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="product-body">
                                    <h5 class="product-title">{{ $product->name }}</h5>
                                    <div class="product-price">
                                        ₹{{ number_format((float) $product->price, 2) }}
                                    </div>
                                    
                                    <div class="product-buttons">
                                        <a href="{{ route('products.show', $product) }}" class="btn btn-view">
                                            <i class="fas fa-eye me-2"></i>View
                                        </a>
                                        
                                        <form method="POST" action="{{ route('cart.add', $product) }}" class="flex-fill">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-cart w-100">
                                                <i class="fas fa-cart-plus me-2"></i>Add to Cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($products->hasPages())
                    <nav aria-label="Products pagination">
                        <ul class="pagination custom-pagination">
                            {{ $products->links() }}
                        </ul>
                    </nav>
                @endif
                
            @else
                <div class="no-products">
                    <i class="fas fa-box-open"></i>
                    <h3>No Products Available</h3>
                    <p class="text-muted">We're working on adding amazing products. Check back soon!</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>