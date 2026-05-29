<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Karyawan;
use App\Models\Layanan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin / Manajer
        $admin = User::create([
            'name'     => 'Admin LaundryKu',
            'email'    => 'admin@laundryku.com',
            'password' => Hash::make('password'),
            'role'     => 'manajer',
        ]);

        // Karyawan user
        $userKaryawan = User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'budi@laundryku.com',
            'password' => Hash::make('password'),
            'role'     => 'karyawan',
        ]);

        Karyawan::create([
            'user_id'       => $userKaryawan->id,
            'nama'          => 'Budi Santoso',
            'no_telp'       => '081234567890',
            'alamat'        => 'Jl. Merdeka No. 10, Bandung',
            'jabatan'       => 'Staff Laundry',
            'tanggal_masuk' => '2023-01-01',
            'status'        => 'aktif',
        ]);

        $userKaryawan2 = User::create([
            'name'     => 'Siti Rahayu',
            'email'    => 'siti@laundryku.com',
            'password' => Hash::make('password'),
            'role'     => 'karyawan',
        ]);

        Karyawan::create([
            'user_id'       => $userKaryawan2->id,
            'nama'          => 'Siti Rahayu',
            'no_telp'       => '082345678901',
            'alamat'        => 'Jl. Sudirman No. 5, Bandung',
            'jabatan'       => 'Kasir',
            'tanggal_masuk' => '2023-03-15',
            'status'        => 'aktif',
        ]);

        // Pelanggan
        Pelanggan::insert([
            ['nama' => 'Ahmad Fauzi',    'no_telp' => '081111111111', 'alamat' => 'Jl. Anggrek No. 1',  'email' => 'ahmad@mail.com',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Dewi Lestari',   'no_telp' => '082222222222', 'alamat' => 'Jl. Mawar No. 5',    'email' => 'dewi@mail.com',   'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Rudi Hartono',   'no_telp' => '083333333333', 'alamat' => 'Jl. Melati No. 8',   'email' => null,              'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Nina Susanti',   'no_telp' => '084444444444', 'alamat' => 'Jl. Kenanga No. 12', 'email' => 'nina@mail.com',   'created_at' => now(), 'updated_at' => now()],
        ]);

        // Layanan
        Layanan::insert([
            ['nama_layanan' => 'Cuci & Setrika',     'harga_per_kg' => 7000,  'estimasi_hari' => 2, 'keterangan' => 'Dicuci dan disetrika rapi', 'created_at' => now(), 'updated_at' => now()],
            ['nama_layanan' => 'Cuci Kering',        'harga_per_kg' => 5000,  'estimasi_hari' => 1, 'keterangan' => 'Dicuci dan dikeringkan saja', 'created_at' => now(), 'updated_at' => now()],
            ['nama_layanan' => 'Setrika Saja',       'harga_per_kg' => 3000,  'estimasi_hari' => 1, 'keterangan' => 'Hanya setrika',              'created_at' => now(), 'updated_at' => now()],
            ['nama_layanan' => 'Cuci Express',       'harga_per_kg' => 12000, 'estimasi_hari' => 1, 'keterangan' => 'Selesai di hari yang sama',  'created_at' => now(), 'updated_at' => now()],
            ['nama_layanan' => 'Cuci Bed Cover',     'harga_per_kg' => 15000, 'estimasi_hari' => 3, 'keterangan' => 'Khusus bed cover & selimut', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
