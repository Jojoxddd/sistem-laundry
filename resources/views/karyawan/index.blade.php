@extends('layouts.app')
@section('title', 'Karyawan')
@section('page-title', 'Karyawan')

@section('content')
<div class="page-header">
    <div>
        <h1>Karyawan</h1>
        <div class="sub">Total {{ $karyawan->total() }} karyawan terdaftar</div>
    </div>
    <a href="{{ route('karyawan.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Karyawan
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
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
                    <td style="color:#94a3b8">{{ $karyawan->firstItem() + $i }}</td>
                    <td>
                        <div style="font-weight:500">{{ $k->nama }}</div>
                        @if(isset($k->user))
                        <div style="font-size:11.5px;color:#94a3b8">{{ $k->user->email }}</div>
                        @endif
                    </td>
                    <td style="color:#64748b">{{ $k->jabatan }}</td>
                    <td style="font-family:monospace;font-size:13px">{{ $k->no_telp }}</td>
                    <td style="color:#64748b">{{ $k->tanggal_masuk->format('d M Y') }}</td>
                    <td>
                        <span class="badge {{ $k->status === 'aktif' ? 'badge-aktif' : 'badge-nonaktif' }}">
                            {{ ucfirst($k->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('karyawan.show', $k) }}" class="btn btn-icon btn-ghost"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('karyawan.edit', $k) }}" class="btn btn-icon btn-ghost"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('karyawan.destroy', $k) }}" method="POST"
                                  onsubmit="return confirm('Hapus {{ $k->nama }}?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-icon btn-ghost" style="color:#dc2626"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5" style="color:#94a3b8">
                        <i class="bi bi-person-badge" style="font-size:32px;display:block;margin-bottom:8px"></i>
                        Belum ada karyawan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($karyawan->hasPages())
    <div class="card-body pt-0 d-flex justify-content-end">{{ $karyawan->links() }}</div>
    @endif
</div>
@endsection
