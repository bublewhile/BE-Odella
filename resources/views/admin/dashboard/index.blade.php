@extends('layouts.admin')
@section('title', 'Dashboard Penjualan')
@section('content')

    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="stat-card accent-1">
                <div class="stat-label">Pendapatan</div>
                <div class="stat-value">Rp {{ number_format($stats['total_revenue'] / 1000, 0, ',', '.') }}k</div>
                <div class="stat-change up"><i class="bi bi-arrow-up-short"></i> Revenue total</div>
                <i class="bi bi-cash-stack stat-icon"></i>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card accent-2">
                <div class="stat-label">Pesanan</div>
                <div class="stat-value">{{ $stats['total_pesanan'] }}</div>
                <div class="stat-change up"><i class="bi bi-arrow-up-short"></i> Total pesanan</div>
                <i class="bi bi-bag stat-icon"></i>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card accent-4">
                <div class="stat-label">Produk Aktif</div>
                <div class="stat-value">{{ $stats['total_produk'] }}</div>
                <div class="stat-change"><i class="bi bi-dot"></i> Total produk</div>
                <i class="bi bi-box-seam stat-icon"></i>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card accent-3">
                <div class="stat-label">Customer</div>
                <div class="stat-value">{{ $stats['total_customer'] }}</div>
                <div class="stat-change up"><i class="bi bi-arrow-up-short"></i> Total pengguna</div>
                <i class="bi bi-people stat-icon"></i>
            </div>
        </div>
    </div>

    @if ($stats['pesanan_baru'] > 0)
        <div class="alert alert-warning d-flex align-items-center gap-2 mb-4">
            <i class="bi bi-clock-history"></i>
            Ada <strong>{{ $stats['pesanan_baru'] }}</strong> pesanan menunggu verifikasi pembayaran.
            <a href="{{ route('admin.pesanan.index', ['status' => 'menunggu_pembayaran']) }}"
                class="ms-auto btn btn-sm btn-primary">Lihat Sekarang</a>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <span><i class="bi bi-bar-chart me-2" style="color:var(--burgundy)"></i>Penjualan 6 Bulan
                        Terakhir</span>
                </div>
                <div class="card-body">
                    <canvas id="chartBulanan" height="110"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <i class="bi bi-trophy me-2" style="color:#C47D2E"></i>Produk Terlaris
                </div>
                <div class="card-body p-0">
                    @foreach ($produkTerlaris as $i => $p)
                        <div class="d-flex align-items-center gap-3 px-3 py-2 {{ $i < count($produkTerlaris) - 1 ? 'border-bottom' : '' }}"
                            style="border-color:var(--cream-dark)!important">
                            <div
                                style="width:22px;height:22px;border-radius:50%;background:var(--burgundy-muted);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:700;color:var(--burgundy);flex-shrink:0">
                                {{ $i + 1 }}</div>
                            <span class="flex-grow-1 small">{{ $p->nama_produk }}</span>
                            <span class="badge bg-light" style="font-size:.7rem">{{ $p->total_terjual }}x</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-clock-history me-2" style="color:var(--burgundy)"></i>Pesanan Terbaru</span>
                    <a href="{{ route('admin.pesanan.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Customer</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pesananTerbaru as $p)
                                <tr>
                                    <td class="text-muted small fw-semibold">#{{ $p->id_pesanan }}</td>
                                    <td class="fw-semibold">{{ $p->user->nama }}</td>
                                    <td class="small text-muted">{{ $p->tanggal_pesan->format('d M Y') }}</td>
                                    <td class="fw-semibold">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="status-pill {{ $p->status_pesanan }}">{{ $p->status_label }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.pesanan.show', $p->id_pesanan) }}"
                                            class="btn btn-sm btn-outline-secondary">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        const ctx = document.getElementById('chartBulanan').getContext('2d');
        const labels = @json($chartBulanan->map(fn($c) => \Carbon\Carbon::create($c->tahun, $c->bulan)->translatedFormat('M Y')));
        const data = @json($chartBulanan->pluck('total'));

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Penjualan (Rp)',
                    data: data,
                    backgroundColor: 'rgba(134,1,32,.15)',
                    borderColor: '#860120',
                    borderWidth: 2,
                    borderRadius: 6,
                    hoverBackgroundColor: 'rgba(134,1,32,.3)',
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#7A5C5C',
                            font: {
                                size: 11
                            }
                        }
                    },
                    y: {
                        grid: {
                            color: 'rgba(0,0,0,.04)'
                        },
                        ticks: {
                            color: '#7A5C5C',
                            font: {
                                size: 11
                            },
                            callback: v => 'Rp ' + new Intl.NumberFormat('id').format(v)
                        }
                    }
                }
            }
        });
    </script>
@endpush
