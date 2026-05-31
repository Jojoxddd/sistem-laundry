<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyPoint extends Model
{
    use HasFactory;

    protected $table = 'loyalty_points';

    protected $fillable = [
        'pelanggan_id',
        'total_poin',
        'level',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function transactions()
    {
        return $this->hasMany(LoyaltyTransaction::class, 'pelanggan_id', 'pelanggan_id');
    }

    /**
     * Tambah poin dan update level otomatis
     */
    public function tambahPoin(int $poin, string $keterangan, ?int $orderId = null): void
    {
        $this->total_poin += $poin;
        $this->level = $this->hitungLevel($this->total_poin);
        $this->save();

        LoyaltyTransaction::create([
            'pelanggan_id' => $this->pelanggan_id,
            'poin'         => $poin,
            'keterangan'   => $keterangan,
            'order_id'     => $orderId,
        ]);
    }

    /**
     * Tukar poin (kurangi)
     */
    public function pakaiPoin(int $poin, string $keterangan): bool
    {
        if ($this->total_poin < $poin) {
            return false;
        }

        $this->total_poin -= $poin;
        $this->level = $this->hitungLevel($this->total_poin);
        $this->save();

        LoyaltyTransaction::create([
            'pelanggan_id' => $this->pelanggan_id,
            'poin'         => -$poin,
            'keterangan'   => $keterangan,
        ]);

        return true;
    }

    /**
     * Hitung level berdasarkan total poin
     */
    public static function hitungLevel(int $poin): string
    {
        return match (true) {
            $poin >= 5000 => 'Platinum',
            $poin >= 2000 => 'Gold',
            $poin >= 500  => 'Silver',
            default       => 'Bronze',
        };
    }

    /**
     * Poin minimum untuk level berikutnya
     */
    public function poinKeLevelBerikutnya(): int
    {
        return match ($this->level) {
            'Bronze'   => 500  - $this->total_poin,
            'Silver'   => 2000 - $this->total_poin,
            'Gold'     => 5000 - $this->total_poin,
            'Platinum' => 0,
            default    => 0,
        };
    }

    public function levelBerikutnya(): string
    {
        return match ($this->level) {
            'Bronze'   => 'Silver',
            'Silver'   => 'Gold',
            'Gold'     => 'Platinum',
            default    => 'Platinum',
        };
    }
}
