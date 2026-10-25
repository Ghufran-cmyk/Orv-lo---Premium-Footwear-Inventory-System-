<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::orderBy('id', 'desc')->get();
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'admin') return redirect()->route('suppliers.index')->with('error', 'Hanya Admin yang dapat menambah data.');
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') return redirect()->route('suppliers.index')->with('error', 'Akses ditolak.');
        
        $request->validate([
            'name' => 'required|max:255',
            'phone' => 'nullable|max:20',
            'email' => 'nullable|email|max:255'
        ]);

        Supplier::create($request->all());
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function edit(Supplier $supplier)
    {
        if (Auth::user()->role !== 'admin') return redirect()->route('suppliers.index')->with('error', 'Hanya Admin yang dapat mengubah data.');
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        if (Auth::user()->role !== 'admin') return redirect()->route('suppliers.index')->with('error', 'Akses ditolak.');

        $request->validate([
            'name' => 'required|max:255',
            'phone' => 'nullable|max:20',
            'email' => 'nullable|email|max:255'
        ]);

        $supplier->update($request->all());
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy(Supplier $supplier)
    {
        if (Auth::user()->role !== 'admin') return redirect()->route('suppliers.index')->with('error', 'Akses ditolak.');

        // Proteksi: Jangan hapus jika supplier sudah pernah melakukan transaksi barang masuk
        if ($supplier->purchases()->count() > 0) {
            return redirect()->route('suppliers.index')->with('error', 'Gagal dihapus! Supplier ini memiliki riwayat transaksi barang masuk.');
        }

        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus.');
    }
}