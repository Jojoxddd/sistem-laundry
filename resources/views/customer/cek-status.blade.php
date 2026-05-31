@extends('customer.layout')
@section('title', 'Cek Status Cucian — Bless Laundry')

@push('styles')
<style>
.search-hero { background: var(--sky-light); padding: 48px 0 32px; }
.search-box { max-width: 540px; margin: 0 auto; }
.step-row { display: flex; gap: 16px; padding: 12px 0; }
.step-col { display: flex; flex-direction: column; align-items: center; }
.step-line { width: 2px; flex: 1; min-height: 20px; background: #e2e8f0; }
.step-line.done { background: var(--green); }
.step-content { padding-top: 6px; }
.order-info-card { background: var(--sky-light); border-radius: 14px; padding: 18px 20px; }
</style>
@endpush

@section('content')

<section class="search-hero">
    <div class="container">
        <div class="text-center mb-4">
            <h1 class="fw-semibold" style="font-size:1.8rem;color:var(--sky-dark)">
                <i class="bi bi-search me-2"></i>Cek status cucian
            </h1>
            <p class="text-muted">Masukkan kode order yang kamu terima saat mengantar cucian</p>
        </div>
        <div class="search-box">
            <form method="GET" action="{{ route('customer.cek-status') }}" class="d-flex gap-2">
                <input type="text" name="kode" value="{{ $kode ?? '' }}"
                    class="form-control form-control-lg"
                    placeholder="Contoh: LDR-20260529-0001"
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

        @if($kode && !$order)
        <div class="text-center py-4">
            <div class="mb-3" style="font-size:48px">🔍</div>
            <h5 class="fw-semibold">Kode order tidak ditemukan</h5>
            <p class="text-muted">Pastikan kode yang kamu masukkan sudah benar.<br>Kode order biasanya berformat <strong>LDR-YYYYMMDD-XXXX</strong></p>
        </div>
        @elseif($order)

        {{-- INFO ORDER --}}
        <div class="bl-card mx-auto mb-4" style="max-width:600px">
            <div class="order-info-card mb-3">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="small text-muted mb-1">Kode order</div>
                        <div class="fw-semibold" style="color:var(--sky-dark)">{{ $order->kode_order }}</div>
                    </div>
                    <div class="col-6">
                        <div class="small text-muted mb-1">Nama pelanggan</div>
                        <div class="fw-semibold">{{ $order->pelanggan->nama }}</div>
                    </div>
                    <div class="col-6">
                        <div class="small text-muted mb-1">Layanan</div>
                        <div class="fw-semibold">{{ $order->layanan->nama_layanan }}</div>
                    </div>
                    <div class="col-6">
                        <div class="small text-muted mb-1">Berat</div>
                        <div class="fw-semibold">{{ $order->berat_kg }} kg</div>
                    </div>
                    <div class="col-6">
                        <div class="small text-muted mb-1">Total harga</div>
                        <div class="fw-semibold" style="color:var(--sky-dark)">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</div>
                    </div>
                    <div class="col-6">
                        <div class="small text-muted mb-1">Status pembayaran</div>
                        @if($order->pembayaran && $order->pembayaran->status === 'lunas')
                            <span class="badge rounded-pill" style="background:var(--green-light);color:var(--green-dark)">
                                <i class="bi bi-check-circle me-1"></i>Lunas
                            </span>
                        @else
                            <span class="badge rounded-pill" style="background:#FEF9C3;color:#713F12">
                                <i class="bi bi-clock me-1"></i>Belum lunas
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- LIVE TRACKING --}}
            <h6 class="fw-semibold mb-3">Status terkini</h6>

            @php
            $steps = [
                ['key' => 'menunggu', 'label' => 'Order diterima',    'icon' => 'bi-bag-check',      'desc' => 'Cucian sudah diterima di outlet'],
                ['key' => 'diproses', 'label' => 'Sedang diproses',   'icon' => 'bi-arrow-repeat',   'desc' => 'Cucian sedang dicuci / disetrika'],
                ['key' => 'selesai',  'label' => 'Siap diambil',      'icon' => 'bi-check2-circle',  'desc' => 'Cucian sudah selesai dan siap diambil'],
                ['key' => 'diambil',  'label' => 'Selesai / diambil', 'icon' => 'bi-house-check',    'desc' => 'Cucian sudah diambil oleh pelanggan'],
            ];
            $urutan = ['menunggu' => 0, 'diproses' => 1, 'selesai' => 2, 'diambil' => 3];
            $currentIndex = $urutan[$order->status] ?? 0;
            @endphp

            @foreach($steps as $i => $step)
            <div class="step-row">
                <div class="step-col">
                    @php
                    $isDone   = $i < $currentIndex;
                    $isActive = $i === $currentIndex;
                    $isPending= $i > $currentIndex;
                    @endphp
                    <div class="step-circle {{ $isDone ? 'step-done' : ($isActive ? 'step-active' : 'step-pending') }}">
                        @if($isDone)
                            <i class="bi bi-check-lg"></i>
                        @elseif($isActive)
                            <i class="bi {{ $step['icon'] }}"></i>
                        @else
                            {{ $i + 1 }}
                        @endif
                    </div>
                    @if(!$loop->last)
                    <div class="step-line {{ $isDone ? 'done' : '' }}"></div>
                    @endif
                </div>
                <div class="step-content pb-2">
                    <div class="fw-semibold" style="font-size:14px;color:{{ $isActive ? 'var(--sky-dark)' : ($isDone ? 'var(--green-dark)' : '#94a3b8') }}">
                        {{ $step['label'] }}
                        @if($isActive) <span class="badge rounded-pill ms-1" style="background:var(--sky-light);color:var(--sky-dark);font-size:11px">sekarang</span> @endif
                    </div>
                    <div class="text-muted" style="font-size:12px">{{ $step['desc'] }}</div>
                    @if($i === 0)
                        <div class="text-muted" style="font-size:12px"><i class="bi bi-calendar3 me-1"></i>{{ $order->tanggal_masuk->format('d M Y') }}</div>
                    @elseif($i === 2 && $order->tanggal_selesai)
                        <div class="text-muted" style="font-size:12px"><i class="bi bi-calendar3 me-1"></i>Estimasi: {{ $order->tanggal_selesai->format('d M Y') }}</div>
                    @endif
                </div>
            </div>
            @endforeach

            @if($order->catatan)
            <div class="mt-3 p-3 rounded-3" style="background:#f8fafc;font-size:13px">
                <i class="bi bi-chat-text me-2 text-muted"></i><span class="text-muted">Catatan:</span> {{ $order->catatan }}
            </div>
            @endif
        </div>

        {{-- LOYALTY PROMO --}}
        <div class="text-center mt-3">
            <a href="{{ route('customer.loyalty') }}" class="btn btn-sky-outline">
                <i class="bi bi-trophy me-2"></i>Cek poin loyalty saya
            </a>
        </div>

        @else
        {{-- STATE AWAL --}}
        <div class="text-center py-5 text-muted">
            <div class="mb-3" style="font-size:56px;opacity:.3"><i class="bi bi-search"></i></div>
            <p>Masukkan kode order di atas untuk melihat status cucianmu</p>
        </div>
        @endif

    </div>
</section>
@endsection
