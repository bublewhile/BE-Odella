@extends('layouts.admin')
@section('title', 'Detail Pesanan #' . $pesanan->id_pesanan)
@section('content')

    <div class="mb-3"><a href="{{ route('admin.pesanan.index') }}"class="btn btn-sm btn-secondary">← Kembali</a></div>
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between">
                    <strong>Info Pesanan</strong>
                    <span
                        class="badge bg-{{ match ($pesanan->status_pesanan) {
                            'selesai' => 'success',
                            'dikirim' => 'info',
                            'diproses' => 'primary',
                            'pembayaran_diverifikasi' => 'warning',
                            'dibatalkan' => 'danger',
                            default => 'secondary',
                        } }}">{{ $pesanan->status_label }}</span>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th width="35%">ID Pesanan</th>
                            <td>#{{ $pesanan->id_pesanan }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Pesan</th>
                            <td>{{ $pesanan->tanggal_pesan->format('d M Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Customer</th>
                            <td>{{ $pesanan->user->nama }}<br><small>{{ $pesanan->user->email }}</small></td>
                        </tr>
                        <tr>
                            <th>Alamat Kirim</th>
                            <td>{{ $pesanan->alamat_pengiriman }}</td>
                        </tr>
                        @if ($pesanan->kode_promo)
                            <tr>
                                <th>Kode Promo</th>
                                <td><span class="badge bg-success">{{ $pesanan->kode_promo }}</span></td>
                            </tr>
                            <tr>
                                <th>Diskon</th>
                                <td class="text-success">- Rp {{ number_format($pesanan->diskon, 0, ',', '.') }}</td>
                            </tr>
                        @endif
                        <tr>
                            <th>Total Harga</th>
                            <td class="fw-bold" style="color:#860120">Rp
                                {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                        </tr>
                        @if ($pesanan->tgl_bayar)
                            <tr>
                                <th>Tanggal Bayar</th>
                                <td>{{ $pesanan->tgl_bayar->format('d M Y, H:i') }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><strong>Detail Produk</strong></div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Harga</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pesanan->detailPesanans as $d)
                                <tr>
                                    <td>
                                        @if ($d->produk->gambar)
                                            <img src="{{ asset('storage/' . $d->produk->gambar) }}"
                                                style="width:30px;height:30px;object-fit:cover" class="rounded me-2">
                                        @endif
                                        {{ $d->produk->nama_produk }}
                                    </td>
                                    <td class="text-center">x{{ $d->qty }}</td>
                                    <td class="text-end">Rp {{ number_format($d->produk->harga, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp {{ number_format($d->sub_total, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="3" class="text-end">Total</th>
                                <th class="text-end" style="color:#860120">Rp
                                    {{ number_format($pesanan->total_harga, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header"><strong>Bukti Pembayaran</strong></div>
                <div class="card-body text-center">
                    @if ($pesanan->bukti_bayar)
                        <img src="{{ asset('storage/' . $pesanan->bukti_bayar) }}" class="img-fluid mb-2"
                            style="max-height:180px">
                        @if ($pesanan->status_pesanan === 'menunggu_pembayaran')
                            <form method="POST" action="{{ route('admin.pesanan.verifikasi', $pesanan->id_pesanan) }}">
                                @csrf @method('PUT')
                                <button class="btn btn-sm btn-success w-100"
                                    onclick="return confirm('Verifikasi pembayaran?')">Verifikasi</button>
                            </form>
                        @else
                            <span class="badge bg-success">Terverifikasi</span>
                        @endif
                    @else
                        <div class="text-muted py-3">Belum ada bukti</div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header"><strong>Update Status</strong></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.pesanan.status', $pesanan->id_pesanan) }}">
                        @csrf @method('PUT')
                        <select name="status_pesanan" class="form-select form-select-sm mb-2">
                            @foreach (\App\Models\Pesanan::STATUS as $val => $label)
                                <option value="{{ $val }}"
                                    {{ $pesanan->status_pesanan === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm w-100">Simpan Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
