<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PembayaranController;

// Redirect root ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard
Route::get('/dashboard', [LaporanController::class, 'dashboard'])->name('dashboard');

// Pelanggan
Route::resource('pelanggan', PelangganController::class);

// Order
Route::resource('order', OrderController::class);
Route::patch('order/{order}/status', [OrderController::class, 'updateStatus'])->name('order.updateStatus');

// Karyawan
Route::resource('karyawan', KaryawanController::class);

// Pembayaran
Route::get('pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
Route::get('pembayaran/create/{order}', [PembayaranController::class, 'create'])->name('pembayaran.create');
Route::post('pembayaran', [PembayaranController::class, 'store'])->name('pembayaran.store');

// Laporan
Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
