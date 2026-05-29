@extends('layouts.app')

@section('title', 'Daftar Order')
@section('page-title', 'Manajemen Order')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <span class="text-muted">Total: <strong>{{ $orders->total() }}</strong> order</span>
    </div>
    <a href="{{ route('order.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Order Baru
    </a>
</div>

<div class="card">
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
                        <th>Tgl Masuk</th>
                        <th>Tgl Selesai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td><strong>{{ $order->kode_order }}</strong></td>
                        <td>{{ $order->pelanggan->nama }}</td>
                        <td>{{ $order->layanan->nama_layanan }}</td>
                        <td>{{ $order->berat_kg }} kg</td>
                        <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        <td>{{ $order->tanggal_masuk->format('d/m/Y') }}</td>
                        <td>{{ $order->tanggal_selesai->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('order.show', $order) }}" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('order.edit', $order) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if(!$order->pembayaran)
                                <a href="{{ route('pembayaran.create', $order) }}" class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-cash"></i>
                                </a>
                                @endif
                                <form action="{{ route('order.destroy', $order) }}" method="POST" onsubmit="return confirm('Hapus order ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="text-center text-muted py-4">Belum ada order</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($orders->hasPages())
    <div class="card-footer bg-white">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
