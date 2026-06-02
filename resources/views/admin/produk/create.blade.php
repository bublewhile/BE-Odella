@extends('layouts.admin')
@section('title', 'Tambah Produk')
@section('content')

    <div class="mb-4">
        <a href="{{ route('admin.produk.index') }}" class="text-muted text-decoration-none small"><i class="bi bi-arrow-left me-1"></i>Kembali ke daftar produk</a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-semibold">
                    <i class="bi bi-plus-circle me-2" style="color:var(--burgundy)"></i>Tambah Produk Baru
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.produk.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Nama Produk <span class="text-danger">*</span></label>
                                <input type="text" name="nama_produk"
                                    class="form-control @error('nama_produk') is-invalid @enderror"
                                    value="{{ old('nama_produk') }}" placeholder="Contoh: Birthday Cake Coklat" required>
                                @error('nama_produk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Kategori</label>
                                <select name="id_kategori" class="form-select @error('id_kategori') is-invalid @enderror">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($kategoris as $kat)
                                        <option value="{{ $kat->id_kategori }}"
                                            {{ old('id_kategori') == $kat->id_kategori ? 'selected' : '' }}>
                                            {{ $kat->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Harga (Rp) <span class="text-danger">*</span></label>
                                <input type="number" name="harga"
                                    class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga') }}"
                                    min="0" required>
                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Stok <span class="text-danger">*</span></label>
                                <input type="number" name="stok"
                                    class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', 0) }}"
                                    min="0" required>
                                @error('stok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4"
                                    placeholder="Deskripsi produk...">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Gambar Produk</label>
                                <input type="file" name="gambar" id="gambarInput"
                                    class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
                                @error('gambar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="mt-2">
                                    <img id="preview" src="" class="rounded"
                                        style="max-height:150px;display:none;">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                        id="isActive" {{ old('is_active', 1) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="isActive">Produk Aktif (tampil di katalog)</label>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn" style="background:var(--burgundy);color:#fff;">
                                <i class="bi bi-check-lg me-1"></i> Simpan Produk
                            </button>
                            <a href="{{ route('admin.produk.index') }}" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.getElementById('gambarInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function(ev) {
                const img = document.getElementById('preview');
                img.src = ev.target.result;
                img.style.display = 'block';
            };
            reader.readAsDataURL(file);
        });
    </script>
@endpush
