@extends('layouts.app')
@section('title', 'Order Baru')
@section('page-title', 'Order Baru')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('order.index') }}" class="btn btn-ghost btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">Informasi Order</div>
            <div class="card-body">
                <form action="{{ route('order.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Pelanggan <span style="color:#dc2626">*</span></label>
                            <select name="pelanggan_id" class="form-select @error('pelanggan_id') is-invalid @enderror" required>
                                <option value="">— Pilih pelanggan —</option>
                                @foreach($pelanggan as $p)
                                <option value="{{ $p->id }}" {{ old('pelanggan_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama }} · {{ $p->no_telp }}
                                </option>
                                @endforeach
                            </select>
                            @error('pelanggan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Karyawan <span style="color:#dc2626">*</span></label>
                            <select name="karyawan_id" class="form-select @error('karyawan_id') is-invalid @enderror" required>
                                <option value="">— Pilih karyawan —</option>
                                @foreach($karyawan as $k)
                                <option value="{{ $k->id }}" {{ old('karyawan_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama }}
                                </option>
                                @endforeach
                            </select>
                            @error('karyawan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Layanan <span style="color:#dc2626">*</span></label>
                            <select name="layanan_id" id="layanan_id"
                                class="form-select @error('layanan_id') is-invalid @enderror" required>
                                <option value="">— Pilih layanan —</option>
                                @foreach($layanan as $l)
                                <option value="{{ $l->id }}" data-harga="{{ $l->harga_per_kg }}"
                                    {{ old('layanan_id') == $l->id ? 'selected' : '' }}>
                                    {{ $l->nama_layanan }} — Rp {{ number_format($l->harga_per_kg,0,',','.') }}/kg
                                </option>
                                @endforeach
                            </select>
                            @error('layanan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Berat (kg) <span style="color:#dc2626">*</span></label>
                            <input type="number" name="berat_kg" id="berat_kg" step="0.1" min="0.1"
                                class="form-control @error('berat_kg') is-invalid @enderror"
                                value="{{ old('berat_kg') }}" required placeholder="Contoh: 3.5">
                            @error('berat_kg')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- ESTIMASI TOTAL --}}
                        <div class="col-12">
                            <div id="estimasi-box" style="display:none;background:#eff6ff;border-radius:10px;padding:14px 16px">
                                <div style="font-size:12px;color:#64748b;margin-bottom:2px">Estimasi total</div>
                                <div style="font-size:1.3rem;font-weight:700;color:#2563eb" id="total_harga">Rp 0</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Masuk <span style="color:#dc2626">*</span></label>
                            <input type="date" name="tanggal_masuk"
                                class="form-control @error('tanggal_masuk') is-invalid @enderror"
                                value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required>
                            @error('tanggal_masuk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Est. Tanggal Selesai <span style="color:#dc2626">*</span></label>
                            <input type="date" name="tanggal_selesai"
                                class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                value="{{ old('tanggal_selesai') }}" required>
                            @error('tanggal_selesai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Catatan <span style="color:#94a3b8;font-weight:400">(opsional)</span></label>
                            <textarea name="catatan" class="form-control" rows="2"
                                placeholder="Catatan khusus untuk order ini">{{ old('catatan') }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>Simpan Order
                        </button>
                        <a href="{{ route('order.index') }}" class="btn btn-ghost">Batal</a>
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
    const sel   = document.getElementById('layanan_id');
    const berat = parseFloat(document.getElementById('berat_kg').value) || 0;
    const harga = parseFloat(sel.options[sel.selectedIndex]?.dataset.harga || 0);
    const total = harga * berat;
    const box   = document.getElementById('estimasi-box');
    if (total > 0) {
        document.getElementById('total_harga').textContent = 'Rp ' + total.toLocaleString('id-ID');
        box.style.display = 'block';
    } else {
        box.style.display = 'none';
    }
}
document.getElementById('layanan_id').addEventListener('change', hitungTotal);
document.getElementById('berat_kg').addEventListener('input', hitungTotal);
</script>
@endpush
