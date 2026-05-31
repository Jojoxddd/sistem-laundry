<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pelanggan;
use App\Models\Karyawan;
use App\Models\Layanan;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected WhatsAppService $wa;

    public function __construct(WhatsAppService $wa)
    {
        $this->wa = $wa;
    }

    public function index()
    {
        $orders = Order::with(['pelanggan', 'karyawan', 'layanan', 'pembayaran'])
            ->latest()->paginate(10);
        return view('order.index', compact('orders'));
    }

    public function create()
    {
        $pelanggan = Pelanggan::orderBy('nama')->get();
        $karyawan  = Karyawan::where('status', 'aktif')->orderBy('nama')->get();
        $layanan   = Layanan::orderBy('nama_layanan')->get();
        return view('order.create', compact('pelanggan', 'karyawan', 'layanan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id'    => 'required|exists:pelanggan,id',
            'karyawan_id'     => 'required|exists:karyawan,id',
            'layanan_id'      => 'required|exists:layanan,id',
            'berat_kg'        => 'required|numeric|min:0.1',
            'tanggal_masuk'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_masuk',
            'catatan'         => 'nullable|string',
        ]);

        $layanan     = Layanan::findOrFail($request->layanan_id);
        $total_harga = $layanan->harga_per_kg * $request->berat_kg;

        $order = Order::create([
            'kode_order'      => Order::generateKodeOrder(),
            'pelanggan_id'    => $request->pelanggan_id,
            'karyawan_id'     => $request->karyawan_id,
            'layanan_id'      => $request->layanan_id,
            'berat_kg'        => $request->berat_kg,
            'total_harga'     => $total_harga,
            'tanggal_masuk'   => $request->tanggal_masuk,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status'          => 'menunggu',
            'catatan'         => $request->catatan,
        ]);

        // ── Notif WA: order diterima ─────────────────────────
        $pelanggan = Pelanggan::find($request->pelanggan_id);
        if ($pelanggan && $pelanggan->notif_wa && $pelanggan->no_telp) {
            $this->wa->notifOrderDiterima(
                $pelanggan->no_telp,
                $pelanggan->nama,
                $order->kode_order,
                $layanan->nama_layanan,
                $request->berat_kg,
                $total_harga
            );
        }
        // ─────────────────────────────────────────────────────

        return redirect()->route('order.index')->with('success', 'Order berhasil dibuat!');
    }

    public function show(Order $order)
    {
        $order->load(['pelanggan', 'karyawan', 'layanan', 'pembayaran']);
        return view('order.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $pelanggan = Pelanggan::orderBy('nama')->get();
        $karyawan  = Karyawan::where('status', 'aktif')->orderBy('nama')->get();
        $layanan   = Layanan::orderBy('nama_layanan')->get();
        return view('order.edit', compact('order', 'pelanggan', 'karyawan', 'layanan'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'pelanggan_id'    => 'required|exists:pelanggan,id',
            'karyawan_id'     => 'required|exists:karyawan,id',
            'layanan_id'      => 'required|exists:layanan,id',
            'berat_kg'        => 'required|numeric|min:0.1',
            'tanggal_masuk'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_masuk',
            'status'          => 'required|in:menunggu,diproses,selesai,diambil',
            'catatan'         => 'nullable|string',
        ]);

        $layanan     = Layanan::findOrFail($request->layanan_id);
        $total_harga = $layanan->harga_per_kg * $request->berat_kg;
        $statusLama  = $order->status;

        $order->update([
            'pelanggan_id'    => $request->pelanggan_id,
            'karyawan_id'     => $request->karyawan_id,
            'layanan_id'      => $request->layanan_id,
            'berat_kg'        => $request->berat_kg,
            'total_harga'     => $total_harga,
            'tanggal_masuk'   => $request->tanggal_masuk,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status'          => $request->status,
            'catatan'         => $request->catatan,
        ]);

        // ── Notif WA jika status berubah ─────────────────────
        if ($statusLama !== $request->status) {
            $pelanggan = Pelanggan::find($request->pelanggan_id);
            if ($pelanggan && $pelanggan->notif_wa && $pelanggan->no_telp) {
                $this->wa->notifStatusBerubah(
                    $pelanggan->no_telp,
                    $pelanggan->nama,
                    $order->kode_order,
                    $request->status
                );
            }
        }
        // ─────────────────────────────────────────────────────

        return redirect()->route('order.index')->with('success', 'Order berhasil diupdate!');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('order.index')->with('success', 'Order berhasil dihapus!');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,diambil',
        ]);

        $statusLama = $order->status;
        $order->update(['status' => $request->status]);

        // ── Notif WA jika status berubah ─────────────────────
        if ($statusLama !== $request->status) {
            $pelanggan = $order->pelanggan;
            if ($pelanggan && $pelanggan->notif_wa && $pelanggan->no_telp) {
                $this->wa->notifStatusBerubah(
                    $pelanggan->no_telp,
                    $pelanggan->nama,
                    $order->kode_order,
                    $request->status
                );
            }
        }
        // ─────────────────────────────────────────────────────

        return back()->with('success', 'Status order berhasil diubah!');
    }
}
