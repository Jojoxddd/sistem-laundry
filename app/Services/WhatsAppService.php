<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected string $token;
    protected string $apiUrl = 'https://api.fonnte.com/send';

    public function __construct()
    {
        $this->token = config('services.fonnte.token', '');
    }

    public function send(string $noTelp, string $pesan): bool
    {
        if (empty($this->token)) {
            Log::warning('WA: FONNTE_TOKEN belum diset di .env');
            return false;
        }
        $nomor = $this->formatNomor($noTelp);
        try {
            $response = Http::withHeaders(['Authorization' => $this->token])
                ->post($this->apiUrl, ['target' => $nomor, 'message' => $pesan]);
            if ($response->successful()) {
                Log::info("WA terkirim ke {$nomor}");
                return true;
            }
            Log::error('WA gagal: ' . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error('WA exception: ' . $e->getMessage());
            return false;
        }
    }

    /** Notif order baru dari halaman customer (sudah ada kode order) */
    public function notifOrderBaru(string $noTelp, string $nama, string $kode, string $layanan, float $berat, float $total, string $tglSelesai): bool
    {
        $pesan = "✅ *Bless Laundry — Order Diterima!*\n\n"
               . "Halo, *{$nama}*! 👋\n\n"
               . "Order cucianmu berhasil dibuat. Antarkan cucianmu ke outlet kami ya!\n\n"
               . "📋 *Detail Order:*\n"
               . "• Kode: *`{$kode}`*\n"
               . "• Layanan: {$layanan}\n"
               . "• Est. berat: {$berat} kg\n"
               . "• Est. total: Rp " . number_format($total, 0, ',', '.') . "\n"
               . "• Est. selesai: {$tglSelesai}\n\n"
               . "📍 Simpan kode order di atas untuk cek status cucian:\n"
               . url('/customer/cek-status') . "\n\n"
               . "_Bless Laundry — Bersih, Cepat, Terpercaya_ 💙";
        return $this->send($noTelp, $pesan);
    }

    public function notifStatusBerubah(string $noTelp, string $nama, string $kode, string $status): bool
    {
        $label = [
            'diproses' => '🫧 Sedang dicuci & disetrika',
            'selesai'  => '✅ Siap diambil di outlet!',
            'diambil'  => '🏠 Sudah diambil — terima kasih!',
        ][$status] ?? $status;
        $pesan = "🔔 *Bless Laundry — Update Status*\n\n"
               . "Halo, *{$nama}*!\n\nStatus cucianmu (*{$kode}*) berubah:\n*{$label}*\n\n";
        if ($status === 'selesai') $pesan .= "Silakan ambil di outlet (07.00–21.00) 😊\n\n";
        $pesan .= "Detail: " . url('/customer/cek-status?kode=' . $kode) . "\n\n_Bless Laundry_ 💙";
        return $this->send($noTelp, $pesan);
    }

    public function notifPoinBertambah(string $noTelp, string $nama, int $poinBaru, int $totalPoin, string $level): bool
    {
        $pesan = "⭐ *Bless Laundry — Loyalty Points*\n\n"
               . "Halo, *{$nama}*!\n\nKamu dapat *+{$poinBaru} poin* 🎉\n"
               . "💎 Total: *{$totalPoin} poin* (Level: {$level})\n\n"
               . "Tukar poin: " . url('/customer/loyalty') . "\n\n_Bless Laundry_ 💙";
        return $this->send($noTelp, $pesan);
    }

    public function notifAktivasi(string $noTelp, string $nama): bool
    {
        $pesan = "✅ *Bless Laundry*\n\nHalo, *{$nama}*!\n\n"
               . "Notifikasi WhatsApp kamu sudah *aktif* 🎉\n"
               . "Kamu akan dapat update otomatis setiap kali status cucian berubah.\n\n"
               . "Cek loyalty points: " . url('/customer/loyalty') . "\n\n"
               . "_Bless Laundry — Bersih, Cepat, Terpercaya_ 💙";
        return $this->send($noTelp, $pesan);
    }

    private function formatNomor(string $nomor): string
    {
        $nomor = preg_replace('/\D/', '', $nomor);
        if (str_starts_with($nomor, '0')) $nomor = '62' . substr($nomor, 1);
        elseif (!str_starts_with($nomor, '62')) $nomor = '62' . $nomor;
        return $nomor;
    }
}
