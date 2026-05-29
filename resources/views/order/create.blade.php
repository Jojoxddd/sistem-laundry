@extends('layouts.app')

@section('title', 'Tambah Order')
@section('page-title', 'Tambah Order Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-bag-plus me-2"></i>Form Order Baru
            </div>
            <div class="card-body">
                <form action="{{ route('order.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Pelanggan <span class="text-danger">*</span></label>
                            <select name="pelanggan_id" class="form-select @error('pelanggan_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Pelanggan --</option>
                                @foreach($pelanggan as $p)
                                <option value="{{ $p->id }}" {{ old('pelanggan_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama }} ({{ $p->no_telp }})
                                </option>
                                @endforeach
                            </select>
                            @error('pelanggan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Karyawan <span class="text-danger">*</span></label>
                            <select name="karyawan_id" class="form-select @error('karyawan_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Karyawan --</option>
                                @foreach($karyawan as $k)
                                <option value="{{ $k->id }}" {{ old('karyawan_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama }}
                                </option>
                                @endforeach
                            </select>
                            @error('karyawan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Layanan <span class="text-danger">*</span></label>
                            <select name="layanan_id" id="layanan_id" class="form-select @error('layanan_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Layanan --</option>
                                @foreach($layanan as $l)
                                <option value="{{ $l->id }}" data-harga="{{ $l->harga_per_kg }}" {{ old('layanan_id') == $l->id ? 'selected' : '' }}>
                                    {{ $l->nama_layanan }} - Rp {{ number_format($l->harga_per_kg, 0, ',', '.') }}/kg
                                </option>
                                @endforeach
                            </select>
                            @error('layanan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Berat (kg) <span class="text-danger">*</span></label>
                            <input type="number" name="berat_kg" id="berat_kg" step="0.1" min="0.1"
                                class="form-control @error('berat_kg') is-invalid @enderror"
                                value="{{ old('berat_kg') }}" required>
                            @error('berat_kg')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-12">
                            <div class="alert alert-info py-2">
                                <strong>Estimasi Total: </strong>
                                <span id="total_harga">Rp 0</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanggal Masuk <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_masuk" class="form-control @error('tanggal_masuk') is-invalid @enderror"
                                value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required>
                            @error('tanggal_masuk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanggal Selesai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                value="{{ old('tanggal_selesai') }}" required>
                            @error('tanggal_selesai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Catatan</label>
                            <textarea name="catatan" class="form-control" rows="2">{{ old('catatan') }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Order
                        </button>
                        <a href="{{ route('order.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function hitungTotal() {
    const layananSelect = document.getElementById('layanan_id');
    const beratInput    = document.getElementById('berat_kg');
    const totalEl       = document.getElementById('total_harga');
    const harga  = parseFloat(layananSelect.options[layananSelect.selectedIndex]?.dataset.harga || 0);
    const berat  = parseFloat(beratInput.value || 0);
    const total  = harga * berat;
    totalEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
}
document.getElementById('layanan_id').addEventListener('change', hitungTotal);
document.getElementById('berat_kg').addEventListener('input', hitungTotal);
</script>
@endpush
