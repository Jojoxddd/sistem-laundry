@extends('layouts.app')
@section('title', 'Detail Karyawan')
@section('page-title', 'Detail Karyawan')
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('karyawan.index') }}" class="btn btn-ghost btn-sm"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-body text-center py-5">
                <div style="width:64px;height:64px;border-radius:50%;background:#f0fdfa;color:#0d9488;
                    display:flex;align-items:center;justify-content:center;font-size:24px;font-weight:700;margin:0 auto 14px">
                    {{ strtoupper(substr($karyawan->nama,0,1)) }}
                </div>
                <div style="font-size:1.1rem;font-weight:700">{{ $karyawan->nama }}</div>
                <div style="font-size:13px;color:#64748b">{{ $karyawan->jabatan }}</div>
                <span class="badge mt-2 {{ $karyawan->status==='aktif' ? 'badge-aktif' : 'badge-nonaktif' }}">
                    {{ ucfirst($karyawan->status) }}
                </span>
            </div>
            <div style="border-top:1px solid #f1f5f9">
                @foreach([
                    ['label'=>'No. Telepon','value'=>$karyawan->no_telp],
                    ['label'=>'Tgl Masuk',  'value'=>$karyawan->tanggal_masuk->format('d M Y')],
                    ['label'=>'Alamat',     'value'=>$karyawan->alamat??'—'],
                ] as $row)
                <div class="d-flex justify-content-between px-4 py-3" style="border-bottom:1px solid #f8fafc">
                    <span style="font-size:12.5px;color:#94a3b8">{{ $row['label'] }}</span>
                    <span style="font-size:13.5px;font-weight:500">{{ $row['value'] }}</span>
                </div>
                @endforeach
            </div>
            <div class="card-body">
                <div class="d-flex gap-2">
                    <a href="{{ route('karyawan.edit', $karyawan) }}" class="btn btn-ghost flex-fill btn-sm">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                    <form action="{{ route('karyawan.destroy', $karyawan) }}" method="POST"
                          onsubmit="return confirm('Hapus {{ $karyawan->nama }}?')" class="flex-fill">
                        @csrf @method('DELETE')
                        <button class="btn btn-ghost w-100 btn-sm" style="color:#dc2626">
                            <i class="bi bi-trash me-1"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
