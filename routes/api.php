<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\PesananController;
use App\Http\Controllers\Api\ProdukController;
use App\Http\Controllers\Api\PromoController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\WishlistController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::get('produk', [ProdukController::class, 'index']);
Route::get('produk/{id}', [ProdukController::class, 'show']);
Route::get('kategori', [KategoriController::class, 'index']);
Route::get('promo', [PromoController::class, 'index']);
Route::post('promo/cek', [PromoController::class, 'cek']);

Route::middleware('auth:api')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::post('auth/refresh', [AuthController::class, 'refresh']);
    Route::get('auth/profile', [AuthController::class, 'profile']);
    Route::put('auth/profile', [AuthController::class, 'updateProfile']);
    Route::apiResource('cart', CartController::class)->except(['show']);
    Route::get('pesanan', [PesananController::class, 'index']);
    Route::get('pesanan/{id}', [PesananController::class, 'show']);
    Route::post('pesanan/checkout', [PesananController::class, 'checkout']);
    Route::post('pesanan/{id}/bukti-bayar', [PesananController::class, 'uploadBuktiBayar']);
    Route::post('rating', [RatingController::class, 'store']);
    Route::get('wishlist', [WishlistController::class, 'index']);
    Route::post('wishlist/toggle', [WishlistController::class, 'toggle']);
});
