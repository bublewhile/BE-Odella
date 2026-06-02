<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        User::create([
            'nama'     => 'Admin Odella',
            'email'    => 'admin@odellabakery.com',
            'password' => Hash::make('password123'),
            'role'     => 'admin',
        ]);

        User::create([
            'nama'     => 'Kurir Odella',
            'email'    => 'kurir@odellabakery.com',
            'password' => Hash::make('password123'),
            'role'     => 'kurir',
        ]);

        User::create([
            'nama'          => 'Customer Test',
            'email'         => 'customer@test.com',
            'password'      => Hash::make('password123'),
            'role'          => 'customer',
            'jenis_kelamin' => 'P',
            'alamat'        => 'Jl. Contoh No. 1, Ciawi',
        ]);

        // Kategori
        $kategoris = [
            ['nama_kategori' => 'Cake'],
            ['nama_kategori' => 'Pastry'],
            ['nama_kategori' => 'Cookies'],
            ['nama_kategori' => 'Minuman Manis'],
            ['nama_kategori' => 'Dessert'],
        ];

        foreach ($kategoris as $kat) {
            Kategori::create($kat);
        }

        // Produk sample
        $produks = [
            ['id_kategori' => 1, 'nama_produk' => 'Birthday Cake Coklat', 'harga' => 250000, 'stok' => 10, 'deskripsi' => 'Cake ulang tahun dengan topping coklat premium'],
            ['id_kategori' => 1, 'nama_produk' => 'Red Velvet Cake',       'harga' => 300000, 'stok' => 8,  'deskripsi' => 'Red velvet dengan cream cheese frosting'],
            ['id_kategori' => 2, 'nama_produk' => 'Croissant Butter',      'harga' => 35000,  'stok' => 20, 'deskripsi' => 'Croissant renyah dengan butter premium'],
            ['id_kategori' => 3, 'nama_produk' => 'Cookies Choco Chip',    'harga' => 45000,  'stok' => 30, 'deskripsi' => 'Cookies renyah dengan choco chip'],
            ['id_kategori' => 4, 'nama_produk' => 'Matcha Latte',          'harga' => 30000,  'stok' => 50, 'deskripsi' => 'Minuman matcha dengan susu segar'],
            ['id_kategori' => 5, 'nama_produk' => 'Tiramisu Cup',          'harga' => 55000,  'stok' => 15, 'deskripsi' => 'Tiramisu classic dalam cup cantik'],
        ];

        foreach ($produks as $p) {
            Produk::create($p);
        }
    }
}
