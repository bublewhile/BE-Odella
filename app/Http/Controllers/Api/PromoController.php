<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    // GET /api/promo  — semua promo aktif
    public function index()
    {
        $promos = Promo::with('produk')->aktif()->get();

        return response()->json([
            'success' => true,
            'data'    => $promos,
        ]);
    }

    // POST /api/promo/cek  — validasi kode promo saat checkout
    public function cek(Request $request)
    {
        $request->validate(['kode_promo' => 'required|string']);

        $promo = Promo::where('kode_promo', $request->kode_promo)->aktif()->first();

        if (!$promo) {
            return response()->json([
                'success' => false,
                'message' => 'Kode promo tidak valid atau sudah kedaluwarsa',
            ], 422);
        }

        return response()->json([
            'success'       => true,
            'message'       => "Promo {$promo->kode_promo} berlaku — diskon {$promo->persen_diskon}%",
            'persen_diskon' => $promo->persen_diskon,
            'data'          => $promo,
        ]);
    }
}
