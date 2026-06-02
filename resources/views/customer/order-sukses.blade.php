@extends('customer.layout')
@section('title', 'Order Berhasil')

@push('styles')
<style>
.sukses-hero {
    background: var(--sky-light);
    padding: 48px 0 36px;
    text-align: center;
}
.kode-box {
    background: #fff;
    border: 2px dashed var(--sky-dark);
    border-radius: 16px;
    padding: 24px;
    text-align: center;
}
.kode-order {
    font-size: 1.9rem; font-weight: 700;
    color: var(--sky-dark); letter-spacing: 2px;
    font-family: monospace;
}
.next-step {
    border: 1px solid #e2e8f0; border-radius: 14px;
    padding: 14px 18px; display: flex; align-items: flex-start; gap: 14px;
}
.step-num {
    width: 32px; height: 32px; border-radius: 50%;
    background: var(--sky-dark); color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 13px; flex-shrink: 0; margin-top: 2px;
}
.wa-notif {
    background: var(--green-light);
    border-radius: 12px; padding: 14px 16px;
    display: flex; align-items: center; gap: 12px;
}
.wa-notif__icon { color: var(--green-dark); font-size: 20px; flex-shrink: 0; }
.wa-notif__title { font-size: 13px; font-weight: 600; color: var(--green-dark); }
.wa-notif__sub { font-size: 12px; color: #64748b; }

.back-link {
    font-size: 13px; color: #94a3b8;
    text-decoration: none; display: inline-flex; align-items: center; gap: 5px;
}
.back-link:hover { color: var(--sky-dark); }
</style>
@endpush

@section('content')

<section class="sukses-hero">
    <div class="container">
        <h1 class="fw-bold mb-2" style="font-size:1.75rem;color:#0f172a">
            Order berhasil dibuat!
        </h1>
        <p class="text-muted mb-0" style="font-size:14px">
            Catat kode order kamu dan antar cucian ke outlet kami
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="mx-auto" style="max-width:560px">

            {{-- Kode order --}}
            <div class="kode-box mb-4">
                <div class="text-muted mb-2" style="font-size:13px">Kode order kamu</div>
                <div class="kode-order" id="kode-text">{{ $order->kode_order }}</div>
                <button class="btn btn-sm mt-3"
                    style="background:var(--sky-light);color:var(--sky-dark);border-radius:50px;padding:5px 16px"
                    onclick="salin()">
                    <i class="bi bi-clipboard me-1" id="copy-icon"></i>
                    <span id="copy-text">Salin kode</span>
                </button>
                <div class="text-muted mt-2" style="font-size:12px">
                    Gunakan kode ini untuk cek status cucian kapan saja
                </div>
            </div>

            {{-- Detail order --}}
            <div class="bl-card mb-4">
                <div class="fw-semibold mb-3" style="font-size:14px">Detail order</div>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="text-muted" style="font-size:12px">Nama</div>
                        <div class="fw-semibold" style="font-size:14px">{{ $order->pelanggan->nama }}</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted" style="font-size:12px">Nomor WA</div>
                        <div class="fw-semibold" style="font-size:14px">{{ $order->pelanggan->no_telp }}</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted" style="font-size:12px">Layanan</div>
                        <div class="fw-semibold" style="font-size:14px">{{ $order->layanan->nama_layanan }}</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted" style="font-size:12px">Est. berat</div>
                        <div class="fw-semibold" style="font-size:14px">{{ $order->berat_kg }} kg</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted" style="font-size:12px">Est. total</div>
                        <div class="fw-semibold" style="font-size:14px;color:var(--sky-dark)">
                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted" style="font-size:12px">Est. selesai</div>
                        <div class="fw-semibold" style="font-size:14px">{{ $order->tanggal_selesai->format('d M Y') }}</div>
                    </div>
                    @if($order->catatan)
                    <div class="col-12">
                        <div class="text-muted" style="font-size:12px">Catatan</div>
                        <div class="fw-semibold" style="font-size:14px">{{ $order->catatan }}</div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Notif WA --}}
            @if($order->pelanggan->notif_wa)
            <div class="wa-notif mb-4">
                <i class="bi bi-whatsapp wa-notif__icon"></i>
                <div>
                    <div class="wa-notif__title">Notifikasi WA aktif</div>
                    <div class="wa-notif__sub">Kamu akan dapat update otomatis ke WhatsApp saat status cucian berubah</div>
                </div>
            </div>
            @else
            <div class="mb-4 p-3 rounded-3 d-flex align-items-center gap-3" style="background:#f8fafc;border:1px solid #e2e8f0">
                <i class="bi bi-bell-slash text-muted fs-5"></i>
                <div>
                    <div class="fw-semibold" style="font-size:13px">Notifikasi WA tidak aktif</div>
                    <div class="text-muted" style="font-size:12px">Aktifkan agar dapat update otomatis</div>
                </div>
            </div>
            @endif

            {{-- Langkah selanjutnya --}}
            <div class="fw-semibold mb-3" style="font-size:14px">Bagaimana Selanjutnya?</div>
            <div class="d-flex flex-column gap-2 mb-4">
                @foreach([
                    ['num'=>'1','judul'=>'Cucian akan di pick-up','desc'=>'Siapkan cucianmu untuk diambil (07.00–21.00) dan tunjukkan kode order di atas'],
                    ['num'=>'2','judul'=>'Cucian diproses','desc'=>'Tim kami timbang, cuci, dan setrika dengan teliti'],
                    ['num'=>'3','judul'=>'Cucian siap diambil','desc'=>'Kami kabarin lewat WhatsApp saat cucian sudah selesai'],
                ] as $step)
                <div class="next-step">
                    <div class="step-num">{{ $step['num'] }}</div>
                    <div>
                        <div class="fw-semibold" style="font-size:14px">{{ $step['judul'] }}</div>
                        <div class="text-muted" style="font-size:13px;line-height:1.5">{{ $step['desc'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Actions --}}
            <div class="d-flex gap-3 flex-wrap">
                <a href="{{ route('customer.cek-status', ['kode' => $order->kode_order]) }}"
                    class="btn btn-sky flex-grow-1 py-2">
                    Cek Status Cucian
                </a>
                <a href="{{ route('customer.order') }}" class="btn btn-sky-outline flex-grow-1 py-2">
                    Order Lagi
                </a>
            </div>
            <div class="text-center mt-3">
                <a href="{{ route('customer.home') }}" class="back-link">
                    Kembali ke beranda
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
