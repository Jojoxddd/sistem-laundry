@extends('customer.layout')
@section('title', 'Order Cucian — Bless Laundry')

@push('styles')
<style>
.order-hero { background:var(--sky-light); padding:40px 0 28px; }
.step-wizard { display:flex; align-items:center; justify-content:center; gap:0; margin-bottom:32px; }
.wiz-step { display:flex; flex-direction:column; align-items:center; }
.wiz-circle { width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:600; }
.wiz-circle.active { background:var(--sky-dark); color:#fff; }
.wiz-circle.done   { background:var(--green); color:#fff; }
.wiz-circle.idle   { background:#e2e8f0; color:#94a3b8; }
.wiz-label { font-size:11px; margin-top:4px; color:#64748b; white-space:nowrap; }
.wiz-line  { width:60px; height:2px; background:#e2e8f0; margin-bottom:16px; }
.form-section { display:none; }
.form-section.active { display:block; }
.layanan-option { border:1.5px solid #e2e8f0; border-radius:12px; padding:14px 16px; cursor:pointer; transition:all .2s; }
.layanan-option:hover { border-color:var(--sky); background:var(--sky-light); }
.layanan-option.selected { border-color:var(--sky-dark); background:var(--sky-light); }
.layanan-option input[type=radio] { display:none; }
.harga-badge { font-size:1.1rem; font-weight:700; color:var(--sky-dark); }
.preview-box { background:var(--sky-light); border-radius:14px; padding:20px; }
.wa-toggle { background:var(--green-light); border-radius:12px; padding:16px 18px; display:flex; align-items:center; gap:14px; }
</style>
@endpush

@section('content')

<section class="order-hero">
    <div class="container text-center">
        <h1 class="fw-semibold mb-1" style="font-size:1.8rem;color:var(--sky-dark)">
            Order Cucian Online
        </h1>
        <p class="text-muted mb-0">Isi formulir di bawah, antar cucian ke outlet, dan pantau statusnya real-time</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="mx-auto" style="max-width:620px">

            {{-- WIZARD STEPS --}}
            <div class="step-wizard mb-4">
                <div class="wiz-step">
                    <div class="wiz-circle active" id="wiz1"><i class="bi bi-person"></i></div>
                    <div class="wiz-label">Data kamu</div>
                </div>
                <div class="wiz-line" id="line1"></div>
                <div class="wiz-step">
                    <div class="wiz-circle idle" id="wiz2">2</div>
                    <div class="wiz-label">Pilih layanan</div>
                </div>
                <div class="wiz-line" id="line2"></div>
                <div class="wiz-step">
                    <div class="wiz-circle idle" id="wiz3">3</div>
                    <div class="wiz-label">Konfirmasi</div>
                </div>
            </div>

            @if($errors->any())
            <div class="alert alert-danger rounded-3 border-0 mb-4">
                <ul class="mb-0 small">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif

            <form method="POST" action="{{ route('customer.order.store') }}" id="order-form">
                @csrf

                {{-- STEP 1: DATA DIRI --}}
                <div class="form-section active" id="step1">
                    <div class="bl-card">
                        <h5 class="fw-semibold mb-4"><i class="bi bi-person-circle me-2" style="color:var(--sky-dark)"></i>Data diri kamu</h5>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Nama lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" placeholder="Contoh: Budi Santoso"
                                value="{{ old('nama') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Nomor WhatsApp <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text" style="background:var(--sky-light);border-color:#e2e8f0"><i class="bi bi-whatsapp" style="color:var(--green)"></i></span>
                                <input type="text" name="no_telp" id="no-telp" class="form-control"
                                    placeholder="08123456789" value="{{ old('no_telp') }}" required>
                            </div>
                            <div id="telp-feedback" class="mt-1" style="font-size:12px;min-height:18px"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-semibold">Alamat <span class="text-muted fw-normal">(opsional)</span></label>
                            <input type="text" name="alamat" class="form-control" placeholder="Untuk kebutuhan pickup/delivery"
                                value="{{ old('alamat') }}">
                        </div>

                        {{-- TOGGLE NOTIFIKASI WA --}}
                        <div class="wa-toggle mb-2">
                            <div style="font-size:24px;color:var(--green)"><i class="bi bi-whatsapp"></i></div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold" style="font-size:14px;color:var(--green-dark)">Aktifkan notifikasi WhatsApp</div>
                                <div class="text-muted" style="font-size:12px">Kami kirim kode order + update status langsung ke WA kamu</div>
                            </div>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" name="notif_wa" id="notif-wa" value="1"
                                    style="width:42px;height:22px" checked>
                            </div>
                        </div>

                        <button type="button" class="btn btn-sky w-100 mt-3 py-2" onclick="goStep(2)">
                            Pilih Layanan <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>

                {{-- STEP 2: PILIH LAYANAN --}}
                <div class="form-section" id="step2">
                    <div class="bl-card">
                        <h5 class="fw-semibold mb-4">Pilih layanan</h5>

                        <div class="mb-3">
                            @foreach($layanan as $l)
                            <label class="layanan-option d-flex align-items-center gap-3 mb-2 w-100" id="opt-{{ $l->id }}">
                                <input type="radio" name="layanan_id" value="{{ $l->id }}"
                                    data-harga="{{ $l->harga_per_kg }}" data-hari="{{ $l->estimasi_hari }}"
                                    {{ old('layanan_id') == $l->id ? 'checked' : '' }}
                                    onchange="pilihLayanan(this, '{{ $l->id }}')">
                                <div class="flex-grow-1">
                                    <div class="fw-semibold" style="font-size:14px">{{ $l->nama_layanan }}</div>
                                    @if($l->keterangan)
                                    <div class="text-muted" style="font-size:12px">{{ $l->keterangan }}</div>
                                    @endif
                                </div>
                                <div class="text-end">
                                    <div class="harga-badge">Rp {{ number_format($l->harga_per_kg,0,',','.') }}<span class="text-muted fw-normal" style="font-size:11px">/kg</span></div>
                                    <div class="text-muted" style="font-size:11px"><i class="bi bi-clock me-1"></i>{{ $l->estimasi_hari }} hari</div>
                                </div>
                            </label>
                            @endforeach
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-semibold">Estimasi berat cucian (kg) <span class="text-danger">*</span></label>
                            <input type="number" name="berat_kg" id="berat-input" class="form-control"
                                placeholder="Contoh: 3" min="0.5" max="100" step="0.5"
                                value="{{ old('berat_kg', 3) }}" oninput="hitungEstimasi()">
                            <div class="form-text">Berat final ditentukan saat cucian ditimbang di outlet</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-semibold">Catatan <span class="text-muted fw-normal">(opsional)</span></label>
                            <textarea name="catatan" class="form-control" rows="2"
                                placeholder="Contoh: ada noda membandel di baju putih">{{ old('catatan') }}</textarea>
                        </div>

                        {{-- ESTIMASI HARGA --}}
                        <div id="estimasi-box" class="preview-box mb-4" style="display:none">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-muted small">Estimasi total pembayaran</div>
                                    <div class="text-muted" style="font-size:12px" id="est-hari-text"></div>
                                </div>
                                <div style="font-size:1.5rem;font-weight:700;color:var(--sky-dark)" id="est-harga">Rp 0</div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sky-outline flex-shrink-0 px-3" onclick="goStep(1)">
                                <i class="bi bi-arrow-left"></i>
                            </button>
                            <button type="button" class="btn btn-sky flex-grow-1 py-2" onclick="goStep(3)">
                                Konfirmasi <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- STEP 3: KONFIRMASI --}}
                <div class="form-section" id="step3">
                    <div class="bl-card">
                        <h5 class="fw-semibold mb-4">Konfirmasi order</h5>

                        <div class="preview-box mb-4">
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="text-muted small">Nama</div>
                                    <div class="fw-semibold" id="prev-nama">—</div>
                                </div>
                                <div class="col-6">
                                    <div class="text-muted small">Nomor WA</div>
                                    <div class="fw-semibold" id="prev-telp">—</div>
                                </div>
                                <div class="col-6">
                                    <div class="text-muted small">Layanan</div>
                                    <div class="fw-semibold" id="prev-layanan">—</div>
                                </div>
                                <div class="col-6">
                                    <div class="text-muted small">Est. berat</div>
                                    <div class="fw-semibold" id="prev-berat">—</div>
                                </div>
                                <div class="col-12">
                                    <div class="text-muted small">Est. total & selesai</div>
                                    <div class="fw-semibold" id="prev-total">—</div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-2 mb-4 p-3 rounded-3" style="background:#f8fafc;font-size:13px">
                            <i class="bi bi-info-circle text-muted"></i>
                            <span class="text-muted">Setelah submit, kamu akan mendapat <strong>kode order unik</strong> yang bisa dipakai untuk cek status cucian kapan saja.</span>
                        </div>

                        <div id="prev-notif" class="mb-4"></div>

                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sky-outline flex-shrink-0 px-3" onclick="goStep(2)">
                                <i class="bi bi-arrow-left"></i>
                            </button>
                            <button type="submit" class="btn btn-sky flex-grow-1 py-2 fw-semibold">
                                Buat Order Sekarang
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
let currentStep = 1;
let layananData = {};

// Populate layanan data
@foreach($layanan as $l)
layananData[{{ $l->id }}] = { nama: '{{ $l->nama_layanan }}', harga: {{ $l->harga_per_kg }}, hari: {{ $l->estimasi_hari }} };
@endforeach

function goStep(step) {
    // Validasi step 1
    if (step > 1) {
        const nama   = document.querySelector('[name=nama]').value.trim();
        const noTelp = document.querySelector('[name=no_telp]').value.trim();
        if (!nama || !noTelp) {
            alert('Nama dan nomor WhatsApp wajib diisi!');
            return;
        }
    }
    // Validasi step 2
    if (step > 2) {
        const layanan = document.querySelector('[name=layanan_id]:checked');
        const berat   = document.querySelector('[name=berat_kg]').value;
        if (!layanan) { alert('Pilih layanan terlebih dahulu!'); return; }
        if (!berat || berat < 0.5) { alert('Masukkan estimasi berat cucian!'); return; }
        isiPreview();
    }

    document.querySelectorAll('.form-section').forEach(s => s.classList.remove('active'));
    document.getElementById('step' + step).classList.add('active');

    // Update wizard
    for (let i = 1; i <= 3; i++) {
        const c = document.getElementById('wiz' + i);
        c.className = 'wiz-circle ' + (i < step ? 'done' : i === step ? 'active' : 'idle');
        if (i < step) c.innerHTML = '<i class="bi bi-check-lg"></i>';
        else if (i === step) c.innerHTML = i === 1 ? '<i class="bi bi-person"></i>' : i === 2 ? '<i class="bi bi-droplet-half"></i>' : '<i class="bi bi-clipboard-check"></i>';
        else c.innerHTML = i;
    }
    ['line1','line2'].forEach((id, idx) => {
        document.getElementById(id).style.background = step > idx+1 ? 'var(--green)' : '#e2e8f0';
    });

    currentStep = step;
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function pilihLayanan(el, id) {
    document.querySelectorAll('.layanan-option').forEach(o => o.classList.remove('selected'));
    document.getElementById('opt-' + id).classList.add('selected');
    hitungEstimasi();
}

function hitungEstimasi() {
    const layananEl = document.querySelector('[name=layanan_id]:checked');
    const berat     = parseFloat(document.getElementById('berat-input').value) || 0;
    if (!layananEl || berat <= 0) { document.getElementById('estimasi-box').style.display = 'none'; return; }

    const l     = layananData[layananEl.value];
    const total = Math.round(l.harga * berat);
    const tgl   = new Date(); tgl.setDate(tgl.getDate() + l.hari);
    const tglStr = tgl.toLocaleDateString('id-ID', { day:'numeric', month:'long', year:'numeric' });

    document.getElementById('est-harga').textContent    = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('est-hari-text').textContent = 'Est. selesai ' + l.hari + ' hari (' + tglStr + ')';
    document.getElementById('estimasi-box').style.display = 'block';
}

function isiPreview() {
    const nama     = document.querySelector('[name=nama]').value;
    const telp     = document.querySelector('[name=no_telp]').value;
    const layananEl= document.querySelector('[name=layanan_id]:checked');
    const berat    = document.getElementById('berat-input').value;
    const notif    = document.getElementById('notif-wa').checked;

    document.getElementById('prev-nama').textContent    = nama;
    document.getElementById('prev-telp').textContent    = telp;
    document.getElementById('prev-berat').textContent   = berat + ' kg (estimasi)';

    if (layananEl) {
        const l = layananData[layananEl.value];
        const total = Math.round(l.harga * parseFloat(berat));
        const tgl   = new Date(); tgl.setDate(tgl.getDate() + l.hari);
        const tglStr = tgl.toLocaleDateString('id-ID', { day:'numeric', month:'long', year:'numeric' });
        document.getElementById('prev-layanan').textContent = l.nama;
        document.getElementById('prev-total').textContent   = 'Rp ' + total.toLocaleString('id-ID') + ' · Est. selesai ' + tglStr;
    }

    document.getElementById('prev-notif').innerHTML = notif
        ? '<div class="d-flex align-items-center gap-2 text-success"><i class="bi bi-whatsapp"></i><span style="font-size:13px">Notifikasi WA akan dikirim ke nomor kamu</span></div>'
        : '<div class="d-flex align-items-center gap-2 text-muted"><i class="bi bi-bell-slash"></i><span style="font-size:13px">Notifikasi WA tidak diaktifkan</span></div>';
}

// Cek nomor real-time
let debounce;
document.getElementById('no-telp').addEventListener('input', function () {
    clearTimeout(debounce);
    const nomor = this.value.trim();
    const fb    = document.getElementById('telp-feedback');
    if (nomor.length < 8) { fb.innerHTML = ''; return; }
    debounce = setTimeout(() => {
        fetch(`{{ route('customer.cek-nomor') }}?no_telp=${encodeURIComponent(nomor)}`)
            .then(r => r.json()).then(d => {
                if (d.terdaftar) {
                    document.querySelector('[name=nama]').value = d.nama;
                    fb.innerHTML = `<span style="color:var(--green-dark)"><i class="bi bi-person-check-fill me-1"></i>Halo lagi, <strong>${d.nama}</strong>! Data kamu sudah terisi otomatis.</span>`;
                } else {
                    fb.innerHTML = '<span class="text-muted"><i class="bi bi-person-plus me-1"></i>Nomor baru — akun pelanggan akan dibuat otomatis.</span>';
                }
            });
    }, 500);
});

// Jika ada old input (validasi gagal), langsung ke step yang relevan
@if($errors->has('layanan_id') || $errors->has('berat_kg'))
    document.addEventListener('DOMContentLoaded', () => goStep(2));
@elseif($errors->has('nama') || $errors->has('no_telp'))
    document.addEventListener('DOMContentLoaded', () => goStep(1));
@endif

// Init layanan yang sudah dipilih (old input)
document.addEventListener('DOMContentLoaded', () => {
    const checked = document.querySelector('[name=layanan_id]:checked');
    if (checked) { pilihLayanan(checked, checked.value); hitungEstimasi(); }
});
</script>
@endpush
