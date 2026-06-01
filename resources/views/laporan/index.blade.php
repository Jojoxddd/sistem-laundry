@extends('layouts.app')
@section('title', 'Laporan')
@section('page-title', 'Laporan')

@section('content')

{{-- FILTER --}}
<div class="d-flex align-items-end gap-3 mb-5 flex-wrap">
    <form method="GET" class="d-flex gap-2 align-items-end flex-wrap">
        <div>
            <label class="form-label">Bulan</label>
            <select name="bulan" class="form-select" style="width:140px">
                @foreach(range(1,12) as $b)
                <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($b)->isoFormat('MMMM') }}
                </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="form-label">Tahun</label>
            <select name="tahun" class="form-select" style="width:100px">
                @foreach(range(date('Y')-2, date('Y')) as $t)
                <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-search me-1"></i>Tampilkan
        </button>
    </form>
    <div class="ms-auto" style="font-size:13px;color:#64748b">
        Periode: <strong>{{ \Carbon\Carbon::create()->month((int)$bulan)->isoFormat('MMMM') }} {{ $tahun }}</strong>
    </div>
</div>

{{-- SUMMARY STATS --}}
<div class="row g-3 mb-5">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="stat-label">Total Order</div>
                <div class="stat-icon" style="background:#eff6ff;color:#2563eb">
                    <i class="bi bi-bag"></i>
                </div>
            </div>
            <div class="stat-value">{{ $summary['total_order'] }}</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="stat-label">Menunggu / Diproses</div>
                <div class="stat-icon" style="background:#fffbeb;color:#d97706">
                    <i class="bi bi-hourglass-split"></i>
                </div>
            </div>
            <div class="stat-value">{{ $summary['order_menunggu'] + $summary['order_diproses'] }}</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="stat-label">Order Selesai</div>
                <div class="stat-icon" style="background:#f0fdf4;color:#16a34a">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
            <div class="stat-value">{{ $summary['order_selesai'] }}</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="stat-label">Total Pendapatan</div>
                <div class="stat-icon" style="background:#f0fdf4;color:#16a34a">
                    <i class="bi bi-cash-stack"></i>
                </div>
            </div>
            <div class="stat-value" style="font-size:1.2rem">
                Rp {{ number_format($summary['total_pendapatan'], 0, ',', '.') }}
            </div>
        </div>
    </div>
</div>

{{-- TABEL DETAIL --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>
            Detail order —
            <span style="font-weight:400;color:#64748b">
                {{ \Carbon\Carbon::create()->month((int)$b)->isoFormat('MMMM') }}
            </span>
        </span>
        <span style="font-size:12px;color:#94a3b8">{{ $orders->count() }} order ditemukan</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
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
                    <td>
                        <a href="{{ route('order.show', $order) }}"
                           style="font-family:monospace;font-size:12.5px;font-weight:600;color:#2563eb;text-decoration:none">
                            {{ $order->kode_order }}
                        </a>
                    </td>
                    <td style="font-weight:500">{{ $order->pelanggan->nama }}</td>
                    <td style="color:#64748b">{{ $order->layanan->nama_layanan }}</td>
                    <td>{{ $order->berat_kg }} kg</td>
                    <td style="font-weight:600">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    <td><span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                    <td>
                        @if($order->pembayaran)
                            <span class="badge badge-lunas">Lunas</span>
                        @else
                            <span class="badge" style="background:#fef2f2;color:#dc2626">Belum</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5" style="color:#94a3b8">
                        <i class="bi bi-calendar-x" style="font-size:32px;display:block;margin-bottom:8px"></i>
                        Tidak ada data untuk periode ini
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
