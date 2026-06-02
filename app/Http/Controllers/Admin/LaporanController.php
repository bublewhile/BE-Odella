<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\LaporanPenjualanExport;
use App\Models\Pesanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggalMulai = $request->get('dari', now()->startOfMonth()->format('Y-m-d'));
        $tanggalAkhir = $request->get('sampai', now()->format('Y-m-d'));

        $pesanans = Pesanan::with('user', 'detailPesanans.produk')
            ->whereBetween('tanggal_pesan', [$tanggalMulai, $tanggalAkhir . ' 23:59:59'])
            ->where('status_pesanan', 'selesai')
            ->latest()
            ->paginate(20);

        $totalRevenue = Pesanan::whereBetween('tanggal_pesan', [$tanggalMulai, $tanggalAkhir . ' 23:59:59'])
            ->where('status_pesanan', 'selesai')
            ->sum('total_harga');

        return view('admin.laporan.index', compact('pesanans', 'tanggalMulai', 'tanggalAkhir', 'totalRevenue'));
    }

    // GET /admin/laporan/export-excel  (FR-11)
    public function exportExcel(Request $request)
    {
        $dari    = $request->get('dari', now()->startOfMonth()->format('Y-m-d'));
        $sampai  = $request->get('sampai', now()->format('Y-m-d'));
        $filename = 'laporan_penjualan_' . $dari . '_sd_' . $sampai . '.xlsx';

        return Excel::download(new LaporanPenjualanExport($dari, $sampai), $filename);
    }

    // GET /admin/laporan/export-pdf  (FR-11)
    public function exportPdf(Request $request)
    {
        $dari   = $request->get('dari', now()->startOfMonth()->format('Y-m-d'));
        $sampai = $request->get('sampai', now()->format('Y-m-d'));

        $pesanans = Pesanan::with('user', 'detailPesanans.produk')
            ->whereBetween('tanggal_pesan', [$dari, $sampai . ' 23:59:59'])
            ->where('status_pesanan', 'selesai')
            ->latest()
            ->get();

        $totalRevenue = $pesanans->sum('total_harga');

        $pdf = Pdf::loadView('admin.laporan.pdf', compact('pesanans', 'dari', 'sampai', 'totalRevenue'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('laporan_penjualan.pdf');
    }
}
