<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - Odella Bakery</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --cream: #FFFBF0;
            --cream-dark: #F5EDD6;
            --cream-mid: #EDE0C4;
            --burgundy: #860120;
            --burgundy-deep: #5E0118;
            --burgundy-soft: #A8193A;
            --burgundy-muted: rgba(134, 1, 32, .08);
            --text-main: #2A1A1A;
            --text-muted: #7A5C5C;
            --text-light: #B89090;
            --border: #E8D5C0;
            --shadow-sm: 0 1px 4px rgba(134, 1, 32, .06);
            --shadow-md: 0 4px 16px rgba(134, 1, 32, .10);
            --radius: 10px;
            --sidebar-w: 240px;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--cream);
            color: var(--text-main);
            font-size: .9rem;
            overflow-x: hidden;
        }

        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: #fff;
            border-right: 1px solid var(--border);
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            z-index: 200;
            transition: transform .25s ease, width .25s ease;
        }

        .sidebar-brand {
            padding: 1.25rem 1.25rem 1.1rem;
            border-bottom: 1px solid var(--border);
        }

        .brand-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: .6rem;
            flex-shrink: 0;
        }

        .brand-icon img {
            width: 100%;
            height: auto;
            max-height: 34px;
            object-fit: contain;
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: var(--text-main);
            font-size: 1rem;
        }

        .brand-sub {
            color: var(--text-light);
            font-size: .68rem;
            text-transform: uppercase;
            margin-top: .1rem;
        }

        .sidebar-nav {
            flex: 1;
            padding: .85rem .75rem;
            overflow-y: auto;
        }

        .nav-section {
            font-size: .62rem;
            text-transform: uppercase;
            color: var(--text-light);
            font-weight: 600;
            padding: .9rem .5rem .3rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: .65rem;
            color: var(--text-muted);
            padding: .5rem .75rem;
            border-radius: var(--radius);
            font-size: .875rem;
            text-decoration: none;
            transition: all .13s;
        }

        .nav-link i {
            font-size: .95rem;
            width: 17px;
            text-align: center;
        }

        .nav-link:hover {
            background: var(--cream);
            color: var(--text-main);
        }

        .nav-link.active {
            background: var(--burgundy-muted);
            color: var(--burgundy);
            font-weight: 600;
        }

        .nav-link .badge {
            margin-left: auto;
        }

        .sidebar-footer {
            padding: .85rem .75rem 1rem;
            border-top: 1px solid var(--border);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: .65rem;
            margin-bottom: .65rem;
        }

        .avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--burgundy-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .72rem;
            font-weight: 700;
            color: var(--burgundy);
            flex-shrink: 0;
        }

        .user-name {
            font-size: .8rem;
            font-weight: 600;
        }

        .user-role {
            font-size: .68rem;
            color: var(--text-light);
        }

        .btn-logout {
            width: 100%;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: .4rem;
            font-size: .78rem;
            cursor: pointer;
            transition: all .13s;
        }

        .btn-logout:hover {
            background: #fbeaed;
            border-color: #f0b8c3;
            color: var(--burgundy);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.45);
            z-index: 190;
            opacity: 0;
            transition: opacity .25s ease;
        }
        .sidebar-overlay.show {
            display: block;
            opacity: 1;
        }

        .main-content {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            transition: margin-left .25s ease;
        }

        .topbar {
            background: var(--cream);
            border-bottom: 1px solid var(--border);
            padding: .9rem 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 50;
            gap: .75rem;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: .75rem;
            min-width: 0;
        }

        .topbar-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .topbar-badge {
            background: var(--cream-dark);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: .3rem .75rem;
            font-size: .75rem;
            white-space: nowrap;
        }

        .btn-hamburger {
            display: none;
            background: none;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: .35rem .5rem;
            color: var(--text-main);
            cursor: pointer;
            flex-shrink: 0;
            transition: background .13s;
        }
        .btn-hamburger:hover { background: var(--cream-dark); }
        .btn-hamburger i { font-size: 1.15rem; }

        .page-body {
            padding: 1.25rem 1.5rem 2.5rem;
        }

        .card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid var(--border);
            padding: .9rem 1.1rem;
            font-weight: 600;
        }

        .stat-card {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            background: #fff;
            padding: 1.1rem 1.25rem;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--burgundy);
        }

        .stat-label {
            font-size: .7rem;
            text-transform: uppercase;
            color: var(--text-muted);
            font-weight: 600;
        }

        .stat-value {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .stat-icon {
            position: absolute;
            right: 1rem;
            bottom: .75rem;
            font-size: 2rem;
            color: var(--burgundy-muted);
            opacity: .6;
        }

        .stat-change {
            font-size: .72rem;
            color: var(--text-muted);
            margin-top: .2rem;
        }
        .stat-change.up { color: #388e3c; }

        .table {
            font-size: .85rem;
        }

        .table thead th {
            background: var(--cream);
            font-size: .7rem;
            text-transform: uppercase;
            font-weight: 600;
            padding: .65rem .9rem;
            border-bottom: 1px solid var(--border);
        }

        .table tbody td {
            padding: .7rem .9rem;
            border-bottom: 1px solid var(--cream-dark);
        }

        .btn-primary {
            background: var(--burgundy);
            border-color: var(--burgundy);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--burgundy-deep);
            border-color: var(--burgundy-deep);
        }

        .status-pill {
            padding: .25rem .7rem;
            border-radius: 20px;
            font-size: .72rem;
            font-weight: 600;
        }
        .status-pill.selesai                 { background: #e8f5ef; color: #2E7D5C; }
        .status-pill.dikirim                 { background: #e3eef9; color: #1A5FA8; }
        .status-pill.diproses                { background: #fef3e2; color: #C47D2E; }
        .status-pill.menunggu_pembayaran     { background: var(--cream-dark); color: var(--text-muted); }
        .status-pill.pembayaran_diverifikasi { background: #fff8e1; color: #f57f17; }
        .status-pill.dibatalkan              { background: #fbeaed; color: var(--burgundy); }

        .filter-status-badge {
            background-color: #860120 !important;
            color: white !important;
            border-radius: 30px;
            padding: 0.4rem 1rem;
            font-weight: 500;
            font-size: 0.8rem;
            text-decoration: none;
            transition: 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }
        .filter-status-badge:hover {
            background-color: #5E0118 !important;
            transform: translateY(-1px);
            color: white;
        }
        .filter-status-badge.active {
            background-color: #5E0118 !important;
            box-shadow: 0 2px 6px rgba(134,1,32,0.3);
        }

        .form-control,
        .form-select {
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: .45rem .8rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--burgundy);
            box-shadow: 0 0 0 3px rgba(134, 1, 32, .1);
        }

        .alert-success {
            background: #e8f5ef;
            border-color: #b8dece;
            color: #1a5c3a;
        }
        .alert-danger {
            background: #fbeaed;
            border-color: #f0b8c3;
            color: var(--burgundy);
        }

        @media (max-width: 991.98px) {
            :root { --sidebar-w: 220px; }

            .page-body { padding: 1rem 1.1rem 2rem; }
        }

        @media (max-width: 767.98px) {
            .sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-w);
                box-shadow: none;
            }
            .sidebar.open {
                transform: translateX(0);
                box-shadow: 4px 0 20px rgba(0,0,0,.15);
            }

            .main-content {
                margin-left: 0;
            }

            .btn-hamburger {
                display: flex;
                align-items: center;
            }

            .topbar {
                padding: .75rem 1rem;
            }

            .topbar-title {
                font-size: .95rem;
            }

            .topbar-badge {
                display: none;
            }

            .page-body {
                padding: .85rem .85rem 2rem;
            }

            .filter-row-mobile .col-md-3,
            .filter-row-mobile .col-md-4,
            .filter-row-mobile .col-md-2 {
                min-width: 0;
            }
        }

        @media (max-width: 575.98px) {
            .stat-value { font-size: 1.25rem; }
            .stat-icon  { font-size: 1.5rem; }
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="d-flex align-items-center">
                <div class="brand-icon">
                    <img src="{{ asset('storage/images/odella_logo.png') }}" alt="Odella Bakery">
                </div>
                <div>
                    <div class="brand-name">Odella Bakery</div>
                    <div class="brand-sub">Admin Panel</div>
                </div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">Menu Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid"></i> <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.produk.index') }}" class="nav-link {{ request()->routeIs('admin.produk*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i> <span>Produk</span>
            </a>
            <a href="{{ route('admin.kategori.index') }}" class="nav-link {{ request()->routeIs('admin.kategori*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i> <span>Kategori</span>
            </a>

            <div class="nav-section">Transaksi</div>
            <a href="{{ route('admin.pesanan.index') }}" class="nav-link {{ request()->routeIs('admin.pesanan*') ? 'active' : '' }}">
                <i class="bi bi-bag"></i> <span>Pesanan</span>
                @php $pending = \App\Models\Pesanan::where('status_pesanan','menunggu_pembayaran')->count() @endphp
                @if ($pending > 0)
                    <span class="badge bg-danger ms-auto">{{ $pending }}</span>
                @endif
            </a>
            <a href="{{ route('admin.promo.index') }}" class="nav-link {{ request()->routeIs('admin.promo*') ? 'active' : '' }}">
                <i class="bi bi-percent"></i> <span>Promo</span>
            </a>

            <div class="nav-section">Lainnya</div>
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> <span>Users</span>
            </a>
            <a href="{{ route('admin.laporan.index') }}" class="nav-link {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-bar-graph"></i> <span>Laporan</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="avatar">{{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}</div>
                <div>
                    <div class="user-name">{{ auth()->user()->nama }}</div>
                    <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="bi bi-box-arrow-right me-1"></i> <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="main-content" id="mainContent">
        <div class="topbar">
            <div class="topbar-left">
                <button class="btn-hamburger" id="btnHamburger" aria-label="Toggle menu">
                    <i class="bi bi-list"></i>
                </button>
                <div class="topbar-title">@yield('title', 'Dashboard')</div>
            </div>
            <div class="topbar-badge">
                <span class="role-dot"></span> {{ auth()->user()->nama }}
            </div>
        </div>

        <div class="px-3 px-md-4 pt-3">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2">
                    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2">
                    <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>

        <div class="page-body">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const sidebar  = document.getElementById('sidebar');
        const overlay  = document.getElementById('sidebarOverlay');
        const btnHamburger = document.getElementById('btnHamburger');

        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        }

        btnHamburger.addEventListener('click', () => {
            sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
        });
        overlay.addEventListener('click', closeSidebar);

        sidebar.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 768) closeSidebar();
            });
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('open');
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
