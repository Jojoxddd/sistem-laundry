<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Manajemen Laundry')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #1a237e 0%, #283593 100%);
            color: white;
            width: 250px;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            padding-top: 1rem;
        }
        .sidebar .brand {
            font-size: 1.1rem;
            font-weight: 700;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 0.5rem;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.7rem 1.5rem;
            border-radius: 0;
            transition: all 0.2s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background: rgba(255,255,255,0.15);
            border-left: 4px solid #ffd600;
        }
        .sidebar .nav-link i { margin-right: 10px; }
        .main-content { margin-left: 250px; padding: 1.5rem; }
        .topbar {
            background: white;
            border-bottom: 1px solid #dee2e6;
            padding: 0.75rem 1.5rem;
            margin-left: 250px;
            position: sticky;
            top: 0;
            z-index: 99;
        }
        .card { border: none; box-shadow: 0 1px 6px rgba(0,0,0,0.08); border-radius: 12px; }
        .card-header { border-radius: 12px 12px 0 0 !important; }
        .badge-menunggu  { background: #fff3cd; color: #856404; }
        .badge-diproses  { background: #cff4fc; color: #055160; }
        .badge-selesai   { background: #d1e7dd; color: #0a3622; }
        .badge-diambil   { background: #e2e3e5; color: #41464b; }
    </style>
    @stack('styles')
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="brand">
        <i class="bi bi-droplet-fill text-warning"></i> LaundryKu
    </div>
    <nav class="nav flex-column mt-2">
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('order.index') }}" class="nav-link {{ request()->routeIs('order.*') ? 'active' : '' }}">
            <i class="bi bi-bag-check"></i> Order
        </a>
        <a href="{{ route('pelanggan.index') }}" class="nav-link {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Pelanggan
        </a>
        <a href="{{ route('karyawan.index') }}" class="nav-link {{ request()->routeIs('karyawan.*') ? 'active' : '' }}">
            <i class="bi bi-person-badge"></i> Karyawan
        </a>
        <a href="{{ route('pembayaran.index') }}" class="nav-link {{ request()->routeIs('pembayaran.*') ? 'active' : '' }}">
            <i class="bi bi-cash-coin"></i> Pembayaran
        </a>
        <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-line"></i> Laporan
        </a>
    </nav>
</div>

<!-- Topbar -->
<div class="topbar d-flex justify-content-between align-items-center">
    <h6 class="mb-0 fw-semibold">@yield('page-title', 'Dashboard')</h6>
    <span class="text-muted small">{{ now()->isoFormat('dddd, D MMMM Y') }}</span>
</div>

<!-- Main Content -->
<div class="main-content">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
