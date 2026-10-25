<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        // Menampilkan riwayat pembelian terbaru
        $purchases = Purchase::with(['supplier', 'user'])->orderBy('id', 'desc')->get();
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('purchases.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        // Validasi input array dari form dinamis
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id' => 'required|array|min:1',
            'product_id.*' => 'required|exists:products,id',
            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|integer|min:1',
            'unit_cost' => 'required|array|min:1',
            'unit_cost.*' => 'required|numeric|min:0',
        ]);

        // Memulai Database Transaction
        DB::beginTransaction();
        try {
            // 1. Buat Header Transaksi
            $purchase = Purchase::create([
                'purchase_number' => 'PO-' . strtoupper(uniqid()),
                'supplier_id' => $request->supplier_id,
                'user_id' => Auth::id(), // Admin/Staff yang login
                'purchased_at' => now(),
                'status' => 'completed',
                'total' => 0 // Akan dihitung di bawah
            ]);

            $grandTotal = 0;

            // 2. Looping setiap barang yang dibeli
            foreach ($request->product_id as $index => $productId) {
                $qty = $request->quantity[$index];
                $cost = $request->unit_cost[$index];
                $subtotal = $qty * $cost;
                $grandTotal += $subtotal;

                // Simpan ke tabel detail (purchase_items)
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $productId,
                    'quantity' => $qty,
                    'unit_cost' => $cost,
                    'subtotal' => $subtotal
                ]);

                // 3. Tambahkan Stok Produk secara realtime
                $product = Product::find($productId);
                $product->stock += $qty;
                $product->save();
            }

            // 4. Update grand total di tabel purchases
            $purchase->update(['total' => $grandTotal]);

            // Jika semua lancar, simpan permanen ke database
            DB::commit();
            return redirect()->route('purchases.index')->with('success', 'Transaksi barang masuk berhasil disimpan. Stok telah bertambah!');

        } catch (\Exception $e) {
            // Jika ada error di tengah jalan, batalkan semua perubahan stok & transaksi
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function show(Purchase $purchase)
    {
        // Menampilkan detail invoice
        $purchase->load(['items.product', 'supplier', 'user']);
        return view('purchases.show', compact('purchase'));
    }
}