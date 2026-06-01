@extends('layouts.app')
@section('title', 'Detail Order')
@section('page-title', 'Detail Order')

@section('content')

<div class="page-header mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('order.index') }}" class="btn btn-ghost btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
        <div>
            <div style="font-family:monospace;font-size:1.1rem;font-weight:700;color:#0f172a">
                {{ $order->kode_order }}
            </div>
            <div style="font-size:12px;color:#64748b">
                Masuk {{ $order->tanggal_masuk->format('d M Y') }}
            </div>
        </div>
        <span class="badge badge-{{ $order->status }}" style="font-size:13px;padding:5px 12px">
            {{ ucfirst($order->status) }}
        </span>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('order.edit', $order) }}" class="btn btn-ghost btn-sm">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
    </div>
</div>

<div class="row g-4">
    {{-- DETAIL UTAMA --}}
    <div class="col-lg-8">

        {{-- INFO ORDER --}}
        <div class="card mb-4">
            <div class="card-header">Informasi Order</div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-sm-6">
                        <div style="font-size:12px;color:#94a3b8;font-weight:500;margin-bottom:4px">PELANGGAN</div>
                        <div style="font-weight:600;font-size:15px">{{ $order->pelanggan->nama }}</div>
                        <div style="font-size:13px;color:#64748b;font-family:monospace">{{ $order->pelanggan->no_telp }}</div>
                        @if($order->pelanggan->notif_wa)
                        <span class="badge mt-1" style="background:#f0fdf4;color:#16a34a;font-size:11px">
                            <i class="bi bi-whatsapp me-1"></i>Notif WA aktif
                        </span>
                        @endif
                    </div>
                    <div class="col-sm-6">
                        <div style="font-size:12px;color:#94a3b8;font-weight:500;margin-bottom:4px">KARYAWAN</div>
                        <div style="font-weight:600;font-size:15px">{{ $order->karyawan->nama }}</div>
                        <div style="font-size:13px;color:#64748b">{{ $order->karyawan->jabatan ?? '' }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div style="font-size:12px;color:#94a3b8;font-weight:500;margin-bottom:4px">LAYANAN</div>
                        <div style="font-weight:600;font-size:15px">{{ $order->layanan->nama_layanan }}</div>
                        <div style="font-size:13px;color:#64748b">
                            Rp {{ number_format($order->layanan->harga_per_kg, 0, ',', '.') }}/kg
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div style="font-size:12px;color:#94a3b8;font-weight:500;margin-bottom:4px">BERAT & TOTAL</div>
                        <div style="font-weight:600;font-size:15px">{{ $order->berat_kg }} kg</div>
                        <div style="font-size:14px;font-weight:700;color:#2563eb">
                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div style="font-size:12px;color:#94a3b8;font-weight:500;margin-bottom:4px">TANGGAL MASUK</div>
                        <div style="font-weight:500">{{ $order->tanggal_masuk->format('d F Y') }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div style="font-size:12px;color:#94a3b8;font-weight:500;margin-bottom:4px">EST. SELESAI</div>
                        @php $over = $order->tanggal_selesai->isPast() && !in_array($order->status,['selesai','diambil']); @endphp
                        <div style="font-weight:500;{{ $over ? 'color:#dc2626' : '' }}">
                            @if($over)<i class="bi bi-exclamation-circle me-1"></i>@endif
                            {{ $order->tanggal_selesai->format('d F Y') }}
                        </div>
                    </div>
                    @if($order->catatan)
                    <div class="col-12">
                        <div style="font-size:12px;color:#94a3b8;font-weight:500;margin-bottom:4px">CATATAN</div>
                        <div style="font-size:13.5px;color:#475569;background:#f8fafc;padding:10px 14px;border-radius:8px">
                            {{ $order->catatan }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- UPDATE STATUS --}}
        <div class="card">
            <div class="card-header">Update Status</div>
            <div class="card-body">
                {{-- PROGRESS VISUAL --}}
                <div class="d-flex align-items-center gap-0 mb-4">
                    @php
                    $steps = ['menunggu'=>'Menunggu','diproses'=>'Diproses','selesai'=>'Selesai','diambil'=>'Diambil'];
                    $urutan = ['menunggu'=>0,'diproses'=>1,'selesai'=>2,'diambil'=>3];
                    $cur = $urutan[$order->status] ?? 0;
                    @endphp
                    @foreach($steps as $key => $label)
                    @php $idx = $urutan[$key]; @endphp
                    <div class="d-flex align-items-center" style="flex:{{ !$loop->last ? '1' : '0' }}">
                        <div class="d-flex flex-column align-items-center" style="flex-shrink:0">
                            <div style="
                                width:32px;height:32px;border-radius:50%;
                                display:flex;align-items:center;justify-content:center;
                                font-size:13px;font-weight:600;
                                {{ $idx < $cur  ? 'background:#16a34a;color:#fff' :
                                   ($idx === $cur ? 'background:#2563eb;color:#fff' :
                                                    'background:#f1f5f9;color:#94a3b8') }}
                            ">
                                @if($idx < $cur)
                                    <i class="bi bi-check-lg"></i>
                                @else
                                    {{ $idx + 1 }}
                                @endif
                            </div>
                            <div style="font-size:11px;margin-top:4px;font-weight:500;
                                {{ $idx === $cur ? 'color:#2563eb' : ($idx < $cur ? 'color:#16a34a' : 'color:#94a3b8') }}">
                                {{ $label }}
                            </div>
                        </div>
                        @if(!$loop->last)
                        <div style="flex:1;height:2px;margin-bottom:16px;
                            background:{{ $idx < $cur ? '#16a34a' : '#e2e8f0' }}"></div>
                        @endif
                    </div>
                    @endforeach
                </div>

                <form action="{{ route('order.updateStatus', $order) }}" method="POST" class="d-flex gap-2">
                    @csrf @method('PATCH')
                    <select name="status" class="form-select">
                        @foreach($steps as $key => $label)
                        <option value="{{ $key }}" {{ $order->status == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary text-nowrap">
                        <i class="bi bi-arrow-repeat me-1"></i>Update
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- SIDEBAR PEMBAYARAN --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">Pembayaran</div>
            <div class="card-body">
                @if($order->pembayaran)
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <span style="font-size:13px;color:#64748b">Status</span>
                    <span class="badge badge-lunas">Lunas</span>
                </div>
                @foreach([
                    ['label'=>'Jumlah Bayar','value'=>'Rp '.number_format($order->pembayaran->jumlah_bayar,0,',','.'),'bold'=>true],
                    ['label'=>'Kembalian',   'value'=>'Rp '.number_format($order->pembayaran->kembalian,0,',','.'),'bold'=>false],
                    ['label'=>'Metode',      'value'=>ucfirst($order->pembayaran->metode),'bold'=>false],
                    ['label'=>'Tanggal',     'value'=>$order->pembayaran->tanggal_bayar?->format('d M Y, H:i')??'—','bold'=>false],
                ] as $row)
                <div class="d-flex justify-content-between py-2" style="border-bottom:1px solid #f1f5f9">
                    <span style="font-size:13px;color:#64748b">{{ $row['label'] }}</span>
                    <span style="font-size:13.5px;{{ $row['bold'] ? 'font-weight:700;color:#2563eb' : '' }}">
                        {{ $row['value'] }}
                    </span>
                </div>
                @endforeach
                @else
                <div class="text-center py-4 mb-3">
                    <div style="font-size:36px;opacity:.3;margin-bottom:8px"><i class="bi bi-credit-card"></i></div>
                    <div style="font-size:13px;color:#94a3b8">Belum ada pembayaran</div>
                    <div style="font-size:14px;font-weight:700;color:#2563eb;margin-top:4px">
                        Tagihan: Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                    </div>
                </div>
                <a href="{{ route('pembayaran.create', $order) }}" class="btn btn-primary w-100">
                    <i class="bi bi-cash me-2"></i>Proses Pembayaran
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
