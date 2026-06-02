<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $query = Pesanan::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status_pesanan', $request->status);
        }

        if ($request->filled('search')) {
            $query->whereHas('user', fn($q) => $q->where('nama', 'like', '%' . $request->search . '%'));
        }

        $pesanans = $query->paginate(20);

        return view('admin.pesanan.index', compact('pesanans'));
    }

    public function show($id)
    {
        $pesanan = Pesanan::with('user', 'detailPesanans.produk')->findOrFail($id);
        return view('admin.pesanan.show', compact('pesanan'));
    }

    // PUT /admin/pesanan/{id}/status  (FR-08)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_pesanan' => 'required|in:' . implode(',', array_keys(Pesanan::STATUS)),
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update(['status_pesanan' => $request->status_pesanan]);

        return redirect()->back()->with('success', 'Status pesanan diperbarui');
    }

    // PUT /admin/pesanan/{id}/verifikasi
    public function verifikasiBayar($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        if (!$pesanan->bukti_bayar) {
            return redirect()->back()->with('error', 'Belum ada bukti pembayaran');
        }

        $pesanan->update(['status_pesanan' => 'pembayaran_diverifikasi']);

        return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi');
    }
}
