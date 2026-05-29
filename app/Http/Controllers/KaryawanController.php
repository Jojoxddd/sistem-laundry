<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::with('user')->latest()->paginate(10);
        return view('karyawan.index', compact('karyawan'));
    }

    public function create()
    {
        return view('karyawan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'no_telp'       => 'required|string|max:20',
            'alamat'        => 'nullable|string',
            'jabatan'       => 'required|string|max:100',
            'tanggal_masuk' => 'required|date',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
        ]);

        $user = User::create([
            'name'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'karyawan',
        ]);

        Karyawan::create([
            'user_id'       => $user->id,
            'nama'          => $request->nama,
            'no_telp'       => $request->no_telp,
            'alamat'        => $request->alamat,
            'jabatan'       => $request->jabatan,
            'tanggal_masuk' => $request->tanggal_masuk,
            'status'        => 'aktif',
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan!');
    }

    public function show(Karyawan $karyawan)
    {
        $karyawan->load(['orders.pelanggan', 'orders.layanan']);
        return view('karyawan.show', compact('karyawan'));
    }

    public function edit(Karyawan $karyawan)
    {
        return view('karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'no_telp'       => 'required|string|max:20',
            'alamat'        => 'nullable|string',
            'jabatan'       => 'required|string|max:100',
            'tanggal_masuk' => 'required|date',
            'status'        => 'required|in:aktif,nonaktif',
        ]);

        $karyawan->update($request->only(['nama', 'no_telp', 'alamat', 'jabatan', 'tanggal_masuk', 'status']));
        $karyawan->user->update(['name' => $request->nama]);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diupdate!');
    }

    public function destroy(Karyawan $karyawan)
    {
        $karyawan->user->delete();
        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil dihapus!');
    }
}
