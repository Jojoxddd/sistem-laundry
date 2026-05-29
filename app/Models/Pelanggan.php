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
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
