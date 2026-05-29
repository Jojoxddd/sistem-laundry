@extends('layouts.app')

@section('title', 'Detail Karyawan')
@section('page-title', 'Detail Karyawan')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-body text-center">
                <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                    style="width:80px;height:80px;font-size:2rem;">
                    {{ strtoupper(substr($karyawan->nama, 0, 1)) }}
                </div>
                <h5 class="fw-bold">{{ $karyawan->nama }}</h5>
                <p class="text-muted mb-1">{{ $karyawan->jabatan }}</p>
                <p class="text-muted mb-1"><i class="bi bi-phone me-1"></i>{{ $karyawan->no_telp }}</p>
                <p class="text-muted mb-1"><i class="bi bi-envelope me-1"></i>{{ $karyawan->user->email }}</p>
                @if($karyawan->alamat)
                <p class="text-muted small"><i class="bi bi-geo-alt me-1"></i>{{ $karyawan->alamat }}</p>
                @endif
                <span class="badge {{ $karyawan->status == 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                    {{ ucfirst($karyawan->status) }}
                </span>
            </div>
            <div class="card-footer bg-white text-center">
                <a href="{{ route('karyawan.edit', $karyawan) }}" class="btn btn-sm btn-warning me-2">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('karyawan.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-bag-check me-2 text-success"></i>Order yang Ditangani
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>Kode</th><th>Pelanggan</th><th>Layanan</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @forelse($karyawan->orders as $order)
                        <tr>
                            <td><a href="{{ route('order.show', $order) }}" class="text-decoration-none">{{ $order->kode_order }}</a></td>
                            <td>{{ $order->pelanggan->nama }}</td>
                            <td>{{ $order->layanan->nama_layanan }}</td>
                            <td><span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted py-3">Belum menangani order</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
