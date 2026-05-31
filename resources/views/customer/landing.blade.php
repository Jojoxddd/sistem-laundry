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
.svc-card--teal { border-top: 4px solid #38BDF8; }
.svc-card--amber { border-top: 4px solid #F5A623; }

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

/* ── How It Works ────────────────────────────────── */
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
<section class="svc-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="svc-badge">Layanan Kami</span>
            <h2 class="svc-heading mt-2">Daftar Layanan</h2>
            <p class="text-muted mt-1">Pilih layanan sesuai kebutuhan cucianmu</p>
        </div>

        {{-- Static illustrated cards for common services --}}
        <div class="row g-4 mb-4">
            <div class="col-6 col-md-3">
                <div class="svc-card svc-card--teal">
                    <div class="svc-card__illo">
                        <svg viewBox="0 0 120 100" xmlns="http://www.w3.org/2000/svg">
                            <!-- laundry basket -->
                            <rect x="25" y="45" width="70" height="45" rx="8" fill="#F5A623" opacity=".15"/>
                            <rect x="25" y="45" width="70" height="45" rx="8" fill="none" stroke="#F5A623" stroke-width="3"/>
                            <!-- basket weave lines -->
                            <line x1="40" y1="45" x2="40" y2="90" stroke="#F5A623" stroke-width="1.5" opacity=".5"/>
                            <line x1="55" y1="45" x2="55" y2="90" stroke="#F5A623" stroke-width="1.5" opacity=".5"/>
                            <line x1="70" y1="45" x2="70" y2="90" stroke="#F5A623" stroke-width="1.5" opacity=".5"/>
                            <line x1="85" y1="45" x2="85" y2="90" stroke="#F5A623" stroke-width="1.5" opacity=".5"/>
                            <line x1="25" y1="62" x2="95" y2="62" stroke="#F5A623" stroke-width="1.5" opacity=".5"/>
                            <line x1="25" y1="75" x2="95" y2="75" stroke="#F5A623" stroke-width="1.5" opacity=".5"/>
                            <!-- clothes sticking out -->
                            <path d="M35 45 Q45 20 55 30 Q65 20 75 30 Q82 18 90 45" fill="#38BDF8" opacity=".8" stroke="#0284C7" stroke-width="2"/>
                            <!-- sparkles -->
                            <circle cx="20" cy="30" r="3" fill="#38BDF8" opacity=".6"/>
                            <circle cx="100" cy="55" r="2" fill="#F5A623" opacity=".6"/>
                            <path d="M15 55 L17 51 L19 55 L23 57 L19 59 L17 63 L15 59 L11 57 Z" fill="#38BDF8" opacity=".4"/>
                        </svg>
                    </div>
                    <div class="svc-card__name">Cuci Kiloan</div>
                    <div class="svc-card__tag"><i class="bi bi-clock me-1"></i>1–3 Hari</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="svc-card svc-card--amber">
                    <div class="svc-card__illo">
                        <svg viewBox="0 0 120 100" xmlns="http://www.w3.org/2000/svg">
                            <!-- steam iron body -->
                            <path d="M20 55 Q20 40 45 38 L90 38 Q100 38 100 48 L100 60 Q100 65 95 65 L25 65 Q20 65 20 60 Z" fill="#F5A623" opacity=".2"/>
                            <path d="M20 55 Q20 40 45 38 L90 38 Q100 38 100 48 L100 60 Q100 65 95 65 L25 65 Q20 65 20 60 Z" fill="none" stroke="#F5A623" stroke-width="3"/>
                            <!-- handle -->
                            <path d="M55 38 Q55 22 70 22 Q85 22 85 38" fill="none" stroke="#F5A623" stroke-width="3" stroke-linecap="round"/>
                            <!-- cord -->
                            <path d="M95 43 Q110 35 112 25" fill="none" stroke="#94A3B8" stroke-width="2.5" stroke-linecap="round"/>
                            <circle cx="112" cy="22" r="4" fill="#94A3B8"/>
                            <!-- steam puffs -->
                            <path d="M38 30 Q38 22 43 22 Q43 16 48 16" fill="none" stroke="#38BDF8" stroke-width="2" stroke-linecap="round" opacity=".7"/>
                            <path d="M52 28 Q52 20 57 20 Q57 14 62 14" fill="none" stroke="#38BDF8" stroke-width="2" stroke-linecap="round" opacity=".7"/>
                            <path d="M66 28 Q66 20 71 20" fill="none" stroke="#38BDF8" stroke-width="2" stroke-linecap="round" opacity=".5"/>
                            <!-- sole plate holes -->
                            <circle cx="35" cy="55" r="2.5" fill="#F5A623" opacity=".4"/>
                            <circle cx="50" cy="55" r="2.5" fill="#F5A623" opacity=".4"/>
                            <circle cx="65" cy="55" r="2.5" fill="#F5A623" opacity=".4"/>
                            <circle cx="80" cy="55" r="2.5" fill="#F5A623" opacity=".4"/>
                        </svg>
                    </div>
                    <div class="svc-card__name">Cuci & Setrika</div>
                    <div class="svc-card__tag"><i class="bi bi-clock me-1"></i>2–3 Hari</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="svc-card svc-card--teal">
                    <div class="svc-card__illo">
                        <svg viewBox="0 0 120 100" xmlns="http://www.w3.org/2000/svg">
                            <!-- shoe sole -->
                            <ellipse cx="62" cy="80" rx="38" ry="9" fill="#38BDF8" opacity=".3"/>
                            <ellipse cx="62" cy="80" rx="38" ry="9" fill="none" stroke="#0284C7" stroke-width="2"/>
                            <!-- shoe body -->
                            <path d="M28 68 Q28 42 50 38 Q70 35 85 45 Q98 52 98 65 L98 72 Q98 76 92 78 L35 78 Q28 78 28 72 Z" fill="#F5A623" opacity=".2"/>
                            <path d="M28 68 Q28 42 50 38 Q70 35 85 45 Q98 52 98 65 L98 72 Q98 76 92 78 L35 78 Q28 78 28 72 Z" fill="none" stroke="#F5A623" stroke-width="2.5"/>
                            <!-- lace lines -->
                            <line x1="50" y1="44" x2="70" y2="48" stroke="#fff" stroke-width="1.5" opacity=".7"/>
                            <line x1="48" y1="52" x2="72" y2="55" stroke="#fff" stroke-width="1.5" opacity=".7"/>
                            <line x1="47" y1="60" x2="73" y2="62" stroke="#fff" stroke-width="1.5" opacity=".7"/>
                            <!-- sparkle -->
                            <path d="M102 40 L104 36 L106 40 L110 42 L106 44 L104 48 L102 44 L98 42 Z" fill="#F5A623" opacity=".6"/>
                            <circle cx="20" cy="55" r="3" fill="#38BDF8" opacity=".5"/>
                        </svg>
                    </div>
                    <div class="svc-card__name">Laundry Sepatu</div>
                    <div class="svc-card__tag"><i class="bi bi-clock me-1"></i>2–4 Hari</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="svc-card svc-card--amber">
                    <div class="svc-card__illo">
                        <svg viewBox="0 0 120 100" xmlns="http://www.w3.org/2000/svg">
                            <!-- bag body -->
                            <rect x="25" y="40" width="70" height="52" rx="10" fill="#F5A623" opacity=".2"/>
                            <rect x="25" y="40" width="70" height="52" rx="10" fill="none" stroke="#F5A623" stroke-width="3"/>
                            <!-- bag handle left -->
                            <path d="M40 40 Q40 22 55 22 Q55 22 55 30" fill="none" stroke="#F5A623" stroke-width="3" stroke-linecap="round"/>
                            <!-- bag handle right -->
                            <path d="M80 40 Q80 22 65 22 Q65 22 65 30" fill="none" stroke="#F5A623" stroke-width="3" stroke-linecap="round"/>
                            <!-- bag strap detail -->
                            <rect x="48" y="28" width="24" height="8" rx="4" fill="#38BDF8" opacity=".5" stroke="#0284C7" stroke-width="1.5"/>
                            <!-- front pocket -->
                            <rect x="38" y="60" width="44" height="25" rx="6" fill="none" stroke="#F5A623" stroke-width="2" opacity=".6"/>
                            <!-- zipper -->
                            <line x1="38" y1="60" x2="82" y2="60" stroke="#F5A623" stroke-width="2" opacity=".6"/>
                            <circle cx="60" cy="60" r="3" fill="#38BDF8" opacity=".7"/>
                            <!-- sparkles -->
                            <circle cx="15" cy="45" r="2.5" fill="#38BDF8" opacity=".5"/>
                            <circle cx="105" cy="72" r="2" fill="#F5A623" opacity=".5"/>
                        </svg>
                    </div>
                    <div class="svc-card__name">Laundry Tas</div>
                    <div class="svc-card__tag"><i class="bi bi-clock me-1"></i>3–5 Hari</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="svc-card svc-card--teal">
                    <div class="svc-card__illo">
                        <svg viewBox="0 0 120 100" xmlns="http://www.w3.org/2000/svg">
                            <!-- prayer rug shape -->
                            <rect x="20" y="25" width="80" height="65" rx="4" fill="#F5A623" opacity=".15"/>
                            <rect x="20" y="25" width="80" height="65" rx="4" fill="none" stroke="#F5A623" stroke-width="3"/>
                            <!-- arch motif -->
                            <path d="M35 80 L35 48 Q60 30 85 48 L85 80" fill="none" stroke="#38BDF8" stroke-width="2.5"/>
                            <!-- inner arch -->
                            <path d="M44 80 L44 54 Q60 42 76 54 L76 80" fill="none" stroke="#38BDF8" stroke-width="1.5" opacity=".5"/>
                            <!-- border lines -->
                            <rect x="24" y="29" width="72" height="57" rx="2" fill="none" stroke="#F5A623" stroke-width="1" opacity=".4"/>
                            <!-- rolled bottom -->
                            <ellipse cx="60" cy="92" rx="40" ry="7" fill="#F5A623" opacity=".25"/>
                            <ellipse cx="60" cy="92" rx="40" ry="7" fill="none" stroke="#F5A623" stroke-width="2"/>
                            <!-- top fringe dots -->
                            <circle cx="30" cy="25" r="2" fill="#38BDF8" opacity=".6"/>
                            <circle cx="60" cy="22" r="2" fill="#F5A623" opacity=".6"/>
                            <circle cx="90" cy="25" r="2" fill="#38BDF8" opacity=".6"/>
                        </svg>
                    </div>
                    <div class="svc-card__name">Cuci Sajadah</div>
                    <div class="svc-card__tag"><i class="bi bi-clock me-1"></i>2–3 Hari</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="svc-card svc-card--amber">
                    <div class="svc-card__illo">
                        <svg viewBox="0 0 120 100" xmlns="http://www.w3.org/2000/svg">
                            <!-- curtain rod -->
                            <rect x="15" y="22" width="90" height="6" rx="3" fill="#94A3B8"/>
                            <circle cx="15" cy="25" r="5" fill="#64748B"/>
                            <circle cx="105" cy="25" r="5" fill="#64748B"/>
                            <!-- left curtain panel -->
                            <path d="M18 28 Q25 50 20 88 L52 88 Q48 50 55 28 Z" fill="#A855F7" opacity=".25"/>
                            <path d="M18 28 Q25 50 20 88 L52 88 Q48 50 55 28 Z" fill="none" stroke="#A855F7" stroke-width="2.5"/>
                            <!-- right curtain panel -->
                            <path d="M102 28 Q95 50 100 88 L68 88 Q72 50 65 28 Z" fill="#38BDF8" opacity=".25"/>
                            <path d="M102 28 Q95 50 100 88 L68 88 Q72 50 65 28 Z" fill="none" stroke="#38BDF8" stroke-width="2.5"/>
                            <!-- curtain hooks -->
                            <circle cx="28" cy="28" r="3" fill="#94A3B8"/>
                            <circle cx="42" cy="28" r="3" fill="#94A3B8"/>
                            <circle cx="78" cy="28" r="3" fill="#94A3B8"/>
                            <circle cx="92" cy="28" r="3" fill="#94A3B8"/>
                            <!-- tie-back left -->
                            <path d="M52 62 Q58 65 52 68" fill="none" stroke="#F5A623" stroke-width="2.5" stroke-linecap="round"/>
                            <path d="M68 62 Q62 65 68 68" fill="none" stroke="#F5A623" stroke-width="2.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div class="svc-card__name">Cuci Gorden</div>
                    <div class="svc-card__tag"><i class="bi bi-clock me-1"></i>3–5 Hari</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="svc-card svc-card--teal">
                    <div class="svc-card__illo">
                        <svg viewBox="0 0 120 100" xmlns="http://www.w3.org/2000/svg">
                            <!-- stroller body -->
                            <path d="M30 35 Q30 22 60 22 Q90 22 90 35 L90 62 Q90 70 80 70 L40 70 Q30 70 30 62 Z" fill="#38BDF8" opacity=".2"/>
                            <path d="M30 35 Q30 22 60 22 Q90 22 90 35 L90 62 Q90 70 80 70 L40 70 Q30 70 30 62 Z" fill="none" stroke="#38BDF8" stroke-width="2.5"/>
                            <!-- canopy -->
                            <path d="M30 40 Q60 22 90 40" fill="#A855F7" opacity=".3"/>
                            <path d="M30 40 Q60 22 90 40" fill="none" stroke="#A855F7" stroke-width="2.5"/>
                            <!-- handle bar -->
                            <path d="M25 48 L25 35 Q25 28 30 28" fill="none" stroke="#64748B" stroke-width="3" stroke-linecap="round"/>
                            <!-- front leg -->
                            <line x1="40" y1="70" x2="30" y2="88" stroke="#64748B" stroke-width="3" stroke-linecap="round"/>
                            <!-- rear leg -->
                            <line x1="80" y1="70" x2="90" y2="88" stroke="#64748B" stroke-width="3" stroke-linecap="round"/>
                            <!-- wheels -->
                            <circle cx="28" cy="89" r="7" fill="none" stroke="#F5A623" stroke-width="2.5"/>
                            <circle cx="92" cy="89" r="7" fill="none" stroke="#F5A623" stroke-width="2.5"/>
                            <circle cx="28" cy="89" r="2.5" fill="#F5A623"/>
                            <circle cx="92" cy="89" r="2.5" fill="#F5A623"/>
                            <!-- sparkles -->
                            <path d="M100 35 L102 30 L104 35 L109 37 L104 39 L102 44 L100 39 L95 37 Z" fill="#F5A623" opacity=".5"/>
                        </svg>
                    </div>
                    <div class="svc-card__name">Cuci Stroller</div>
                    <div class="svc-card__tag"><i class="bi bi-clock me-1"></i>3–4 Hari</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="svc-card svc-card--amber">
                    <div class="svc-card__illo">
                        <svg viewBox="0 0 120 100" xmlns="http://www.w3.org/2000/svg">
                            <!-- teddy bear ears -->
                            <circle cx="40" cy="30" r="14" fill="#C4956A" opacity=".8"/>
                            <circle cx="80" cy="30" r="14" fill="#C4956A" opacity=".8"/>
                            <circle cx="40" cy="30" r="8" fill="#E8B98A"/>
                            <circle cx="80" cy="30" r="8" fill="#E8B98A"/>
                            <!-- body -->
                            <ellipse cx="60" cy="70" rx="32" ry="28" fill="#C4956A" opacity=".8"/>
                            <!-- head -->
                            <circle cx="60" cy="45" r="24" fill="#C4956A"/>
                            <!-- muzzle -->
                            <ellipse cx="60" cy="55" rx="13" ry="9" fill="#E8B98A"/>
                            <!-- nose -->
                            <ellipse cx="60" cy="51" rx="4" ry="3" fill="#8B5E3C"/>
                            <!-- eyes -->
                            <circle cx="52" cy="43" r="4" fill="#2D2D2D"/>
                            <circle cx="68" cy="43" r="4" fill="#2D2D2D"/>
                            <circle cx="53" cy="42" r="1.5" fill="#fff"/>
                            <circle cx="69" cy="42" r="1.5" fill="#fff"/>
                            <!-- smile -->
                            <path d="M54 57 Q60 62 66 57" fill="none" stroke="#8B5E3C" stroke-width="1.5" stroke-linecap="round"/>
                            <!-- teal glow circle behind -->
                            <circle cx="85" cy="28" r="18" fill="#38BDF8" opacity=".15"/>
                        </svg>
                    </div>
                    <div class="svc-card__name">Cuci Boneka</div>
                    <div class="svc-card__tag"><i class="bi bi-clock me-1"></i>2–4 Hari</div>
                </div>
            </div>
        </div>

        {{-- Dynamic services from database --}}
        @if($layanan->count())
        <!-- <div class="text-center mb-3">
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
<section class="howto-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="svc-badge">Mudah & Cepat</span>
            <h2 class="svc-heading mt-2">Cara Kerja</h2>
            <p class="text-muted mt-1">4 langkah simpel untuk cucian bersih & wangi</p>
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
                    'bg' => '#FEF3C7',
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
// ── Estimasi Harga ───────────────────────────────────────────
function hitungHarga() {
    const sel   = document.getElementById('layanan-sel');
    const opt   = sel.options[sel.selectedIndex];
    const harga = parseFloat(opt.getAttribute('data-harga')) || 0;
    const hari  = opt.getAttribute('data-hari') || 1;
    const berat = parseFloat(document.getElementById('berat-input').value) || 0;
    const total = Math.round(harga * berat);
    document.getElementById('harga-result').textContent = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('est-hari').textContent = 'Estimasi selesai: ' + hari + ' hari';
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
