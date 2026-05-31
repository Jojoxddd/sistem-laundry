<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel loyalty points pelanggan
        Schema::create('loyalty_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('pelanggan')->onDelete('cascade');
            $table->integer('total_poin')->default(0);
            $table->string('level')->default('Bronze'); // Bronze, Silver, Gold, Platinum
            $table->timestamps();
        });

        // Riwayat transaksi poin (masuk/keluar)
        Schema::create('loyalty_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('pelanggan')->onDelete('cascade');
            $table->integer('poin');             // positif = dapat poin, negatif = pakai poin
            $table->string('keterangan');        // "Order #LDR-xxx", "Tukar: Diskon 20%", dll
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('set null');
            $table->timestamps();
        });

        // Tabel nomor WhatsApp pelanggan (untuk notifikasi)
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->boolean('notif_wa')->default(false)->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->dropColumn('notif_wa');
        });
        Schema::dropIfExists('loyalty_transactions');
        Schema::dropIfExists('loyalty_points');
    }
};
