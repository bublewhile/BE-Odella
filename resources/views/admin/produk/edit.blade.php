@extends('layouts.admin')
@section('title', 'Edit Produk')
@section('content')

<div class="mb-4">
    <a href="{{ route('admin.produk.index') }}" class="text-muted text-decoration-none small"><i class="bi bi-arrow-left me-1"></i>Kembali ke daftar produk</a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-pencil-square me-2" style="color:var(--burgundy)"></i>Edit Produk
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.produk.update', $produk->id_produk) }}" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" name="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror"
                                   value="{{ old('nama_produk', $produk->nama_produk) }}" required>
                            @error('nama_produk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Kategori</label>
                            <select name="id_kategori" class="form-select">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $kat)
                                    <option value="{{ $kat->id_kategori }}"
                                        {{ old('id_kategori', $produk->id_kategori) == $kat->id_kategori ? 'selected' : '' }}>
                                        {{ $kat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror"
                                   value="{{ old('harga', $produk->harga) }}" min="0" required>
                            @error('harga') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Stok <span class="text-danger">*</span></label>
                            <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror"
                                   value="{{ old('stok', $produk->stok) }}" min="0" required>
                            @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Ganti Gambar</label>
                            @if($produk->gambar)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$produk->gambar) }}" class="rounded" style="max-height:120px;" id="preview">
                                </div>
                            @else
                                <img id="preview" src="" class="rounded mb-2" style="max-height:120px;display:none;">
                            @endif
                            <input type="file" name="gambar" id="gambarInput" class="form-control" accept="image/*">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti gambar</small>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                       id="isActive" {{ old('is_active', $produk->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="isActive">Produk Aktif</label>
                            </div>
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn" style="background:var(--burgundy);color:#fff;">
                            <i class="bi bi-check-lg me-1"></i> Update Produk
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
