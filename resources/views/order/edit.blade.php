@extends('layouts.app')
@section('title', 'Edit Order')
@section('page-title', 'Edit Order')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('order.show', $order) }}" class="btn btn-ghost btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
    <span style="font-family:monospace;font-size:14px;font-weight:600;color:#64748b">
        {{ $order->kode_order }}
    </span>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">Edit Order</div>
            <div class="card-body">
                <form action="{{ route('order.update', $order) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Pelanggan <span style="color:#dc2626">*</span></label>
                            <select name="pelanggan_id" class="form-select" required>
                                @foreach($pelanggan as $p)
                                <option value="{{ $p->id }}"
                                    {{ (old('pelanggan_id', $order->pelanggan_id) == $p->id) ? 'selected' : '' }}>
                                    {{ $p->nama }} · {{ $p->no_telp }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Karyawan <span style="color:#dc2626">*</span></label>
                            <select name="karyawan_id" class="form-select" required>
                                @foreach($karyawan as $k)
                                <option value="{{ $k->id }}"
                                    {{ (old('karyawan_id', $order->karyawan_id) == $k->id) ? 'selected' : '' }}>
                                    {{ $k->nama }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Layanan <span style="color:#dc2626">*</span></label>
                            <select name="layanan_id" id="layanan_id" class="form-select" required>
                                @foreach($layanan as $l)
                                <option value="{{ $l->id }}" data-harga="{{ $l->harga_per_kg }}"
                                    {{ (old('layanan_id', $order->layanan_id) == $l->id) ? 'selected' : '' }}>
                                    {{ $l->nama_layanan }} — Rp {{ number_format($l->harga_per_kg,0,',','.') }}/kg
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Berat (kg) <span style="color:#dc2626">*</span></label>
                            <input type="number" name="berat_kg" id="berat_kg" step="0.1" min="0.1"
                                class="form-control" value="{{ old('berat_kg', $order->berat_kg) }}" required>
                        </div>
                        <div class="col-12">
                            <div id="estimasi-box" style="background:#eff6ff;border-radius:10px;padding:14px 16px">
                                <div style="font-size:12px;color:#64748b;margin-bottom:2px">Estimasi total</div>
                                <div style="font-size:1.3rem;font-weight:700;color:#2563eb" id="total_harga">
                                    Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Masuk <span style="color:#dc2626">*</span></label>
                            <input type="date" name="tanggal_masuk" class="form-control"
                                value="{{ old('tanggal_masuk', $order->tanggal_masuk->format('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Est. Tanggal Selesai <span style="color:#dc2626">*</span></label>
                            <input type="date" name="tanggal_selesai" class="form-control"
                                value="{{ old('tanggal_selesai', $order->tanggal_selesai->format('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                @foreach(['menunggu'=>'Menunggu','diproses'=>'Diproses','selesai'=>'Selesai','diambil'=>'Diambil'] as $val=>$label)
                                <option value="{{ $val }}" {{ old('status', $order->status) == $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Catatan</label>
                            <textarea name="catatan" class="form-control" rows="2">{{ old('catatan', $order->catatan) }}</textarea>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>Simpan Perubahan
                        </button>
                        <a href="{{ route('order.show', $order) }}" class="btn btn-ghost">Batal</a>
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
    if (total > 0) document.getElementById('total_harga').textContent = 'Rp ' + total.toLocaleString('id-ID');
}
document.getElementById('layanan_id').addEventListener('change', hitungTotal);
document.getElementById('berat_kg').addEventListener('input', hitungTotal);
</script>
@endpush
