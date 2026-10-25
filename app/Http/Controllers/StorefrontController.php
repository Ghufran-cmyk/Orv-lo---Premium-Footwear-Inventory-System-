<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StorefrontController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('stock', '>', 0);

        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
            
            $query->where(function($q) use ($keyword) {
                // Mencari dari nama produk
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhereHas('category', function($q2) use ($keyword) {
                      $q2->where('name', 'like', "%{$keyword}%");
                  });
            });
        }

        $products = $query->orderBy('id', 'desc')->paginate(8);
        return view('storefront.index', compact('products'));
    }

    public function addToCart(Request $request, Product $product)
    {
        $qtyToAdd = $request->quantity ?? 1;

        if ($product->stock < $qtyToAdd) {
            return back()->with('error', 'Maaf, stok tidak mencukupi.');
        }

        $cart = Cart::where('user_id', Auth::id())->where('product_id', $product->id)->first();

        if ($cart) {
            if ($product->stock < ($cart->quantity + $qtyToAdd)) {
                return back()->with('error', 'Stok tidak cukup untuk tambahan qty ini.');
            }
            $cart->update(['quantity' => $cart->quantity + $qtyToAdd]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $qtyToAdd
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function cart()
    {
        $carts = Cart::with('product')->where('user_id', Auth::id())->get();
        return view('storefront.cart', compact('carts'));
    }

    public function checkout()
    {
        $carts = Cart::with('product')->where('user_id', Auth::id())->get();

        if ($carts->isEmpty()) {
            return back()->with('error', 'Keranjang belanja Anda kosong.');
        }

        DB::beginTransaction();
        try {
            $sale = Sale::create([
                'sale_number' => 'ORD-' . strtoupper(uniqid()),
                'user_id' => Auth::id(),
                'total' => 0,
                'status' => 'completed',
                'sold_at' => Carbon::now(),
            ]);

            $grandTotal = 0;

            foreach ($carts as $cart) {
                $product = $cart->product;
                $qty = $cart->quantity;

                if ($product->stock < $qty) {
                    throw new \Exception("Maaf, stok '{$product->name}' habis saat Anda membayar.");
                }

                // Perbaikan format perhitungan subtotal
                $subtotal = $qty * $product->selling_price;
                $grandTotal += $subtotal;

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'unit_price' => $product->selling_price,
                    'subtotal' => $subtotal
                ]);

                $product->stock -= $qty;
                $product->save();
            }

            $sale->update(['total' => $grandTotal]);
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();
            return redirect()->route('home')->with('success', 'Checkout berhasil! Terima kasih telah berbelanja.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    // Fungsi baru untuk menghapus barang dari keranjang
    public function removeFromCart($id)
    {
        $cartItem = Cart::where('user_id', Auth::id())->where('id', $id)->first();
        
        if ($cartItem) {
            $cartItem->delete();
            return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
        }

        return back()->with('error', 'Produk tidak ditemukan di keranjang.');
    }
}