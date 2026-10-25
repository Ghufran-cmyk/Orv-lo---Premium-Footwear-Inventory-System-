@extends('layouts.app')

@section('content')

<style>
    /* Kartu Statistik Asli Orvélo */
    .stat-card {
        background: linear-gradient(135deg, var(--orvelo-teal, #1a4242) 0%, #112d2d 100%);
        border: none;
        border-radius: 20px;
        padding: 2rem;
        color: white;
        box-shadow: 0 10px 30px rgba(15, 41, 41, 0.1);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: 0.3s;
        position: relative;
        overflow: hidden;
        height: 100%;
    }
    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(15, 41, 41, 0.2);
    }
    
    .stat-bg-icon {
        position: absolute;
        right: -10%;
        bottom: -20%;
        font-size: 8rem;
        color: rgba(255, 255, 255, 0.05);
        z-index: 0;
        transform: rotate(-15deg);
        pointer-events: none;
    }

    .stat-title {
        font-size: 1rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.7);
        z-index: 1;
    }
    .stat-value {
        font-size: 2.5rem;
        font-weight: 800;
        margin-top: 10px;
        z-index: 1;
    }
    
    .stat-card-warning {
        background: linear-gradient(135deg, #856404 0%, #d39e00 100%);
    }

    .page-title {
        font-weight: 800;
        color: var(--orvelo-teal, #1a4242);
        letter-spacing: -0.5px;
    }

    /* Banner Welcome Glassmorphism Hijau Elegan */
    .welcome-banner-glass {
        /* Warna hijau transparan agar efek blur/glass terlihat jelas */
        background: linear-gradient(135deg, rgba(26, 66, 66, 0.12) 0%, rgba(26, 66, 66, 0.03) 100%);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.6);
        box-shadow: 0 10px 30px rgba(15, 41, 41, 0.05);
        position: relative;
        overflow: hidden;
        min-height: 200px;
        display: flex;
        align-items: center;
    }
</style>

<!-- Header Top -->
<div class="d-flex justify-content-between align-items-center mb-4 mt-2">
    <h2 class="page-title mb-0">Dashboard</h2>
    <div class="bg-white px-4 py-2 rounded-pill shadow-sm fw-bold border text-muted">
        <i class="bi bi-calendar3 me-2"></i> {{ date('d F Y') }}
    </div>
</div>

<!-- Banner -->
<div class="welcome-banner-glass mb-4 position-relative overflow-hidden">
    <!-- Area Teks -->
    <div class="p-4 p-md-5 position-relative" style="z-index: 2; width: 65%;">
        <h3 class="fw-bold mb-2" style="color: var(--orvelo-teal, #1a4242); letter-spacing: -0.5px;">Halo, {{ ucfirst(Auth::user()->name ?? 'Admin') }}!</h3>
        <p class="mb-0 fs-6 text-muted">Selamat datang di area kerja. Berikut adalah ringkasan performa inventaris Orvélo hari ini.</p>
    </div>
    
    <!-- Gambar -->
    <img src="{{ asset('images/sepatu.png') }}" alt="Koleksi Orvélo" class="d-none d-md-block position-absolute" style="right: -65px; top: 50%; transform: translateY(-50%) rotate(-15deg) scale(1.25); height: 180%; width: auto; z-index: 1; mix-blend-mode: multiply; opacity: 0.9; pointer-events: none;">
</div>

<!-- Grid Kartu Statistik -->
<div class="row g-4">
    
    <div class="col-12 col-md-6 col-lg-3">
        <div class="stat-card">
            <i class="bi bi-box-seam-fill stat-bg-icon"></i>
            <div class="stat-title">Total Produk Aktif</div>
            <div class="stat-value">{{ $totalProduk ?? 0 }}</div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
        <div class="stat-card">
            <i class="bi bi-receipt stat-bg-icon"></i>
            <div class="stat-title">Total Transaksi</div>
            <div class="stat-value">{{ $totalTransaksi ?? 0 }}</div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
        <div class="stat-card">
            <i class="bi bi-cash-stack stat-bg-icon"></i>
            <div class="stat-title">Penjualan Hari Ini</div>
            <div class="stat-value fs-3 mt-3">Rp {{ number_format($penjualanHariIni ?? 0, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
        <div class="stat-card stat-card-warning">
            <i class="bi bi-exclamation-triangle-fill stat-bg-icon"></i>
            <div class="stat-title text-white">Produk Stok Rendah</div>
            <div class="stat-value">{{ $stokRendah ?? 0 }}</div>
        </div>
    </div>

</div>

@endsection