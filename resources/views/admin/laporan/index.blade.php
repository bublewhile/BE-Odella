@extends('layouts.admin')
@section('title', 'Laporan Penjualan')
@section('content')

    <div class="card shadow-sm mb-4">
        <div class="card-body py-3">
            <form method="GET" class="row g-2 align-items-end filter-row-mobile">
                <div class="col-6 col-md-3">
                    <label class="form-label small fw-semibold mb-1">Dari Tanggal</label>
                    <input type="date" name="dari" class="form-control form-control-sm" value="{{ $tanggalMulai }}">
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label small fw-semibold mb-1">Sampai Tanggal</label>
                    <input type="date" name="sampai" class="form-control form-control-sm" value="{{ $tanggalAkhir }}">
                </div>
                <div class="col-12 col-md-2">
                    <button type="submit" class="btn btn-sm btn-primary w-100">
                        <i class="bi bi-funnel me-1"></i>Filter
                    </button>
                </div>
                <div class="col-12 col-md-4 d-flex gap-2">
                    <a href="{{ route('admin.laporan.excel', ['dari' => $tanggalMulai, 'sampai' => $tanggalAkhir]) }}"
                        class="btn btn-sm btn-success flex-fill">
                        <i class="bi bi-file-earmark-excel me-1"></i><span class="d-none d-sm-inline">Export </span>Excel
                    </a>
                    <a href="{{ route('admin.laporan.pdf', ['dari' => $tanggalMulai, 'sampai' => $tanggalAkhir]) }}"
                        class="btn btn-sm btn-danger flex-fill" target="_blank">
                        <i class="bi bi-file-earmark-pdf me-1"></i><span class="d-none d-sm-inline">Export </span>PDF
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-sm-4">
            <div class="card text-center">
                <div class="card-body py-2">
                    <div class="small text-muted">Total Revenue</div>
                    <div class="fw-bold" style="color:#860120">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card text-center">
                <div class="card-body py-2">
                    <div class="small text-muted">Jumlah Pesanan</div>
                    <div class="fw-bold text-primary">{{ $pesanans->total() }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card text-center">
                <div class="card-body py-2">
                    <div class="small text-muted">Rata-rata</div>
                    <div class="fw-bold text-success">Rp
                        {{ $pesanans->total() > 0 ? number_format($totalRevenue / $pesanans->total(), 0, ',', '.') : '0' }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-sm mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Tgl</th>
                        <th>Customer</th>
                        <th>Produk</th>
                        <th>Diskon</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanans as $p)
                        <tr>
                            <td class="text-muted">#{{ $p->id_pesanan }}</td>
                            <td>{{ $p->tanggal_pesan->format('d/m/Y') }}</td>
                            <td>{{ $p->user->nama }}<br><span class="small text-muted">{{ $p->user->email }}</span></td>
                            <td class="small">
                                @foreach ($p->detailPesanans as $d)
                                    {{ $d->produk->nama_produk }} x{{ $d->qty }}<br>
                                @endforeach
                            </td>
                            <td class="small">
                                @if ($p->diskon > 0)
                                    -Rp {{ number_format($p->diskon, 0, ',', '.') }}
                                    @if ($p->kode_promo)
                                        <span class="badge bg-light">{{ $p->kode_promo }}</span>
                                    @endif
                                @else
                                    —
                                @endif
                            </td>
                            <td class="fw-bold" style="color:#860120">Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                            </td>
                            <td><a href="{{ route('admin.pesanan.show', $p->id_pesanan) }}"
                                    class="btn btn-sm btn-outline-secondary">Detail</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-3">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($pesanans->hasPages())
            <div class="card-footer">{{ $pesanans->withQueryString()->links() }}</div>
        @endif
    </div>
@endsection
