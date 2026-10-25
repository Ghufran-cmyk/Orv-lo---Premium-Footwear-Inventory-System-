<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $products = Product::with('category')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('sku', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->get(); 

        return view('products.index', compact('products', 'search'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'admin') return redirect()->route('products.index')->with('error', 'Hanya Admin yang dapat menambah data.');
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') return redirect()->route('products.index')->with('error', 'Akses ditolak.');
        
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sku' => 'required|unique:products,sku|max:50',
            'name' => 'required|max:150',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        // SIMPAN LANGSUNG KE FOLDER PUBLIC (Bypass Symlink)
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/products'), $imageName); // Folder otomatis terbuat
            $data['image'] = $imageName;
        }

        Product::create($data);
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        if (Auth::user()->role !== 'admin') return redirect()->route('products.index')->with('error', 'Hanya Admin yang dapat mengubah data.');
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if (Auth::user()->role !== 'admin') return redirect()->route('products.index')->with('error', 'Akses ditolak.');

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sku' => 'required|max:50|unique:products,sku,' . $product->id,
            'name' => 'required|max:150',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        // SIMPAN LANGSUNG KE FOLDER PUBLIC (Bypass Symlink)
        if ($request->hasFile('image')) {
            // Hapus foto lama jika ada
            if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
                unlink(public_path('images/products/' . $product->image));
            }
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/products'), $imageName);
            $data['image'] = $imageName;
        }

        $product->update($data);
        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if (Auth::user()->role !== 'admin') return redirect()->route('products.index')->with('error', 'Akses ditolak.');
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}