@extends('layouts.app')

@section('content')
<div class="card shadow-sm mb-4">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Transaksi Penjualan Manual (Kasir Admin)</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('sales.store') }}" method="POST">
            @csrf

            <h6 class="fw-bold border-bottom pb-2 mt-3">Daftar Barang yang Dijual</h6>
            <!-- Area alert jika ada error dari controller (seperti stok kurang) -->
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-bordered" id="salesTable">
                <thead class="table-light">
                    <tr>
                        <th width="60%">Pilih Produk (Otomatis pakai Harga Jual sistem)</th>
                        <th width="25%">Qty (Jumlah)</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbody-sales-items">
                    <tr>
                        <td>
                            <select name="product_id[]" class="form-select" required>
                                <option value="">-- Pilih Produk --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product->name }} (Sisa Stok: {{ $product->stock }} | Harga: Rp {{ number_format($product->selling_price, 0, ',', '.') }})
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" name="quantity[]" class="form-control" min="1" required>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm btn-remove-row" disabled>X</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <button type="button" class="btn btn-secondary btn-sm mb-4" id="btn-add-row">+ Tambah Baris Barang</button>

            <div class="d-flex justify-content-between border-top pt-3">
                <a href="{{ route('sales.index') }}" class="btn btn-light border">Batal</a>
                <button type="submit" class="btn btn-success fw-bold">Proses & Kurangi Stok</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('btn-add-row').addEventListener('click', function() {
        var tbody = document.getElementById('tbody-sales-items');
        var firstRow = tbody.firstElementChild;
        var newRow = firstRow.cloneNode(true);
        
        var inputs = newRow.querySelectorAll('input');
        inputs.forEach(function(input) { input.value = ''; });
        
        var removeBtn = newRow.querySelector('.btn-remove-row');
        removeBtn.disabled = false;
        
        removeBtn.addEventListener('click', function() {
            newRow.remove();
        });
        
        tbody.appendChild(newRow);
    });
</script>
@endsection