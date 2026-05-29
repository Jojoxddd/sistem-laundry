@extends('layouts.app')

@section('title', 'Detail Order')
@section('page-title', 'Detail Order')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center bg-white">
                <h6 class="mb-0 fw-bold">{{ $order->kode_order }}</h6>
                <span class="badge badge-{{ $order->status }} fs-6">{{ ucfirst($order->status) }}</span>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <small class="text-muted">Pelanggan</small>
                        <div class="fw-semibold">{{ $order->pelanggan->nama }}</div>
                        <div class="text-muted small">{{ $order->pelanggan->no_telp }}</div>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">Karyawan</small>
                        <div class="fw-semibold">{{ $order->karyawan->nama }}</div>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">Layanan</small>
                        <div class="fw-semibold">{{ $order->layanan->nama_layanan }}</div>
                        <div class="text-muted small">Rp {{ number_format($order->layanan->harga_per_kg, 0, ',', '.') }}/kg</div>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">Berat</small>
                        <div class="fw-semibold">{{ $order->berat_kg }} kg</div>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">Tanggal Masuk</small>
                        <div class="fw-semibold">{{ $order->tanggal_masuk->format('d F Y') }}</div>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">Tanggal Selesai</small>
                        <div class="fw-semibold">{{ $order->tanggal_selesai->format('d F Y') }}</div>
                    </div>
                    @if($order->catatan)
                    <div class="col-12">
                        <small class="text-muted">Catatan</small>
                        <div>{{ $order->catatan }}</div>
                    </div>
                    @endif
                    <div class="col-12">
                        <div class="alert alert-primary mb-0">
                            <strong>Total Harga: Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ubah Status -->
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Ubah Status Order</h6>
                <form action="{{ route('order.updateStatus', $order) }}" method="POST" class="d-flex gap-2">
                    @csrf @method('PATCH')
                    <select name="status" class="form-select">
                        @foreach(['menunggu','diproses','selesai','diambil'] as $s)
                        <option value="{{ $s }}" {{ $order->status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary text-nowrap">Update Status</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Pembayaran -->
        <div class="card">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-cash-coin me-2 text-success"></i>Pembayaran
            </div>
            <div class="card-body">
                @if($order->pembayaran)
                    <div class="mb-2">
                        <small class="text-muted">Status</small>
                        <div><span class="badge bg-success">Lunas</span></div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Jumlah Bayar</small>
                        <div class="fw-semibold">Rp {{ number_format($order->pembayaran->jumlah_bayar, 0, ',', '.') }}</div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Kembalian</small>
                        <div>Rp {{ number_format($order->pembayaran->kembalian, 0, ',', '.') }}</div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Metode</small>
                        <div>{{ ucfirst($order->pembayaran->metode) }}</div>
                    </div>
                    <div>
                        <small class="text-muted">Tanggal Bayar</small>
                        <div>{{ $order->pembayaran->tanggal_bayar->format('d/m/Y H:i') }}</div>
                    </div>
                @else
                    <p class="text-muted mb-3">Belum ada pembayaran</p>
                    <a href="{{ route('pembayaran.create', $order) }}" class="btn btn-success w-100">
                        <i class="bi bi-cash me-1"></i> Bayar Sekarang
                    </a>
                @endif
            </div>
        </div>

        <div class="d-flex gap-2 mt-3">
            <a href="{{ route('order.edit', $order) }}" class="btn btn-warning flex-fill">
                <i class="bi bi-pencil me-1"></i> Edit
            </a>
            <a href="{{ route('order.index') }}" class="btn btn-secondary flex-fill">Kembali</a>
        </div>
    </div>
</div>
@endsection
