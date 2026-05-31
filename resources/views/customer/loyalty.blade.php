@extends('customer.layout')
@section('title', 'Loyalty Points — Bless Laundry')

@push('styles')
<style>
.loyalty-hero { background: linear-gradient(135deg, var(--sky-light) 0%, var(--green-light) 100%); padding: 48px 0 32px; }
.points-big { font-size: 3rem; font-weight: 700; color: var(--sky-dark); }
.level-badge { font-size: 14px; font-weight: 600; padding: 6px 16px; border-radius: 20px; }
.progress-track { background: #e2e8f0; border-radius: 8px; height: 10px; }
.progress-fill  { background: var(--sky-dark); border-radius: 8px; height: 10px; transition: width .5s; }
.reward-card {
    border: 1px solid #e2e8f0; border-radius: 14px; padding: 18px;
    text-align: center; transition: transform .2s;
}
.reward-card:hover { transform: translateY(-3px); }
.reward-card.featured { border: 2px solid var(--sky-dark); }
.reward-poin { font-size: 1.1rem; font-weight: 700; color: var(--sky-dark); }
.tx-row { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #f1f5f9; }
.tx-row:last-child { border-bottom: none; }
</style>
@endpush

@section('content')

<section class="loyalty-hero">
    <div class="container">
        <div class="text-center mb-4">
            <h1 class="fw-semibold" style="font-size:1.8rem;color:var(--sky-dark)">
                <i class="bi bi-trophy me-2"></i>Loyalty points
            </h1>
            <p class="text-muted">Kumpulkan poin dari setiap laundry dan tukar dengan hadiah menarik</p>
        </div>

        <div class="search-box mx-auto" style="max-width:480px">
            <form method="GET" action="{{ route('customer.loyalty') }}" class="d-flex gap-2">
                <input type="text" name="no_telp" value="{{ $noTelp ?? '' }}"
                    class="form-control form-control-lg"
                    placeholder="Masukkan nomor WhatsApp terdaftar"
                    style="border-radius:12px">
                <button type="submit" class="btn btn-sky btn-lg px-4" style="white-space:nowrap">
                    <i class="bi bi-search me-1"></i>Cek
                </button>
            </form>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">

        @if($noTelp && !$pelanggan)
        <div class="text-center py-4">
            <div class="mb-3" style="font-size:48px">🔍</div>
            <h5 class="fw-semibold">Nomor tidak terdaftar</h5>
            <p class="text-muted">Pastikan nomor yang kamu masukkan sama dengan yang terdaftar di outlet.</p>
        </div>

        @elseif($pelanggan && $loyalty)
        <div class="row g-4 justify-content-center">

            {{-- KARTU POIN --}}
            <div class="col-lg-5">
                <div class="bl-card mb-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <div class="text-muted small">Halo, {{ $pelanggan->nama }}</div>
                            <div class="points-big">{{ number_format($loyalty->total_poin, 0, ',', '.') }}</div>
                            <div class="text-muted small">total poin</div>
                        </div>
                        <span class="level-badge
                            @if($loyalty->level === 'Platinum') badge-platinum
                            @elseif($loyalty->level === 'Gold') badge-gold
                            @elseif($loyalty->level === 'Silver') badge-silver
                            @else badge-bronze @endif">
                            <i class="bi bi-star-fill me-1"></i>{{ $loyalty->level }}
                        </span>
                    </div>

                    @if($loyalty->level !== 'Platinum')
                    @php
                    $targetPoin = ['Bronze'=>500,'Silver'=>2000,'Gold'=>5000][$loyalty->level] ?? 500;
                    $startPoin  = ['Bronze'=>0,'Silver'=>500,'Gold'=>2000][$loyalty->level] ?? 0;
                    $progress   = min(100, round(($loyalty->total_poin - $startPoin) / ($targetPoin - $startPoin) * 100));
                    @endphp
                    <div class="progress-track mb-2">
                        <div class="progress-fill" style="width:{{ $progress }}%"></div>
                    </div>
                    <div class="text-muted" style="font-size:12px">
                        {{ number_format($loyalty->poinKeLevelBerikutnya(), 0, ',', '.') }} poin lagi untuk level
                        <strong>{{ $loyalty->levelBerikutnya() }}</strong>
                    </div>
                    @else
                    <div class="text-muted" style="font-size:12px"><i class="bi bi-trophy-fill me-1" style="color:var(--sky-dark)"></i>Kamu sudah di level tertinggi! 🎉</div>
                    @endif

                    <hr>
                    <div class="small text-muted">
                        <i class="bi bi-info-circle me-1"></i>Setiap Rp 1.000 = 1 poin · Poin otomatis ditambah setelah pembayaran
                    </div>
                </div>

                {{-- RIWAYAT --}}
                @if($transaksi->count())
                <div class="bl-card">
                    <h6 class="fw-semibold mb-3">Riwayat poin</h6>
                    @foreach($transaksi as $tx)
                    <div class="tx-row">
                        <div>
                            <div style="font-size:13px;font-weight:500">{{ $tx->keterangan }}</div>
                            <div class="text-muted" style="font-size:12px">{{ $tx->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        <div class="fw-semibold" style="color:{{ $tx->poin > 0 ? 'var(--green-dark)' : '#DC2626' }}">
                            {{ $tx->poin > 0 ? '+' : '' }}{{ number_format($tx->poin, 0, ',', '.') }}
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- REWARD --}}
            <div class="col-lg-7">
                <h5 class="fw-semibold mb-3">Tukar poin dengan reward</h5>
                <div class="row g-3">
                    @foreach($rewards as $i => $reward)
                    <div class="col-6 col-md-4">
                        <div class="reward-card h-100 {{ $i === 1 ? 'featured' : '' }}">
                            @if($i === 1)
                            <div class="mb-2">
                                <span class="badge rounded-pill" style="background:var(--sky-light);color:var(--sky-dark);font-size:11px">Populer</span>
                            </div>
                            @endif
                            <div class="fs-2 mb-2" style="color:var(--sky-dark)"><i class="bi {{ $reward['icon'] }}"></i></div>
                            <div class="reward-poin">{{ number_format($reward['poin'], 0, ',', '.') }} poin</div>
                            <div class="text-muted mb-3" style="font-size:13px">{{ $reward['nama'] }}</div>

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
                            <button class="btn btn-sm w-100" style="background:#f1f5f9;color:#94a3b8" disabled>
                                Poin kurang
                            </button>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        @else
        {{-- STATE AWAL --}}
        <div class="row g-4 justify-content-center">
            <div class="col-md-4 text-center">
                <div class="py-5 text-muted">
                    <div class="mb-3" style="font-size:56px;opacity:.3"><i class="bi bi-trophy"></i></div>
                    <p>Masukkan nomor WhatsApp terdaftar untuk cek poin loyalty kamu</p>
                </div>
            </div>
            {{-- INFO CARA DAPAT POIN --}}
            <div class="col-md-8">
                <h5 class="fw-semibold mb-3">Cara mendapatkan poin</h5>
                <div class="row g-3">
                    @foreach([
                        ['icon'=>'bi-bag-check','judul'=>'Setiap laundry','desc'=>'Setiap Rp 1.000 yang kamu bayar = 1 poin otomatis'],
                        ['icon'=>'bi-person-plus','judul'=>'Daftar pertama','desc'=>'Dapatkan 50 poin bonus saat pertama kali daftar'],
                        ['icon'=>'bi-star','judul'=>'Layanan premium','desc'=>'Poin 2x lipat untuk layanan cuci express'],
                    ] as $item)
                    <div class="col-md-4">
                        <div class="bl-card h-100 text-center">
                            <div class="fs-2 mb-2" style="color:var(--sky-dark)"><i class="bi {{ $item['icon'] }}"></i></div>
                            <div class="fw-semibold mb-1" style="font-size:14px">{{ $item['judul'] }}</div>
                            <div class="text-muted" style="font-size:13px">{{ $item['desc'] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <h5 class="fw-semibold mt-4 mb-3">Level membership</h5>
                <div class="row g-2">
                    @foreach([
                        ['level'=>'Bronze','min'=>'0','max'=>'499','class'=>'badge-bronze'],
                        ['level'=>'Silver','min'=>'500','max'=>'1.999','class'=>'badge-silver'],
                        ['level'=>'Gold','min'=>'2.000','max'=>'4.999','class'=>'badge-gold'],
                        ['level'=>'Platinum','min'=>'5.000+','max'=>'','class'=>'badge-platinum'],
                    ] as $lv)
                    <div class="col-6 col-md-3">
                        <div class="text-center p-3 rounded-3" style="background:#f8fafc">
                            <span class="level-badge {{ $lv['class'] }} d-inline-block mb-2">{{ $lv['level'] }}</span>
                            <div class="text-muted" style="font-size:12px">{{ $lv['min'] }}{{ $lv['max'] ? ' – '.$lv['max'] : '' }} poin</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

    </div>
</section>
@endsection
