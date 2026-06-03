<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
            $table->timestamp('tanggal_pesan')->useCurrent();
            $table->enum('status_pesanan', [
                'menunggu_pembayaran',
                'pembayaran_diverifikasi',
                'diproses',
                'dikirim',
                'selesai',
                'dibatalkan',
            ])->default('menunggu_pembayaran');
            $table->decimal('total_harga', 12, 2)->default(0);
            $table->text('alamat_pengiriman')->nullable();
            $table->string('bukti_bayar')->nullable();
            $table->timestamp('tgl_bayar')->nullable();
            $table->string('kode_promo')->nullable();
            $table->decimal('diskon', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
