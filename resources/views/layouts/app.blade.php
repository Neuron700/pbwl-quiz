<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LaundryKuy — Sistem Informasi Laundry')</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🧺</text></svg>">
    <style>
        :root {
            --lk-brand: #0f766e;
            --lk-brand-dark: #115e59;
            --lk-accent: #f59e0b;
        }
        body { background: #f4f6f8; min-height: 100vh; }
        #wrapper { display: flex; min-height: 100vh; }
        #sidebar-wrapper {
            width: 250px; flex-shrink: 0;
            background: linear-gradient(180deg, var(--lk-brand) 0%, var(--lk-brand-dark) 100%);
            color: #fff; position: sticky; top: 0; height: 100vh;
        }
        #sidebar-wrapper .brand { padding: 1.25rem 1rem; border-bottom: 1px solid rgba(255,255,255,.18); }
        #sidebar-wrapper .brand small { display:block; font-size:.72rem; opacity:.8; letter-spacing:.06em; text-transform: uppercase; }
        #sidebar-wrapper .nav-link {
            color: rgba(255,255,255,.92);
            border-radius: .55rem;
            padding: .55rem .8rem;
            margin: .15rem .5rem;
        }
        #sidebar-wrapper .nav-link:hover { background: rgba(255,255,255,.14); color: #fff; }
        #sidebar-wrapper .nav-link.active { background: var(--lk-accent); color: #2f2410; font-weight: 700; }
        #page-content { flex: 1; min-width: 0; }
        .card { border: 0; border-radius: .9rem; }
        .btn-brand {
            --bs-btn-bg: var(--lk-brand);
            --bs-btn-border-color: var(--lk-brand);
            --bs-btn-hover-bg: var(--lk-brand-dark);
            --bs-btn-hover-border-color: var(--lk-brand-dark);
            --bs-btn-color: #fff;
            --bs-btn-hover-color: #fff;
        }
        .table thead th {
            font-size: .78rem; letter-spacing: .05em; text-transform: uppercase; color: #6b7280;
        }
        @media (max-width: 768px) {
            #sidebar-wrapper { position: fixed; left: -250px; z-index: 1040; transition: left .25s ease; }
            #sidebar-wrapper.show { left: 0; }
            .sidebar-backdrop { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.45); z-index: 1030; }
            .sidebar-backdrop.show { display: block; }
        }
    </style>
    @stack('styles')
</head>
<body>
<div id="wrapper">
    <aside id="sidebar-wrapper">
        <div class="brand">
            <div class="fs-4 fw-bold">🧺 LaundryKuy</div>
            <small>Sistem Informasi Laundry</small>
        </div>
        <nav class="py-3">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">📊 Dashboard</a>
            <a class="nav-link {{ request()->routeIs('transaksi.*') ? 'active' : '' }}" href="{{ route('transaksi.index') }}">🧾 Transaksi</a>
            <a class="nav-link {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}" href="{{ route('pelanggan.index') }}">👥 Pelanggan</a>
            <a class="nav-link {{ request()->routeIs('layanan.*') ? 'active' : '' }}" href="{{ route('layanan.index') }}">🧺 Layanan</a>
        </nav>
        <div class="mt-auto px-3 pb-3" style="position:absolute; bottom:0; width:250px;">
            <hr class="text-white-50">
            <div class="small text-white-50 mb-1">Masuk sebagai</div>
            <div class="fw-semibold text-truncate">{{ auth()->user()->user_namalengkap ?? 'Administrator' }}</div>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm w-100">Keluar</button>
            </form>
        </div>
    </aside>

    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <main id="page-content">
        <div class="d-flex align-items-center gap-2 px-4 py-3 bg-white border-bottom">
            <button class="btn btn-light d-md-none" id="menuToggle" aria-label="Buka menu">☰</button>
            <div class="fw-semibold text-secondary">@yield('breadcrumb', 'LaundryKuy')</div>
        </div>

        <div class="p-4 p-md-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            @endif
            @yield('content')
        </div>
    </main>
</div>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script>
    const sidebar = document.getElementById('sidebar-wrapper');
    const backdrop = document.getElementById('sidebarBackdrop');
    document.getElementById('menuToggle')?.addEventListener('click', () => {
        sidebar.classList.toggle('show');
        backdrop.classList.toggle('show');
    });
    backdrop?.addEventListener('click', () => {
        sidebar.classList.remove('show');
        backdrop.classList.remove('show');
    });
</script>
@stack('scripts')
</body>
</html>
