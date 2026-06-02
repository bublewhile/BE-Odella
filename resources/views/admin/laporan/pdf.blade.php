<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan - Odella Bakery</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        td,
        th {
            border: 1px solid #ccc;
            padding: 4px 6px;
            vertical-align: top;
        }

        .header {
            background: #860120;
            color: white;
            padding: 6px 10px;
            margin-bottom: 15px;
        }

        .judul {
            font-size: 14px;
            font-weight: bold;
        }

        .periode {
            font-size: 9px;
        }

        .summary-table td {
            background: #f9f9f9;
            text-align: center;
            width: 33%;
        }

        .total-revenue {
            color: #860120;
            font-weight: bold;
        }

        .total-pesanan {
            color: #1976d2;
            font-weight: bold;
        }

        .rata-rata {
            color: #388e3c;
            font-weight: bold;
        }

        .total-col {
            font-weight: bold;
        }

        .footer {
            text-align: center;
            font-size: 9px;
            border-top: 1px solid #ccc;
            padding-top: 6px;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="judul">Odella Bakery - Laporan Penjualan</div>
        <div class="periode">
            Periode: {{ \Carbon\Carbon::parse($dari)->format('d M Y') }} s/d
            {{ \Carbon\Carbon::parse($sampai)->format('d M Y') }}<br>
            Dicetak: {{ now()->format('d/m/Y H:i') }}
        </div>
    </div>

    <table class="summary-table">
        <tr>
            <td>
                <strong>Total Pendapatan</strong><br>
                <span class="total-revenue">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
            </td>
            <td>
                <strong>Jumlah Pesanan</strong><br>
                <span class="total-pesanan">{{ $pesanans->count() }}</span>
            </td>
            <td>
                <strong>Rata-rata per Pesanan</strong><br>
                <span class="rata-rata">Rp
                    {{ $pesanans->count() > 0 ? number_format($totalRevenue / $pesanans->count(), 0, ',', '.') : '0' }}</span>
            </td>
        </tr>
    </table>

    <table>
        <thead style="background:#860120; color:white;">
            <tr>
                <th>#ID</th>
                <th>Tgl</th>
                <th>Customer</th>
                <th>Produk</th>
                <th>Diskon</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pesanans as $p)
                <tr>
                    <td>#{{ $p->id_pesanan }}</td>
                    <td>{{ $p->tanggal_pesan->format('d/m/Y') }}</td>
                    <td>{{ $p->user->nama }}<br><span style="color:#666">{{ $p->user->email }}</span></td>
                    <td>
                        @foreach ($p->detailPesanans as $d)
                            {{ $d->produk->nama_produk }} ({{ $d->qty }}x)<br>
                        @endforeach
                    </td>
                    <td>
                        @if ($p->diskon > 0)
                            @if ($p->kode_promo)
                                {{ $p->kode_promo }}<br>
                            @endif
                            - Rp {{ number_format($p->diskon, 0, ',', '.') }}
                        @else
                            —
                        @endif
                    </td>
                    <td class="total-col">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" style="text-align:right"><strong>TOTAL</strong></td>
                <td class="total-col">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Dicetak oleh sistem Odella Bakery
    </div>

</body>

</html>
