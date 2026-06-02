<?php

namespace App\Http\Controllers\Kurir;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;

class DashboardController extends Controller
{
    public function index()
    {
        $pesanans = Pesanan::with('user')
            ->whereIn('status_pesanan', ['pembayaran_diverifikasi', 'diproses', 'dikirim'])
            ->latest()
            ->paginate(15);

        $stats = [
            'perlu_dikirim' => Pesanan::where('status_pesanan', 'diproses')->count(),
            'sedang_dikirim'=> Pesanan::where('status_pesanan', 'dikirim')->count(),
            'selesai_hari_ini' => Pesanan::where('status_pesanan', 'selesai')
                ->whereDate('updated_at', today())
                ->count(),
        ];

        return view('kurir.dashboard', compact('pesanans', 'stats'));
    }
}
