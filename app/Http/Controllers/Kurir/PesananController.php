<?php

namespace App\Http\Controllers\Kurir;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;

class PesananController extends Controller
{
    public function kirim($id)
    {
        $pesanan = Pesanan::where('status_pesanan', 'diproses')->findOrFail($id);
        $pesanan->update(['status_pesanan' => 'dikirim']);

        return redirect()->back()->with('success', "Pesanan #{$id} ditandai dikirim");
    }

    public function selesai($id)
    {
        $pesanan = Pesanan::where('status_pesanan', 'dikirim')->findOrFail($id);
        $pesanan->update(['status_pesanan' => 'selesai']);

        return redirect()->back()->with('success', "Pesanan #{$id} selesai");
    }
}
