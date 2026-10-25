<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SaleController extends Controller
{
    public function index()
    {
        // Menampilkan riwayat penjualan
        $sales = Sale::with('user')->orderBy('id', 'desc')->get();
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        // Hanya kirim produk yang stoknya lebih dari 0
        $products = Product::where('stock', '>', 0)->get();
        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|array|min:1',
            'product_id.*' => 'required|exists:products,id',
            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            // 1. Buat Header Penjualan (Nomor Invoice sudah ditambahkan di sini)
            $sale = Sale::create([
                'sale_number' => 'INV-' . strtoupper(uniqid()),
                'user_id' => Auth::id(), // Kasir yang bertugas
                'total' => 0,
                'status' => 'completed',
                'sold_at' => Carbon::now(),
            ]);

            $grandTotal = 0;

            // 2. Looping item yang dijual
            foreach ($request->product_id as $index => $productId) {
                $qty = $request->quantity[$index];
                $product = Product::find($productId);

                // VALIDASI STOK: Jangan biarkan stok minus!
                if ($product->stock < $qty) {
                    throw new \Exception("Gagal! Stok '{$product->name}' tidak cukup. Sisa stok: {$product->stock}");
                }

                $price = $product->selling_price; // Ambil harga jual dari master data produk
                $subtotal = $qty * $price;
                $grandTotal += $subtotal;

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $productId,
                    'quantity' => $qty,
                    'unit_price' => $price, // <--- UBAH DI SINI (dari 'price' menjadi 'unit_price')
                    'subtotal' => $subtotal
                ]);

                // Kurangi stok produk
                $product->stock -= $qty;
                $product->save();
            }

            // 3. Update total akhir
            $sale->update(['total' => $grandTotal]);

            DB::commit();
            return redirect()->route('sales.index')->with('success', 'Transaksi Penjualan berhasil! Stok telah dikurangi.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Sale $sale)
    {
        $sale->load(['items.product', 'user']);
        return view('sales.show', compact('sale'));
    }
}   