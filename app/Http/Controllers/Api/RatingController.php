<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    // POST /api/rating  (FR-07)
    public function store(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:produks,id_produk',
            'bintang'   => 'required|integer|min:1|max:5',
            'komen'     => 'nullable|string|max:255',
        ]);

        $userId = auth('api')->id();

        // Pastikan user sudah pernah beli produk ini
        $sudahBeli = Pesanan::where('id_user', $userId)
            ->where('status_pesanan', 'selesai')
            ->whereHas('detailPesanans', fn($q) => $q->where('id_produk', $request->id_produk))
            ->exists();

        if (!$sudahBeli) {
            return response()->json([
                'success' => false,
                'message' => 'Hanya bisa memberi rating setelah pesanan selesai',
            ], 403);
        }

        // Cek duplikat
        $existing = Rating::where('id_user', $userId)
            ->where('id_produk', $request->id_produk)
            ->first();

        if ($existing) {
            $existing->update(['bintang' => $request->bintang, 'komen' => $request->komen]);
            $rating = $existing;
        } else {
            $rating = Rating::create([
                'id_user'   => $userId,
                'id_produk' => $request->id_produk,
                'bintang'   => $request->bintang,
                'komen'     => $request->komen,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Rating berhasil disimpan',
            'data'    => $rating->load('produk', 'user'),
        ], 201);
    }
}
