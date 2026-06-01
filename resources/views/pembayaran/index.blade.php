@extends('layouts.app')
@section('title', 'Pembayaran')
@section('page-title', 'Pembayaran')

@section('content')
<div class="page-header">
    <div>
        <h1>Pembayaran</h1>
        <div class="sub">Riwayat semua transaksi pembayaran</div>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Kode Order</th>
                    <th>Pelanggan</th>
                    <th>Layanan</th>
                    <th>Jumlah Bayar</th>
                    <th>Kembalian</th>
                    <th>Metode</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pembayaran as $p)
                <tr>
                    <td>
                        <a href="{{ route('order.show', $p->order) }}"
                           style="font-family:monospace;font-size:12.5px;font-weight:600;color:#2563eb;text-decoration:none">
                            {{ $p->order->kode_order }}
                        </a>
                    </td>
                    <td style="font-weight:500">{{ $p->order->pelanggan->nama }}</td>
                    <td style="color:#64748b">{{ $p->order->layanan->nama_layanan }}</td>
                    <td style="font-weight:600">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                    <td style="color:#64748b">Rp {{ number_format($p->kembalian, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge" style="background:#f1f5f9;color:#475569">{{ ucfirst($p->metode) }}</span>
                    </td>
                    <td style="color:#64748b;font-size:13px">{{ $p->tanggal_bayar?->format('d M Y, H:i') ?? '—' }}</td>
                    <td><span class="badge badge-lunas">{{ ucfirst($p->status) }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5" style="color:#94a3b8">
                        <i class="bi bi-credit-card" style="font-size:32px;display:block;margin-bottom:8px"></i>
                        Belum ada data pembayaran
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($pembayaran->hasPages())
    <div class="card-body pt-0 d-flex justify-content-end">{{ $pembayaran->links() }}</div>
    @endif
</div>
@endsection
