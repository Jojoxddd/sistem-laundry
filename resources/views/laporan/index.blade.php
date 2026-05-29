@extends('layouts.app')

@section('title', 'Laporan')
@section('page-title', 'Laporan Keuangan')

@section('content')
<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold">Bulan</label>
                <select name="bulan" class="form-select">
                    @foreach(range(1,12) as $b)
                    <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($b)->isoFormat('MMMM') }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Tahun</label>
                <select name="tahun" class="form-select">
                    @foreach(range(date('Y')-2, date('Y')) as $t)
                    <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search me-1"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Summary -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-center border-0 bg-primary bg-opacity-10">
            <div class="card-body">
                <div class="fs-2 fw-bold text-primary">{{ $summary['total_order'] }}</div>
                <div class="text-muted small">Total Order</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-0 bg-warning bg-opacity-10">
            <div class="card-body">
                <div class="fs-2 fw-bold text-warning">{{ $summary['order_menunggu'] }}</div>
                <div class="text-muted small">Menunggu</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-0 bg-success bg-opacity-10">
            <div class="card-body">
                <div class="fs-2 fw-bold text-success">{{ $summary['order_selesai'] }}</div>
                <div class="text-muted small">Selesai</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-0 bg-info bg-opacity-10">
            <div class="card-body">
                <div class="fw-bold text-info" style="font-size:1.1rem">
                    Rp {{ number_format($summary['total_pendapatan'], 0, ',', '.') }}
                </div>
                <div class="text-muted small">Total Pendapatan</div>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Detail -->
<div class="card">
    <div class="card-header bg-white fw-semibold">
        Detail Order Bulan {{ \Carbon\Carbon::create()->month($bulan)->isoFormat('MMMM') }} {{ $tahun }}
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode Order</th>
                        <th>Pelanggan</th>
                        <th>Layanan</th>
                        <th>Berat</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->kode_order }}</td>
                        <td>{{ $order->pelanggan->nama }}</td>
                        <td>{{ $order->layanan->nama_layanan }}</td>
                        <td>{{ $order->berat_kg }} kg</td>
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
                    <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada data untuk periode ini</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
