<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    // GET /api/produk
    public function index(Request $request)
    {
        $query = Produk::with('kategori')
            ->where('is_active', true);

        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        if ($request->filled('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        // append gambar_url accessor ke setiap item paginator
        $produks = $query->latest()->paginate(12);
        $produks->getCollection()->transform(function ($produk) {
            $produk->append('gambar_url');
            return $produk;
        });

        return response()->json([
            'success' => true,
            'data'    => $produks,
        ]);
    }

    // GET /api/produk/{id}
    public function show($id)
    {
        $produk = Produk::with(['kategori', 'ratings.user', 'promos' => fn($q) => $q->aktif()])
            ->where('is_active', true)
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => array_merge($produk->toArray(), [
                'rating_rata' => $produk->rating_rata,
                'gambar_url'  => $produk->gambar_url,
            ]),
        ]);
    }
}
