<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
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

        $order       = Order::findOrFail($request->order_id);
        $kembalian   = $request->jumlah_bayar - $order->total_harga;

        Pembayaran::create([
            'order_id'     => $request->order_id,
            'jumlah_bayar' => $request->jumlah_bayar,
            'kembalian'    => max(0, $kembalian),
            'metode'       => $request->metode,
            'status'       => 'lunas',
            'tanggal_bayar' => now(),
        ]);

        $order->update(['status' => 'selesai']);

        return redirect()->route('order.show', $order)->with('success', 'Pembayaran berhasil dicatat!');
    }
}
