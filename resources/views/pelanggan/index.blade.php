@extends('layouts.app')
@section('title', 'Pelanggan')
@section('page-title', 'Pelanggan')

@section('content')
<div class="page-header">
    <div>
        <h1>Pelanggan</h1>
        <div class="sub">Total {{ $pelanggan->total() }} pelanggan terdaftar</div>
    </div>
    <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Pelanggan
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>No. Telepon</th>
                    <th>Alamat</th>
                    <th>Notif WA</th>
                    <th>Total Order</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pelanggan as $i => $p)
                <tr>
                    <td style="color:#94a3b8">{{ $pelanggan->firstItem() + $i }}</td>
                    <td style="font-weight:500">{{ $p->nama }}</td>
                    <td style="font-family:monospace;font-size:13px">{{ $p->no_telp }}</td>
                    <td style="color:#64748b">{{ $p->alamat ?? '—' }}</td>
                    <td>
                        @if($p->notif_wa)
                            <span class="badge" style="background:#f0fdf4;color:#16a34a">
                                <i class="bi bi-whatsapp me-1"></i>Aktif
                            </span>
                        @else
                            <span style="color:#cbd5e1;font-size:13px">—</span>
                        @endif
                    </td>
                    <td>
                        <span style="font-weight:600;color:#2563eb">{{ $p->orders_count }}</span>
                        <span style="color:#94a3b8;font-size:12px"> order</span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('pelanggan.show', $p) }}" class="btn btn-icon btn-ghost"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('pelanggan.edit', $p) }}" class="btn btn-icon btn-ghost"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('pelanggan.destroy', $p) }}" method="POST"
                                  onsubmit="return confirm('Hapus {{ $p->nama }}?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-icon btn-ghost" style="color:#dc2626"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5" style="color:#94a3b8">
                        <i class="bi bi-people" style="font-size:32px;display:block;margin-bottom:8px"></i>
                        Belum ada pelanggan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($pelanggan->hasPages())
    <div class="card-body pt-0 d-flex justify-content-end">{{ $pelanggan->links() }}</div>
    @endif
</div>
@endsection
