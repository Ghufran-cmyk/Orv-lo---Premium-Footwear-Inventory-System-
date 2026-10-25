@extends('layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 fw-bold">Invoice Penjualan #TRX-{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</h5>
        <a href="{{ route('sales.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
    </div>
    <div class="card-body p-4">
        <div class="row mb-4">
            <div class="col-sm-6">
                <h6 class="text-muted mb-1">Diterbitkan Oleh:</h6>
                <p class="fw-bold mb-0">Sistem Inventaris & Penjualan</p>
                <p class="mb-0">Kasir: {{ $sale->user->name }}</p>
            </div>
            <div class="col-sm-6 text-sm-end">
                <h6 class="text-muted mb-1">Detail Transaksi:</h6>
                <p class="mb-0">Tanggal: <span class="fw-bold">{{ \Carbon\Carbon::parse($sale->sold_at)->format('d M Y, H:i') }}</span></p>
                <p class="mb-0">Status: <span class="badge bg-success text-uppercase">{{ $sale->status }}</span></p>
            </div>
        </div>

        <table class="table table-bordered mb-4">
            <thead class="table-light text-center">
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Produk</th>
                    <th width="10%">Qty</th>
                    <th width="20%">Harga Satuan</th>
                    <th width="20%">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->items as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="text-end fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="table-light">
                    <th colspan="4" class="text-end fs-6">TOTAL BAYAR:</th>
                    <th class="text-end text-success fs-5 fw-bold">Rp {{ number_format($sale->total, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
        
        <div class="text-center mt-5">
            <button onclick="window.print()" class="btn btn-outline-primary">🖨️ Cetak Struk</button>
        </div>
    </div>
</div>
@endsection