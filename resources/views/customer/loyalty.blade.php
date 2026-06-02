@extends('customer.layout')
@section('title', 'Loyalty Points')

@push('styles')
<style>
.loyalty-hero { background: var(--sky-light); padding: 48px 0 36px; }
.search-box   { max-width: 480px; margin: 0 auto; }

/* Kartu poin — flat, no gradient */
.poin-card {
    border: 1.5px solid #e2e8f0;
    border-radius: 18px;
    padding: 24px;
    background: #fff;
}
.poin-card__num  { font-size: 3rem; font-weight: 800; color: #0f172a; line-height: 1; }
.poin-card__sub  { font-size: 13px; color: #94a3b8; margin-top: 2px; margin-bottom: 20px; }
.poin-card__bar  { background: #f1f5f9; border-radius: 99px; height: 7px; margin-bottom: 6px; }
.poin-card__fill { background: var(--sky-dark); border-radius: 99px; height: 100%; transition: width .5s; }
.poin-card__hint { font-size: 12px; color: #94a3b8; }
.poin-card__note { font-size: 12px; color: #94a3b8; border-top: 1px solid #f1f5f9; margin-top: 16px; padding-top: 12px; }

/* Level badge */
.level-badge { font-size: 12px; font-weight: 600; padding: 4px 12px; border-radius: 99px; }
.badge-bronze  { background: #FEF3C7; color: #92400E; }
.badge-silver  { background: #f1f5f9; color: #475569; }
.badge-gold    { background: #FEF9C3; color: #713F12; }
.badge-platinum{ background: var(--sky-light); color: var(--sky-dark); }

/* Riwayat */
.tx-row { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #f8fafc; }
.tx-row:last-child { border-bottom: none; }

/* Reward card */
.reward-card {
    border: 1.5px solid #e2e8f0; border-radius: 14px;
    padding: 18px 14px; text-align: center;
    transition: transform .2s, box-shadow .2s;
    height: 100%;
}
.reward-card:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(2,132,199,.08); }
.reward-card.featured { border-color: var(--sky-dark); }
.reward-poin { font-size: 15px; font-weight: 700; color: var(--sky-dark); }

/* Info cara dapat poin */
.info-card {
    background: #fff; border: 1.5px solid #e2e8f0;
    border-radius: 14px; padding: 16px 18px;
    display: flex; align-items: flex-start; gap: 14px;
}
.info-card__icon {
    width: 38px; height: 38px; border-radius: 10px;
    background: var(--sky-light); color: var(--sky-dark);
    display: flex; align-items: center; justify-content: center;
    font-size: 17px; flex-shrink: 0;
}

/* Level table */
.level-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: 10px 14px; border-radius: 10px; background: #f8fafc;
}
</style>
@endpush

@section('content')

<section class="loyalty-hero">
    <div class="container">
        <div class="text-center mb-4">
            <h1 class="fw-bold mb-1" style="font-size:1.75rem;color:#0f172a">
                Pengen liat poin kamu berapa?
            </h1>
            <p class="text-muted" style="font-size:14px">Masukkan nomor WhatsApp yang terdaftar di outlet</p>
        </div>
        <div class="search-box">
            <form method="GET" action="{{ route('customer.loyalty') }}" class="d-flex gap-2">
                <input type="text" name="no_telp" value="{{ $noTelp ?? '' }}"
                    class="form-control form-control-lg"
                    placeholder="Nomor WhatsApp terdaftar"
                    style="border-radius:50px;padding-left:20px">
                <button type="submit" class="btn btn-sky btn-lg px-4" style="white-space:nowrap">
                    Cek
                </button>
            </form>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">

        @if($noTelp && !$pelanggan)
        <div class="text-center py-5">
            <div class="mb-3" style="font-size:48px">🔍</div>
            <h5 class="fw-semibold mb-1">Nomor tidak ditemukan</h5>
            <p class="text-muted" style="font-size:14px">Pastikan nomornya sama dengan yang terdaftar di outlet ya.</p>
        </div>

        @elseif($pelanggan && $loyalty)
        <div class="row g-4 justify-content-center">

            {{-- Kiri: kartu poin + riwayat --}}
            <div class="col-lg-4">
                <div class="poin-card mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="text-muted" style="font-size:13px">Halo, {{ $pelanggan->nama }} 👋</div>
                        <span class="level-badge
                            @if($loyalty->level === 'Platinum') badge-platinum
                            @elseif($loyalty->level === 'Gold') badge-gold
                            @elseif($loyalty->level === 'Silver') badge-silver
                            @else badge-bronze @endif">
                            {{ $loyalty->level }}
                        </span>
                    </div>
                    <div class="poin-card__num">{{ number_format($loyalty->total_poin, 0, ',', '.') }}</div>
                    <div class="poin-card__sub">poin terkumpul</div>

                    @if($loyalty->level !== 'Platinum')
                    @php
                    $targetPoin = ['Bronze'=>500,'Silver'=>2000,'Gold'=>5000][$loyalty->level] ?? 500;
                    $startPoin  = ['Bronze'=>0,'Silver'=>500,'Gold'=>2000][$loyalty->level] ?? 0;
                    $progress   = min(100, round(($loyalty->total_poin - $startPoin) / ($targetPoin - $startPoin) * 100));
                    @endphp
                    <div class="poin-card__bar">
                        <div class="poin-card__fill" style="width:{{ $progress }}%"></div>
                    </div>
                    <div class="poin-card__hint">
                        {{ number_format($loyalty->poinKeLevelBerikutnya(), 0, ',', '.') }} poin lagi → level <strong>{{ $loyalty->levelBerikutnya() }}</strong>
                    </div>
                    @else
                    <div class="poin-card__hint">Kamu sudah di level tertinggi 🎉</div>
                    @endif

                    <div class="poin-card__note">
                        <i class="bi bi-info-circle me-1"></i>Rp 1.000 = 1 poin · masuk otomatis tiap transaksi
                    </div>
                </div>

                @if($transaksi->count())
                <div class="bl-card">
                    <div class="fw-semibold mb-3" style="font-size:14px">Riwayat poin</div>
                    @foreach($transaksi as $tx)
                    <div class="tx-row">
                        <div>
                            <div style="font-size:13px;font-weight:500">{{ $tx->keterangan }}</div>
                            <div class="text-muted" style="font-size:11px">{{ $tx->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        <div class="fw-bold" style="color:{{ $tx->poin > 0 ? 'var(--green-dark)' : '#DC2626' }};font-size:14px">
                            {{ $tx->poin > 0 ? '+' : '' }}{{ number_format($tx->poin, 0, ',', '.') }}
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Kanan: reward --}}
            <div class="col-lg-7">
                <div class="fw-semibold mb-1" style="font-size:16px">Tukar poin dengan reward</div>
                <p class="text-muted mb-4" style="font-size:13px">Poin kamu cukup? Langsung tukar sekarang.</p>
                <div class="row g-3">
                    @foreach($rewards as $i => $reward)
                    <div class="col-6 col-md-4">
                        <div class="reward-card h-100 {{ $i === 1 ? 'featured' : '' }}">
                            @if($i === 1)
                            <div class="mb-2">
                            </div>
                            @endif
                            <div class="fs-2 mb-2" style="color:var(--sky-dark)">
                                <i class="bi {{ $reward['icon'] }}"></i>
                            </div>
                            <div class="reward-poin mb-1">{{ number_format($reward['poin'], 0, ',', '.') }} poin</div>
                            <div class="text-muted mb-3" style="font-size:12px">{{ $reward['nama'] }}</div>

                            @if($loyalty->total_poin >= $reward['poin'])
                            <form action="{{ route('customer.loyalty.tukar') }}" method="POST">
                                @csrf
                                <input type="hidden" name="pelanggan_id" value="{{ $pelanggan->id }}">
                                <input type="hidden" name="reward_id" value="{{ $reward['id'] }}">
                                <button type="submit" class="btn btn-sky btn-sm w-100"
                                    onclick="return confirm('Tukar {{ $reward['poin'] }} poin dengan {{ $reward['nama'] }}?')">
                                    Tukar
                                </button>
                            </form>
                            @else
                            <div class="text-muted" style="font-size:11px">
                                Kurang {{ number_format($reward['poin'] - $loyalty->total_poin, 0, ',', '.') }} poin
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        @else
        {{-- State awal --}}
        <div class="row g-4 justify-content-center">
            <div class="col-lg-4">
                <div class="text-center py-4 text-muted">
                    <div class="mb-3" style="font-size:52px;opacity:.2"><i class="bi bi-trophy"></i></div>
                    <p style="font-size:14px">Masukkan nomor WhatsApp terdaftar untuk cek poin kamu</p>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="fw-semibold mb-3" style="font-size:15px">Cara dapat poin</div>
                <div class="d-flex flex-column gap-3 mb-4">
                    @foreach([
                        ['icon'=>'bi-bag-check', 'judul'=>'Tiap transaksi laundry',  'desc'=>'Setiap Rp 1.000 yang kamu bayar otomatis dapat 1 poin'],
                        ['icon'=>'bi-person-plus','judul'=>'Bonus daftar pertama',   'desc'=>'50 poin langsung masuk waktu pertama kali daftar'],
                        ['icon'=>'bi-star',       'judul'=>'Layanan tertentu',        'desc'=>'Beberapa layanan kasih poin 2x lipat'],
                    ] as $item)
                    <div class="info-card">
                        <div class="info-card__icon"><i class="bi {{ $item['icon'] }}"></i></div>
                        <div>
                            <div class="fw-semibold" style="font-size:14px">{{ $item['judul'] }}</div>
                            <div class="text-muted" style="font-size:13px">{{ $item['desc'] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="fw-semibold mb-3" style="font-size:15px">Level membership</div>
                <div class="d-flex flex-column gap-2">
                    @foreach([
                        ['level'=>'Bronze', 'range'=>'0 – 499 poin',    'class'=>'badge-bronze'],
                        ['level'=>'Silver', 'range'=>'500 – 1.999 poin', 'class'=>'badge-silver'],
                        ['level'=>'Gold',   'range'=>'2.000 – 4.999 poin','class'=>'badge-gold'],
                        ['level'=>'Platinum','range'=>'5.000+ poin',     'class'=>'badge-platinum'],
                    ] as $lv)
                    <div class="level-row">
                        <span class="level-badge {{ $lv['class'] }}">{{ $lv['level'] }}</span>
                        <span class="text-muted" style="font-size:13px">{{ $lv['range'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

    </div>
</section>
@endsection
