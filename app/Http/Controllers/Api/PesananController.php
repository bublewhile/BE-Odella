<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Pesanan;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    // GET /api/pesanan
    public function index()
    {
        $pesanans = Pesanan::with('detailPesanans.produk')
            ->where('id_user', auth('api')->id())
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $pesanans,
        ]);
    }

    // GET /api/pesanan/{id}
    public function show($id)
    {
        $pesanan = Pesanan::with('detailPesanans.produk')
            ->where('id_user', auth('api')->id())
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $pesanan,
        ]);
    }

    // POST /api/pesanan/checkout  (FR-06, FR-13 - database transaction)
    public function checkout(Request $request)
    {
        $request->validate([
            'alamat_pengiriman' => 'required|string',
            'kode_promo'        => 'nullable|string|exists:promos,kode_promo',
        ]);

        $userId = auth('api')->id();

        return DB::transaction(function () use ($request, $userId) {
            $carts = Cart::with('produk')
                ->where('id_user', $userId)
                ->get();

            if ($carts->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart kosong',
                ], 422);
            }

            // Validasi stok
            foreach ($carts as $cart) {
                if ($cart->produk->stok < $cart->qty) {
                    return response()->json([
                        'success' => false,
                        'message' => "Stok {$cart->produk->nama_produk} tidak mencukupi",
                    ], 422);
                }
            }

            $totalHarga = $carts->sum(fn($c) => $c->qty * $c->produk->harga);
            $diskon     = 0;

            // Cek promo
            if ($request->filled('kode_promo')) {
                $promo = Promo::where('kode_promo', $request->kode_promo)->aktif()->first();
                if ($promo) {
                    $diskon = $totalHarga * ($promo->persen_diskon / 100);
                }
            }

            // Buat pesanan
            $pesanan = Pesanan::create([
                'id_user'           => $userId,
                'tanggal_pesan'     => now(),
                'status_pesanan'    => 'menunggu_pembayaran',
                'total_harga'       => $totalHarga - $diskon,
                'alamat_pengiriman' => $request->alamat_pengiriman,
                'kode_promo'        => $request->kode_promo,
                'diskon'            => $diskon,
            ]);

            // Buat detail pesanan & kurangi stok
            foreach ($carts as $cart) {
                $pesanan->detailPesanans()->create([
                    'id_produk' => $cart->id_produk,
                    'qty'       => $cart->qty,
                    'sub_total' => $cart->qty * $cart->produk->harga,
                ]);

                $cart->produk->decrement('stok', $cart->qty);
            }

            // Hapus cart
            Cart::where('id_user', $userId)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat',
                'data'    => $pesanan->load('detailPesanans.produk'),
            ], 201);
        });
    }

    // POST /api/pesanan/{id}/bukti-bayar  (FR-06 upload bukti)
    public function uploadBuktiBayar(Request $request, $id)
    {
        $request->validate([
            'bukti_bayar' => 'required|image|max:2048',
        ]);

        $pesanan = Pesanan::where('id_user', auth('api')->id())
            ->where('status_pesanan', 'menunggu_pembayaran')
            ->findOrFail($id);

        $path = $request->file('bukti_bayar')->store('bukti_bayar', 'public');

        $pesanan->update([
            'bukti_bayar' => $path,
            'tgl_bayar'   => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bukti pembayaran berhasil diupload',
            'data'    => $pesanan,
        ]);
    }
}
