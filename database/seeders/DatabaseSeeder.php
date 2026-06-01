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
            ['nama_layanan' => 'Laundry Kiloan',    'harga_per_kg' => 7000,  'estimasi_hari' => 2, 'keterangan' => 'Cuci + kering, dihitung per kg',         'created_at' => now(), 'updated_at' => now()],
            ['nama_layanan' => 'Cuci & Setrika',    'harga_per_kg' => 10000, 'estimasi_hari' => 3, 'keterangan' => 'Dicuci dan disetrika rapi, per kg',       'created_at' => now(), 'updated_at' => now()],
            ['nama_layanan' => 'Laundry Bedcover',  'harga_per_kg' => 35000, 'estimasi_hari' => 3, 'keterangan' => 'Dihitung per item (pcs)',                  'created_at' => now(), 'updated_at' => now()],
            ['nama_layanan' => 'Laundry Boneka',    'harga_per_kg' => 25000, 'estimasi_hari' => 3, 'keterangan' => 'Dihitung per item (pcs)',                  'created_at' => now(), 'updated_at' => now()],
            ['nama_layanan' => 'Laundry Karpet',    'harga_per_kg' => 15000, 'estimasi_hari' => 5, 'keterangan' => 'Dihitung per meter persegi (m²)',          'created_at' => now(), 'updated_at' => now()],
            ['nama_layanan' => 'Laundry Sprei',     'harga_per_kg' => 20000, 'estimasi_hari' => 3, 'keterangan' => 'Dihitung per item (pcs)',                  'created_at' => now(), 'updated_at' => now()],
            ['nama_layanan' => 'Laundry Selimut',   'harga_per_kg' => 25000, 'estimasi_hari' => 3, 'keterangan' => 'Dihitung per item (pcs)',                  'created_at' => now(), 'updated_at' => now()],
            ['nama_layanan' => 'Laundry Gorden',    'harga_per_kg' => 12000, 'estimasi_hari' => 5, 'keterangan' => 'Dihitung per meter persegi (m²)',          'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}