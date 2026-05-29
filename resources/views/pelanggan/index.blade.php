@extends('layouts.app')

@section('title', 'Data Pelanggan')
@section('page-title', 'Data Pelanggan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <span class="text-muted">Total: <strong>{{ $pelanggan->total() }}</strong> pelanggan</span>
    <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Pelanggan
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>No. Telepon</th>
                    <th>Alamat</th>
                    <th>Total Order</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pelanggan as $i => $p)
                <tr>
                    <td>{{ $pelanggan->firstItem() + $i }}</td>
                    <td><strong>{{ $p->nama }}</strong></td>
                    <td>{{ $p->no_telp }}</td>
                    <td>{{ $p->alamat ?? '-' }}</td>
                    <td><span class="badge bg-primary">{{ $p->orders_count }} order</span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('pelanggan.show', $p) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('pelanggan.edit', $p) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('pelanggan.destroy', $p) }}" method="POST" onsubmit="return confirm('Hapus pelanggan ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada pelanggan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($pelanggan->hasPages())
    <div class="card-footer bg-white">{{ $pelanggan->links() }}</div>
    @endif
</div>
@endsection
