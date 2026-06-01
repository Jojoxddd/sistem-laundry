@extends('layouts.app')
@section('title', 'Proses Pembayaran')
@section('page-title', 'Proses Pembayaran')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('order.show', $order) }}" class="btn btn-ghost btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">

        {{-- RINGKASAN ORDER --}}
        <div class="card mb-4">
            <div class="card-header">Ringkasan Order</div>
            <div class="card-body">
                @foreach([
                    ['label'=>'Kode Order', 'value'=>$order->kode_order, 'mono'=>true],
                    ['label'=>'Pelanggan',  'value'=>$order->pelanggan->nama, 'mono'=>false],
                    ['label'=>'Layanan',    'value'=>$order->layanan->nama_layanan, 'mono'=>false],
                    ['label'=>'Berat',      'value'=>$order->berat_kg.' kg', 'mono'=>false],
                ] as $row)
                <div class="d-flex justify-content-between py-2" style="border-bottom:1px solid #f1f5f9">
                    <span style="font-size:13px;color:#64748b">{{ $row['label'] }}</span>
                    <span style="font-size:13.5px;{{ $row['mono'] ? 'font-family:monospace;font-weight:700' : 'font-weight:500' }}">
                        {{ $row['value'] }}
                    </span>
                </div>
                @endforeach
                <div class="d-flex justify-content-between pt-3">
                    <span style="font-size:13px;color:#64748b">Total Tagihan</span>
                    <span style="font-size:1.2rem;font-weight:700;color:#2563eb">
                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- FORM PEMBAYARAN --}}
        <div class="card">
            <div class="card-header">Detail Pembayaran</div>
            <div class="card-body">
                <form action="{{ route('pembayaran.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">

                    <div class="mb-3">
                        <label class="form-label">Jumlah Bayar <span style="color:#dc2626">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text" style="background:#f8fafc;border-color:#e2e8f0;font-size:13px">Rp</span>
                            <input type="number" name="jumlah_bayar" id="jumlah_bayar"
                                class="form-control @error('jumlah_bayar') is-invalid @enderror"
                                min="{{ $order->total_harga }}"
                                value="{{ old('jumlah_bayar', $order->total_harga) }}"
                                required>
                        </div>
                        @error('jumlah_bayar')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    {{-- KEMBALIAN --}}
                    <div class="mb-3">
                        <label class="form-label">Kembalian</label>
                        <div id="kembalian-box" style="background:#f0fdf4;border-radius:10px;padding:12px 14px">
                            <span style="font-size:1.2rem;font-weight:700;color:#16a34a" id="kembalian-val">Rp 0</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Metode Pembayaran <span style="color:#dc2626">*</span></label>
                        <div class="d-flex gap-2">
                            @foreach(['tunai'=>'Tunai','transfer'=>'Transfer Bank','qris'=>'QRIS'] as $val=>$label)
                            <label style="flex:1;cursor:pointer">
                                <input type="radio" name="metode" value="{{ $val }}"
                                    {{ old('metode','tunai')===$val ? 'checked' : '' }}
                                    class="d-none metode-radio" id="metode-{{ $val }}">
                                <div class="metode-btn" data-target="metode-{{ $val }}"
                                     style="border:1.5px solid #e2e8f0;border-radius:9px;padding:10px;text-align:center;font-size:13.5px;font-weight:500;color:#475569;transition:all .15s">
                                    {{ $label }}
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">
                        <i class="bi bi-check-circle me-2"></i>Konfirmasi Pembayaran
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
const total = {{ $order->total_harga }};

document.getElementById('jumlah_bayar').addEventListener('input', function () {
    const bayar = parseFloat(this.value) || 0;
    const kem   = Math.max(0, bayar - total);
    document.getElementById('kembalian-val').textContent = 'Rp ' + kem.toLocaleString('id-ID');
    document.getElementById('kembalian-box').style.background = kem > 0 ? '#f0fdf4' : '#f8fafc';
});

// Metode payment toggle style
function updateMetode() {
    document.querySelectorAll('.metode-radio').forEach(radio => {
        const btn = document.querySelector(`.metode-btn[data-target="${radio.id}"]`);
        if (radio.checked) {
            btn.style.borderColor = '#2563eb';
            btn.style.background  = '#eff6ff';
            btn.style.color       = '#2563eb';
        } else {
            btn.style.borderColor = '#e2e8f0';
            btn.style.background  = '#fff';
            btn.style.color       = '#475569';
        }
    });
}
document.querySelectorAll('.metode-radio').forEach(r => r.addEventListener('change', updateMetode));
document.querySelectorAll('.metode-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.getElementById(btn.dataset.target).checked = true;
        updateMetode();
    });
});
updateMetode();
</script>
@endpush
