@extends('layouts.admin')
@section('title', 'Manajemen Users')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Daftar Pengguna</h5>
        <p class="text-muted small mb-0">Total: {{ $users->total() }} pengguna</p>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body py-3">
        <form method="GET" class="row g-2">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Cari nama atau email..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="role" class="form-select form-select-sm">
                    <option value="">Semua Role</option>
                    <option value="customer"  {{ request('role') === 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="admin"     {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="kurir"     {{ request('role') === 'kurir' ? 'selected' : '' }}>Kurir</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary w-100">
                    <i class="bi bi-search me-1"></i>Filter
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">#</th>
                        <th>Pengguna</th>
                        <th>Role</th>
                        <th>Jenis Kelamin</th>
                        <th>Bergabung</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $i => $user)
                    <tr>
                        <td class="ps-3 text-muted small">{{ $users->firstItem() + $i }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white"
                                     style="width:38px;height:38px;background:var(--burgundy);font-size:.9rem">
                                    {{ strtoupper(substr($user->nama, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold small">{{ $user->nama }}</div>
                                    <div class="text-muted" style="font-size:.75rem">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @php
                                $roleClass = match($user->role) {
                                    'admin'  => 'danger',
                                    'kurir'  => 'info',
                                    default  => 'secondary',
                                };
                            @endphp
                            <span class="badge bg-{{ $roleClass }}">{{ ucfirst($user->role) }}</span>
                        </td>
                        <td class="small">{{ $user->jenis_kelamin === 'L' ? '♂ Laki-laki' : ($user->jenis_kelamin === 'P' ? '♀ Perempuan' : '-') }}</td>
                        <td>
                            @if($user->created_at->diffInDays() < 7)
                            <span class="badge bg-success">Baru</span>
                            @endif
                        </td>
                        <td class="small text-muted">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="text-center">
                            @if($user->role !== 'admin')
                            <form method="POST" action="{{ route('admin.users.destroy', $user->id_user) }}"
                                  onsubmit="return confirm('Hapus user {{ $user->nama }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                            @else
                            <span class="text-muted small">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-people fs-2 d-block mb-2"></i>
                            Belum ada pengguna
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
    <div class="card-footer bg-white">{{ $users->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
