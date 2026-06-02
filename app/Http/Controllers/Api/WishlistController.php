<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    // GET /api/wishlist
    public function index()
    {
        $wishlists = Wishlist::with('produk.kategori')
            ->where('id_user', auth('api')->id())
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $wishlists,
        ]);
    }

    // POST /api/wishlist  (toggle)
    public function toggle(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:produks,id_produk',
        ]);

        $userId = auth('api')->id();

        $existing = Wishlist::where('id_user', $userId)
            ->where('id_produk', $request->id_produk)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['success' => true, 'message' => 'Dihapus dari wishlist', 'in_wishlist' => false]);
        }

        Wishlist::create(['id_user' => $userId, 'id_produk' => $request->id_produk]);

        return response()->json(['success' => true, 'message' => 'Ditambahkan ke wishlist', 'in_wishlist' => true]);
    }
}
