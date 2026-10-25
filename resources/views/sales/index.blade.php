@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 mt-2">
    <h2 class="fw-bold" style="color: var(--orvelo-teal); letter-spacing: -0.5px;">Barang Keluar (Penjualan)</h2>
    <a href="{{ route('sales.create') }}" class="btn btn-primary shadow-sm">
        + Transaksi Baru
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID Transaksi</th>
                    <th>Tanggal</th>
                    <th>Total Belanja</th>
                    <th>Kasir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                <tr>
                    <td class="text-center fw-bold">TRX-{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($sale->sold_at)->format('d M Y, H:i') }}</td>
                    <td class="text-end">Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $sale->user->name }}</td>
                    <td class="text-center">
                        <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-info text-white">Struk / Invoice</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada transaksi barang keluar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection