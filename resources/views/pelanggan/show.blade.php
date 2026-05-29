@extends('layouts.app')

@section('title', 'Detail Pelanggan')
@section('page-title', 'Detail Pelanggan')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-body text-center">
                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                    style="width:80px;height:80px;font-size:2rem;">
                    {{ strtoupper(substr($pelanggan->nama, 0, 1)) }}
                </div>
                <h5 class="fw-bold">{{ $pelanggan->nama }}</h5>
                <p class="text-muted mb-1"><i class="bi bi-phone me-1"></i>{{ $pelanggan->no_telp }}</p>
                @if($pelanggan->email)
                <p class="text-muted mb-1"><i class="bi bi-envelope me-1"></i>{{ $pelanggan->email }}</p>
                @endif
                @if($pelanggan->alamat)
                <p class="text-muted small"><i class="bi bi-geo-alt me-1"></i>{{ $pelanggan->alamat }}</p>
                @endif
            </div>
            <div class="card-footer bg-white text-center">
                <a href="{{ route('pelanggan.edit', $pelanggan) }}" class="btn btn-sm btn-warning me-2">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('pelanggan.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-bag-check me-2 text-primary"></i>Riwayat Order
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>Kode</th><th>Layanan</th><th>Total</th><th>Status</th><th>Bayar</th></tr>
                    </thead>
                    <tbody>
                        @forelse($pelanggan->orders as $order)
                        <tr>
                            <td><a href="{{ route('order.show', $order) }}" class="text-decoration-none">{{ $order->kode_order }}</a></td>
                            <td>{{ $order->layanan->nama_layanan }}</td>
                            <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                            <td><span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                            <td>
                                @if($order->pembayaran)
                                    <span class="badge bg-success">Lunas</span>
                                @else
                                    <span class="badge bg-danger">Belum</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-3">Belum ada order</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
