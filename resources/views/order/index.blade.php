@extends('layouts.app')
@section('title', 'Order')
@section('page-title', 'Order')

@section('content')
<div class="page-header">
    <div>
        <h1>Order</h1>
        <div class="sub">Total {{ $orders->total() }} order terdaftar</div>
    </div>
    <a href="{{ route('order.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Order Baru
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Kode Order</th>
                    <th>Pelanggan</th>
                    <th>Layanan</th>
                    <th>Berat</th>
                    <th>Total</th>
                    <th>Tgl Masuk</th>
                    <th>Est. Selesai</th>
                    <th>Status</th>
                    <th>Aksi</th>
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
                    <td style="color:#64748b">{{ $order->tanggal_masuk->format('d M Y') }}</td>
                    <td>
                        @php $over = $order->tanggal_selesai->isPast() && !in_array($order->status,['selesai','diambil']); @endphp
                        <span style="{{ $over ? 'color:#dc2626;font-weight:600' : 'color:#64748b' }}">
                            {{ $order->tanggal_selesai->format('d M Y') }}
                        </span>
                    </td>
                    <td><span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('order.show', $order) }}" class="btn btn-icon btn-ghost" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('order.edit', $order) }}" class="btn btn-icon btn-ghost" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @if(!$order->pembayaran)
                            <a href="{{ route('pembayaran.create', $order) }}" class="btn btn-icon btn-ghost" title="Bayar"
                               style="color:#16a34a">
                                <i class="bi bi-cash"></i>
                            </a>
                            @endif
                            <form action="{{ route('order.destroy', $order) }}" method="POST"
                                  onsubmit="return confirm('Hapus order {{ $order->kode_order }}?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-icon btn-ghost" style="color:#dc2626" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-5" style="color:#94a3b8">
                        <i class="bi bi-bag" style="font-size:32px;display:block;margin-bottom:8px"></i>
                        Belum ada order
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
    <div class="card-body pt-0 d-flex justify-content-end">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection
