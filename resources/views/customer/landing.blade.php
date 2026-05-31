@extends('customer.layout')
@section('title', 'Bless Laundry — Bersih, Cepat, Terpercaya')

@push('styles')
<style>
.hero-section {
    background: var(--sky-light);
    padding: 64px 0 48px;
}
.hero-title { font-size: 2.4rem; font-weight: 700; color: var(--sky-dark); line-height: 1.2; }
.hero-title span { color: var(--green-dark); }
.feat-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 14px;
    padding: 16px; display: flex; align-items: center; gap: 14px;
}
.feat-icon {
    width: 44px; height: 44px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;
}
.stat-box { text-align: center; }
.stat-num { font-size: 1.6rem; font-weight: 700; color: var(--sky-dark); }
.stat-lbl { font-size: 12px; color: #64748b; }
.section-title { font-size: 1.5rem; font-weight: 600; }
.calc-result {
    background: var(--sky-light); border-radius: 12px; padding: 18px 20px;
    display: flex; justify-content: space-between; align-items: center;
}
.result-price { font-size: 1.6rem; font-weight: 700; color: var(--sky-dark); }
.layanan-card {
    border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px;
    text-align: center; transition: transform .2s, box-shadow .2s;
}
.layanan-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(2,132,199,.1); }
.layanan-harga { font-size: 1.3rem; font-weight: 700; color: var(--sky-dark); }
.wa-box {
    background: var(--green-light); border-radius: 20px; padding: 32px;
    display: flex; gap: 24px; align-items: center;
}
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <span class="badge rounded-pill mb-3 px-3 py-2" style="background:var(--green-light);color:var(--green-dark);font-size:13px">
                    <i class="bi bi-star-fill me-1"></i> #1 Laundry Terpercaya di Kota Anda
                </span>
                <h1 class="hero-title mb-3">
                    Laundry Bersih,<br><span>Hidup Lebih Ringan</span>
                </h1>
                <p class="text-muted mb-4" style="font-size:15px;line-height:1.7">
                    Layanan laundry profesional dengan estimasi harga transparan, live tracking status cucian,
                    notifikasi WhatsApp otomatis, dan program loyalty rewards untuk pelanggan setia.
                </p>
                <div class="d-flex gap-3 flex-wrap mb-4">
                    <a href="#estimasi" class="btn btn-sky btn-lg px-4">
                        <i class="bi bi-calculator me-2"></i>Hitung Estimasi
                    </a>
                    <a href="{{ route('customer.cek-status') }}" class="btn btn-sky-outline btn-lg px-4">
                        <i class="bi bi-geo-alt me-2"></i>Cek Status Cucian
                    </a>
                </div>
                <div class="d-flex gap-4">
                    <div class="stat-box"><div class="stat-num">2.400+</div><div class="stat-lbl">Pelanggan puas</div></div>
                    <div class="stat-box"><div class="stat-num">1–3 hari</div><div class="stat-lbl">Estimasi selesai</div></div>
                    <div class="stat-box"><div class="stat-num">4.9 <i class="bi bi-star-fill" style="font-size:14px;color:var(--sky-dark)"></i></div><div class="stat-lbl">Rating</div></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="d-flex flex-column gap-3" style="max-width:360px;margin-left:auto">
                    <div class="feat-card">
                        <div class="feat-icon" style="background:var(--sky-light);color:var(--sky-dark)"><i class="bi bi-calculator"></i></div>
                        <div><div class="fw-semibold" style="font-size:14px">Estimasi harga otomatis</div><div class="text-muted" style="font-size:12px">Input berat → harga langsung muncul</div></div>
                    </div>
                    <div class="feat-card">
                        <div class="feat-icon" style="background:var(--green-light);color:var(--green-dark)"><i class="bi bi-whatsapp"></i></div>
                        <div><div class="fw-semibold" style="font-size:14px">Notifikasi WhatsApp</div><div class="text-muted" style="font-size:12px">Update otomatis saat cucian selesai</div></div>
                    </div>
                    <div class="feat-card">
                        <div class="feat-icon" style="background:#FEF9C3;color:#854D0E"><i class="bi bi-trophy"></i></div>
                        <div><div class="fw-semibold" style="font-size:14px">Loyalty points</div><div class="text-muted" style="font-size:12px">Kumpul poin, tukar hadiah gratis</div></div>
                    </div>
                    <div class="feat-card">
                        <div class="feat-icon" style="background:var(--sky-light);color:var(--sky-dark)"><i class="bi bi-map"></i></div>
                        <div><div class="fw-semibold" style="font-size:14px">Live tracking</div><div class="text-muted" style="font-size:12px">Pantau status cucian step by step</div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- LAYANAN --}}
<section class="py-5" style="background:#f8fafc">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="section-title">Daftar layanan</h2>
            <p class="text-muted">Pilih layanan sesuai kebutuhan cucianmu</p>
        </div>
        <div class="row g-3">
            @foreach($layanan as $l)
            <div class="col-6 col-md-4 col-lg-2">
                <div class="layanan-card h-100">
                    <div class="fs-2 mb-2 text-sky" style="color:var(--sky-dark)"><i class="bi bi-droplet-half"></i></div>
                    <div class="fw-semibold mb-1" style="font-size:14px">{{ $l->nama_layanan }}</div>
                    <div class="layanan-harga mb-1">Rp {{ number_format($l->harga_per_kg, 0, ',', '.') }}<span class="text-muted fw-normal" style="font-size:12px">/kg</span></div>
                    <div class="text-muted" style="font-size:12px"><i class="bi bi-clock me-1"></i>{{ $l->estimasi_hari }} hari</div>
                    @if($l->keterangan)
                    <div class="text-muted mt-1" style="font-size:11px">{{ $l->keterangan }}</div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ESTIMASI HARGA --}}
<section class="py-5" id="estimasi">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="section-title">Estimasi harga</h2>
            <p class="text-muted">Hitung biaya laundry sebelum antar cucian</p>
        </div>
        <div class="bl-card mx-auto" style="max-width:560px">
            <div class="row g-3 mb-3">
                <div class="col-md-7">
                    <label class="form-label small text-muted">Jenis layanan</label>
                    <select class="form-select" id="layanan-sel" onchange="hitungHarga()">
                        @foreach($layanan as $l)
                        <option value="{{ $l->id }}" data-harga="{{ $l->harga_per_kg }}" data-hari="{{ $l->estimasi_hari }}">
                            {{ $l->nama_layanan }} — Rp {{ number_format($l->harga_per_kg,0,',','.') }}/kg
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label small text-muted">Berat cucian (kg)</label>
                    <input type="number" class="form-control" id="berat-input" value="3" min="0.5" max="100" step="0.5" oninput="hitungHarga()">
                </div>
            </div>
            <div class="calc-result">
                <div>
                    <div class="text-muted small">Estimasi total</div>
                    <div id="est-hari" class="text-muted" style="font-size:12px;margin-top:2px">Estimasi selesai: 2 hari</div>
                </div>
                <div class="result-price" id="harga-result">Rp 0</div>
            </div>
            <div class="text-muted mt-2" style="font-size:12px">
                <i class="bi bi-info-circle me-1"></i>Harga final ditentukan setelah penimbangan di outlet
            </div>
        </div>
    </div>
</section>

{{-- CARA KERJA --}}
<section class="py-5" style="background:#f8fafc">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="section-title">Cara kerja</h2>
            <p class="text-muted">4 langkah mudah untuk cucian bersih</p>
        </div>
        <div class="row g-3 justify-content-center">
            @foreach([
                ['icon'=>'bi-bag','step'=>'1','judul'=>'Antar cucian','desc'=>'Bawa cucianmu ke outlet atau hubungi kami untuk pickup'],
                ['icon'=>'bi-receipt','step'=>'2','judul'=>'Terima kode order','desc'=>'Dapatkan kode unik untuk tracking status cucian'],
                ['icon'=>'bi-phone','step'=>'3','judul'=>'Pantau via WhatsApp','desc'=>'Kami kirim notifikasi update status cucianmu'],
                ['icon'=>'bi-bag-check','step'=>'4','judul'=>'Ambil cucian','desc'=>'Ambil cucian bersih atau kami antar ke rumahmu'],
            ] as $item)
            <div class="col-6 col-md-3">
                <div class="text-center p-3">
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width:60px;height:60px;background:var(--sky-light)">
                        <i class="bi {{ $item['icon'] }} fs-4" style="color:var(--sky-dark)"></i>
                    </div>
                    <div class="fw-semibold mb-1">{{ $item['judul'] }}</div>
                    <div class="text-muted" style="font-size:13px">{{ $item['desc'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- NOTIFIKASI WHATSAPP --}}
<section class="py-5">
    <div class="container">
        <div class="wa-box">
            <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0"
                 style="width:64px;height:64px;background:var(--green);font-size:28px;color:#fff">
                <i class="bi bi-whatsapp"></i>
            </div>
            <div class="flex-grow-1">
                <h3 class="fw-semibold mb-1" style="color:var(--green-dark)">Aktifkan notifikasi WhatsApp</h3>
                <p class="text-muted mb-3" style="font-size:14px">
                    Kami kirim update otomatis saat cucianmu masuk, sedang diproses, dan siap diambil — langsung ke WhatsApp kamu.
                </p>
                <form action="{{ route('customer.notif-wa') }}" method="POST" class="d-flex gap-2 flex-wrap">
                    @csrf
                    <input type="text" name="no_telp" class="form-control" placeholder="Nomor WhatsApp (contoh: 08123456789)" style="max-width:280px">
                    <button type="submit" class="btn btn-green px-4">
                        <i class="bi bi-whatsapp me-2"></i>Aktifkan sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- CTA LOYALTY --}}
<section class="py-5" style="background:var(--sky-light)">
    <div class="container text-center">
        <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width:64px;height:64px;background:var(--sky-dark)">
            <i class="bi bi-trophy text-white fs-4"></i>
        </div>
        <h2 class="section-title mb-2">Program loyalty points</h2>
        <p class="text-muted mb-4">Setiap Rp 1.000 = 1 poin. Kumpulkan dan tukar dengan hadiah menarik!</p>
        <a href="{{ route('customer.loyalty') }}" class="btn btn-sky btn-lg px-5">
            <i class="bi bi-gift me-2"></i>Cek poin saya
        </a>
    </div>
</section>

@endsection

@push('scripts')
<script>
function hitungHarga() {
    const sel = document.getElementById('layanan-sel');
    const opt = sel.options[sel.selectedIndex];
    const harga = parseFloat(opt.getAttribute('data-harga')) || 0;
    const hari  = opt.getAttribute('data-hari') || 1;
    const berat = parseFloat(document.getElementById('berat-input').value) || 0;
    const total = Math.round(harga * berat);
    document.getElementById('harga-result').textContent = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('est-hari').textContent = 'Estimasi selesai: ' + hari + ' hari';
}
document.addEventListener('DOMContentLoaded', hitungHarga);
</script>
@endpush
