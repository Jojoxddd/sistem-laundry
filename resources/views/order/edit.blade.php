@extends('layouts.app')

@section('title', 'Edit Order')
@section('page-title', 'Edit Order')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <i class="bi bi-pencil me-2"></i>Edit Order {{ $order->kode_order }}
            </div>
            <div class="card-body">
                <form action="{{ route('order.update', $order) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Pelanggan <span class="text-danger">*</span></label>
                            <select name="pelanggan_id" class="form-select" required>
                                @foreach($pelanggan as $p)
                                <option value="{{ $p->id }}" {{ $order->pelanggan_id == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Karyawan <span class="text-danger">*</span></label>
                            <select name="karyawan_id" class="form-select" required>
                                @foreach($karyawan as $k)
                                <option value="{{ $k->id }}" {{ $order->karyawan_id == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Layanan <span class="text-danger">*</span></label>
                            <select name="layanan_id" class="form-select" required>
                                @foreach($layanan as $l)
                                <option value="{{ $l->id }}" {{ $order->layanan_id == $l->id ? 'selected' : '' }}>
                                    {{ $l->nama_layanan }} - Rp {{ number_format($l->harga_per_kg, 0, ',', '.') }}/kg
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Berat (kg) <span class="text-danger">*</span></label>
                            <input type="number" name="berat_kg" step="0.1" min="0.1"
                                class="form-control" value="{{ $order->berat_kg }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select" required>
                                @foreach(['menunggu','diproses','selesai','diambil'] as $s)
                                <option value="{{ $s }}" {{ $order->status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" class="form-control"
                                value="{{ $order->tanggal_masuk->format('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control"
                                value="{{ $order->tanggal_selesai->format('Y-m-d') }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Catatan</label>
                            <textarea name="catatan" class="form-control" rows="2">{{ $order->catatan }}</textarea>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-warning"><i class="bi bi-save me-1"></i> Update</button>
                        <a href="{{ route('order.show', $order) }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
