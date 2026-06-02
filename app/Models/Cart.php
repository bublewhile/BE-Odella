<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_cart';

    protected $fillable = [
        'id_user',
        'id_produk',
        'qty',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function getSubTotalAttribute(): float
    {
        return $this->qty * ($this->produk->harga ?? 0);
    }
}
