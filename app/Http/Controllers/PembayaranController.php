<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyPoint;
use App\Models\Order;
use App\Models\Pembayaran;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    protected WhatsAppService $wa;

    public function __construct(WhatsAppService $wa)
    {
        $this->wa = $wa;
    }

    public function index()
    {
        $pembayaran = Pembayaran::with(['order.pelanggan', 'order.layanan'])->latest()->paginate(10);
        return view('pembayaran.index', compact('pembayaran'));
    }

    public function create(Order $order)
    {
        return view('pembayaran.create', compact('order'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id'     => 'required|exists:orders,id',
            'jumlah_bayar' => 'required|numeric|min:0',
            'metode'       => 'required|in:tunai,transfer,qris',
        ]);

        $order     = Order::with(['pelanggan', 'layanan'])->findOrFail($request->order_id);
        $kembalian = $request->jumlah_bayar - $order->total_harga;

        Pembayaran::create([
            'order_id'      => $request->order_id,
            'jumlah_bayar'  => $request->jumlah_bayar,
            'kembalian'     => max(0, $kembalian),
            'metode'        => $request->metode,
            'status'        => 'lunas',
            'tanggal_bayar' => now(),
        ]);

        $order->update(['status' => 'selesai']);

        // ── Loyalty Points: Rp 1.000 = 1 poin ──────────────
        $poinBaru = (int) floor($order->total_harga / 1000);
        $totalPoin = 0;
        $level = 'Bronze';

        if ($poinBaru > 0 && $order->pelanggan_id) {
            $loyalty = LoyaltyPoint::firstOrCreate(
                ['pelanggan_id' => $order->pelanggan_id],
                ['total_poin' => 0, 'level' => 'Bronze']
            );
            $loyalty->tambahPoin($poinBaru, 'Order ' . $order->kode_order, $order->id);
            $totalPoin = $loyalty->fresh()->total_poin;
            $level     = $loyalty->fresh()->level;
        }

        // ── Notifikasi WhatsApp ──────────────────────────────
        $pelanggan = $order->pelanggan;
        if ($pelanggan && $pelanggan->notif_wa && $pelanggan->no_telp) {
            // Notif status selesai
            $this->wa->notifStatusBerubah(
                $pelanggan->no_telp,
                $pelanggan->nama,
                $order->kode_order,
                'selesai'
            );
            // Notif poin bertambah (jika dapat poin)
            if ($poinBaru > 0) {
                $this->wa->notifPoinBertambah(
                    $pelanggan->no_telp,
                    $pelanggan->nama,
                    $poinBaru,
                    $totalPoin,
                    $level
                );
            }
        }
        // ─────────────────────────────────────────────────────

        $msg = 'Pembayaran berhasil!';
        if ($poinBaru > 0) {
            $msg .= " Pelanggan mendapat +{$poinBaru} poin loyalty (total: {$totalPoin} poin).";
        }

        return redirect()->route('order.show', $order)->with('success', $msg);
    }
}
