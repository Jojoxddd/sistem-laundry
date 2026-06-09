<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Bless Laundry')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --sky:#38BDF8; --sky-dark:#0284C7; --sky-light:#E0F2FE;
            --green:#22C55E; --green-dark:#15803D; --green-light:#DCFCE7;
        }
        body { font-family:'Segoe UI',sans-serif; background:#fff; color:#1e293b; }
        .bl-nav { background:#fff; border-bottom:1px solid #e2e8f0; padding:14px 0; position:sticky; top:0; z-index:100; }
        .bl-nav .brand { font-size:1.2rem; font-weight:600; color:var(--sky-dark); text-decoration:none; }
        .bl-nav .brand small { display:block; font-size:11px; font-weight:400; color:#64748b; }
        .bl-nav .nav-link { color:#64748b; font-size:14px; padding:8px 14px !important; }
        .bl-nav .nav-link:hover, .bl-nav .nav-link.active { color:var(--sky-dark); }
        .btn-order-nav { background:var(--sky-dark); color:#fff; border:none; padding:9px 22px; border-radius:10px; font-size:14px; text-decoration:none; }
        .btn-order-nav:hover { background:#0369a1; color:#fff; }
        .btn-sky { background:var(--sky-dark); color:#fff; border:none; border-radius:50px; }
        .btn-sky:hover { background:#0369a1; color:#fff; }
        .btn-sky-outline { background:transparent; color:var(--sky-dark); border:1.5px solid var(--sky-dark); border-radius:50px; }
        .btn-sky-outline:hover { background:var(--sky-light); color:var(--sky-dark); }
        .btn-green { background:var(--green); color:#fff; border:none; border-radius:10px; }
        .btn-green:hover { background:var(--green-dark); color:#fff; }
        .bl-card { border:1px solid #e2e8f0; border-radius:16px; background:#fff; padding:24px; }
        .bl-footer { background:#1e293b; color:#94a3b8; padding:40px 0 24px; }
        .bl-footer .brand { font-size:1.1rem; font-weight:600; color:#fff; }
        .badge-bronze   { background:#FEF3C7; color:#92400E; }
        .badge-silver   { background:#F1F5F9; color:#475569; }
        .badge-gold     { background:#FEF9C3; color:#713F12; }
        .badge-platinum { background:#EDE9FE; color:#4C1D95; }
        .step-done   .step-circle { background:var(--green); color:#fff; }
        .step-active .step-circle { background:var(--sky-dark); color:#fff; }
        .step-pending .step-circle { background:#e2e8f0; color:#94a3b8; }
        .step-circle { width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:14px; flex-shrink:0; }
        .step-line { width:2px; min-height:24px; background:#e2e8f0; margin:0 auto; }
        .step-line.done { background:var(--green); }
    </style>
    @stack('styles')
</head>
<body>

<nav class="bl-nav">
    <div class="container d-flex align-items-center justify-content-between">
        <a href="{{ route('customer.home') }}" class="brand">
            <span><i class="bi bi-droplet-half"></i> Bless Laundry</span>
            <small>Bersih, Cepat, Terpercaya</small>
        </a>
        <div class="d-none d-md-flex align-items-center gap-1">
            <a href="{{ route('customer.home') }}"       class="nav-link {{ request()->routeIs('customer.home')       ? 'active fw-semibold' : '' }}">Beranda</a>
            <a href="{{ route('customer.cek-status') }}" class="nav-link {{ request()->routeIs('customer.cek-status') ? 'active fw-semibold' : '' }}">Cek Status</a>
            <a href="{{ route('customer.loyalty') }}"    class="nav-link {{ request()->routeIs('customer.loyalty')    ? 'active fw-semibold' : '' }}">Poin Saya</a>
        </div>
        <a href="{{ route('customer.order') }}" class="btn-order-nav {{ request()->routeIs('customer.order*') ? 'opacity-75' : '' }}">
            <i class="bi bi-bag-plus me-1"></i> Order Cucian
        </a>
    </div>
</nav>

<main>
    @if(session('success'))
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show border-0 rounded-3">
            <i class="bi bi-check-circle-fill me-2 text-success"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif
    @if(session('error'))
    <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3">
            <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif
    @yield('content')
</main>

<footer class="bl-footer">
    <div class="container">
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="brand mb-2"><i class="bi bi-droplet-half"></i> Bless Laundry</div>
                <p class="small mb-0">Layanan laundry profesional dengan teknologi modern dan harga terjangkau.</p>
            </div>
            <div class="col-md-4">
                <div class="fw-semibold text-white mb-2">Layanan</div>
                <div class="row g-0">
                    <div class="col-6">
                        <ul class="list-unstyled small mb-0">
                            <li>Laundry Kiloan</li>
                            <li>Cuci &amp; Setrika</li>
                            <li>Laundry Bedcover</li>
                            <li>Laundry Boneka</li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="list-unstyled small mb-0">
                            <li>Laundry Karpet</li>
                            <li>Laundry Sprei</li>
                            <li>Laundry Selimut</li>
                            <li>Laundry Gorden</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="fw-semibold text-white mb-2">Kontak</div>
                <ul class="list-unstyled small">
                    <li><i class="bi bi-geo-alt me-2"></i>Jl. Tegal Alur, Kalideres, Jakarta Barat 11820, RT.1/RW.5</li>
                    <li class="mt-2"><i class="bi bi-whatsapp me-2"></i>0813-1616-7745</li>
                    <li><i class="bi bi-envelope me-2"></i>blesslaundry@mail.com</li>
                    <li class="mt-2"><i class="bi bi-clock me-2"></i>Buka setiap hari 07.00 – 21.00</li>
                </ul>
            </div>
        </div>
        <hr style="border-color:#334155">
        <div class="text-center small">© {{ date('Y') }} Bless Laundry. Semua hak dilindungi.</div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>



