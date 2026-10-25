@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-bold">Manajemen Produk</h2>
    @if(Auth::user()->role === 'admin')
        <a href="{{ route('products.create') }}" class="btn btn-primary">+ Tambah Produk</a>
    @endif
</div>

<div class="card shadow-sm mb-3 border-0">
    <div class="card-body bg-light rounded">
        <form action="{{ route('products.index') }}" method="GET" class="d-flex w-50">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari SKU atau Nama Produk..." value="{{ $search ?? '' }}">
            <button type="submit" class="btn btn-dark">Cari</button>
            @if(isset($search))
                <a href="{{ route('products.index') }}" class="btn btn-outline-danger ms-2">Reset</a>
            @endif
        </form>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th>SKU</th>
                        <th width="10%">Foto</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $index => $product)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center"><span class="badge bg-secondary">{{ $product->sku }}</span></td>
                        
                        <td class="text-center">
                            @if($product->image)
                                <img src="{{ asset('images/products/' . $product->image) }}" alt="Foto Produk" class="rounded shadow-sm" style="width: 55px; height: 55px; object-fit: cover; border: 2px solid #eaf0ef;">
                            @else
                                <div class="rounded bg-light text-muted d-flex align-items-center justify-content-center mx-auto" style="width: 55px; height: 55px; font-size: 0.75rem; border: 1px dashed #ccc;">
                                    No Pic
                                </div>
                            @endif
                        </td>

                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? '-' }}</td>
                        <td class="text-end">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                        <td class="text-end">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                        <td class="text-center">
                            @if($product->stock <= $product->minimum_stock)
                                <span class="badge bg-danger">{{ $product->stock }} (Low)</span>
                            @else
                                <span class="badge bg-success">{{ $product->stock }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            @else
                                <span class="text-muted fst-italic">Hanya lihat</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">Produk tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection