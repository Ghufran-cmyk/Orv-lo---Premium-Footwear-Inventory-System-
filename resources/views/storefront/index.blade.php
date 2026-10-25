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
        :root {
            --orvelo-teal: #1a4242;
        }
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Styling Kategori */
        .category-card {
            background: #ffffff;
            border-radius: 1rem;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: 0.3s;
            cursor: pointer;
            text-decoration: none;
            color: var(--orvelo-teal);
            display: block;
        }
        .category-card:hover {
            transform: translateY(-5px);
            background: var(--orvelo-teal);
            color: #ffffff;
        }
        .category-icon {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        /* Styling Produk */
        .card-glass {
            border: none;
            border-radius: 1.5rem;
            transition: all 0.3s ease;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        }
        .card-glass:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(15, 41, 41, 0.1);
        }
        .product-img-box {
            background: #f8f9fa;
            text-align: center;
            border-radius: 1.5rem 1.5rem 0 0;
        }
        .btn-orvelo {
            background-color: var(--orvelo-teal);
            color: white;
            border-radius: 50px;
            font-weight: 600;
        }
        .btn-orvelo:hover {
            background-color: #0f2929;
            color: white;
        }

        /* Custom Pagination Orvélo */
        nav .text-muted.small {
            display: none !important; /* Menyembunyikan teks "Showing 1 to 8..." */
        }
        nav .justify-content-sm-between {
            justify-content: center !important; /* Memusatkan tombol angka */
        }
        .pagination {
            gap: 5px;
        }
        .pagination .page-link {
            color: var(--orvelo-teal);
            border: none;
            border-radius: 50%; /* Membuat tombol menjadi bulat */
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            font-weight: 600;
        }
        .pagination .page-link:hover {
            background-color: #f8f9fa;
            color: var(--orvelo-teal);
        }
        .pagination .page-item.active .page-link {
            background-color: var(--orvelo-teal);
            color: white;
            box-shadow: 0 4px 10px rgba(26, 66, 66, 0.2);
        }
        .pagination .page-item.disabled .page-link {
            background-color: transparent;
            color: #ccc;
            box-shadow: none;
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
                    <img src="{{ asset('images/logo-nama.png') }}" alt="Orvélo Logo" style="height: 30px; object-fit: contain; margin-left: -40px;">
                </a>
            </div>

            <!-- TENGAH: Pencarian -->
            <div class="d-flex justify-content-center" style="flex: 2;">
                <form action="{{ url('/') }}" method="GET" class="w-100" style="max-width: 550px; position: relative;">
                    <input type="text" name="search" class="form-control rounded-pill border-0 shadow-sm" placeholder="Cari sepatu (contoh: casual, sport)..." style="padding-left: 20px; padding-top: 10px; padding-bottom: 10px; padding-right: 45px; background-color: #f8f9fa;">
                    <button type="submit" class="btn position-absolute top-50 end-0 translate-middle-y border-0 text-muted" style="border-radius: 0 50rem 50rem 0; padding-right: 20px;">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>

            <!-- KANAN: Ikon Keranjang & Profil -->
            <div class="d-flex justify-content-end align-items-center" style="flex: 1; gap: 20px;">
                <a href="{{ route('cart.index') }}" class="text-white text-decoration-none fs-5">
                     <i class="bi bi-cart3"></i>
                </a>
                
                @auth
                    <!-- Jika SUDAH login: Tampilkan Dropdown -->
                    <div class="dropdown">
                        <a href="#" class="text-white text-decoration-none fs-5 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                            <i class="bi bi-person-circle"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3">
                            <li><a class="dropdown-item fw-bold" href="{{ route('dashboard') }}">Customer</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <!-- Jika BELUM login: Langsung ke halaman login -->
                    <a href="{{ route('login') }}" class="text-white text-decoration-none fs-5">
                        <i class="bi bi-person-circle"></i>
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- SPACER agar konten tidak tertutup navbar -->
    <div style="padding-top: 100px;"></div>

    <div class="container">
        <!-- SLIDER / CAROUSEL PROMOSI GAMBAR KUSTOM -->
        <div id="promoSlider" class="carousel slide mb-5 shadow-sm" data-bs-ride="carousel" style="border-radius: 1.5rem; overflow: hidden;">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#promoSlider" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#promoSlider" data-bs-slide-to="1"></button>
            </div>
            
            <div class="carousel-inner">
                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <img src="{{ asset('images/banner1.jpg') }}" class="d-block w-100" alt="Promo 1" style="height: 400px; object-fit: cover;">
                </div>
                
                <!-- Slide 2 -->
                <div class="carousel-item">
                    <img src="{{ asset('images/banner2.jpg') }}" class="d-block w-100" alt="Promo 2" style="height: 400px; object-fit: cover;">
                </div>
            </div>
            
            <button class="carousel-control-prev" type="button" data-bs-target="#promoSlider" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#promoSlider" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>

        <!-- KATEGORI PILL BUTTONS -->
        <div class="d-flex flex-wrap gap-2 mb-5 justify-content-center">
            <!-- Tombol Tampilkan Semua -->
            <a href="{{ url('/') }}" class="btn {{ !request('search') ? 'btn-dark' : 'btn-outline-secondary' }} rounded-pill px-4 fw-semibold shadow-sm">
                Tampilkan Semua
            </a>
            <!-- Tombol Kategori -->
            <a href="?search=sport" class="btn {{ request('search') == 'sport' ? 'btn-dark' : 'btn-outline-secondary' }} rounded-pill px-4 fw-semibold shadow-sm">
                Sport
            </a>
            <a href="?search=casual" class="btn {{ request('search') == 'casual' ? 'btn-dark' : 'btn-outline-secondary' }} rounded-pill px-4 fw-semibold shadow-sm">
                Casual
            </a>
            <a href="?search=formal" class="btn {{ request('search') == 'formal' ? 'btn-dark' : 'btn-outline-secondary' }} rounded-pill px-4 fw-semibold shadow-sm">
                Formal
            </a>
            <a href="?search=outdoor" class="btn {{ request('search') == 'outdoor' ? 'btn-dark' : 'btn-outline-secondary' }} rounded-pill px-4 fw-semibold shadow-sm">
                Outdoor
            </a>
        </div>

        <!-- KATALOG PRODUK DINAMIS -->
        <h3 class="fw-bold mb-4" style="color: var(--orvelo-teal);">Our Collections</h3>

        <div class="row g-4 mb-4">
            @forelse($products as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card card-glass h-100">
                        <!-- PEMANGGIL GAMBAR DINAMIS -->
                        <div class="product-img-box position-relative p-0" style="height: 200px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                            @if($product->image)
                                <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 1.5rem 1.5rem 0 0;">
                            @else
                                <span style="font-size: 4rem; filter: drop-shadow(0 10px 10px rgba(0,0,0,0.1));">👞</span>
                            @endif
                        </div>
                        
                        <div class="card-body p-4 text-center">
                            <h6 class="fw-bold mb-1 text-truncate" title="{{ $product->name }}">
                                {{ $product->name }}
                            </h6>
                            <div class="text-muted small mb-3">Stok: {{ $product->stock }}</div>
                            <h5 class="fw-bold mb-0" style="color: var(--orvelo-teal);">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</h5>
                        </div>
                        <div class="card-footer bg-transparent border-0 p-3 pt-0">
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <div class="d-flex gap-2 mb-2">
                                    <input type="number" name="quantity" class="form-control form-control-sm text-center rounded-pill" value="1" min="1" max="{{ $product->stock }}" required>
                                </div>
                                <button type="submit" class="btn btn-orvelo btn-sm w-100 fw-bold">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <h4 class="text-muted">Produk tidak ditemukan.</h4>
                </div>
            @endforelse
        </div>

        <!-- NAVIGASI PAGINATION -->
        <div class="mt-5 mb-5">
            {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>