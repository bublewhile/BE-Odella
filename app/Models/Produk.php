<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'id_kategori',
        'nama_produk',
        'harga',
        'stok',
        'deskripsi',
        'gambar',
        'is_active',
    ];

    protected $casts = [
        'harga'     => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relations
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'id_produk', 'id_produk');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'id_produk', 'id_produk');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'id_produk', 'id_produk');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'id_produk', 'id_produk');
    }

    public function promos()
    {
        return $this->hasMany(Promo::class, 'id_produk', 'id_produk');
    }

    // Helpers
    public function getRatingRataAttribute(): float
    {
        return $this->ratings()->avg('bintang') ?? 0;
    }

    public function getGambarUrlAttribute(): ?string
    {
        return $this->gambar ? asset('storage/' . $this->gambar) : null;
    }
}
