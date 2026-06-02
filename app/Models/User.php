<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    protected $primaryKey = 'id_user';
    protected $fillable = [
        'nama',
        'email',
        'password',
        'jenis_kelamin',
        'alamat',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [
            'role' => $this->role,
        ];
    }

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'id_user', 'id_user');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'id_user', 'id_user');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'id_user', 'id_user');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'id_user', 'id_user');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isKurir(): bool
    {
        return $this->role === 'kurir';
    }
}
