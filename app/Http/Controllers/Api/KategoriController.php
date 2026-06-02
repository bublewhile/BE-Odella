<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;

class KategoriController extends Controller
{
    // GET /api/kategori
    public function index()
    {
        $kategoris = Kategori::withCount('produks')->get();

        return response()->json([
            'success' => true,
            'data'    => $kategoris,
        ]);
    }
}
