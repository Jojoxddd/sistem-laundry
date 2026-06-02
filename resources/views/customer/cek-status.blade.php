@extends('customer.layout')
@section('title', 'Cek Status Cucian')

@push('styles')
<style>
.status-hero { background: var(--sky-light); padding: 48px 0 36px; }
.search-box  { max-width: 520px; margin: 0 auto; }

/* step tracker */
.step-row  { display: flex; gap: 14px; padding: 10px 0; }
.step-col  { display: flex; flex-direction: column; align-items: center; }
.step-line { width: 2px; flex: 1; min-height: 18px; background: #e2e8f0; }
.step-line.done { background: var(--green-dark); }

.step-circle {
    width: 36px; height: 36px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; font-weight: 700; flex-shrink: 0;
}
.step-done    { background: var(--green-light); color: var(--green-dark); border: 2px solid var(--green-dark); }
.step-active  { background: var(--sky-dark);    color: #fff; border: 2px solid var(--sky-dark); }
.step-pending { background: #f1f5f9; color: #94a3b8; border: 2px solid #e2e8f0; }

.step-content { padding-top: 6px; padding-bottom: 4px; }

.order-info-card { background: var(--sky-light); border-radius: 14px; padding: 18px 20px; }

.status-badge-lunas  { background: var(--green-light); color: var(--green-dark); }
.status-badge-belum  { background: #FEF3C7; color: #713F12; }
</style>
@endpush

@section('content')

<section class="status-hero">
    <div class="container">
        <div class="text-center mb-4">
            <h1 class="fw-bold mb-1" style="font-size:1.75rem;color:#0f172a">
                Ingin tahu cucianmu lagi di mana?
            </h1>
            <p class="text-muted" style="font-size:14px">Masukkan kode order yang kamu dapat waktu antar cucian</p>
        </div>
        <div class="search-box">
            <form method="GET" action="{{ route('customer.cek-status') }}" class="d-flex gap-2">
                <input type="text" name="kode" value="{{ $kode ?? '' }}"
                    class="form-control form-control-lg"
                    placeholder="Contoh: LDR-20260529-0001"
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

        @if($kode && !$order)
        <div class="text-center py-5">
            <div class="mb-3" style="font-size:48px">🔍</div>
            <h5 class="fw-semibold mb-1">Kode tidak ditemukan</h5>
            <p class="text-muted" style="font-size:14px">
                Pastikan kodenya sudah benar ya.<br>
                Formatnya biasanya <strong>LDR-YYYYMMDD-XXXX</strong>
            </p>
        </div>

        @elseif($order)

        <div class="bl-card mx-auto mb-4" style="max-width:580px">

            {{-- Info order --}}
            <div class="order-info-card mb-4">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="small text-muted mb-1">Kode order</div>
                        <div class="fw-bold" style="color:var(--sky-dark)">{{ $order->kode_order }}</div>
                    </div>
                    <div class="col-6">
                        <div class="small text-muted mb-1">Nama</div>
                        <div class="fw-semibold">{{ $order->pelanggan->nama }}</div>
                    </div>
                    <div class="col-6">
                        <div class="small text-muted mb-1">Layanan</div>
                        <div class="fw-semibold">{{ $order->layanan->nama_layanan }}</div>
                    </div>
                    <div class="col-6">
                        <div class="small text-muted mb-1">Berat / Jumlah</div>
                        <div class="fw-semibold">{{ $order->berat_kg }} kg</div>
                    </div>
                    <div class="col-6">
                        <div class="small text-muted mb-1">Total</div>
                        <div class="fw-bold" style="color:var(--sky-dark)">
                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="small text-muted mb-1">Pembayaran</div>
                        @if($order->pembayaran && $order->pembayaran->status === 'lunas')
                            <span class="badge rounded-pill status-badge-lunas">
                                <i class="bi bi-check-circle me-1"></i>Lunas
                            </span>
                        @else
                            <span class="badge rounded-pill status-badge-belum">
                                <i class="bi bi-clock me-1"></i>Sudah lunas
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Step tracker --}}
            <div class="fw-semibold mb-3" style="font-size:14px">Status terkini</div>

            @php
            $steps = [
                ['key'=>'menunggu','label'=>'Order diterima',   'icon'=>'bi-bag-check',    'desc'=>'Cucian sudah masuk ke outlet'],
                ['key'=>'diproses','label'=>'Lagi diproses',    'icon'=>'bi-arrow-repeat', 'desc'=>'Sedang dicuci atau disetrika'],
                ['key'=>'selesai', 'label'=>'Siap diambil',     'icon'=>'bi-check2-circle','desc'=>'Cucian sudah selesai, bisa diambil'],
                ['key'=>'diambil', 'label'=>'Selesai',          'icon'=>'bi-house-check',  'desc'=>'Cucian sudah diambil'],
            ];
            $urutan = ['menunggu'=>0,'diproses'=>1,'selesai'=>2,'diambil'=>3];
            $currentIndex = $urutan[$order->status] ?? 0;
            @endphp

            @foreach($steps as $i => $step)
            @php
            $isDone    = $i < $currentIndex;
            $isActive  = $i === $currentIndex;
            @endphp
            <div class="step-row">
                <div class="step-col">
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
                <div class="step-content">
                    <div class="fw-semibold" style="font-size:14px;color:{{ $isActive ? 'var(--sky-dark)' : ($isDone ? 'var(--green-dark)' : '#94a3b8') }}">
                        {{ $step['label'] }}
                        @if($isActive)
                        <span class="badge rounded-pill ms-1" style="background:var(--sky-light);color:var(--sky-dark);font-size:10px;font-weight:500">sekarang</span>
                        @endif
                    </div>
                    <div class="text-muted" style="font-size:12px;line-height:1.5">{{ $step['desc'] }}</div>
                    @if($i === 0)
                        <div class="text-muted" style="font-size:11px"><i class="bi bi-calendar3 me-1"></i>{{ $order->tanggal_masuk->format('d M Y') }}</div>
                    @elseif($i === 2 && $order->tanggal_selesai)
                        <div class="text-muted" style="font-size:11px"><i class="bi bi-calendar3 me-1"></i>Estimasi selesai: {{ $order->tanggal_selesai->format('d M Y') }}</div>
                    @endif
                </div>
            </div>
            @endforeach

            @if($order->catatan)
            <div class="mt-3 p-3 rounded-3" style="background:#f8fafc;font-size:13px;color:#64748b">
                <i class="bi bi-chat-text me-2"></i>{{ $order->catatan }}
            </div>
            @endif
        </div>

        <!-- <div class="text-center mt-2">
            <a href="{{ route('customer.loyalty') }}" class="btn btn-sky-outline">
                <i class="bi bi-trophy me-2"></i>Cek poin loyalty saya
            </a>
        </div> -->

        @else
        <div class="text-center py-5 text-muted">
            <div class="mb-3" style="font-size:52px;opacity:.2"><i class="bi bi-search"></i></div>
            <p style="font-size:14px">Masukkan kode order di atas untuk lihat status cucianmu</p>
        </div>
        @endif

    </div>
</section>
@endsection
