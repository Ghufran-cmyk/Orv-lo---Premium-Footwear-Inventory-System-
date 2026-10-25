@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-bold">Barang Masuk (Pembelian)</h2>
    <a href="{{ route('purchases.create') }}" class="btn btn-primary">+ Transaksi Baru</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead class="table-dark text-center">
                <tr>
                    <th>No. Transaksi</th>
                    <th>Tanggal</th>
                    <th>Supplier</th>
                    <th>Total Biaya</th>
                    <th>Kasir/Admin</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($purchases as $purchase)
                <tr>
                    <td class="text-center fw-bold">{{ $purchase->purchase_number }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($purchase->purchased_at)->format('d M Y, H:i') }}</td>
                    <td>{{ $purchase->supplier->name }}</td>
                    <td class="text-end">Rp {{ number_format($purchase->total, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $purchase->user->name }}</td>
                    <td class="text-center">
                        <a href="{{ route('purchases.show', $purchase->id) }}" class="btn btn-sm btn-info text-white">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada transaksi barang masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection