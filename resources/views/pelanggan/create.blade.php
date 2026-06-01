@extends('layouts.app')
@section('title', 'Tambah Pelanggan')
@section('page-title', 'Tambah Pelanggan')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('pelanggan.index') }}" class="btn btn-ghost btn-sm"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">Tambah Pelanggan</div>
            <div class="card-body">
                <form action="{{ route('pelanggan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span style="color:#dc2626">*</span></label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama') }}" required placeholder="Masukkan nama lengkap">
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No. Telepon / WhatsApp <span style="color:#dc2626">*</span></label>
                        <input type="text" name="no_telp" class="form-control @error('no_telp') is-invalid @enderror"
                            value="{{ old('no_telp') }}" required placeholder="08xxxxxxxxxx">
                        @error('no_telp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Alamat <span style="color:#94a3b8;font-weight:400">(opsional)</span></label>
                        <textarea name="alamat" class="form-control" rows="2"
                            placeholder="Alamat lengkap pelanggan">{{ old('alamat') }}</textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan</button>
                        <a href="{{ route('pelanggan.index') }}" class="btn btn-ghost">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
