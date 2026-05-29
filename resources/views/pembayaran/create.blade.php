@extends('layouts.app')

@section('title', 'Proses Pembayaran')
@section('page-title', 'Proses Pembayaran')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-receipt me-2"></i>Ringkasan Order
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr><td class="text-muted">Kode Order</td><td><strong>{{ $order->kode_order }}</strong></td></tr>
                    <tr><td class="text-muted">Pelanggan</td><td>{{ $order->pelanggan->nama }}</td></tr>
                    <tr><td class="text-muted">Layanan</td><td>{{ $order->layanan->nama_layanan }}</td></tr>
                    <tr><td class="text-muted">Berat</td><td>{{ $order->berat_kg }} kg</td></tr>
                    <tr>
                        <td class="text-muted">Total Tagihan</td>
                        <td><strong class="text-primary fs-5">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-success text-white">
                <i class="bi bi-cash-coin me-2"></i>Form Pembayaran
            </div>
            <div class="card-body">
                <form action="{{ route('pembayaran.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jumlah Bayar <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="jumlah_bayar" id="jumlah_bayar"
                                class="form-control @error('jumlah_bayar') is-invalid @enderror"
                                min="{{ $order->total_harga }}" value="{{ old('jumlah_bayar', $order->total_harga) }}"
                                required>
                        </div>
                        @error('jumlah_bayar')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kembalian</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" id="kembalian" class="form-control bg-light" readonly value="0">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Metode Pembayaran <span class="text-danger">*</span></label>
                        <select name="metode" class="form-select" required>
                            <option value="tunai">Tunai</option>
                            <option value="transfer">Transfer Bank</option>
                            <option value="qris">QRIS</option>
                        </select>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success flex-fill">
                            <i class="bi bi-check-circle me-1"></i> Konfirmasi Pembayaran
                        </button>
                        <a href="{{ route('order.show', $order) }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const total = {{ $order->total_harga }};
document.getElementById('jumlah_bayar').addEventListener('input', function() {
    const bayar     = parseFloat(this.value) || 0;
    const kembalian = Math.max(0, bayar - total);
    document.getElementById('kembalian').value = kembalian.toLocaleString('id-ID');
});
</script>
@endpush
