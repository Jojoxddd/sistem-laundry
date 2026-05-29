@extends('layouts.app')

@section('title', 'Data Pembayaran')
@section('page-title', 'Data Pembayaran')

@section('content')
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode Order</th>
                    <th>Pelanggan</th>
                    <th>Layanan</th>
                    <th>Jumlah Bayar</th>
                    <th>Kembalian</th>
                    <th>Metode</th>
                    <th>Tanggal Bayar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pembayaran as $p)
                <tr>
                    <td><a href="{{ route('order.show', $p->order) }}" class="text-decoration-none fw-semibold">{{ $p->order->kode_order }}</a></td>
                    <td>{{ $p->order->pelanggan->nama }}</td>
                    <td>{{ $p->order->layanan->nama_layanan }}</td>
                    <td>Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($p->kembalian, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($p->metode) }}</td>
                    <td>{{ $p->tanggal_bayar?->format('d/m/Y H:i') ?? '-' }}</td>
                    <td><span class="badge bg-success">{{ ucfirst($p->status) }}</span></td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">Belum ada data pembayaran</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($pembayaran->hasPages())
    <div class="card-footer bg-white">{{ $pembayaran->links() }}</div>
    @endif
</div>
@endsection
