<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pembayaran;
use App\Models\Pelanggan;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $bulan = request('bulan', date('m'));
        $tahun = request('tahun', date('Y'));

        $orders = Order::with(['pelanggan', 'karyawan', 'layanan', 'pembayaran'])
            ->whereMonth('tanggal_masuk', $bulan)
            ->whereYear('tanggal_masuk', $tahun)
            ->latest()
            ->get();

        $totalPendapatan = Pembayaran::whereHas('order', function ($q) use ($bulan, $tahun) {
            $q->whereMonth('tanggal_masuk', $bulan)->whereYear('tanggal_masuk', $tahun);
        })->where('status', 'lunas')->sum('jumlah_bayar');

        $summary = [
            'total_order'      => $orders->count(),
            'order_selesai'    => $orders->where('status', 'selesai')->count(),
            'order_diproses'   => $orders->where('status', 'diproses')->count(),
            'order_menunggu'   => $orders->where('status', 'menunggu')->count(),
            'total_pendapatan' => $totalPendapatan,
        ];

        return view('laporan.index', compact('orders', 'summary', 'bulan', 'tahun'));
    }

    public function dashboard()
    {
        $totalPelanggan    = Pelanggan::count();
        $totalKaryawan     = Karyawan::where('status', 'aktif')->count();
        $totalOrderHariIni = Order::whereDate('tanggal_masuk', today())->count();
        $pendapatanBulanIni = Pembayaran::whereMonth('tanggal_bayar', date('m'))
            ->whereYear('tanggal_bayar', date('Y'))
            ->where('status', 'lunas')
            ->sum('jumlah_bayar');

        $orderTerbaru = Order::with(['pelanggan', 'layanan'])
            ->latest()->take(5)->get();

        $orderBelumSelesai = Order::with(['pelanggan', 'layanan'])
            ->whereIn('status', ['menunggu', 'diproses'])
            ->latest()->get();

        return view('dashboard', compact(
            'totalPelanggan',
            'totalKaryawan',
            'totalOrderHariIni',
            'pendapatanBulanIni',
            'orderTerbaru',
            'orderBelumSelesai'
        ));
    }
}
