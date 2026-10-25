<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    // Menampilkan daftar kategori (Admin & Staff bisa akses)
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('categories.index', compact('categories'));
    }

    // Menampilkan form tambah (Hanya Admin)
    public function create()
    {
        if (Auth::user()->role !== 'admin') return redirect()->route('categories.index')->with('error', 'Hanya Admin yang dapat menambah data.');
        return view('categories.create');
    }

    // Menyimpan data baru (Hanya Admin)
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') return redirect()->route('categories.index')->with('error', 'Akses ditolak.');
        
        $request->validate([
            'name' => 'required|unique:categories,name|max:255'
        ]);

        Category::create($request->all());
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    // Menampilkan form edit (Hanya Admin)
    public function edit(Category $category)
    {
        if (Auth::user()->role !== 'admin') return redirect()->route('categories.index')->with('error', 'Hanya Admin yang dapat mengubah data.');
        return view('categories.edit', compact('category'));
    }

    // Menyimpan perubahan data (Hanya Admin)
    public function update(Request $request, Category $category)
    {
        if (Auth::user()->role !== 'admin') return redirect()->route('categories.index')->with('error', 'Akses ditolak.');

        $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $category->id
        ]);

        $category->update($request->all());
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    // Menghapus data (Hanya Admin)
    public function destroy(Category $category)
    {
        try {
            // Pengecekan dari sisi Eloquent
            if ($category->products()->count() > 0) {
                return redirect()->route('categories.index')->with('error', 'Gagal dihapus! Kategori ini sedang digunakan oleh produk.');
            }

            $category->delete();
            return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');

        } catch (\Illuminate\Database\QueryException $e) {
            // Menangkap error dari sisi Database MySQL jika masih ada relasi yang terlewat
            return redirect()->route('categories.index')->with('error', 'Gagal dihapus! Kategori ini masih terikat secara paksa dengan data lain di database.');
        }
    }
}