@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- STAT CARDS --}}
<div class="row g-3 mb-5">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="stat-label">Total Pelanggan</div>
                <div class="stat-icon" style="background:#eff6ff;color:#2563eb">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
            <div class="stat-value">{{ number_format($totalPelanggan) }}</div>
            <div class="mt-2" style="font-size:12px;color:#64748b">
                <a href="{{ route('pelanggan.index') }}" style="color:#2563eb;text-decoration:none">Lihat semua →</a>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="stat-label">Karyawan Aktif</div>
                <div class="stat-icon" style="background:#f0fdfa;color:#0d9488">
                    <i class="bi bi-person-badge-fill"></i>
                </div>
            </div>
            <div class="stat-value">{{ number_format($totalKaryawan) }}</div>
            <div class="mt-2" style="font-size:12px;color:#64748b">
                <a href="{{ route('karyawan.index') }}" style="color:#0d9488;text-decoration:none">Lihat semua →</a>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="stat-label">Order Hari Ini</div>
                <div class="stat-icon" style="background:#fffbeb;color:#d97706">
                    <i class="bi bi-bag-check-fill"></i>
                </div>
            </div>
            <div class="stat-value">{{ number_format($totalOrderHariIni) }}</div>
            <div class="mt-2" style="font-size:12px;color:#64748b">
                <a href="{{ route('order.index') }}" style="color:#d97706;text-decoration:none">Lihat order →</a>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="stat-label">Pendapatan Bulan Ini</div>
                <div class="stat-icon" style="background:#f0fdf4;color:#16a34a">
                    <i class="bi bi-cash-stack"></i>
                </div>
            </div>
            <div class="stat-value" style="font-size:1.3rem">
                Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}
            </div>
            <div class="mt-2" style="font-size:12px;color:#64748b">
                <a href="{{ route('laporan.index') }}" style="color:#16a34a;text-decoration:none">Lihat laporan →</a>
            </div>
        </div>
    </div>
</div>

{{-- CONTENT GRID --}}
<div class="row g-4">

    {{-- ORDER TERBARU --}}
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history me-2" style="color:#2563eb"></i>Order Terbaru</span>
                <a href="{{ route('order.index') }}" class="btn btn-ghost btn-sm">Lihat semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Kode Order</th>
                            <th>Pelanggan</th>
                            <th>Layanan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orderTerbaru as $order)
                        <tr>
                            <td>
                                <a href="{{ route('order.show', $order) }}"
                                   style="color:#2563eb;text-decoration:none;font-weight:600;font-family:monospace;font-size:12.5px">
                                    {{ $order->kode_order }}
                                </a>
                            </td>
                            <td>{{ $order->pelanggan->nama }}</td>
                            <td style="color:#64748b">{{ $order->layanan->nama_layanan }}</td>
                            <td>
                                <span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5" style="color:#94a3b8">
                                <i class="bi bi-inbox" style="font-size:28px;display:block;margin-bottom:8px"></i>
                                Belum ada order
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- PERLU DIPROSES --}}
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>
                    <i class="bi bi-hourglass-split me-2" style="color:#d97706"></i>Perlu Diproses
                    @if($orderBelumSelesai->count() > 0)
                    <span class="badge ms-1" style="background:#fffbeb;color:#d97706;font-size:11px">
                        {{ $orderBelumSelesai->count() }}
                    </span>
                    @endif
                </span>
                <a href="{{ route('order.index') }}" class="btn btn-ghost btn-sm">Kelola</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Pelanggan</th>
                            <th>Est. Selesai</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orderBelumSelesai as $order)
                        <tr>
                            <td>
                                <div style="font-weight:500">{{ $order->pelanggan->nama }}</div>
                                <div style="font-size:11.5px;color:#94a3b8;font-family:monospace">{{ $order->kode_order }}</div>
                            </td>
                            <td>
                                @php $overdue = $order->tanggal_selesai->isPast(); @endphp
                                <span style="font-size:12.5px;{{ $overdue ? 'color:#dc2626;font-weight:600' : 'color:#64748b' }}">
                                    @if($overdue)<i class="bi bi-exclamation-circle me-1"></i>@endif
                                    {{ $order->tanggal_selesai->format('d M') }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-5" style="color:#94a3b8">
                                <i class="bi bi-check-circle" style="font-size:28px;display:block;margin-bottom:8px;color:#16a34a"></i>
                                Semua order selesai 🎉
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
