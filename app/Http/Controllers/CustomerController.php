<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\LoyaltyPoint;
use App\Models\LoyaltyTransaction;
use App\Models\Order;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Landing page utama
     */
    public function index()
    {
        $layanan = Layanan::all();
        return view('customer.landing', compact('layanan'));
    }

    /**
     * API: Estimasi harga otomatis (dipanggil via AJAX)
     */
    public function estimasiHarga(Request $request)
    {
        $request->validate([
            'layanan_id' => 'required|exists:layanan,id',
            'berat_kg'   => 'required|numeric|min:0.5|max:100',
        ]);

        $layanan = Layanan::findOrFail($request->layanan_id);
        $total   = $layanan->harga_per_kg * $request->berat_kg;

        return response()->json([
            'layanan'       => $layanan->nama_layanan,
            'harga_per_kg'  => $layanan->harga_per_kg,
            'berat_kg'      => $request->berat_kg,
            'total'         => round($total),
            'estimasi_hari' => $layanan->estimasi_hari,
        ]);
    }

    /**
     * Halaman cek status cucian + hasil
     */
    public function cekStatus(Request $request)
    {
        $order = null;
        $kode  = $request->query('kode');

        if ($kode) {
            $order = Order::with(['pelanggan', 'layanan', 'pembayaran'])
                ->where('kode_order', $kode)
                ->first();
        }

        $layanan = Layanan::all();
        return view('customer.cek-status', compact('order', 'kode', 'layanan'));
    }

    /**
     * Halaman loyalty points pelanggan
     */
    public function loyaltyPoints(Request $request)
    {
        $pelanggan = null;
        $loyalty   = null;
        $transaksi = collect();
        $noTelp    = $request->query('no_telp');

        if ($noTelp) {
            $pelanggan = Pelanggan::where('no_telp', $noTelp)->first();

            if ($pelanggan) {
                $loyalty = LoyaltyPoint::firstOrCreate(
                    ['pelanggan_id' => $pelanggan->id],
                    ['total_poin' => 0, 'level' => 'Bronze']
                );
                $transaksi = LoyaltyTransaction::where('pelanggan_id', $pelanggan->id)
                    ->latest()
                    ->take(10)
                    ->get();
            }
        }

        $rewards = $this->daftarReward();
        return view('customer.loyalty', compact('pelanggan', 'loyalty', 'transaksi', 'noTelp', 'rewards'));
    }

    /**
     * Tukar poin dengan reward
     */
    public function tukarPoin(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'reward_id'    => 'required',
        ]);

        $pelanggan = Pelanggan::findOrFail($request->pelanggan_id);
        $loyalty   = LoyaltyPoint::where('pelanggan_id', $pelanggan->id)->first();

        if (!$loyalty) {
            return back()->with('error', 'Data poin tidak ditemukan.');
        }

        $rewards = $this->daftarReward();
        $reward  = collect($rewards)->firstWhere('id', $request->reward_id);

        if (!$reward) {
            return back()->with('error', 'Reward tidak ditemukan.');
        }

        if (!$loyalty->pakaiPoin($reward['poin'], 'Tukar: ' . $reward['nama'])) {
            return back()->with('error', 'Poin tidak cukup untuk reward ini.');
        }

        return back()->with('success', 'Berhasil menukar ' . $reward['poin'] . ' poin dengan "' . $reward['nama'] . '"! Tunjukkan halaman ini ke kasir.');
    }

    /**
     * Aktifkan / nonaktifkan notifikasi WhatsApp
     */
    public function toggleNotifWa(Request $request)
    {
        $request->validate([
            'no_telp' => 'required',
        ]);

        $pelanggan = Pelanggan::where('no_telp', $request->no_telp)->first();

        if (!$pelanggan) {
            return back()->with('error', 'Nomor telepon tidak terdaftar sebagai pelanggan.');
        }

        $pelanggan->update(['notif_wa' => !$pelanggan->notif_wa]);
        $status = $pelanggan->notif_wa ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Notifikasi WhatsApp berhasil $status untuk nomor {$pelanggan->no_telp}.");
    }

    /**
     * Helper: daftar reward yang tersedia
     */
    private function daftarReward(): array
    {
        return [
            ['id' => 'diskon20',   'nama' => 'Diskon 20%',           'poin' => 300,  'icon' => 'bi-percent'],
            ['id' => 'cuci2kg',    'nama' => 'Cuci gratis 2 kg',     'poin' => 500,  'icon' => 'bi-droplet'],
            ['id' => 'gratisakir', 'nama' => 'Setrika gratis 3 kg',  'poin' => 400,  'icon' => 'bi-lightning'],
            ['id' => 'cuci5kg',    'nama' => 'Cuci gratis 5 kg',     'poin' => 1000, 'icon' => 'bi-stars'],
            ['id' => 'pickup',     'nama' => 'Pickup & delivery gratis', 'poin' => 600, 'icon' => 'bi-truck'],
            ['id' => 'premium',    'nama' => 'Upgrade layanan express', 'poin' => 800, 'icon' => 'bi-arrow-up-circle'],
        ];
    }
}
