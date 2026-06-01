@extends('layouts.app')
@section('title', 'Tambah Karyawan')
@section('page-title', 'Tambah Karyawan')
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('karyawan.index') }}" class="btn btn-ghost btn-sm"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">Tambah Karyawan</div>
            <div class="card-body">
                <form action="{{ route('karyawan.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama <span style="color:#dc2626">*</span></label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama') }}" required>
                            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jabatan <span style="color:#dc2626">*</span></label>
                            <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror"
                                value="{{ old('jabatan') }}" required placeholder="Contoh: Staf Laundry">
                            @error('jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No. Telepon <span style="color:#dc2626">*</span></label>
                            <input type="text" name="no_telp" class="form-control @error('no_telp') is-invalid @enderror"
                                value="{{ old('no_telp') }}" required>
                            @error('no_telp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Masuk <span style="color:#dc2626">*</span></label>
                            <input type="date" name="tanggal_masuk" class="form-control @error('tanggal_masuk') is-invalid @enderror"
                                value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required>
                            @error('tanggal_masuk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2">{{ old('alamat') }}</textarea>
                        </div>
                        <div class="col-12"><hr style="border-color:#f1f5f9;margin:4px 0"></div>
                        <div class="col-md-6">
                            <label class="form-label">Email Login <span style="color:#dc2626">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password <span style="color:#dc2626">*</span></label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan</button>
                        <a href="{{ route('karyawan.index') }}" class="btn btn-ghost">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
