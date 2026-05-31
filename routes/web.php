<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\CustomerController;

// =============================================
// HALAMAN PELANGGAN (publik)
// =============================================
Route::prefix('customer')->name('customer.')->group(function () {
    Route::get('/',                [CustomerController::class, 'index'])->name('home');
    Route::get('/cek-status',      [CustomerController::class, 'cekStatus'])->name('cek-status');
    Route::post('/estimasi-harga', [CustomerController::class, 'estimasiHarga'])->name('estimasi-harga');
    Route::get('/loyalty',         [CustomerController::class, 'loyaltyPoints'])->name('loyalty');
    Route::post('/loyalty/tukar',  [CustomerController::class, 'tukarPoin'])->name('loyalty.tukar');
    Route::post('/notif-wa',       [CustomerController::class, 'toggleNotifWa'])->name('notif-wa');
    Route::get('/cek-nomor',       [CustomerController::class, 'cekNomor'])->name('cek-nomor');
});

// Root → landing page pelanggan
Route::get('/', function () {
    return redirect()->route('customer.home');
});

// =============================================
// DASHBOARD & ADMIN
// =============================================
Route::get('/dashboard', [LaporanController::class, 'dashboard'])->name('dashboard');

Route::resource('pelanggan', PelangganController::class);

Route::resource('order', OrderController::class);
Route::patch('order/{order}/status', [OrderController::class, 'updateStatus'])->name('order.updateStatus');

Route::resource('karyawan', KaryawanController::class);

Route::get('pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
Route::get('pembayaran/create/{order}', [PembayaranController::class, 'create'])->name('pembayaran.create');
Route::post('pembayaran', [PembayaranController::class, 'store'])->name('pembayaran.store');

Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
