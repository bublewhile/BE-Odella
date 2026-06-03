<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->id('id_promo');
            $table->foreignId('id_produk')->nullable()->constrained('produks', 'id_produk')->onDelete('set null');
            $table->string('kode_promo')->unique();
            $table->timestamp('tgl_berlaku');
            $table->timestamp('tgl_berakhir');
            $table->decimal('persen_diskon', 5, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
