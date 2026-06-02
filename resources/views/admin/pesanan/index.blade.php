@extends('layouts.admin')
@section('title', 'Manajemen Pesanan')
@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-0">Daftar Pesanan</h5>
            <small class="text-muted">Total: {{ $pesanans->total() }} pesanan</small>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body py-2">
            <form method="GET" class="row g-2 align-items-center">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control form-control-sm"
                        placeholder="Cari nama customer..." value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Semua Status</option>
                        @foreach (\App\Models\Pesanan::STATUS as $val => $label)
                            <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>
                                {{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <button class="btn btn-sm btn-outline-secondary">Filter</button>
                    <a href="{{ route('admin.pesanan.index') }}" class="btn btn-sm btn-light">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex gap-2 mb-3 flex-wrap">
        @foreach (\App\Models\Pesanan::STATUS as $val => $label)
            @php $count = \App\Models\Pesanan::where('status_pesanan', $val)->count() @endphp
            <a href="{{ route('admin.pesanan.index', ['status' => $val]) }}"
                class="btn btn-sm {{ request('status') == $val ? 'btn-dark' : 'btn-outline-secondary' }}">
                {{ $label }} <span class="badge bg-danger ms-1">{{ $count }}</span>
            </a>
        @endforeach
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#ID</th>
                        <th>Customer</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Bukti Bayar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanans as $p)
                        <tr>
                            <td class="fw-semibold text-muted">#{{ $p->id_pesanan }}</td>
                            <td>
                                <div class="fw-semibold">{{ $p->user->nama }}</div>
                                <small class="text-muted">{{ $p->user->email }}</small>
                            </td>
                            <td class="small text-muted">
                                {{ $p->tanggal_pesan->format('d M Y') }}<br>{{ $p->tanggal_pesan->format('H:i') }}</td>
                            <td class="fw-semibold">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                            <td>
                                @if ($p->bukti_bayar)
                                    <a href="{{ asset('storage/' . $p->bukti_bayar) }}" target="_blank"
                                        class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-image"></i> Lihat
                                    </a>
                                @else
                                    <span class="text-muted small">Belum upload</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $statusClass = match ($p->status_pesanan) {
                                        'selesai' => 'success',
                                        'dikirim' => 'info',
                                        'diproses' => 'primary',
                                        'pembayaran_diverifikasi' => 'warning',
                                        'dibatalkan' => 'danger',
                                        default => 'secondary',
                                    };
                                @endphp
                                <span class="badge bg-{{ $statusClass }}">{{ $p->status_label }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.pesanan.show', $p->id_pesanan) }}"
                                    class="btn btn-sm btn-outline-secondary">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-bag fs-2 d-block mb-2"></i>Belum ada pesanan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($pesanans->hasPages())
            <div class="card-footer bg-white">{{ $pesanans->appends(request()->query())->links() }}</div>
        @endif
    </div>

@endsection
