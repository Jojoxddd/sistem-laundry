<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';

    protected $fillable = [
        'nama',
        'no_telp',
        'alamat',
        'email',
        'notif_wa',  // tambahan untuk notifikasi WhatsApp
    ];

    protected $casts = [
        'notif_wa' => 'boolean',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function loyaltyPoint()
    {
        return $this->hasOne(LoyaltyPoint::class);
    }

    public function loyaltyTransactions()
    {
        return $this->hasMany(LoyaltyTransaction::class);
    }
}
