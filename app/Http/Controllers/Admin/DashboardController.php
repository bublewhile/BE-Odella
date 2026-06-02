<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Ringkasan statistik
        $stats = [
            'total_pesanan'  => Pesanan::count(),
            'pesanan_baru'   => Pesanan::where('status_pesanan', 'menunggu_pembayaran')->count(),
            'total_produk'   => Produk::where('is_active', true)->count(),
            'total_customer' => User::where('role', 'customer')->count(),
            'total_revenue'  => Pesanan::where('status_pesanan', 'selesai')->sum('total_harga'),
        ];

        // Chart penjualan 6 bulan terakhir (FR-10)
        $chartBulanan = Pesanan::selectRaw('MONTH(tanggal_pesan) as bulan, YEAR(tanggal_pesan) as tahun, SUM(total_harga) as total, COUNT(*) as jumlah')
            ->where('status_pesanan', 'selesai')
            ->where('tanggal_pesan', '>=', now()->subMonths(6))
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        // Produk terlaris
        $produkTerlaris = DB::table('detail_pesanans')
            ->join('produks', 'detail_pesanans.id_produk', '=', 'produks.id_produk')
            ->join('pesanans', 'detail_pesanans.id_pesanan', '=', 'pesanans.id_pesanan')
            ->where('pesanans.status_pesanan', 'selesai')
            ->selectRaw('produks.nama_produk, SUM(detail_pesanans.qty) as total_terjual')
            ->groupBy('produks.id_produk', 'produks.nama_produk')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();

        // Pesanan terbaru
        $pesananTerbaru = Pesanan::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard.index', compact(
            'stats',
            'chartBulanan',
            'produkTerlaris',
            'pesananTerbaru'
        ));
    }
}
