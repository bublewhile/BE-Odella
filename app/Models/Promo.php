<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Promo extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_promo';

    protected $fillable = [
        'id_produk',
        'kode_promo',
        'tgl_berlaku',
        'tgl_berakhir',
        'persen_diskon',
        'is_active',
    ];

    protected $casts = [
        'tgl_berlaku'   => 'datetime',
        'tgl_berakhir'  => 'datetime',
        'persen_diskon' => 'decimal:2',
        'is_active'     => 'boolean',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function getMasihBerlakuAttribute(): bool
    {
        $now = Carbon::now();
        return $this->is_active
            && $now->gte($this->tgl_berlaku)
            && $now->lte($this->tgl_berakhir);
    }

    public function scopeAktif($query)
    {
        return $query->where('is_active', true)
            ->where('tgl_berlaku', '<=', now())
            ->where('tgl_berakhir', '>=', now());
    }
}
