<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Produk;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // GET /api/cart
    public function index()
    {
        $carts = Cart::with('produk.kategori')
            ->where('id_user', auth('api')->id())
            ->get();

        $total = $carts->sum(fn($c) => $c->sub_total);

        return response()->json([
            'success' => true,
            'data'    => $carts,
            'total'   => $total,
        ]);
    }

    // POST /api/cart
    public function store(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:produks,id_produk',
            'qty'       => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->id_produk);

        if ($produk->stok < $request->qty) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi',
            ], 422);
        }

        $cart = Cart::updateOrCreate(
            ['id_user' => auth('api')->id(), 'id_produk' => $request->id_produk],
            ['qty'     => $request->qty]
        );

        return response()->json([
            'success' => true,
            'message' => 'Produk ditambahkan ke cart',
            'data'    => $cart->load('produk'),
        ]);
    }

    // PUT /api/cart/{id}
    public function update(Request $request, $id)
    {
        $cart = Cart::where('id_user', auth('api')->id())->findOrFail($id);
        $request->validate(['qty' => 'required|integer|min:1']);

        $cart->update(['qty' => $request->qty]);

        return response()->json([
            'success' => true,
            'message' => 'Cart diperbarui',
            'data'    => $cart->load('produk'),
        ]);
    }

    // DELETE /api/cart/{id}
    public function destroy($id)
    {
        Cart::where('id_user', auth('api')->id())->findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item dihapus dari cart',
        ]);
    }
}
