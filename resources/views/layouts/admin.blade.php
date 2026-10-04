@extends('layouts.app')

@section('styles')
<style>
    .admin-wrapper {
        display: flex;
        min-height: 100vh;
    }

    .admin-sidebar {
        width: 260px;
        background-color: var(--starkink-navy);
        color: #94A3B8;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
    }

    .sidebar-brand {
        padding: 1.25rem 1.5rem;
        font-size: 1.25rem;
        font-weight: 800;
        color: #FFFFFF;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        border-bottom: 1px solid rgba(255,255,255,0.08);
    }

    .sidebar-nav {
        padding: 1rem 0.75rem;
        flex: 1;
    }

    .sidebar-nav .nav-link {
        color: #94A3B8;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.25rem;
        transition: all 0.2s ease;
    }

    .sidebar-nav .nav-link:hover, .sidebar-nav .nav-link.active {
        color: #FFFFFF;
        background-color: rgba(255, 255, 255, 0.1);
    }

    .sidebar-nav .nav-link.active {
        background: linear-gradient(90deg, #1E40AF 0%, #2563EB 100%);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    .admin-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        background-color: var(--starkink-bg);
    }

    .admin-header {
        background: #FFFFFF;
        border-bottom: 1px solid var(--starkink-border);
        padding: 0.9rem 1.75rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .admin-main {
        padding: 1.75rem;
        flex: 1;
    }

    @media (max-width: 991.98px) {
        .admin-sidebar {
            position: fixed;
            z-index: 1050;
            height: 100vh;
            left: -260px;
        }
        .admin-sidebar.show {
            left: 0;
        }
    }
</style>
@yield('admin_styles')
@endsection

@section('content')
<div class="admin-wrapper">
    <!-- Admin Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('images/logo.png') }}" alt="Life Solution Connection Logo" class="rounded-2 shadow-sm" style="width: 40px; height: 40px; object-fit: contain; background: #ffffff; padding: 2px;">
            <div>
                <div class="lh-1 text-white fw-bold" style="font-size: 0.92rem;">Life Solution</div>
                <small class="text-xs" style="color: #38BDF8; font-size: 0.68rem; letter-spacing: 0.5px;">STARLINK PARTNER</small>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="text-uppercase px-3 mb-2" style="font-size: 0.7rem; font-weight: 700; color: #64748B;">Navigasi Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i> Dashboard
            </a>
            <a href="{{ route('admin.responses.index') }}" class="nav-link {{ request()->routeIs('admin.responses.*') ? 'active' : '' }}">
                <i class="fa-solid fa-clipboard-list"></i> Respon Inventaris
            </a>
            <a href="{{ route('admin.form-builder.index') }}" class="nav-link {{ request()->routeIs('admin.form-builder.*') ? 'active' : '' }}">
                <i class="fa-solid fa-sliders"></i> Kelola Form
            </a>

            <div class="text-uppercase px-3 mt-4 mb-2" style="font-size: 0.7rem; font-weight: 700; color: #64748B;">Export & Laporan</div>
            <a href="{{ route('admin.export.excel') }}" class="nav-link">
                <i class="fa-solid fa-file-excel text-success"></i> Export Excel
            </a>
            <a href="{{ route('admin.export.csv') }}" class="nav-link">
                <i class="fa-solid fa-file-csv text-info"></i> Export CSV
            </a>

            <div class="text-uppercase px-3 mt-4 mb-2" style="font-size: 0.7rem; font-weight: 700; color: #64748B;">Form User</div>
            <a href="{{ route('form.index') }}" target="_blank" class="nav-link">
                <i class="fa-solid fa-external-link-alt text-warning"></i> Lihat Form Public
            </a>
        </nav>

        <div class="p-3 border-top border-secondary border-opacity-25">
            <div class="d-flex align-items-center gap-2 text-white">
                <div class="bg-secondary bg-opacity-25 rounded-circle p-2 text-center" style="width: 36px; height: 36px;">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="lh-sm overflow-hidden">
                    <div class="fw-semibold text-truncate" style="font-size: 0.85rem;">{{ Auth::user()->name ?? 'Admin STARLINK' }}</div>
                    <small class="text-muted d-block text-truncate" style="font-size: 0.75rem;">{{ Auth::user()->email ?? 'admin@starkink.co.id' }}</small>
                </div>
            </div>
        </div>
    </aside>

    <!-- Admin Content Area -->
    <div class="admin-content">
        <!-- Top Navbar -->
        <header class="admin-header">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light d-lg-none" type="button" id="sidebarToggle">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h5 class="mb-0 fw-bold text-dark">@yield('page_title', 'Dashboard')</h5>
            </div>

            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill fw-semibold">
                    <i class="fa-solid fa-shield-halved me-1"></i> Admin Panel
                </span>

                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                        <i class="fa-solid fa-right-from-bracket me-1"></i> Keluar
                    </button>
                </form>
            </div>
        </header>

        <!-- Main Body -->
        <main class="admin-main">
            <!-- Flash Message Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('admin_content')
        </main>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('sidebarToggle')?.addEventListener('click', function() {
        document.getElementById('adminSidebar').classList.toggle('show');
    });
</script>
@yield('admin_scripts')
@endsection
