<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_order',
        'pelanggan_id',
        'karyawan_id',
        'layanan_id',
        'berat_kg',
        'total_harga',
        'tanggal_masuk',
        'tanggal_selesai',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_masuk'   => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    public static function generateKodeOrder(): string
    {
        $prefix = 'LDR-' . date('Ymd') . '-';
        $last = self::where('kode_order', 'like', $prefix . '%')->latest()->first();
        $number = $last ? (int) substr($last->kode_order, -4) + 1 : 1;
        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'menunggu'  => 'warning',
            'diproses'  => 'info',
            'selesai'   => 'success',
            'diambil'   => 'secondary',
            default     => 'light',
        };
    }
}
