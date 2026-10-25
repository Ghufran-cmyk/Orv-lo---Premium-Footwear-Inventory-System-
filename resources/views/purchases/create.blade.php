@extends('layouts.app')

@section('content')
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Transaksi Barang Masuk Baru</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('purchases.store') }}" method="POST">
            @csrf
            <div class="mb-4 w-50">
                <label class="form-label fw-bold">Pilih Supplier <span class="text-danger">*</span></label>
                <select name="supplier_id" class="form-select" required>
                    <option value="">-- Pilih Supplier --</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>

            <h6 class="fw-bold border-bottom pb-2">Daftar Barang yang Dibeli</h6>
            <table class="table table-bordered" id="transactionTable">
                <thead class="table-light">
                    <tr>
                        <th width="40%">Pilih Produk</th>
                        <th width="20%">Qty (Jumlah)</th>
                        <th width="30%">Harga Satuan (Rp)</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbody-items">
                    <!-- Baris pertama (default) -->
                    <tr>
                        <td>
                            <select name="product_id[]" class="form-select" required>
                                <option value="">-- Pilih Produk --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }} (Stok: {{ $product->stock }})</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" name="quantity[]" class="form-control" min="1" required>
                        </td>
                        <td>
                            <input type="number" name="unit_cost[]" class="form-control" min="0" required>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm btn-remove-row" disabled>X</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <button type="button" class="btn btn-success btn-sm mb-4" id="btn-add-row">+ Tambah Baris Barang</button>

            <div class="d-flex justify-content-between border-top pt-3">
                <a href="{{ route('purchases.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary fw-bold">Simpan & Proses Stok</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Script sederhana untuk menduplikasi baris barang
    document.getElementById('btn-add-row').addEventListener('click', function() {
        var tbody = document.getElementById('tbody-items');
        var firstRow = tbody.firstElementChild;
        var newRow = firstRow.cloneNode(true);
        
        // Kosongkan nilai input di baris baru
        var inputs = newRow.querySelectorAll('input');
        inputs.forEach(function(input) { input.value = ''; });
        
        // Aktifkan tombol hapus di baris baru
        var removeBtn = newRow.querySelector('.btn-remove-row');
        removeBtn.disabled = false;
        
        // Fungsi hapus baris
        removeBtn.addEventListener('click', function() {
            newRow.remove();
        });
        
        tbody.appendChild(newRow);
    });
</script>
@endsection