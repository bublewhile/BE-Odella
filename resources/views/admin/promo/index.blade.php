@extends('layouts.admin')
@section('title', 'Manajemen Promo')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Daftar Promo & Voucher</h5>
        <p class="text-muted small mb-0">Total: {{ $promos->total() }} promo</p>
    </div>
    <a href="{{ route('admin.promo.create') }}" class="btn btn-sm text-white fw-semibold"
       style="background:linear-gradient(135deg,var(--burgundy),var(--burgundy));border:none">
        <i class="bi bi-plus-lg me-1"></i>Tambah Promo
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">#</th>
                        <th>Kode Promo</th>
                        <th>Produk</th>
                        <th>Diskon</th>
                        <th>Berlaku</th>
                        <th>Berakhir</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($promos as $i => $promo)
                    <tr>
                        <td class="ps-3 text-muted small">{{ $promos->firstItem() + $i }}</td>
                        <td>
                            <code class="bg-light px-2 py-1 rounded fw-bold text-danger">{{ $promo->kode_promo }}</code>
                        </td>
                        <td class="small">{{ $promo->produk->nama_produk ?? '<span class="text-muted">Semua Produk</span>' }}</td>
                        <td>
                            <span class="badge bg-success fs-6">{{ $promo->persen_diskon }}%</span>
                        </td>
                        <td class="small">{{ $promo->tgl_berlaku->format('d M Y') }}</td>
                        <td class="small">{{ $promo->tgl_berakhir->format('d M Y') }}</td>
                        <td>
                            @if($promo->masih_berlaku)
                                <span class="badge bg-success-subtle text-success border border-success-subtle">Aktif</span>
                            @elseif(!$promo->is_active)
                                <span class="badge bg-secondary-subtle text-secondary border">Nonaktif</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Kedaluwarsa</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('admin.promo.edit', $promo->id_promo) }}"
                                   class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.promo.destroy', $promo->id_promo) }}"
                                      onsubmit="return confirm('Hapus promo ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-percent fs-2 d-block mb-2"></i>
                            Belum ada promo
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($promos->hasPages())
    <div class="card-footer bg-white">{{ $promos->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
