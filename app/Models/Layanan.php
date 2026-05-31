<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanan';

    protected $fillable = [
        'nama_layanan',
        'harga_per_kg',
        'estimasi_hari',
        'keterangan',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
