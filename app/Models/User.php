<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * PERBAIKAN: Tambahkan 'role' ke $fillable
     * Sebelumnya pakai PHP attribute #[Fillable] yang tidak menyertakan 'role',
     * sehingga kolom role tidak tersimpan saat User::create([...'role'=>'karyawan'...])
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /**
     * Relasi ke tabel karyawan
     */
    public function karyawan()
    {
        return $this->hasOne(Karyawan::class);
    }

    /**
     * Helper: cek apakah user adalah admin/manajer
     */
    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'manajer']);
    }
}
