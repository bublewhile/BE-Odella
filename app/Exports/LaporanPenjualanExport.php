<?php

namespace App\Exports;

use App\Models\Pesanan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanPenjualanExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithTitle,
    ShouldAutoSize
{
    protected string $dari;
    protected string $sampai;
    protected int $no = 0;

    public function __construct(string $dari, string $sampai)
    {
        $this->dari   = $dari;
        $this->sampai = $sampai;
    }

    public function collection()
    {
        return Pesanan::with('user', 'detailPesanans.produk')
            ->whereBetween('tanggal_pesan', [$this->dari, $this->sampai . ' 23:59:59'])
            ->where('status_pesanan', 'selesai')
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'ID Pesanan',
            'Tanggal',
            'Customer',
            'Email',
            'Produk',
            'Diskon (Rp)',
            'Kode Promo',
            'Total (Rp)',
        ];
    }

    public function map($row): array
    {
        $this->no++;

        $produk = $row->detailPesanans->map(fn($d) => $d->produk->nama_produk . ' x' . $d->qty)->implode(', ');

        return [
            $this->no,
            '#' . $row->id_pesanan,
            $row->tanggal_pesan->format('d/m/Y'),
            $row->user->nama,
            $row->user->email,
            $produk,
            $row->diskon > 0 ? $row->diskon : 0,
            $row->kode_promo ?? '-',
            $row->total_harga,
        ];
    }

    public function title(): string
    {
        return 'Laporan Penjualan';
    }
}
