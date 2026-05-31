@extends('customer.layout')
@section('title', 'Order Berhasil — Bless Laundry')

@push('styles')
<style>
.sukses-hero { background:linear-gradient(135deg, var(--sky-light) 0%, var(--green-light) 100%); padding:56px 0; }
.kode-box { background:#fff; border:2px dashed var(--sky-dark); border-radius:16px; padding:24px; text-align:center; }
.kode-order { font-size:2rem; font-weight:700; color:var(--sky-dark); letter-spacing:2px; font-family:monospace; }
.next-step { border:1px solid #e2e8f0; border-radius:14px; padding:16px 18px; display:flex; align-items:center; gap:14px; }
.step-num { width:36px; height:36px; border-radius:50%; background:var(--sky-dark); color:#fff; display:flex; align-items:center; justify-content:center; font-weight:700; flex-shrink:0; }
</style>
@endpush

@section('content')

<section class="sukses-hero">
    <div class="container text-center">
        <div class="mb-3" style="font-size:56px">🎉</div>
        <h1 class="fw-semibold mb-2" style="font-size:1.8rem;color:var(--sky-dark)">Order berhasil dibuat!</h1>
        <p class="text-muted mb-0">Catat kode order kamu dan antarkan cucian ke outlet kami</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="mx-auto" style="max-width:580px">

            {{-- KODE ORDER --}}
            <div class="kode-box mb-4">
                <div class="text-muted small mb-2">Kode order kamu</div>
                <div class="kode-order" id="kode-text">{{ $order->kode_order }}</div>
                <button class="btn btn-sm mt-3" style="background:var(--sky-light);color:var(--sky-dark);border-radius:8px"
                    onclick="salin()">
                    <i class="bi bi-clipboard me-1" id="copy-icon"></i><span id="copy-text">Salin kode</span>
                </button>
                <div class="text-muted mt-2" style="font-size:12px">
                    Gunakan kode ini untuk cek status cucian kapan saja
                </div>
            </div>

            {{-- DETAIL ORDER --}}
            <div class="bl-card mb-4">
                <h6 class="fw-semibold mb-3">Detail order</h6>
                <div class="row g-2">
                    <div class="col-6">
                        <div class="text-muted small">Nama</div>
                        <div class="fw-semibold">{{ $order->pelanggan->nama }}</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">Nomor WA</div>
                        <div class="fw-semibold">{{ $order->pelanggan->no_telp }}</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">Layanan</div>
                        <div class="fw-semibold">{{ $order->layanan->nama_layanan }}</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">Est. berat</div>
                        <div class="fw-semibold">{{ $order->berat_kg }} kg</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">Est. total</div>
                        <div class="fw-semibold" style="color:var(--sky-dark)">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">Est. selesai</div>
                        <div class="fw-semibold">{{ $order->tanggal_selesai->format('d M Y') }}</div>
                    </div>
                    @if($order->catatan)
                    <div class="col-12">
                        <div class="text-muted small">Catatan</div>
                        <div class="fw-semibold">{{ $order->catatan }}</div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- NOTIF WA STATUS --}}
            @if($order->pelanggan->notif_wa)
            <div class="mb-4 p-3 rounded-3 d-flex align-items-center gap-3" style="background:var(--green-light)">
                <i class="bi bi-whatsapp fs-4" style="color:var(--green-dark)"></i>
                <div>
                    <div class="fw-semibold" style="font-size:14px;color:var(--green-dark)">Notifikasi WA aktif ✅</div>
                    <div class="text-muted" style="font-size:12px">Kamu akan dapat update otomatis ke WhatsApp saat status cucian berubah</div>
                </div>
            </div>
            @else
            <div class="mb-4 p-3 rounded-3 d-flex align-items-center gap-3" style="background:#f8fafc">
                <i class="bi bi-bell-slash fs-4 text-muted"></i>
                <div>
                    <div class="fw-semibold" style="font-size:14px">Notifikasi WA tidak aktif</div>
                    <div class="text-muted" style="font-size:12px">Aktifkan di halaman beranda agar dapat update otomatis</div>
                </div>
            </div>
            @endif

            {{-- LANGKAH SELANJUTNYA --}}
            <h6 class="fw-semibold mb-3">Langkah selanjutnya</h6>

            @foreach([
                ['num'=>'1','judul'=>'Antar cucian ke outlet','desc'=>'Bawa cucianmu ke Bless Laundry (07.00–21.00) dan tunjukkan kode order di atas'],
                ['num'=>'2','judul'=>'Cucian diproses','desc'=>'Tim kami akan menimbang, mencuci, dan menyetrika cucianmu dengan teliti'],
                ['num'=>'3','judul'=>'Cucian siap diambil','desc'=>'Kami kirim notifikasi saat cucian sudah selesai dan siap diambil'],
            ] as $step)
            <div class="next-step mb-2">
                <div class="step-num">{{ $step['num'] }}</div>
                <div>
                    <div class="fw-semibold" style="font-size:14px">{{ $step['judul'] }}</div>
                    <div class="text-muted" style="font-size:13px">{{ $step['desc'] }}</div>
                </div>
            </div>
            @endforeach

            {{-- ACTIONS --}}
            <div class="d-flex gap-3 mt-4 flex-wrap">
                <a href="{{ route('customer.cek-status', ['kode' => $order->kode_order]) }}"
                    class="btn btn-sky flex-grow-1 py-2">
                    <i class="bi bi-search me-2"></i>Cek Status Cucian
                </a>
                <a href="{{ route('customer.order') }}" class="btn btn-sky-outline flex-grow-1 py-2">
                    <i class="bi bi-plus me-2"></i>Order Lagi
                </a>
            </div>
            <div class="text-center mt-3">
                <a href="{{ route('customer.home') }}" class="text-muted" style="font-size:13px">
                    <i class="bi bi-house me-1"></i>Kembali ke beranda
                </a>
            </div>

        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
function salin() {
    const kode = document.getElementById('kode-text').textContent;
    navigator.clipboard.writeText(kode).then(() => {
        document.getElementById('copy-icon').className = 'bi bi-clipboard-check me-1';
        document.getElementById('copy-text').textContent = 'Tersalin!';
        setTimeout(() => {
            document.getElementById('copy-icon').className = 'bi bi-clipboard me-1';
            document.getElementById('copy-text').textContent = 'Salin kode';
        }, 2000);
    });
}
</script>
@endpush
