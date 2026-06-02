<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/login',  fn() => view('auth.login'))->name('admin.login');
Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('admin.login.post');
Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('produk', ProdukController::class);
        Route::resource('kategori', KategoriController::class)->except(['show']);
        Route::resource('pesanan', PesananController::class)->only(['index', 'show']);
        Route::put('pesanan/{id}/status',    [PesananController::class, 'updateStatus'])->name('pesanan.status');
        Route::put('pesanan/{id}/verifikasi', [PesananController::class, 'verifikasiBayar'])->name('pesanan.verifikasi');
        Route::resource('promo', PromoController::class);
        Route::resource('users', UserController::class)->only(['index', 'show', 'destroy']);
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/',              [LaporanController::class, 'index'])->name('index');
            Route::get('export-excel',   [LaporanController::class, 'exportExcel'])->name('excel');
            Route::get('export-pdf',     [LaporanController::class, 'exportPdf'])->name('pdf');
        });
    });

Route::prefix('kurir')
    ->name('kurir.')
    ->middleware(['auth', 'role:kurir'])
    ->group(function () {
        Route::get('/', [App\Http\Controllers\Kurir\DashboardController::class, 'index'])->name('dashboard');
        Route::put('pesanan/{id}/kirim', [App\Http\Controllers\Kurir\PesananController::class, 'kirim'])->name('pesanan.kirim');
    });

Route::get('/', fn() => redirect()->route('admin.dashboard'));
