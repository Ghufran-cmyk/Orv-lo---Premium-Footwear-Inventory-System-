<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung total produk
        $totalProduk = Product::count();
        
        // Menghitung produk dengan stok di bawah atau sama dengan batas minimum
        $stokRendah = Product::whereColumn('stock', '<=', 'minimum_stock')->count();
        
        // Menghitung total pendapatan penjualan hari ini
        $penjualanHariIni = Sale::whereDate('sold_at', Carbon::today())
                          ->where('status', 'completed')
                          ->sum('total');
                          
        // Menghitung jumlah transaksi penjualan keseluruhan
        $totalTransaksi = Sale::count();

        // Mengirimkan variabel dengan nama yang sesuai dengan index.blade.php
        return view('dashboard.index', compact(
            'totalProduk', 
            'stokRendah', 
            'penjualanHariIni', 
            'totalTransaksi'
        ));
    }
}