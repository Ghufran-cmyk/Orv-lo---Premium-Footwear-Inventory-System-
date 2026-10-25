<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keranjang - Orvélo</title>

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
                <form action="#" method="GET" class="w-100" style="max-width: 550px; position: relative;">
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
                    <a href="{{ route('login') }}" class="text-white text-decoration-none fs-5">
                        <i class="bi bi-person-circle"></i>
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- SPACER -->
    <div style="padding-top: 100px;"></div>

    <!-- KONTEN KERANJANG -->
    <div class="container mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold" style="color: var(--orvelo-teal);">
                <i class="bi bi-cart3 me-2"></i>Keranjang Belanja
            </h3>
            <a href="{{ url('/') }}" class="btn btn-outline-secondary rounded-pill px-4">Belanja Lagi</a>
        </div>

        <!-- NOTIFIKASI SUKSES / ERROR -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <!-- TABEL KERANJANG (KIRI) -->
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead style="background-color: var(--orvelo-teal); color: white;">
                                    <tr>
                                        <th class="ps-4 py-3 border-0 rounded-start-4">Produk</th>
                                        <th class="py-3 border-0">Harga</th>
                                        <th class="text-center py-3 border-0">Qty</th>
                                        <th class="py-3 border-0">Subtotal</th>
                                        <!-- KOLOM AKSI -->
                                        <th class="pe-4 py-3 text-center border-0 rounded-end-4">Aksi</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @php $total = 0; @endphp
                                    
                                    <!-- LOOPING DARI DATABASE KERANJANG -->
                                    @if($carts->isNotEmpty())
                                        @foreach($carts as $cart)
                                            @php $total += $cart->product->selling_price * $cart->quantity; @endphp
                                            <tr>
                                                <td class="ps-4 py-4 fw-semibold text-secondary">{{ $cart->product->name }}</td>
                                                <td class="py-4">Rp {{ number_format($cart->product->selling_price, 0, ',', '.') }}</td>
                                                <td class="text-center py-4">{{ $cart->quantity }}</td>
                                                <td class="py-4 fw-bold">Rp {{ number_format($cart->product->selling_price * $cart->quantity, 0, ',', '.') }}</td>
                                                
                                                <!-- TOMBOL HAPUS -->
                                                <td class="pe-4 py-4 text-center">
                                                    <form action="{{ route('cart.remove', $cart->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" onclick="return confirm('Hapus produk ini dari keranjang?');">
                                                            <i class="bi bi-trash3-fill"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                Keranjang belanja Anda masih kosong.<br>
                                                <a href="{{ url('/') }}" class="btn btn-sm btn-dark mt-3 rounded-pill">Mulai Belanja</a>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RINGKASAN BELANJA (KANAN) -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4 border-bottom pb-3">Ringkasan Belanja</h5>
                        
                        <div class="d-flex justify-content-between mb-4">
                            <span class="text-muted">Total Harga:</span>
                            <span class="fw-bold fs-5" style="color: #28a745;">Rp {{ number_format($total ?? 0, 0, ',', '.') }}</span>
                        </div>
                        
                        <!-- TOMBOL CHECKOUT (Dibungkus Form agar berfungsi) -->
                        <form action="{{ route('checkout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn w-100 rounded-pill text-white fw-bold py-2 shadow-sm" style="background-color: var(--orvelo-teal);" @if($carts->isEmpty()) disabled @endif>
                                Checkout Sekarang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>