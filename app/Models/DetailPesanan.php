<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_detail_pesanan';

    protected $fillable = [
        'id_pesanan',
        'id_produk',
        'qty',
        'sub_total',
    ];

    protected $casts = [
        'sub_total' => 'decimal:2',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
