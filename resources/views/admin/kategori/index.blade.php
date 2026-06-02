@extends('layouts.admin')
@section('title', 'Kategori Produk')
@section('content')

    <div class="row g-4">
        <div class="col-md-4 col-lg-3">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-plus-circle me-2" style="color:var(--burgundy)"></i>Tambah Kategori
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.kategori.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" name="nama_kategori"
                                class="form-control @error('nama_kategori') is-invalid @enderror"
                                value="{{ old('nama_kategori') }}" placeholder="Contoh: Cake, Pastry..." required>
                            @error('nama_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100 btn-sm">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-lg-9">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <span class="fw-semibold" style="font-size:.9rem">Daftar Kategori</span>
                    <span class="ms-2 badge bg-light" style="font-size:.72rem">{{ $kategoris->total() }} kategori</span>
                </div>
            </div>

            @if ($kategoris->isEmpty())
                <div class="empty-state">
                    <i class="bi bi-tags"></i>
                    Belum ada kategori. Tambahkan kategori pertama!
                </div>
            @else
                <div class="row g-3">
                    @foreach ($kategoris as $kat)
                        <div class="col-sm-6 col-lg-4">
                            <div class="kat-card">
                                <div class="kat-icon">
                                    <i class="bi bi-tags-fill"></i>
                                </div>
                                <div class="kat-body">
                                    <div class="kat-name">{{ $kat->nama_kategori }}</div>
                                    <div class="kat-count">{{ $kat->produks_count }} produk terdaftar</div>
                                </div>
                                <div class="kat-actions">
                                    <button class="kat-btn kat-btn--edit" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $kat->id_kategori }}" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form method="POST" action="{{ route('admin.kategori.destroy', $kat->id_kategori) }}"
                                        class="d-inline"
                                        onsubmit="return confirm('Hapus kategori {{ $kat->nama_kategori }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="kat-btn kat-btn--del" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="editModal{{ $kat->id_kategori }}" tabindex="-1">
                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title" style="font-size:.9rem">Edit Kategori</h6>
                                        <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form method="POST" action="{{ route('admin.kategori.update', $kat->id_kategori) }}">
                                        @csrf @method('PUT')
                                        <div class="modal-body">
                                            <input type="text" name="nama_kategori" class="form-control"
                                                value="{{ $kat->nama_kategori }}" required>
                                        </div>
                                        <div class="modal-footer" style="padding:.65rem 1rem">
                                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($kategoris->hasPages())
                    {{ $kategoris->links() }}
                @endif
            @endif
        </div>
    </div>

@endsection

@push('styles')
    <style>
        .kat-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1rem 1rem .85rem;
            display: flex;
            align-items: center;
            gap: .85rem;
            transition: box-shadow .15s, border-color .15s;
        }

        .kat-card:hover {
            box-shadow: var(--shadow-md);
            border-color: var(--cream-mid);
        }

        .kat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--burgundy-muted);
            border: 1px solid rgba(134, 1, 32, .12);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--burgundy);
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .kat-body {
            flex: 1;
            min-width: 0;
        }

        .kat-name {
            font-weight: 600;
            font-size: .875rem;
            color: var(--text-main);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .kat-count {
            font-size: .72rem;
            color: var(--text-light);
            margin-top: .1rem;
        }

        .kat-actions {
            display: flex;
            gap: .3rem;
            flex-shrink: 0;
        }

        .kat-btn {
            width: 28px;
            height: 28px;
            border-radius: 7px;
            border: 1px solid var(--border);
            background: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .78rem;
            transition: all .12s;
            color: var(--text-muted);
        }

        .kat-btn:hover {
            background: var(--cream-dark);
            color: var(--text-main);
        }

        .kat-btn--del:hover {
            background: #fbeaed;
            border-color: #f0b8c3;
            color: var(--burgundy);
        }
    </style>
@endpush
