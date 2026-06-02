<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pesanan';

    protected $fillable = [
        'id_user',
        'tanggal_pesan',
        'status_pesanan',
        'total_harga',
        'alamat_pengiriman',
        'bukti_bayar',
        'tgl_bayar',
        'kode_promo',
        'diskon',
    ];

    protected $casts = [
        'tanggal_pesan' => 'datetime',
        'tgl_bayar'     => 'datetime',
        'total_harga'   => 'decimal:2',
        'diskon'        => 'decimal:2',
    ];

    const STATUS = [
        'menunggu_pembayaran'      => 'Menunggu Pembayaran',
        'pembayaran_diverifikasi'  => 'Pembayaran Diverifikasi',
        'diproses'                 => 'Diproses',
        'dikirim'                  => 'Dikirim',
        'selesai'                  => 'Selesai',
        'dibatalkan'               => 'Dibatalkan',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan', 'id_pesanan');
    }

    // Helpers
    public function getStatusLabelAttribute(): string
    {
        return self::STATUS[$this->status_pesanan] ?? $this->status_pesanan;
    }

    public function getBuktiUrlAttribute(): ?string
    {
        return $this->bukti_bayar ? asset('storage/' . $this->bukti_bayar) : null;
    }
}
