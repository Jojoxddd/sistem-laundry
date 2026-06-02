<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Bless Laundry') — Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; }

        :root {
            --sidebar-w: 232px;
            --slate-950: #0a0f1a;
            --slate-900: #0f172a;
            --slate-800: #1e293b;
            --slate-700: #334155;
            --slate-500: #64748b;
            --slate-300: #cbd5e1;
            --slate-100: #f1f5f9;
            --slate-50:  #f8fafc;
            --blue:      #2563eb;
            --blue-light:#eff6ff;
            --teal:      #0d9488;
            --teal-light:#f0fdfa;
            --amber:     #d97706;
            --amber-light:#fffbeb;
            --red:       #dc2626;
            --red-light: #fef2f2;
            --green:     #16a34a;
            --green-light:#f0fdf4;
            --radius:    10px;
            --radius-lg: 14px;
            --shadow:    0 1px 3px rgba(0,0,0,.08), 0 1px 2px rgba(0,0,0,.04);
            --shadow-md: 0 4px 12px rgba(0,0,0,.08);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--slate-50);
            color: var(--slate-800);
            font-size: 14px;
            line-height: 1.6;
        }

        /* ── SIDEBAR ─────────────────────────────── */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--slate-900);
            position: fixed;
            top: 0; left: 0;
            z-index: 200;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255,255,255,.04);
        }

        .sidebar-brand {
            padding: 20px 20px 16px;
            border-bottom: 1px solid rgba(255,255,255,.06);
        }
        .sidebar-brand .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .sidebar-brand .logo-icon {
            width: 34px; height: 34px;
            background: var(--blue);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; color: #fff;
            flex-shrink: 0;
        }
        .sidebar-brand .logo-text { font-size: 15px; font-weight: 700; color: #fff; }
        .sidebar-brand .logo-sub  { font-size: 11px; color: var(--slate-500); line-height: 1; }

        .sidebar-section {
            padding: 14px 12px 4px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--slate-500);
        }

        .sidebar nav { padding: 8px 12px; flex: 1; }

        .sidebar .nav-item { margin-bottom: 2px; }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: 8px;
            color: rgba(255,255,255,.55);
            font-size: 13.5px;
            font-weight: 500;
            text-decoration: none;
            transition: all .15s;
        }
        .sidebar .nav-link i {
            font-size: 15px;
            width: 18px;
            text-align: center;
            flex-shrink: 0;
        }
        .sidebar .nav-link:hover  { color: #fff; background: rgba(255,255,255,.07); }
        .sidebar .nav-link.active { color: #fff; background: var(--blue); }

        .sidebar-footer {
            padding: 14px 12px;
            border-top: 1px solid rgba(255,255,255,.06);
        }
        .sidebar-footer .user-row {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 10px; border-radius: 8px;
            color: rgba(255,255,255,.55); font-size: 13px;
        }
        .user-avatar {
            width: 28px; height: 28px; border-radius: 50%;
            background: var(--blue); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700; flex-shrink: 0;
        }
        .sidebar-customer-link {
            display: flex; align-items: center; gap: 8px;
            padding: 7px 10px; margin-bottom: 6px;
            border-radius: 8px; font-size: 12.5px; font-weight: 500;
            color: var(--teal); background: rgba(13,148,136,.1);
            text-decoration: none; transition: background .15s;
        }
        .sidebar-customer-link:hover { background: rgba(13,148,136,.18); color: var(--teal); }

        /* ── TOPBAR ──────────────────────────────── */
        .topbar {
            margin-left: var(--sidebar-w);
            background: #fff;
            border-bottom: 1px solid var(--slate-100);
            padding: 0 28px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .topbar-title { font-size: 15px; font-weight: 600; color: var(--slate-800); }
        .topbar-date {
            font-size: 12.5px; color: var(--slate-500);
            background: var(--slate-50); border: 1px solid var(--slate-100);
            padding: 5px 12px; border-radius: 20px;
        }
        .btn-hamburger {
            display: none;
            width: 34px; height: 34px; border-radius: 8px;
            background: transparent; border: 1px solid var(--slate-100);
            align-items: center; justify-content: center;
            cursor: pointer; font-size: 16px; color: var(--slate-700);
            flex-shrink: 0;
        }

        /* ── MAIN CONTENT ────────────────────────── */
        .main-content {
            margin-left: var(--sidebar-w);
            padding: 24px 28px;
            min-height: calc(100vh - 56px);
        }

        /* ── OVERLAY (mobile) ────────────────────── */
        .sidebar-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,.45);
            z-index: 199;
        }
        .sidebar-overlay.active { display: block; }

        /* ── RESPONSIVE ──────────────────────────── */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform .25s ease;
            }
            .sidebar.open { transform: translateX(0); }
            .topbar { margin-left: 0; padding: 0 16px; }
            .main-content { margin-left: 0; padding: 16px; }
            .btn-hamburger { display: flex; }
            .topbar-date { display: none; }
            /* Tabel scroll di mobile */
            .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }
            /* Stat cards 2 kolom di mobile */
            .stat-card .stat-value { font-size: 1.4rem; }
        }

        /* ── CARDS ───────────────────────────────── */
        .card {
            background: #fff;
            border: 1px solid var(--slate-100);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
        }
        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--slate-100);
            padding: 16px 20px;
            font-weight: 600;
            font-size: 14px;
        }
        .card-body { padding: 20px; }

        /* ── STAT CARDS ──────────────────────────── */
        .stat-card {
            background: #fff;
            border: 1px solid var(--slate-100);
            border-radius: var(--radius-lg);
            padding: 20px;
            box-shadow: var(--shadow);
        }
        .stat-label { font-size: 12px; color: var(--slate-500); font-weight: 500; margin-bottom: 8px; }
        .stat-value { font-size: 1.75rem; font-weight: 700; color: var(--slate-800); line-height: 1; }
        .stat-icon  {
            width: 38px; height: 38px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 17px;
        }

        /* ── TABLES ──────────────────────────────── */
        .table { margin-bottom: 0; }
        .table thead th {
            background: var(--slate-50);
            font-size: 11.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: var(--slate-500);
            border-bottom: 1px solid var(--slate-100);
            padding: 10px 16px;
            white-space: nowrap;
        }
        .table tbody td {
            padding: 12px 16px;
            border-color: var(--slate-100);
            vertical-align: middle;
            font-size: 13.5px;
        }
        .table-hover tbody tr:hover { background: var(--slate-50); }

        /* ── BADGES ──────────────────────────────── */
        .badge { font-size: 11.5px; font-weight: 600; padding: 4px 9px; border-radius: 6px; }
        .badge-menunggu { background: var(--amber-light); color: var(--amber); }
        .badge-diproses { background: #eff6ff; color: var(--blue); }
        .badge-selesai  { background: var(--green-light); color: var(--green); }
        .badge-diambil  { background: var(--slate-100); color: var(--slate-500); }
        .badge-lunas    { background: var(--green-light); color: var(--green); }
        .badge-aktif    { background: var(--green-light); color: var(--green); }
        .badge-nonaktif { background: var(--slate-100); color: var(--slate-500); }

        /* ── BUTTONS ─────────────────────────────── */
        .btn { font-size: 13.5px; font-weight: 500; border-radius: 8px; }
        .btn-primary { background: var(--blue); border-color: var(--blue); }
        .btn-primary:hover { background: #1d4ed8; border-color: #1d4ed8; }
        .btn-sm { padding: 5px 10px; font-size: 12.5px; border-radius: 6px; }
        .btn-icon {
            width: 30px; height: 30px; padding: 0;
            display: inline-flex; align-items: center; justify-content: center;
            border-radius: 7px; font-size: 13px;
        }
        .btn-ghost {
            background: transparent;
            border: 1px solid var(--slate-200, #e2e8f0);
            color: var(--slate-600, #475569);
        }
        .btn-ghost:hover { background: var(--slate-50); color: var(--slate-800); border-color: var(--slate-300); }

        /* ── FORMS ───────────────────────────────── */
        .form-label { font-size: 13px; font-weight: 600; color: var(--slate-700); margin-bottom: 5px; }
        .form-control, .form-select {
            font-size: 13.5px;
            border-color: var(--slate-200, #e2e8f0);
            border-radius: 8px;
            padding: 8px 12px;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(37,99,235,.1);
        }

        /* ── ALERTS ──────────────────────────────── */
        .alert {
            border: none;
            border-radius: var(--radius);
            font-size: 13.5px;
            padding: 12px 16px;
        }
        .alert-success { background: var(--green-light); color: #166534; }
        .alert-danger  { background: var(--red-light);   color: #991b1b; }

        /* ── PAGE HEADER ─────────────────────────── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .page-header h1 {
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0;
            color: var(--slate-800);
        }
        .page-header .sub { font-size: 12.5px; color: var(--slate-500); margin-top: 2px; }

        /* ── PAGINATION ──────────────────────────── */
        .pagination { margin: 0; }
        .page-link { font-size: 13px; border-radius: 7px !important; border-color: var(--slate-100); color: var(--slate-700); }
        .page-link:hover { background: var(--slate-50); color: var(--blue); }
        .page-item.active .page-link { background: var(--blue); border-color: var(--blue); }
    </style>
    @stack('styles')
</head>
<body>

{{-- SIDEBAR --}}
<aside class="sidebar">
    <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}" class="logo">
            <div class="logo-icon"><i class="bi bi-droplet-fill"></i></div>
            <div>
                <div class="logo-text">Bless Laundry</div>
                <div class="logo-sub">Admin Panel</div>
            </div>
        </a>
    </div>

    <nav>
        <div class="sidebar-section">Utama</div>
        <div class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-squares-fill"></i> Dashboard
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('order.index') }}" class="nav-link {{ request()->routeIs('order.*') ? 'active' : '' }}">
                <i class="bi bi-bag-check"></i> Order
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('pembayaran.index') }}" class="nav-link {{ request()->routeIs('pembayaran.*') ? 'active' : '' }}">
                <i class="bi bi-credit-card"></i> Pembayaran
            </a>
        </div>

        <div class="sidebar-section">Data</div>
        <div class="nav-item">
            <a href="{{ route('pelanggan.index') }}" class="nav-link {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Pelanggan
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('karyawan.index') }}" class="nav-link {{ request()->routeIs('karyawan.*') ? 'active' : '' }}">
                <i class="bi bi-person-badge"></i> Karyawan
            </a>
        </div>

        <div class="sidebar-section">Analitik</div>
        <div class="nav-item">
            <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart"></i> Laporan
            </a>
        </div>
    </nav>

    <div class="sidebar-footer">
        <a href="{{ route('customer.home') }}" target="_blank" class="sidebar-customer-link">
            <i class="bi bi-arrow-up-right-square"></i> Lihat halaman pelanggan
        </a>
        <div class="user-row">
            <div class="user-avatar">A</div>
            <div>
                <div style="color:#fff;font-size:13px;font-weight:500">Admin</div>
                <div style="font-size:11px">Bless Laundry</div>
            </div>
        </div>
    </div>
</aside>

{{-- OVERLAY mobile --}}
<div class="sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>

{{-- TOPBAR --}}
<header class="topbar">
    <div class="topbar-left">
        <button class="btn-hamburger" id="hamburger" onclick="toggleSidebar()">
            <i class="bi bi-list"></i>
        </button>
        <span class="topbar-title">@yield('page-title', 'Dashboard')</span>
    </div>
    <div class="topbar-date">
        <i class="bi bi-calendar3 me-1"></i>{{ now()->isoFormat('dddd, D MMMM Y') }}
    </div>
</header>

{{-- CONTENT --}}
<main class="main-content">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('open');
    document.getElementById('sidebar-overlay').classList.toggle('active');
}
function closeSidebar() {
    document.querySelector('.sidebar').classList.remove('open');
    document.getElementById('sidebar-overlay').classList.remove('active');
}
// Tutup sidebar otomatis saat klik nav link di mobile
document.querySelectorAll('.sidebar .nav-link').forEach(link => {
    link.addEventListener('click', () => {
        if (window.innerWidth <= 768) closeSidebar();
    });
});
</script>
@stack('scripts')
</body>
</html>
