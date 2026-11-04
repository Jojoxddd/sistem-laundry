<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Layanan;
use App\Models\LoyaltyPoint;
use App\Models\LoyaltyTransaction;
use App\Models\Order;
use App\Models\Pelanggan;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CustomerController extends Controller
{
    protected WhatsAppService $wa;

    public function __construct(WhatsAppService $wa)
    {
        $this->wa = $wa;
    }

    /** Landing page */
    public function index()
    {
        $layanan = Layanan::all();
        return view('customer.landing', compact('layanan'));
    }

    /** Halaman form order online */
    public function orderForm()
    {
        $layanan = Layanan::orderBy('nama_layanan')->get();
        return view('customer.order', compact('layanan'));
    }

    /** Proses order dari customer */
    public function orderStore(Request $request)
    {
        $request->validate([
            'nama'       => 'required|string|max:100',
            'no_telp'    => 'required|string|max:20',
            'alamat'     => 'nullable|string|max:255',
            'layanan_id' => 'required|exists:layanan,id',
            'berat_kg'   => 'required|numeric|min:0.5|max:100',
            'catatan'    => 'nullable|string|max:500',
            'notif_wa'   => 'nullable|boolean',
        ]);

        $pelanggan = Pelanggan::where('no_telp', $request->no_telp)->first();
        if (!$pelanggan) {
            $pelanggan = Pelanggan::create([
                'nama'     => $request->nama,
                'no_telp'  => $request->no_telp,
                'alamat'   => $request->alamat,
                'notif_wa' => $request->boolean('notif_wa'),
            ]);
        } else {
            $pelanggan->update([
                'nama'     => $request->nama,
                'alamat'   => $request->alamat ?? $pelanggan->alamat,
                'notif_wa' => $request->boolean('notif_wa'),
            ]);
        }

        $layanan     = Layanan::findOrFail($request->layanan_id);
        $total_harga = $layanan->harga_per_kg * $request->berat_kg;
        $tglMasuk    = Carbon::today();
        $tglSelesai  = Carbon::today()->addDays($layanan->estimasi_hari);

        $karyawan = Karyawan::where('status', 'aktif')->first();
        if (!$karyawan) {
            return back()->withInput()->with('error', 'Belum ada karyawan aktif. Hubungi outlet kami.');
        }

        $order = Order::create([
            'kode_order'      => Order::generateKodeOrder(),
            'pelanggan_id'    => $pelanggan->id,
            'karyawan_id'     => $karyawan->id,
            'layanan_id'      => $layanan->id,
            'berat_kg'        => $request->berat_kg,
            'total_harga'     => $total_harga,
            'tanggal_masuk'   => $tglMasuk,
            'tanggal_selesai' => $tglSelesai,
            'status'          => 'menunggu',
            'catatan'         => $request->catatan,
        ]);

        if ($pelanggan->notif_wa) {
            $this->wa->notifOrderBaru(
                $pelanggan->no_telp,
                $pelanggan->nama,
                $order->kode_order,
                $layanan->nama_layanan,
                $request->berat_kg,
                $total_harga,
                $tglSelesai->format('d M Y')
            );
        }

        return redirect()->route('customer.order.sukses', ['kode' => $order->kode_order]);
    }

    /** Halaman sukses setelah order */
    public function orderSukses(Request $request)
    {
        $kode  = $request->query('kode');
        $order = Order::with(['pelanggan', 'layanan'])
            ->where('kode_order', $kode)
            ->firstOrFail();
        return view('customer.order-sukses', compact('order'));
    }

    /**
     * Cek status cucian.
     *
     * SECURITY FIX: Wajib input kode_order + no_telp secara bersamaan.
     * Kode order saja tidak cukup — harus cocok dengan no HP pemiliknya.
     */
    public function cekStatus(Request $request)
    {
        $order  = null;
        $error  = null;
        $kode   = $request->query('kode');
        $noTelp = $request->query('no_telp');
        $layanan = Layanan::all();

        if ($kode && $noTelp) {
            // Cari order berdasarkan kode + no_telp pelanggan sekaligus
            $order = Order::with(['pelanggan', 'layanan', 'pembayaran'])
                ->where('kode_order', $kode)
                ->whereHas('pelanggan', function ($q) use ($noTelp) {
                    $q->where('no_telp', $noTelp);
                })
                ->first();

            // Jangan beritahu apakah kode atau no HP yang salah
            // — pesan generik supaya tidak bisa ditebak satu per satu
            if (!$order) {
                $error = 'Kode order atau nomor HP tidak ditemukan. Pastikan keduanya benar.';
            }
        } elseif ($kode || $noTelp) {
            // Salah satu diisi tapi tidak keduanya
            $error = 'Masukkan kode order dan nomor HP secara bersamaan.';
        }

        return view('customer.cek-status', compact('order', 'kode', 'noTelp', 'error', 'layanan'));
    }

    /**
     * Loyalty points.
     *
     * SECURITY FIX: Hanya tampilkan poin setelah verifikasi no_telp + nama.
     * no_telp saja tidak cukup — harus cocok dengan nama terdaftar.
     */
    public function loyaltyPoints(Request $request)
    {
        $pelanggan = null;
        $loyalty   = null;
        $transaksi = collect();
        $error     = null;
        $noTelp    = $request->query('no_telp');
        $nama      = $request->query('nama');

        if ($noTelp && $nama) {
            // Verifikasi: no_telp + nama harus cocok
            $pelanggan = Pelanggan::where('no_telp', $noTelp)
                ->whereRaw('LOWER(nama) = ?', [strtolower(trim($nama))])
                ->first();

            if ($pelanggan) {
                $loyalty = LoyaltyPoint::firstOrCreate(
                    ['pelanggan_id' => $pelanggan->id],
                    ['total_poin' => 0, 'level' => 'Bronze']
                );
                $transaksi = LoyaltyTransaction::where('pelanggan_id', $pelanggan->id)
                    ->latest()->take(10)->get();
            } else {
                // Pesan generik — jangan bilang "nama salah" atau "no HP tidak ada"
                $error = 'Data tidak ditemukan. Pastikan nomor HP dan nama sesuai data pendaftaran.';
            }
        } elseif ($noTelp || $nama) {
            $error = 'Masukkan nomor HP dan nama secara bersamaan.';
        }

        $rewards = $this->daftarReward();
        return view('customer.loyalty', compact('pelanggan', 'loyalty', 'transaksi', 'noTelp', 'nama', 'error', 'rewards'));
    }

    /** Tukar poin */
    public function tukarPoin(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'reward_id'    => 'required',
        ]);

        $pelanggan = Pelanggan::findOrFail($request->pelanggan_id);
        $loyalty   = LoyaltyPoint::where('pelanggan_id', $pelanggan->id)->first();

        if (!$loyalty) return back()->with('error', 'Data poin tidak ditemukan.');

        $rewards = $this->daftarReward();
        $reward  = collect($rewards)->firstWhere('id', $request->reward_id);

        if (!$reward) return back()->with('error', 'Reward tidak ditemukan.');

        if (!$loyalty->pakaiPoin($reward['poin'], 'Tukar: ' . $reward['nama'])) {
            return back()->with('error', 'Poin tidak cukup untuk reward ini.');
        }

        return back()->with('success', 'Berhasil tukar ' . $reward['poin'] . ' poin dengan "' . $reward['nama'] . '"! Tunjukkan halaman ini ke kasir.');
    }

    /** Toggle notif WA */
    public function toggleNotifWa(Request $request)
    {
        $request->validate(['no_telp' => 'required|string']);

        $pelanggan = Pelanggan::where('no_telp', $request->no_telp)->first();
        if (!$pelanggan) {
            return back()->with('error', '❌ Nomor ' . $request->no_telp . ' belum terdaftar. Order dulu untuk daftar otomatis.');
        }

        $pelanggan->update(['notif_wa' => !$pelanggan->notif_wa]);

        if ($pelanggan->notif_wa) {
            $terkirim = $this->wa->notifAktivasi($pelanggan->no_telp, $pelanggan->nama);
            $msg = '✅ Notifikasi WhatsApp aktif untuk ' . $pelanggan->nama . '!';
            if ($terkirim) $msg .= ' Pesan konfirmasi sudah dikirim ke WhatsApp kamu.';
            return back()->with('success', $msg);
        }

        return back()->with('success', 'Notifikasi WhatsApp dinonaktifkan.');
    }

    /**
     * AJAX: cek nomor.
     *
     * SECURITY FIX: Hanya kembalikan apakah nomor terdaftar atau tidak.
     * Nama dan status notif_wa TIDAK dikembalikan — data ini sensitif.
     */
    public function cekNomor(Request $request)
    {
        $nomor     = $request->query('no_telp', '');
        $terdaftar = Pelanggan::where('no_telp', $nomor)->exists();

        return response()->json(['terdaftar' => $terdaftar]);
    }

    /** AJAX: estimasi harga */
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

    private function daftarReward(): array
    {
        return [
            ['id' => 'diskon20',   'nama' => 'Diskon 20%',               'poin' => 300,  'icon' => 'bi-percent'],
            ['id' => 'cuci2kg',    'nama' => 'Cuci gratis 2 kg',         'poin' => 500,  'icon' => 'bi-droplet'],
            ['id' => 'setrika3kg', 'nama' => 'Setrika gratis 3 kg',      'poin' => 400,  'icon' => 'bi-lightning'],
            ['id' => 'cuci5kg',    'nama' => 'Cuci gratis 5 kg',         'poin' => 1000, 'icon' => 'bi-stars'],
            ['id' => 'pickup',     'nama' => 'Pickup & delivery gratis', 'poin' => 600,  'icon' => 'bi-truck'],
            ['id' => 'express',    'nama' => 'Upgrade ke express',        'poin' => 800,  'icon' => 'bi-arrow-up-circle'],
        ];
    }
} 