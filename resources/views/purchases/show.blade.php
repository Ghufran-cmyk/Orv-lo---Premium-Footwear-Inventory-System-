@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Detail Pembelian #{{ $purchase->purchase_number }}</h5>
        <a href="{{ route('purchases.index') }}" class="btn btn-sm btn-light">Kembali</a>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-sm-6">
                <h6 class="text-muted mb-1">Informasi Supplier:</h6>
                <p class="fw-bold mb-0">{{ $purchase->supplier->name }}</p>
                <p class="mb-0">{{ $purchase->supplier->phone ?? '-' }}</p>
                <p class="mb-0">{{ $purchase->supplier->email ?? '-' }}</p>
            </div>
            <div class="col-sm-6 text-sm-end">
                <h6 class="text-muted mb-1">Waktu Transaksi:</h6>
                <p class="fw-bold mb-0">{{ \Carbon\Carbon::parse($purchase->purchased_at)->format('d F Y, H:i') }}</p>
                <p class="text-muted mb-0">Petugas: {{ $purchase->user->name }}</p>
            </div>
        </div>

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th class="text-center">Qty</th>
                    <th class="text-end">Harga Satuan</th>
                    <th class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchase->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-end">Rp {{ number_format($item->unit_cost, 0, ',', '.') }}</td>
                    <td class="text-end fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-end">GRAND TOTAL</th>
                    <th class="text-end text-success fs-5">Rp {{ number_format($purchase->total, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection