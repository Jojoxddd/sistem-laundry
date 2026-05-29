@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-white" style="background: linear-gradient(135deg,#1a237e,#3949ab)">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-people-fill fs-1 opacity-75"></i>
                <div>
                    <div class="small opacity-75">Total Pelanggan</div>
                    <div class="fs-3 fw-bold">{{ $totalPelanggan }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white" style="background: linear-gradient(135deg,#00695c,#00897b)">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-person-badge-fill fs-1 opacity-75"></i>
                <div>
                    <div class="small opacity-75">Karyawan Aktif</div>
                    <div class="fs-3 fw-bold">{{ $totalKaryawan }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white" style="background: linear-gradient(135deg,#e65100,#fb8c00)">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-bag-check-fill fs-1 opacity-75"></i>
                <div>
                    <div class="small opacity-75">Order Hari Ini</div>
                    <div class="fs-3 fw-bold">{{ $totalOrderHariIni }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white" style="background: linear-gradient(135deg,#6a1b9a,#8e24aa)">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-cash-stack fs-1 opacity-75"></i>
                <div>
                    <div class="small opacity-75">Pendapatan Bulan Ini</div>
                    <div class="fs-4 fw-bold">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Order Terbaru -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-white fw-semibold border-0 pt-3">
                <i class="bi bi-clock-history text-primary me-2"></i>Order Terbaru
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Kode</th>
                                <th>Pelanggan</th>
                                <th>Layanan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orderTerbaru as $order)
                            <tr>
                                <td><a href="{{ route('order.show', $order) }}" class="text-decoration-none fw-semibold">{{ $order->kode_order }}</a></td>
                                <td>{{ $order->pelanggan->nama }}</td>
                                <td>{{ $order->layanan->nama_layanan }}</td>
                                <td>
                                    <span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">Belum ada order</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Belum Selesai -->
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-white fw-semibold border-0 pt-3">
                <i class="bi bi-hourglass-split text-warning me-2"></i>Perlu Diproses
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr><th>Pelanggan</th><th>Tgl Selesai</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            @forelse($orderBelumSelesai as $order)
                            <tr>
                                <td>{{ $order->pelanggan->nama }}</td>
                                <td>{{ $order->tanggal_selesai->format('d/m/Y') }}</td>
                                <td><span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted py-3">Semua order sudah selesai 🎉</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
