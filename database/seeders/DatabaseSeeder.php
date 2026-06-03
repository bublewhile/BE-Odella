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

        foreach ($produks as $p) {
            Produk::create($p);
        }
    }
}
