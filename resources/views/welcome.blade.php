<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Orvélo - Premium Footwear</title>

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #f8f9fa; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        /* Efek Hover Kartu Produk */
        .product-card {
            transition: all 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
        }
        /* Penyesuaian Banner Slider */
        .hero-banner {
            background-color: #1a4242; /* Hijau Orvélo */
            min-height: 320px;
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>

    <!-- NAVBAR GLASSMORPHISM -->
    <nav class="navbar navbar-expand-md fixed-top shadow-sm" style="background-color: rgba(26, 66, 66, 0.85); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255,255,255,0.1); z-index: 1030;">
        <div class="container d-flex justify-content-between align-items-center py-2">

            <!-- KIRI: Logo -->
            <div class="d-flex align-items-center" style="flex: 1;">
                <a class="navbar-brand text-decoration-none" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo-nama.png') }}" alt="Orvélo Logo" style="height: 30px; object-fit: contain;">
                </a>
            </div>

            <!-- TENGAH: Pencarian Presisi Center -->
            <div class="d-flex justify-content-center" style="flex: 2;">
                <form action="#" method="GET" class="w-100" style="max-width: 550px; position: relative;">
                    <input type="text" name="search" class="form-control rounded-pill border-0 shadow-sm" placeholder="Cari sepatu (contoh: casual, sport)..." style="padding-left: 20px; padding-top: 10px; padding-bottom: 10px; padding-right: 45px;">
                    <button type="submit" class="btn position-absolute top-50 end-0 translate-middle-y border-0 text-muted" style="border-radius: 0 50rem 50rem 0; padding-right: 20px;">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>

            <!-- KANAN: Ikon Keranjang & Profil -->
            <div class="d-flex justify-content-end align-items-center" style="flex: 1; gap: 20px;">
                <a href="#" class="text-white text-decoration-none fs-5">
                    <i class="bi bi-cart3"></i>
                </a>
                
                <div class="dropdown">
                    <a href="#" class="text-white text-decoration-none fs-5 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                        <i class="bi bi-person-circle"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3">
                        @auth
                            <li><a class="dropdown-item fw-bold" href="{{ route('dashboard') }}">Dashboard Admin</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        @else
                            <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                        @endauth
                    </ul>
                </div>
            </div>

        </div>
    </nav>

    <!-- SPACER -->
    <div style="padding-top: 100px;"></div>

    <!-- MAIN CONTENT -->
    <div class="container mb-5">
        
        <!-- SLIDER / BANNER (Persis seperti desain Anda) -->
        <div id="heroCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            </div>
            <div class="carousel-inner rounded-4 shadow-sm hero-banner">
                <!-- Slide 1 -->
                <div class="carousel-item active w-100 text-center text-white p-5">
                    <h1 class="fw-bold display-5 mb-3">New Casual Collection</h1>
                    <p class="fs-5 opacity-75">Tampil gaya setiap hari dengan langkah nyaman.</p>
                </div>
                <!-- Slide 2 -->
                <div class="carousel-item w-100 text-center text-white p-5">
                    <h1 class="fw-bold display-5 mb-3">Premium Formal Wear</h1>
                    <p class="fs-5