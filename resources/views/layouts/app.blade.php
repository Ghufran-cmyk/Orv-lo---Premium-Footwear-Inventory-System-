<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orvélo - Premium Footwear</title>
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --orvelo-teal: #0f2929;
            --orvelo-light: #1a4242;
            --orvelo-bg: #f4f7f6;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--orvelo-bg);
            color: #333;
            overflow-x: hidden;
        }

        /* --- FLOATING ADMIN SIDEBAR (CLEANMAC STYLE) --- */
        .admin-sidebar {
            width: 100px; /* Lebar sidebar */
            background-color: var(--orvelo-teal);
            position: fixed;
            top: 20px;
            bottom: 20px;
            left: 20px;
            border-radius: 28px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 5px 10px 30px rgba(15, 41, 41, 0.15);
            z-index: 1000;
        }

        .admin-main {
            margin-left: 140px; /* Menyesuaikan jarak sidebar + margin */
            padding: 20px 3rem 20px 1rem;
            min-height: 100vh;
            background-color: var(--orvelo-bg);
        }

        /* Logo Top */
        .sidebar-top {
            width: 100%;
            padding-top: 1.5rem;
            display: flex;
            justify-content: center;
        }
        .sidebar-logo {
            font-size: 1.8rem;
            font-weight: 800;
            color: #ffffff;
            text-decoration: none;
            letter-spacing: -1px;
        }

        /* Menu Icons Center Container */
        .sidebar-menu {
            flex-grow: 1;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center; 
            align-items: flex-end; 
            gap: 0.5rem;
        }

        /* Standard Icon Link */
        .sidebar-link {
            color: rgba(255, 255, 255, 0.4);
            text-decoration: none;
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 20px;
            margin-right: 20px; 
            transition: all 0.3s ease;
            position: relative;
        }
        
        .sidebar-link i {
            font-size: 1.4rem;
            transition: all 0.3s ease;
        }
        
        .sidebar-link:hover:not(.active) {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        /* --- EFEK CUTOUT/GOOEY MENU AKTIF (MAGIC CSS) --- */
        .sidebar-link.active {
            width: 80px; /* Memanjang sampai mentok kanan */
            margin-right: 0; /* Nempel ke ujung kanan sidebar */
            background-color: var(--orvelo-bg); /* Sama dengan warna body */
            color: var(--orvelo-teal);
            border-radius: 24px 0 0 24px; /* Melengkung di kiri saja */
        }
        
        .sidebar-link.active i {
            font-size: 1.6rem; /* Lebih besar saat aktif */
            font-weight: bold;
            transform: translateX(-10px); /* Geser dikit biar pas posisinya */
        }

        /* Lengkungan luar atas */
        .sidebar-link.active::before {
            content: "";
            position: absolute;
            right: 0;
            top: -24px;
            width: 24px;
            height: 24px;
            background-color: transparent;
            border-bottom-right-radius: 24px;
            box-shadow: 10px 10px 0 10px var(--orvelo-bg);
            pointer-events: none;
        }

        /* Lengkungan luar bawah */
        .sidebar-link.active::after {
            content: "";
            position: absolute;
            right: 0;
            bottom: -24px;
            width: 24px;
            height: 24px;
            background-color: transparent;
            border-top-right-radius: 24px;
            box-shadow: 10px -10px 0 10px var(--orvelo-bg);
            pointer-events: none;
        }

        /* Logout Bottom */
        .sidebar-bottom {
            width: 100%;
            padding-bottom: 1.5rem;
            display: flex;
            justify-content: center;
        }
        .btn-logout {
            width: 50px;
            height: 50px;
            border-radius: 16px;
            background-color: rgba(255, 107, 107, 0.1);
            color: #ff6b6b;
            border: none;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: 0.3s;
        }
        .btn-logout:hover {
            background-color: #ff6b6b;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
        }

        /* --- CUSTOMER NAVBAR --- */
        .navbar-custom { background-color: var(--orvelo-teal); padding: 1rem 0; }
        .navbar-brand-cust { font-weight: 800; font-size: 1.8rem; color: #ffffff !important; letter-spacing: -0.5px; }
        .search-form { width: 100%; max-width: 600px; }
        .search-input { border-radius: 50px 0 0 50px; padding-left: 1.5rem; border: none; }
        .search-btn { border-radius: 0 50px 50px 0; background-color: #ffffff; border: none; padding-right: 1.5rem; color: var(--orvelo-teal); }
        .nav-icon { color: #ffffff; font-size: 1.5rem; margin-left: 1.2rem; transition: 0.3s; text-decoration: none; }
        .nav-icon:hover { color: #f3c25b; }

        /* --- GLOBAL STYLE TABEL & TOMBOL --- */
        .admin-main .card { border: none; border-radius: 16px; box-shadow: 0 5px 15px rgba(0,0,0,0.03); overflow: hidden; }
        .table { margin-bottom: 0; vertical-align: middle; }
        .table thead th { background-color: var(--orvelo-teal) !important; color: #ffffff !important; font-weight: 600; border-bottom: none; padding: 1rem; letter-spacing: 0.5px; }
        .table tbody td { padding: 1rem; border-bottom: 1px solid #f0f0f0; color: #444; }
        .table tbody tr:hover td { background-color: #f8faf9; }
        
        .btn-primary { background-color: var(--orvelo-teal); border-color: var(--orvelo-teal); border-radius: 8px; font-weight: 600; padding: 0.5rem 1rem; transition: 0.3s; }
        .btn-primary:hover { background-color: var(--orvelo-light); border-color: var(--orvelo-light); transform: translateY(-2px); box-shadow: 0 4px 10px rgba(15, 41, 41, 0.15); }
        .btn-warning { background-color: #d4af37 !important; border-color: #d4af37 !important; color: white !important; border-radius: 6px; font-size: 0.85rem; font-weight: 600; }
        .btn-warning:hover { background-color: #bfa33b !important; }
        .btn-danger { background-color: #c95c5c !important; border-color: #c95c5c !important; border-radius: 6px; font-size: 0.85rem; font-weight: 600; }
        .btn-danger:hover { background-color: #b54949 !important; }
        .btn-info { background-color: #4b8b8b !important; border-color: #4b8b8b !important; color: white !important; border-radius: 6px; font-size: 0.85rem; font-weight: 600; }
        .btn-info:hover { background-color: #3d7373 !important; }
        .badge { padding: 0.5em 0.8em; border-radius: 6px; font-weight: 600; }
    </style>
</head>
<body>

@if(Auth::check() && in_array(Auth::user()->role, ['admin', 'staff']))
    
    <!-- TAMPILAN ADMIN -->
    <div class="admin-sidebar d-none d-lg-flex">
        
        <!-- Logo -->
        <div class="sidebar-top mb-4">
            <a href="{{ route('dashboard') }}" class="d-flex justify-content-center align-items-center text-decoration-none">
                <img src="{{ asset('images/logo-baru.png') }}" alt="Logo Orvélo" style="width: 55px; height: auto; object-fit: contain; filter: drop-shadow(0 2px 5px rgba(0,0,0,0.2)); transition: 0.3s;">
            </a>
        </div>
        
        <!-- Icons Menu (Perfectly Centered) -->
        <div class="sidebar-menu">
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" title="Dashboard">
                <i class="bi {{ request()->routeIs('dashboard') ? 'bi-columns-gap' : 'bi-columns-gap' }}"></i>
            </a>
            
            <a href="{{ route('categories.index') }}" class="sidebar-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" title="Kategori">
                <i class="bi {{ request()->routeIs('categories.*') ? 'bi-bookmarks-fill' : 'bi-bookmarks' }}"></i>
            </a>
            
            <a href="{{ route('products.index') }}" class="sidebar-link {{ request()->routeIs('products.*') ? 'active' : '' }}" title="Produk">
                <i class="bi {{ request()->routeIs('products.*') ? 'bi-box-seam-fill' : 'bi-box-seam' }}"></i>
            </a>
            
            <a href="{{ route('suppliers.index') }}" class="sidebar-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" title="Supplier">
                <i class="bi {{ request()->routeIs('suppliers.*') ? 'bi-buildings-fill' : 'bi-buildings' }}"></i>
            </a>
            
            <!-- Separator Line -->
            <div style="width: 30px; height: 2px; background-color: rgba(255,255,255,0.08); margin: 10px 20px 10px 0;"></div>
            
            <a href="{{ route('purchases.index') }}" class="sidebar-link {{ request()->routeIs('purchases.*') ? 'active' : '' }}" title="Barang Masuk">
                <i class="bi {{ request()->routeIs('purchases.*') ? 'bi-arrow-down-square-fill' : 'bi-arrow-down-square' }}"></i>
            </a>
            
            <a href="{{ route('sales.index') }}" class="sidebar-link {{ request()->routeIs('sales.*') ? 'active' : '' }}" title="Barang Keluar">
                <i class="bi {{ request()->routeIs('sales.*') ? 'bi-arrow-up-square-fill' : 'bi-arrow-up-square' }}"></i>
            </a>
        </div>

        <!-- Logout -->
        <div class="sidebar-bottom">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout" title="Keluar Sistem">
                    <i class="bi bi-box-arrow-left fs-5"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="admin-main">
        
        <!-- HEADER KANAN ATAS UNTUK PROFIL (PP) -->
        <div class="d-flex justify-content-end mb-4">
            <div class="bg-white d-flex align-items-center px-3 py-2 rounded-pill shadow-sm border" style="border-color: rgba(0,0,0,0.05) !important;">
                <div class="text-end me-3 d-none d-md-block">
                    
                    @if(Auth::user()->role === 'admin')
                        <!-- Tampilan Jika Login Sebagai ADMIN -->
                        <div class="fw-bold lh-1 mb-1" style="color: var(--orvelo-teal); font-size: 0.95rem;">Ghufran</div>
                        <div style="background-color: rgba(212, 175, 55, 0.12); color: #b08204; font-size: 0.7rem; font-weight: 800; padding: 0.25rem 0.6rem; border-radius: 8px; letter-spacing: 0.5px; display: inline-block;">
                            ADMIN ORVÉLO
                        </div>
                    @else
                        <!-- Tampilan Jika Login Sebagai STAFF -->
                        <div class="fw-bold lh-1 mb-1" style="color: var(--orvelo-teal); font-size: 0.95rem;">Rahmyn</div>
                        <div style="background-color: rgba(26, 66, 66, 0.12); color: var(--orvelo-teal); font-size: 0.7rem; font-weight: 800; padding: 0.25rem 0.6rem; border-radius: 8px; letter-spacing: 0.5px; display: inline-block;">
                            STAFF ORVÉLO
                        </div>
                    @endif

                </div>
                
                <!-- Foto Profil -->
                <div style="width: 42px; height: 42px; border-radius: 50%; overflow: hidden; border: 2px solid #f4f7f6;">
                    @if(Auth::user()->role === 'admin')
                        <!-- Foto Admin -->
                        <img src="{{ asset('images/foto-ghufran.jpg') }}" alt="Profile Ghufran" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <!-- Foto Staff -->
                        <img src="{{ asset('images/foto-rahmyn.jpg') }}" alt="Profile Rahmyn" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='{{ asset('images/logo-ov.png') }}'">
                    @endif
                </div>
            </div>
        </div>

        <!-- Notifikasi -->
        @if (session('success'))
            <div class="alert alert-success rounded-3 border-0 shadow-sm alert-dismissible fade show">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger rounded-3 border-0 shadow-sm alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Area Konten Utama Halaman -->
        @yield('content')
        
    </div>

@else

    <!-- TAMPILAN CUSTOMER (TIDAK DIUBAH) -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top shadow-sm">
        <div class="container-fluid px-md-5 d-flex justify-content-between align-items-center">
            <a class="navbar-brand-cust me-4" href="{{ route('home') }}">orvélo.</a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <form class="d-flex search-form mx-auto my-2 my-lg-0 d-none d-lg-flex" action="{{ route('home') }}" method="GET">
                    <input class="form-control search-input form-control-sm bg-light" type="search" name="search" placeholder="Cari sepatu (contoh: casual, sport)..." value="{{ request('search') }}">
                    <button class="btn search-btn" type="submit"><i class="bi bi-search"></i></button>
                </form>

                <div class="d-flex align-items-center ms-auto">
                    <a href="{{ route('cart.index') }}" class="nav-icon position-relative" title="Keranjang">
                        <i class="bi bi-cart3"></i>
                    </a>
                    @auth
                        <div class="dropdown ms-3">
                            <a href="#" class="nav-icon dropdown-toggle text-decoration-none" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-3">
                                <li>
                                    <div class="dropdown-header text-dark">
                                        <div class="fw-bold fs-6">{{ Auth::user()->name }}</div>
                                        <small class="text-muted">{{ ucfirst(Auth::user()->role) }}</small>
                                    </div>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger fw-bold"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="nav-icon text-decoration-none ms-3"><i class="bi bi-person-circle"></i></a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4 mb-5">
        @if (session('success'))
            <div class="alert alert-success rounded-3 border-0 shadow-sm alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger rounded-3 border-0 shadow-sm alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

@endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>