@extends('layouts.app')

@section('title', 'Data Karyawan')
@section('page-title', 'Data Karyawan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <span class="text-muted">Total: <strong>{{ $karyawan->total() }}</strong> karyawan</span>
    <a href="{{ route('karyawan.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Karyawan
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>No. Telepon</th>
                    <th>Tgl Masuk</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($karyawan as $i => $k)
                <tr>
                    <td>{{ $karyawan->firstItem() + $i }}</td>
                    <td>
                        <strong>{{ $k->nama }}</strong>
                        <div class="text-muted small">{{ $k->user->email }}</div>
                    </td>
                    <td>{{ $k->jabatan }}</td>
                    <td>{{ $k->no_telp }}</td>
                    <td>{{ $k->tanggal_masuk->format('d/m/Y') }}</td>
                    <td>
                        @if($k->status == 'aktif')
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('karyawan.show', $k) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('karyawan.edit', $k) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('karyawan.destroy', $k) }}" method="POST" onsubmit="return confirm('Hapus karyawan ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Belum ada karyawan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($karyawan->hasPages())
    <div class="card-footer bg-white">{{ $karyawan->links() }}</div>
    @endif
</div>
@endsection
