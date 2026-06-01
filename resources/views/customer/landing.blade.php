@extends('customer.layout')
@section('title', 'Bless Laundry — Bersih, Cepat, Terpercaya')

@push('styles')
<style>
.hero-section {
    background: var(--sky-light);
    padding: 64px 0 48px;
}
.hero-title { font-size: 2.4rem; font-weight: 700; color: #0284C7; line-height: 1.2; }
.hero-title span { color: #15803D; }
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

/* ── Hero Float Layout ───────────────────────────── */
.hero-float-wrap {
    position: relative;
    width: 100%;
    max-width: 500px;
    margin-left: auto;
    padding: 60px 0;
}
.hero-float-img {
    display: block;
    width: 55%;
    max-width: 260px;
    margin: 0 auto;
    object-fit: contain;
    border-radius: 24px;
    animation: hero-float 3.5s ease-in-out infinite;
    filter: drop-shadow(0 12px 32px rgba(2,132,199,.15));
}
@keyframes hero-float {
    0%, 100% { transform: translateY(0); }
    50%       { transform: translateY(-10px); }
}

/* Floating card base */
.float-card {
    position: absolute;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,.10);
    padding: 10px 14px;
    display: flex;
    align-items: center;
    gap: 10px;
    white-space: nowrap;
    z-index: 2;
    animation: card-in .5s ease both;
}
.float-card__icon {
    width: 44px; height: 44px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(0,0,0,.08);
}
.float-card__title { font-size: 13px; font-weight: 700; color: #0f172a; }

/* Posisi: 2 kiri (atas+bawah), 2 kanan (atas+bawah), gambar di tengah */
.float-card--1 { top: 10%;    left: 0;   animation-delay: .10s; }
.float-card--2 { bottom: 10%; left: 0;   animation-delay: .25s; }
.float-card--3 { top: 10%;    right: 0;  animation-delay: .15s; animation-name: card-in-right; }
.float-card--4 { bottom: 10%; right: 0;  animation-delay: .30s; animation-name: card-in-right; }

@keyframes card-in {
    from { opacity: 0; transform: translateX(-14px); }
    to   { opacity: 1; transform: translateX(0); }
}
@keyframes card-in-right {
    from { opacity: 0; transform: translateX(14px); }
    to   { opacity: 1; transform: translateX(0); }
}

/* Mobile: grid 2 kolom */
@media (max-width: 991px) {
    .hero-float-wrap {
        padding: 0; max-width: 100%;
        display: grid; grid-template-columns: 1fr 1fr; gap: 10px;
    }
    .hero-float-img { grid-column: 1/-1; max-width: 220px; margin: 0 auto; }
    .float-card { position: static; white-space: normal; animation: none; opacity: 1; }
}

/* ── Service Section ─────────────────────────────── */
.svc-section { background: #f8fafc; }
.svc-badge {
    display: inline-block;
    background: linear-gradient(135deg, #E0F2FE, #DCFCE7);
    color: var(--sky-dark);
    font-size: 12px; font-weight: 600; letter-spacing: .06em; text-transform: uppercase;
    padding: 5px 14px; border-radius: 99px;
    border: 1px solid #BAE6FD;
}
.svc-heading {
    font-size: 1.75rem; font-weight: 700; color: #0f172a;
    font-family: 'Segoe UI', sans-serif;
}

/* Illustrated service card */
.svc-card {
    border-radius: 20px;
    background: #fff;
    border: 1.5px solid #e2e8f0;
    padding: 20px 16px 16px;
    text-align: center;
    transition: transform .25s, box-shadow .25s;
    cursor: default;
    height: 100%;
    display: flex; flex-direction: column; align-items: center;
}
.svc-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 40px rgba(2,132,199,.12);
    border-color: #BAE6FD;
}
.svc-card__illo {
    width: 120px; height: 100px;
    margin: 0 auto 14px;
}
.svc-card__illo svg { width: 100%; height: 100%; }
.svc-card__name {
    font-weight: 700; font-size: 14px; color: #0f172a; margin-bottom: 6px;
}
.svc-card__tag {
    font-size: 12px; color: var(--sky-dark);
    background: var(--sky-light); border-radius: 99px; padding: 3px 10px;
    font-weight: 500; margin-top: auto;
}
.svc-card--teal { border-top: 4px solid #0284C7; }
.svc-card--amber { border-top: 4px solid #15803D; }

/* Price card from database */
.svc-price-card {
    border-radius: 16px; background: #fff;
    border: 1.5px solid #e2e8f0;
    padding: 18px 16px;
    text-align: center;
    transition: transform .2s, box-shadow .2s;
}
.svc-price-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(2,132,199,.1); }
.svc-price-card__icon {
    font-size: 26px; color: var(--sky-dark); margin-bottom: 8px;
}
.svc-price-card__name { font-weight: 600; font-size: 14px; color: #1e293b; margin-bottom: 6px; }
.svc-price-card__harga { font-size: 1.2rem; font-weight: 700; color: var(--sky-dark); }
.svc-price-card__harga span { font-size: 12px; font-weight: 400; color: #94a3b8; }
.svc-price-card__hari { font-size: 12px; color: #64748b; margin-top: 4px; }
.svc-price-card__ket { font-size: 11px; color: #94a3b8; margin-top: 4px; }

/* ── Loyalty Section ─────────────────────────────── */
.loyalty-section { background: #fff; border-top: 1px solid #f1f5f9; }
.loyalty-inner {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px;
    align-items: start;
    padding: 72px 0;
}
.loyalty-label {
    font-size: 11px; font-weight: 600; letter-spacing: .1em;
    text-transform: uppercase; color: var(--sky-dark);
    margin-bottom: 16px;
}
.loyalty-heading {
    font-size: 2rem; font-weight: 700; color: #0f172a;
    line-height: 1.25; margin-bottom: 16px; letter-spacing: -.02em;
}
.loyalty-desc {
    font-size: 14.5px; color: #64748b; line-height: 1.75;
    margin-bottom: 32px; max-width: 380px;
}
.loyalty-link {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: 14px; font-weight: 600; color: #0f172a;
    text-decoration: none; border-bottom: 1.5px solid #0f172a;
    padding-bottom: 2px; transition: opacity .15s;
}
.loyalty-link:hover { opacity: .6; color: #0f172a; }

/* Right side — reward table */
.loyalty-table { width: 100%; border-collapse: collapse; }
.loyalty-table thead th {
    font-size: 11px; font-weight: 600; letter-spacing: .07em;
    text-transform: uppercase; color: #94a3b8;
    padding: 0 0 14px; border-bottom: 1px solid #f1f5f9;
    text-align: left;
}
.loyalty-table thead th:last-child { text-align: right; }
.loyalty-table tbody tr { border-bottom: 1px solid #f8fafc; }
.loyalty-table tbody tr:last-child { border-bottom: none; }
.loyalty-table tbody td {
    padding: 16px 0; font-size: 14px; color: #1e293b; vertical-align: middle;
}
.loyalty-table tbody td:last-child { text-align: right; }
.loyalty-pts {
    font-size: 13px; font-weight: 700; color: var(--sky-dark);
    background: var(--sky-light); padding: 3px 10px;
    border-radius: 6px; white-space: nowrap;
}
.loyalty-note {
    margin-top: 28px; padding-top: 20px;
    border-top: 1px solid #f1f5f9;
    font-size: 13px; color: #94a3b8; line-height: 1.6;
}

@media (max-width: 900px) {
    .loyalty-inner { grid-template-columns: 1fr; gap: 48px; padding: 48px 0; }
}
.howto-section { background: #fff; }
.howto-card {
    background: #fff; border: 1.5px solid #e2e8f0;
    border-radius: 20px; padding: 24px 20px;
    text-align: center; position: relative;
    transition: transform .25s, box-shadow .25s;
    height: 100%;
}
.howto-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 40px rgba(2,132,199,.1);
}
.howto-card__num {
    display: inline-flex; align-items: center; justify-content: center;
    width: 36px; height: 36px; border-radius: 50%;
    font-size: 13px; font-weight: 800; letter-spacing: .02em;
    margin-bottom: 16px;
}
.howto-card__illo {
    width: 90px; height: 80px; border-radius: 16px;
    margin: 0 auto 16px; display: flex; align-items: center; justify-content: center;
    overflow: hidden;
}
.howto-card__illo svg { width: 100%; height: 100%; }
.howto-card__title { font-weight: 700; font-size: 15px; color: #0f172a; margin-bottom: 8px; }
.howto-card__desc { font-size: 13px; color: #64748b; line-height: 1.55; }
.howto-arrow {
    position: absolute; right: -20px; top: 50%;
    transform: translateY(-50%);
    z-index: 2; align-items: center; justify-content: center;
}
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <h1 class="hero-title mb-3">
                    Laundry Bersih,<br><span>Hidup Lebih Ringan</span>
                </h1>
                <p class="text-muted mb-4" style="font-size:15px;line-height:1.7">
                    Layanan laundry profesional dengan estimasi harga transparan, live tracking status cucian,
                    notifikasi WhatsApp otomatis, dan program loyalty rewards untuk pelanggan setia.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="#estimasi" class="btn btn-sky btn-lg px-4">
                        <i class="bi bi-calculator me-2"></i>Hitung Estimasi
                    </a>
                    <a href="{{ route('customer.cek-status') }}" class="btn btn-sky-outline btn-lg px-4">
                        <i class="bi bi-geo-alt me-2"></i>Cek Status Cucian
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-float-wrap">
                    {{-- Gambar karakter --}}
                    <img src="{{ asset('images/laundry.svg') }}"
                         alt="Karakter laundry"
                         class="hero-float-img">

                    {{-- Card 1: kiri atas — Estimasi --}}
                    <div class="float-card float-card--1">
                        <div class="float-card__icon" style="background:var(--sky-light);color:var(--sky-dark)">
                            <i class="bi bi-calculator"></i>
                        </div>
                        <div>
                            <div class="float-card__title">Estimasi harga otomatis</div>
                        </div>
                    </div>

                    {{-- Card 2: kiri bawah — Loyalty --}}
                    <div class="float-card float-card--2">
                        <div class="float-card__icon" style="background:#DCFCE7;color:#14532D">
                            <i class="bi bi-trophy"></i>
                        </div>
                        <div>
                            <div class="float-card__title">Loyalty points</div>
                        </div>
                    </div>

                    {{-- Card 3: kanan atas — WhatsApp --}}
                    <div class="float-card float-card--3">
                        <div class="float-card__icon" style="background:var(--green-light);color:var(--green-dark)">
                            <i class="bi bi-whatsapp"></i>
                        </div>
                        <div>
                            <div class="float-card__title">Notifikasi WhatsApp</div>
                        </div>
                    </div>

                    {{-- Card 4: kanan bawah — Live tracking --}}
                    <div class="float-card float-card--4">
                        <div class="float-card__icon" style="background:var(--sky-light);color:var(--sky-dark)">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div>
                            <div class="float-card__title">Live tracking</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- LAYANAN --}}
<section class="svc-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="svc-heading mt-2">Apa yang bisa kami cuciin?</h2>
            <p class="text-muted mt-1">Dari baju kiloan sampai karpet, semua kami tangani.</p>
        </div>

        {{-- 8 Layanan utama --}}
        <div class="row g-4 mb-4">

            {{-- 1. Laundry Kiloan --}}
            <div class="col-6 col-md-3">
                <div class="svc-card svc-card--teal">
                    <div class="svc-card__illo">
                        <svg viewBox="0 0 120 100" xmlns="http://www.w3.org/2000/svg">
                            <rect x="28" y="48" width="64" height="42" rx="8" fill="#E0F2FE"/>
                            <rect x="28" y="48" width="64" height="42" rx="8" fill="none" stroke="#0284C7" stroke-width="2.5"/>
                            <line x1="42" y1="48" x2="42" y2="90" stroke="#0284C7" stroke-width="1.5" opacity=".3"/>
                            <line x1="60" y1="48" x2="60" y2="90" stroke="#0284C7" stroke-width="1.5" opacity=".3"/>
                            <line x1="78" y1="48" x2="78" y2="90" stroke="#0284C7" stroke-width="1.5" opacity=".3"/>
                            <line x1="28" y1="64" x2="92" y2="64" stroke="#0284C7" stroke-width="1.5" opacity=".3"/>
                            <line x1="28" y1="76" x2="92" y2="76" stroke="#0284C7" stroke-width="1.5" opacity=".3"/>
                            <path d="M36 48 Q46 24 57 34 Q68 24 79 34 Q86 22 92 48" fill="#38BDF8" stroke="#0284C7" stroke-width="2"/>
                            <circle cx="18" cy="32" r="3" fill="#38BDF8" opacity=".5"/>
                            <circle cx="102" cy="58" r="2.5" fill="#38BDF8" opacity=".4"/>
                        </svg>
                    </div>
                    <div class="svc-card__name">Laundry Kiloan</div>
                    <div class="svc-card__tag"><i class="bi bi-clock me-1"></i>1–3 Hari</div>
                </div>
            </div>

            {{-- 2. Cuci & Setrika --}}
            <div class="col-6 col-md-3">
                <div class="svc-card svc-card--amber">
                    <div class="svc-card__illo">
                        <svg viewBox="0 0 120 100" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 58 Q18 42 44 40 L92 40 Q102 40 102 50 L102 63 Q102 68 96 68 L24 68 Q18 68 18 63 Z" fill="#DCFCE7"/>
                            <path d="M18 58 Q18 42 44 40 L92 40 Q102 40 102 50 L102 63 Q102 68 96 68 L24 68 Q18 68 18 63 Z" fill="none" stroke="#15803D" stroke-width="2.5"/>
                            <path d="M54 40 Q54 24 68 24 Q82 24 82 40" fill="none" stroke="#15803D" stroke-width="2.5" stroke-linecap="round"/>
                            <path d="M96 45 Q108 38 110 28" fill="none" stroke="#94A3B8" stroke-width="2" stroke-linecap="round"/>
                            <circle cx="110" cy="25" r="3.5" fill="#94A3B8"/>
                            <path d="M36 30 Q36 23 40 18" fill="none" stroke="#38BDF8" stroke-width="2" stroke-linecap="round" opacity=".7"/>
                            <path d="M50 28 Q50 21 54 16" fill="none" stroke="#38BDF8" stroke-width="2" stroke-linecap="round" opacity=".7"/>
                            <path d="M64 28 Q64 22 68 18" fill="none" stroke="#38BDF8" stroke-width="2" stroke-linecap="round" opacity=".5"/>
                            <circle cx="36" cy="57" r="2" fill="#15803D" opacity=".5"/>
                            <circle cx="52" cy="57" r="2" fill="#15803D" opacity=".5"/>
                            <circle cx="68" cy="57" r="2" fill="#15803D" opacity=".5"/>
                            <circle cx="84" cy="57" r="2" fill="#15803D" opacity=".5"/>
                        </svg>
                    </div>
                    <div class="svc-card__name">Cuci & Setrika</div>
                    <div class="svc-card__tag"><i class="bi bi-clock me-1"></i>2–3 Hari</div>
                </div>
            </div>

            {{-- 3. Laundry Bedcover --}}
            <div class="col-6 col-md-3">
                <div class="svc-card svc-card--teal">
                    <div class="svc-card__illo">
                        <svg viewBox="0 0 120 100" xmlns="http://www.w3.org/2000/svg">
                            <!-- kasur/bantal -->
                            <rect x="15" y="52" width="90" height="34" rx="10" fill="#E0F2FE"/>
                            <rect x="15" y="52" width="90" height="34" rx="10" fill="none" stroke="#0284C7" stroke-width="2.5"/>
                            <!-- bantal kiri -->
                            <rect x="22" y="44" width="32" height="22" rx="8" fill="#38BDF8" opacity=".5"/>
                            <rect x="22" y="44" width="32" height="22" rx="8" fill="none" stroke="#0284C7" stroke-width="2"/>
                            <!-- bantal kanan -->
                            <rect x="66" y="44" width="32" height="22" rx="8" fill="#38BDF8" opacity=".5"/>
                            <rect x="66" y="44" width="32" height="22" rx="8" fill="none" stroke="#0284C7" stroke-width="2"/>
                            <!-- selimut/bedcover -->
                            <path d="M15 68 Q60 58 105 68" fill="none" stroke="#0284C7" stroke-width="2" opacity=".5"/>
                            <!-- motif bunga kecil -->
                            <circle cx="60" cy="72" r="3" fill="#38BDF8" opacity=".6"/>
                            <circle cx="40" cy="76" r="2" fill="#38BDF8" opacity=".4"/>
                            <circle cx="80" cy="76" r="2" fill="#38BDF8" opacity=".4"/>
                        </svg>
                    </div>
                    <div class="svc-card__name">Laundry Bedcover</div>
                    <div class="svc-card__tag"><i class="bi bi-clock me-1"></i>2–4 Hari</div>
                </div>
            </div>

            {{-- 4. Laundry Boneka --}}
            <div class="col-6 col-md-3">
                <div class="svc-card svc-card--amber">
                    <div class="svc-card__illo">
                        <svg viewBox="0 0 120 100" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="42" cy="32" r="12" fill="#BBF7D0"/>
                            <circle cx="78" cy="32" r="12" fill="#BBF7D0"/>
                            <circle cx="42" cy="32" r="7" fill="#DCFCE7"/>
                            <circle cx="78" cy="32" r="7" fill="#DCFCE7"/>
                            <ellipse cx="60" cy="70" rx="28" ry="24" fill="#BBF7D0"/>
                            <circle cx="60" cy="46" r="22" fill="#BBF7D0"/>
                            <ellipse cx="60" cy="55" rx="12" ry="8" fill="#DCFCE7"/>
                            <ellipse cx="60" cy="51" rx="3.5" ry="2.5" fill="#92400E"/>
                            <circle cx="53" cy="43" r="3.5" fill="#1C1917"/>
                            <circle cx="67" cy="43" r="3.5" fill="#1C1917"/>
                            <circle cx="54" cy="42" r="1.5" fill="#fff"/>
                            <circle cx="68" cy="42" r="1.5" fill="#fff"/>
                            <path d="M54 57 Q60 62 66 57" fill="none" stroke="#92400E" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div class="svc-card__name">Laundry Boneka</div>
                    <div class="svc-card__tag"><i class="bi bi-clock me-1"></i>2–4 Hari</div>
                </div>
            </div>

            {{-- 5. Laundry Karpet --}}
            <div class="col-6 col-md-3">
                <div class="svc-card svc-card--teal">
                    <div class="svc-card__illo">
                        <svg viewBox="0 0 120 100" xmlns="http://www.w3.org/2000/svg">
                            <!-- karpet digulung -->
                            <ellipse cx="60" cy="82" rx="44" ry="10" fill="#E0F2FE"/>
                            <ellipse cx="60" cy="82" rx="44" ry="10" fill="none" stroke="#0284C7" stroke-width="2"/>
                            <!-- badan karpet -->
                            <rect x="16" y="30" width="88" height="52" rx="4" fill="#E0F2FE"/>
                            <rect x="16" y="30" width="88" height="52" rx="4" fill="none" stroke="#0284C7" stroke-width="2.5"/>
                            <!-- border dalam -->
                            <rect x="22" y="36" width="76" height="40" rx="2" fill="none" stroke="#0284C7" stroke-width="1" opacity=".4"/>
                            <!-- motif tengah -->
                            <rect x="42" y="46" width="36" height="20" rx="3" fill="#38BDF8" opacity=".3" stroke="#0284C7" stroke-width="1.5"/>
                            <circle cx="60" cy="56" r="6" fill="#38BDF8" opacity=".5" stroke="#0284C7" stroke-width="1"/>
                            <!-- fringe atas -->
                            <line x1="24" y1="30" x2="22" y2="22" stroke="#0284C7" stroke-width="1.5" opacity=".5"/>
                            <line x1="34" y1="30" x2="32" y2="22" stroke="#0284C7" stroke-width="1.5" opacity=".5"/>
                            <line x1="44" y1="30" x2="42" y2="22" stroke="#0284C7" stroke-width="1.5" opacity=".5"/>
                            <line x1="54" y1="30" x2="52" y2="22" stroke="#0284C7" stroke-width="1.5" opacity=".5"/>
                            <line x1="64" y1="30" x2="62" y2="22" stroke="#0284C7" stroke-width="1.5" opacity=".5"/>
                            <line x1="74" y1="30" x2="72" y2="22" stroke="#0284C7" stroke-width="1.5" opacity=".5"/>
                            <line x1="84" y1="30" x2="82" y2="22" stroke="#0284C7" stroke-width="1.5" opacity=".5"/>
                            <line x1="94" y1="30" x2="92" y2="22" stroke="#0284C7" stroke-width="1.5" opacity=".5"/>
                        </svg>
                    </div>
                    <div class="svc-card__name">Laundry Karpet</div>
                    <div class="svc-card__tag"><i class="bi bi-clock me-1"></i>3–5 Hari</div>
                </div>
            </div>

            {{-- 6. Laundry Sprei --}}
            <div class="col-6 col-md-3">
                <div class="svc-card svc-card--amber">
                    <div class="svc-card__illo">
                        <svg viewBox="0 0 120 100" xmlns="http://www.w3.org/2000/svg">
                            <!-- sprei dilipat -->
                            <path d="M15 72 Q60 55 105 72 L105 85 Q60 95 15 85 Z" fill="#DCFCE7"/>
                            <path d="M15 72 Q60 55 105 72 L105 85 Q60 95 15 85 Z" fill="none" stroke="#15803D" stroke-width="2"/>
                            <path d="M15 62 Q60 45 105 62 L105 72 Q60 55 15 72 Z" fill="#BBF7D0"/>
                            <path d="M15 62 Q60 45 105 62 L105 72 Q60 55 15 72 Z" fill="none" stroke="#15803D" stroke-width="2"/>
                            <path d="M15 52 Q60 35 105 52 L105 62 Q60 45 15 62 Z" fill="#DCFCE7"/>
                            <path d="M15 52 Q60 35 105 52 L105 62 Q60 45 15 62 Z" fill="none" stroke="#15803D" stroke-width="2"/>
                            <!-- motif bunga -->
                            <circle cx="38" cy="58" r="4" fill="#15803D" opacity=".5"/>
                            <circle cx="60" cy="54" r="4" fill="#15803D" opacity=".5"/>
                            <circle cx="82" cy="58" r="4" fill="#15803D" opacity=".5"/>
                            <!-- tali -->
                            <line x1="44" y1="25" x2="76" y2="25" stroke="#94A3B8" stroke-width="2.5" stroke-linecap="round"/>
                            <line x1="44" y1="25" x2="44" y2="52" stroke="#94A3B8" stroke-width="1.5" opacity=".4" stroke-dasharray="3 3"/>
                            <line x1="76" y1="25" x2="76" y2="52" stroke="#94A3B8" stroke-width="1.5" opacity=".4" stroke-dasharray="3 3"/>
                        </svg>
                    </div>
                    <div class="svc-card__name">Laundry Sprei</div>
                    <div class="svc-card__tag"><i class="bi bi-clock me-1"></i>2–3 Hari</div>
                </div>
            </div>

            {{-- 7. Laundry Selimut --}}
            <div class="col-6 col-md-3">
                <div class="svc-card svc-card--teal">
                    <div class="svc-card__illo">
                        <svg viewBox="0 0 120 100" xmlns="http://www.w3.org/2000/svg">
                            <!-- selimut digulung/dilipat -->
                            <path d="M20 40 Q20 28 60 28 Q100 28 100 40 L100 75 Q100 85 60 85 Q20 85 20 75 Z" fill="#E0F2FE"/>
                            <path d="M20 40 Q20 28 60 28 Q100 28 100 40 L100 75 Q100 85 60 85 Q20 85 20 75 Z" fill="none" stroke="#0284C7" stroke-width="2.5"/>
                            <!-- lipatan atas -->
                            <path d="M20 40 Q60 50 100 40" fill="#38BDF8" opacity=".3"/>
                            <path d="M20 40 Q60 50 100 40" fill="none" stroke="#0284C7" stroke-width="2"/>
                            <!-- motif kotak-kotak -->
                            <line x1="40" y1="52" x2="40" y2="82" stroke="#0284C7" stroke-width="1" opacity=".3"/>
                            <line x1="60" y1="52" x2="60" y2="82" stroke="#0284C7" stroke-width="1" opacity=".3"/>
                            <line x1="80" y1="52" x2="80" y2="82" stroke="#0284C7" stroke-width="1" opacity=".3"/>
                            <line x1="22" y1="62" x2="98" y2="62" stroke="#0284C7" stroke-width="1" opacity=".3"/>
                            <line x1="22" y1="74" x2="98" y2="74" stroke="#0284C7" stroke-width="1" opacity=".3"/>
                            <!-- fringe bawah -->
                            <line x1="28" y1="85" x2="26" y2="93" stroke="#0284C7" stroke-width="1.5" opacity=".4"/>
                            <line x1="40" y1="85" x2="38" y2="93" stroke="#0284C7" stroke-width="1.5" opacity=".4"/>
                            <line x1="52" y1="85" x2="50" y2="93" stroke="#0284C7" stroke-width="1.5" opacity=".4"/>
                            <line x1="68" y1="85" x2="66" y2="93" stroke="#0284C7" stroke-width="1.5" opacity=".4"/>
                            <line x1="80" y1="85" x2="78" y2="93" stroke="#0284C7" stroke-width="1.5" opacity=".4"/>
                            <line x1="92" y1="85" x2="90" y2="93" stroke="#0284C7" stroke-width="1.5" opacity=".4"/>
                        </svg>
                    </div>
                    <div class="svc-card__name">Laundry Selimut</div>
                    <div class="svc-card__tag"><i class="bi bi-clock me-1"></i>2–3 Hari</div>
                </div>
            </div>

            {{-- 8. Laundry Gorden --}}
            <div class="col-6 col-md-3">
                <div class="svc-card svc-card--amber">
                    <div class="svc-card__illo">
                        <svg viewBox="0 0 120 100" xmlns="http://www.w3.org/2000/svg">
                            <!-- rel gorden -->
                            <rect x="12" y="20" width="96" height="5" rx="2.5" fill="#94A3B8"/>
                            <circle cx="12" cy="22" r="5" fill="#64748B"/>
                            <circle cx="108" cy="22" r="5" fill="#64748B"/>
                            <!-- panel kiri -->
                            <path d="M16 25 Q22 52 18 88 L50 88 Q46 52 52 25 Z" fill="#BBF7D0" opacity=".6"/>
                            <path d="M16 25 Q22 52 18 88 L50 88 Q46 52 52 25 Z" fill="none" stroke="#15803D" stroke-width="2.5"/>
                            <!-- panel kanan -->
                            <path d="M104 25 Q98 52 102 88 L70 88 Q74 52 68 25 Z" fill="#BBF7D0" opacity=".6"/>
                            <path d="M104 25 Q98 52 102 88 L70 88 Q74 52 68 25 Z" fill="none" stroke="#15803D" stroke-width="2.5"/>
                            <!-- ring/kait -->
                            <circle cx="24" cy="25" r="2.5" fill="#94A3B8"/>
                            <circle cx="38" cy="25" r="2.5" fill="#94A3B8"/>
                            <circle cx="82" cy="25" r="2.5" fill="#94A3B8"/>
                            <circle cx="96" cy="25" r="2.5" fill="#94A3B8"/>
                            <!-- tali pengikat -->
                            <path d="M50 60 Q56 64 50 68" fill="none" stroke="#15803D" stroke-width="2.5" stroke-linecap="round"/>
                            <path d="M70 60 Q64 64 70 68" fill="none" stroke="#15803D" stroke-width="2.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div class="svc-card__name">Laundry Gorden</div>
                    <div class="svc-card__tag"><i class="bi bi-clock me-1"></i>3–5 Hari</div>
                </div>
            </div>

        </div>

        <!-- {{-- Dynamic services from database --}}
        @if($layanan->count())
        <div class="text-center mb-3">
            <span class="svc-badge">Tarif & Layanan</span>
        </div>
        <div class="row g-3">
            @foreach($layanan as $l)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="svc-price-card h-100">
                    <div class="svc-price-card__icon"><i class="bi bi-droplet-half"></i></div>
                    <div class="svc-price-card__name">{{ $l->nama_layanan }}</div>
                    <div class="svc-price-card__harga">Rp {{ number_format($l->harga_per_kg, 0, ',', '.') }}<span>/kg</span></div>
                    <div class="svc-price-card__hari"><i class="bi bi-clock me-1"></i>{{ $l->estimasi_hari }} hari</div>
                    @if($l->keterangan)
                    <div class="svc-price-card__ket">{{ $l->keterangan }}</div>
                    @endif
                </div>
            </div>
            @endforeach
        </div> -->
        @endif
    </div>
</section>

{{-- ESTIMASI HARGA --}}
<section class="py-5" id="estimasi" style="background:#f8fafc">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="svc-heading mt-2">Berapa kira-kira biayanya?</h2>
            <p class="text-muted mt-1">Masukkan jenis layanan dan jumlahnya, kami hitung dulu.</p>
        </div>
        <div class="bl-card mx-auto" style="max-width:580px">
            <div class="row g-3 mb-3">
                <div class="col-12">
                    <label class="form-label small fw-semibold text-muted">Jenis Layanan</label>
                    <select class="form-select" id="layanan-sel" onchange="hitungHarga()">
                        @foreach($layanan as $l)
                        <option value="{{ $l->id }}"
                            data-harga="{{ $l->harga_per_kg }}"
                            data-hari="{{ $l->estimasi_hari }}"
                            data-satuan="{{ in_array($l->nama_layanan, ['Laundry Bedcover','Laundry Boneka','Laundry Sprei','Laundry Selimut']) ? 'pcs' : (in_array($l->nama_layanan, ['Laundry Karpet','Laundry Gorden']) ? 'm²' : 'kg') }}">
                            {{ $l->nama_layanan }} — Rp {{ number_format($l->harga_per_kg,0,',','.') }}/{{ in_array($l->nama_layanan, ['Laundry Bedcover','Laundry Boneka','Laundry Sprei','Laundry Selimut']) ? 'pcs' : (in_array($l->nama_layanan, ['Laundry Karpet','Laundry Gorden']) ? 'm²' : 'kg') }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label small fw-semibold text-muted" id="label-jumlah">Jumlah (kg)</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="berat-input" value="3" min="0.5" max="100" step="0.5" oninput="hitungHarga()">
                        <span class="input-group-text" id="satuan-label" style="min-width:48px;justify-content:center">kg</span>
                    </div>
                </div>
            </div>
            <div class="calc-result">
                <div>
                    <div class="text-muted small">Estimasi total</div>
                    <div id="est-hari" class="text-muted" style="font-size:12px;margin-top:2px">
                        <i class="bi bi-clock me-1"></i>Selesai dalam <span id="hari-val">2</span> hari
                    </div>
                </div>
                <div class="result-price" id="harga-result">Rp 0</div>
            </div>
            <div class="text-muted mt-2" style="font-size:12px">
                <i class="bi bi-info-circle me-1"></i>Harga final ditentukan setelah penimbangan/pengukuran di outlet
            </div>
        </div>
    </div>
</section>

{{-- CARA KERJA --}}
<section class="howto-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="svc-heading mt-2">Gampang banget, kok.</h2>
            <p class="text-muted mt-1">Cuma 4 langkah dan cucian beres.</p>
        </div>
        <div class="row g-0 justify-content-center align-items-start">
            @foreach([
                [
                    'step' => '01',
                    'judul' => 'Antar Cucian',
                    'desc' => 'Bawa cucianmu ke outlet terdekat atau hubungi kami untuk layanan pickup ke rumahmu.',
                    'color' => '#38BDF8',
                    'bg' => '#E0F2FE',
                    'svg' => '<svg viewBox="0 0 90 80" xmlns="http://www.w3.org/2000/svg"><rect x="15" y="38" width="60" height="38" rx="7" fill="#38BDF8" opacity=".2"/><rect x="15" y="38" width="60" height="38" rx="7" fill="none" stroke="#38BDF8" stroke-width="2.5"/><line x1="28" y1="38" x2="28" y2="76" stroke="#38BDF8" stroke-width="1" opacity=".4"/><line x1="45" y1="38" x2="45" y2="76" stroke="#38BDF8" stroke-width="1" opacity=".4"/><line x1="62" y1="38" x2="62" y2="76" stroke="#38BDF8" stroke-width="1" opacity=".4"/><line x1="15" y1="56" x2="75" y2="56" stroke="#38BDF8" stroke-width="1" opacity=".4"/><path d="M22 38 Q30 16 45 22 Q60 16 68 38" fill="#F5A623" opacity=".8" stroke="#E09200" stroke-width="2"/><circle cx="10" cy="30" r="3" fill="#38BDF8" opacity=".5"/><path d="M78 25 L80 20 L82 25 L87 27 L82 29 L80 34 L78 29 L73 27 Z" fill="#F5A623" opacity=".5"/></svg>'
                ],
                [
                    'step' => '02',
                    'judul' => 'Terima Kode Order',
                    'desc' => 'Dapatkan kode unik untuk memantau status cucian kamu secara real-time kapan saja.',
                    'color' => '#F5A623',
                    'bg' => '#DCFCE7',
                    'svg' => '<svg viewBox="0 0 90 80" xmlns="http://www.w3.org/2000/svg"><rect x="22" y="8" width="46" height="64" rx="8" fill="#F5A623" opacity=".15"/><rect x="22" y="8" width="46" height="64" rx="8" fill="none" stroke="#F5A623" stroke-width="2.5"/><rect x="32" y="18" width="26" height="4" rx="2" fill="#F5A623" opacity=".5"/><rect x="28" y="28" width="34" height="3" rx="1.5" fill="#94A3B8" opacity=".5"/><rect x="28" y="35" width="28" height="3" rx="1.5" fill="#94A3B8" opacity=".4"/><rect x="28" y="42" width="30" height="3" rx="1.5" fill="#94A3B8" opacity=".3"/><rect x="28" y="55" width="34" height="8" rx="4" fill="#F5A623" opacity=".3" stroke="#F5A623" stroke-width="1.5"/><circle cx="45" cy="59" r="2" fill="#F5A623"/><circle cx="10" cy="45" r="2.5" fill="#F5A623" opacity=".4"/><circle cx="80" cy="22" r="2" fill="#38BDF8" opacity=".5"/></svg>'
                ],
                [
                    'step' => '03',
                    'judul' => 'Pantau via WhatsApp',
                    'desc' => 'Kami kirim notifikasi otomatis saat cucian masuk, sedang diproses, dan siap diambil.',
                    'color' => '#22C55E',
                    'bg' => '#DCFCE7',
                    'svg' => '<svg viewBox="0 0 90 80" xmlns="http://www.w3.org/2000/svg"><rect x="20" y="5" width="50" height="70" rx="10" fill="#22C55E" opacity=".1"/><rect x="20" y="5" width="50" height="70" rx="10" fill="none" stroke="#22C55E" stroke-width="2.5"/><circle cx="45" cy="10" r="3" fill="#22C55E" opacity=".4"/><rect x="28" y="18" width="34" height="22" rx="5" fill="#22C55E" opacity=".15"/><rect x="28" y="18" width="34" height="22" rx="5" fill="none" stroke="#22C55E" stroke-width="1.5"/><circle cx="37" cy="28" r="5" fill="#22C55E" opacity=".6"/><rect x="45" y="24" width="13" height="3" rx="1.5" fill="#22C55E" opacity=".5"/><rect x="45" y="30" width="10" height="2" rx="1" fill="#94A3B8" opacity=".4"/><path d="M28 42 L32 38 L28 34" fill="none" stroke="#22C55E" stroke-width="1.5" opacity=".5"/><rect x="28" y="48" width="24" height="3" rx="1.5" fill="#94A3B8" opacity=".3"/><rect x="28" y="55" width="18" height="3" rx="1.5" fill="#94A3B8" opacity=".25"/><path d="M78 48 L80 43 L82 48 L87 50 L82 52 L80 57 L78 52 L73 50 Z" fill="#22C55E" opacity=".4"/></svg>'
                ],
                [
                    'step' => '04',
                    'judul' => 'Ambil Cucian Bersih',
                    'desc' => 'Ambil cucian di outlet atau kami antar ke rumahmu. Bersih, wangi, dan rapi!',
                    'color' => '#0284C7',
                    'bg' => '#E0F2FE',
                    'svg' => '<svg viewBox="0 0 90 80" xmlns="http://www.w3.org/2000/svg"><rect x="18" y="30" width="54" height="42" rx="8" fill="#0284C7" opacity=".1"/><rect x="18" y="30" width="54" height="42" rx="8" fill="none" stroke="#0284C7" stroke-width="2.5"/><path d="M30 30 Q30 18 45 18 Q60 18 60 30" fill="none" stroke="#0284C7" stroke-width="2.5" stroke-linecap="round"/><path d="M33 55 L41 63 L60 42" fill="none" stroke="#22C55E" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/><circle cx="14" cy="52" r="3" fill="#0284C7" opacity=".4"/><path d="M74 30 L76 25 L78 30 L83 32 L78 34 L76 39 L74 34 L69 32 Z" fill="#F5A623" opacity=".5"/></svg>'
                ]
            ] as $i => $step)
            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
                <div class="howto-card">
                    <div class="howto-card__num" style="color:{{ $step['color'] }};background:{{ $step['bg'] }}">{{ $step['step'] }}</div>
                    <div class="howto-card__illo" style="background:{{ $step['bg'] }}">
                        {!! $step['svg'] !!}
                    </div>
                    <div class="howto-card__title">{{ $step['judul'] }}</div>
                    <div class="howto-card__desc">{{ $step['desc'] }}</div>
                </div>
                @if($i < 3)
                <div class="howto-arrow d-none d-lg-flex">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8 16 L24 16 M18 10 L24 16 L18 22" stroke="#CBD5E1" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                @endif
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

                {{-- Feedback cek nomor real-time --}}
                <div id="wa-feedback" class="mb-2" style="font-size:13px;min-height:20px"></div>

                <form action="{{ route('customer.notif-wa') }}" method="POST" class="d-flex gap-2 flex-wrap" id="wa-form">
                    @csrf
                    <input type="text" name="no_telp" id="no-telp-input"
                        class="form-control"
                        placeholder="Nomor WhatsApp terdaftar (contoh: 08123456789)"
                        style="max-width:300px"
                        autocomplete="off">
                    <button type="submit" class="btn btn-green px-4" id="wa-btn" disabled>
                        <i class="bi bi-whatsapp me-2"></i><span id="wa-btn-text">Aktifkan</span>
                    </button>
                </form>
                <div class="mt-2" style="font-size:12px;color:var(--green-dark)">
                    <i class="bi bi-info-circle me-1"></i>Nomor harus terdaftar sebagai pelanggan di outlet kami
                </div>
            </div>
        </div>
    </div>
</section>

{{-- LOYALTY --}}
<section class="loyalty-section">
    <div class="container">
        <div class="loyalty-inner">

            {{-- Kiri: copy --}}
            <div>
                <div class="loyalty-label">Program Loyalty</div>
                <h2 class="loyalty-heading">Makin sering<br>laundry, makin<br>banyak untungnya.</h2>
                <p class="loyalty-desc">
                    Setiap Rp 1.000 yang kamu bayar otomatis jadi 1 poin.
                    Tidak perlu daftar ulang — poin langsung masuk setelah pembayaran.
                </p>
                <a href="{{ route('customer.loyalty') }}" class="loyalty-link">
                    Cek poin saya <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            {{-- Kanan: tabel reward --}}
            <div>
                <table class="loyalty-table">
                    <thead>
                        <tr>
                            <th>Reward</th>
                            <th>Poin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Cuci gratis 2 kg</td>
                            <td><span class="loyalty-pts">500 poin</span></td>
                        </tr>
                        <tr>
                            <td>Diskon 20% untuk order berikutnya</td>
                            <td><span class="loyalty-pts">300 poin</span></td>
                        </tr>
                        <tr>
                            <td>Setrika gratis 3 kg</td>
                            <td><span class="loyalty-pts">400 poin</span></td>
                        </tr>
                        <tr>
                            <td>Cuci gratis 5 kg</td>
                            <td><span class="loyalty-pts">1.000 poin</span></td>
                        </tr>
                        <tr>
                            <td>Pickup &amp; delivery gratis</td>
                            <td><span class="loyalty-pts">600 poin</span></td>
                        </tr>
                    </tbody>
                </table>
                <div class="loyalty-note">
                    Rp 1.000 = 1 poin &nbsp;·&nbsp; Berlaku untuk semua jenis layanan &nbsp;·&nbsp;
                    Poin tidak kadaluarsa
                </div>
            </div>

        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
// ── Estimasi Harga ───────────────────────────────────────────
function hitungHarga() {
    const sel    = document.getElementById('layanan-sel');
    const opt    = sel.options[sel.selectedIndex];
    const harga  = parseFloat(opt.getAttribute('data-harga')) || 0;
    const hari   = parseInt(opt.getAttribute('data-hari')) || 1;
    const satuan = opt.getAttribute('data-satuan') || 'kg';
    const jumlah = parseFloat(document.getElementById('berat-input').value) || 0;

    // Update label & satuan input dinamis
    const labelMap = { 'kg': 'Berat cucian (kg)', 'pcs': 'Jumlah item (pcs)', 'm²': 'Luas (m²)' };
    document.getElementById('label-jumlah').textContent = labelMap[satuan] || 'Jumlah';
    document.getElementById('satuan-label').textContent = satuan;

    const total = Math.round(harga * jumlah);
    document.getElementById('harga-result').textContent = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('hari-val').textContent = hari;
}
document.addEventListener('DOMContentLoaded', hitungHarga);

// ── Cek Nomor WhatsApp Real-time ────────────────────────────
const noTelpInput = document.getElementById('no-telp-input');
const waFeedback  = document.getElementById('wa-feedback');
const waBtn       = document.getElementById('wa-btn');
const waBtnText   = document.getElementById('wa-btn-text');
let debounceTimer = null;

if (noTelpInput) {
    noTelpInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        const nomor = this.value.trim();

        if (nomor.length < 8) {
            waFeedback.innerHTML = '';
            waBtn.disabled = true;
            return;
        }

        waFeedback.innerHTML = '<span class="text-muted"><i class="bi bi-hourglass-split me-1"></i>Mengecek nomor...</span>';

        debounceTimer = setTimeout(() => {
            fetch(`{{ route('customer.cek-nomor') }}?no_telp=${encodeURIComponent(nomor)}`)
                .then(r => r.json())
                .then(data => {
                    if (data.terdaftar) {
                        const statusNotif = data.notif_wa
                            ? '<span class="badge rounded-pill ms-1" style="background:var(--green-light);color:var(--green-dark);font-size:11px"><i class="bi bi-check-circle me-1"></i>Notif aktif</span>'
                            : '<span class="badge rounded-pill ms-1" style="background:#fef9c3;color:#713f12;font-size:11px"><i class="bi bi-bell-slash me-1"></i>Notif nonaktif</span>';

                        waFeedback.innerHTML = `<span style="color:var(--green-dark)"><i class="bi bi-person-check-fill me-1"></i>Halo, <strong>${data.nama}</strong>! ${statusNotif}</span>`;
                        waBtn.disabled = false;
                        waBtnText.textContent = data.notif_wa ? 'Nonaktifkan notif' : 'Aktifkan notif';
                        waBtn.style.background = data.notif_wa ? '#dc2626' : '';
                        waBtn.style.borderColor = data.notif_wa ? '#dc2626' : '';
                    } else {
                        waFeedback.innerHTML = '<span style="color:#dc2626"><i class="bi bi-x-circle me-1"></i>Nomor belum terdaftar. Daftar dulu ke outlet kami.</span>';
                        waBtn.disabled = true;
                        waBtnText.textContent = 'Aktifkan';
                        waBtn.style.background = '';
                    }
                })
                .catch(() => {
                    waFeedback.innerHTML = '<span class="text-muted">Gagal mengecek nomor.</span>';
                    waBtn.disabled = true;
                });
        }, 600);
    });
}
</script>
@endpush
