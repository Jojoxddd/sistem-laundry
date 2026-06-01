@extends('layouts.app')
@section('title', 'Detail Pelanggan')
@section('page-title', 'Detail Pelanggan')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('pelanggan.index') }}" class="btn btn-ghost btn-sm"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center py-4">
                <div style="width:60px;height:60px;border-radius:50%;background:#eff6ff;color:#2563eb;
                    display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:700;margin:0 auto 12px">
                    {{ strtoupper(substr($pelanggan->nama,0,1)) }}
                </div>
                <div style="font-size:1.1rem;font-weight:700">{{ $pelanggan->nama }}</div>
                <div style="font-size:13px;color:#64748b;font-family:monospace">{{ $pelanggan->no_telp }}</div>
                @if($pelanggan->notif_wa)
                <span class="badge mt-2" style="background:#f0fdf4;color:#16a34a">
                    <i class="bi bi-whatsapp me-1"></i>Notif WA aktif
                </span>
                @endif
                @if($pelanggan->alamat)
                <div style="font-size:13px;color:#94a3b8;margin-top:8px">{{ $pelanggan->alamat }}</div>
                @endif
                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('pelanggan.edit', $pelanggan) }}" class="btn btn-ghost btn-sm flex-fill">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">Riwayat Order</div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead><tr><th>Kode</th><th>Layanan</th><th>Total</th><th>Tgl Masuk</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse($pelanggan->orders()->with('layanan')->latest()->get() as $order)
                        <tr>
                            <td>
                                <a href="{{ route('order.show', $order) }}"
                                   style="font-family:monospace;font-size:12.5px;font-weight:600;color:#2563eb;text-decoration:none">
                                    {{ $order->kode_order }}
                                </a>
                            </td>
                            <td style="color:#64748b">{{ $order->layanan->nama_layanan }}</td>
                            <td style="font-weight:600">Rp {{ number_format($order->total_harga,0,',','.') }}</td>
                            <td style="color:#64748b">{{ $order->tanggal_masuk->format('d M Y') }}</td>
                            <td><span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-4" style="color:#94a3b8">Belum ada order</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
