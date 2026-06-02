@extends('layouts.admin')

@section('title', 'Manajemen Produk')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-0">Daftar Produk</h5>
            <small class="text-muted">Total: {{ $produks->total() }} produk</small>
        </div>
        <a href="{{ route('admin.produk.create') }}" class="btn btn-sm" style="background:var(--burgundy);color:#fff;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Produk
        </a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body py-2">
            <form method="GET" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <input type="text" name="search" class="form-control form-control-sm"
                        placeholder="Cari nama produk..." value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <select name="kategori" class="form-select form-select-sm">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoris as $kat)
                            <option value="{{ $kat->id_kategori }}"
                                {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <button class="btn btn-sm btn-outline-secondary">Filter</button>
                    <a href="{{ route('admin.produk.index') }}" class="btn btn-sm btn-light">Reset</a>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="60">Gambar</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produks as $produk)
                        <tr>
                            <td>
                                @if ($produk->gambar)
                                    <img src="{{ asset('storage/' . $produk->gambar) }}" class="rounded" width="48"
                                        height="48" style="object-fit:cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                        style="width:48px;height:48px;">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $produk->nama_produk }}</div>
                                <small class="text-muted">{{ Str::limit($produk->deskripsi, 50) }}</small>
                            </td>
                            <td><span
                                    class="badge bg-light text-dark border">{{ $produk->kategori->nama_kategori ?? '-' }}</span>
                            </td>
                            <td class="fw-semibold">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                            <td>
                                <span
                                    class="badge {{ $produk->stok > 5 ? 'bg-success' : ($produk->stok > 0 ? 'bg-warning text-dark' : 'bg-danger') }}">
                                    {{ $produk->stok }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $produk->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $produk->is_active ? 'Aktif' : 'Non-aktif' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.produk.edit', $produk->id_produk) }}"
                                    class="btn btn-sm btn-outline-primary btn-icon">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.produk.destroy', $produk->id_produk) }}"
                                    class="d-inline" onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-box-seam fs-2 d-block mb-2"></i>
                                Belum ada produk. <a href="{{ route('admin.produk.create') }}">Tambah sekarang</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($produks->hasPages())
            <div class="card-footer bg-white">
                {{ $produks->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

@endsection
