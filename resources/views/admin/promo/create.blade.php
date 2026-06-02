@extends('layouts.admin')
@section('title', 'Tambah Promo')
@section('content')

<div class="mb-4">
    <a href="{{ route('admin.promo.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="card shadow-sm" style="max-width:640px">
    <div class="card-header bg-white fw-semibold">
        <i class="bi bi-percent me-2 text-success"></i>Form Tambah Promo
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.promo.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold small">Kode Promo <span class="text-danger">*</span></label>
                <input type="text" name="kode_promo" class="form-control @error('kode_promo') is-invalid @enderror"
                       value="{{ old('kode_promo') }}" placeholder="contoh: ODELLA20" style="text-transform:uppercase">
                @error('kode_promo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold small">Khusus Produk</label>
                <select name="id_produk" class="form-select @error('id_produk') is-invalid @enderror">
                    <option value="">Berlaku untuk semua produk</option>
                    @foreach($produks as $p)
                        <option value="{{ $p->id_produk }}" {{ old('id_produk') == $p->id_produk ? 'selected' : '' }}>
                            {{ $p->nama_produk }}
                        </option>
                    @endforeach
                </select>
                @error('id_produk')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold small">Persen Diskon (%) <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="number" name="persen_diskon" class="form-control @error('persen_diskon') is-invalid @enderror"
                           value="{{ old('persen_diskon') }}" min="1" max="100" step="0.01" placeholder="20">
                    <span class="input-group-text">%</span>
                    @error('persen_diskon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Tanggal Berlaku <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="tgl_berlaku" class="form-control @error('tgl_berlaku') is-invalid @enderror"
                           value="{{ old('tgl_berlaku') }}">
                    @error('tgl_berlaku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Tanggal Berakhir <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="tgl_berakhir" class="form-control @error('tgl_berakhir') is-invalid @enderror"
                           value="{{ old('tgl_berakhir') }}">
                    @error('tgl_berakhir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1"
                           id="isActive" {{ old('is_active', '1') ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold small" for="isActive">Aktifkan promo</label>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Simpan Promo
                </button>
                <a href="{{ route('admin.promo.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
