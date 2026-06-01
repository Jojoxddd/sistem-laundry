@extends('layouts.app')
@section('title', 'Edit Karyawan')
@section('page-title', 'Edit Karyawan')
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('karyawan.show', $karyawan) }}" class="btn btn-ghost btn-sm"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">Edit Karyawan</div>
            <div class="card-body">
                <form action="{{ route('karyawan.update', $karyawan) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama <span style="color:#dc2626">*</span></label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama', $karyawan->nama) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jabatan <span style="color:#dc2626">*</span></label>
                            <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $karyawan->jabatan) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No. Telepon <span style="color:#dc2626">*</span></label>
                            <input type="text" name="no_telp" class="form-control" value="{{ old('no_telp', $karyawan->no_telp) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Masuk <span style="color:#dc2626">*</span></label>
                            <input type="date" name="tanggal_masuk" class="form-control"
                                value="{{ old('tanggal_masuk', $karyawan->tanggal_masuk->format('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="aktif"    {{ old('status',$karyawan->status)==='aktif'    ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status',$karyawan->status)==='nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $karyawan->alamat) }}</textarea>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan</button>
                        <a href="{{ route('karyawan.show', $karyawan) }}" class="btn btn-ghost">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
