@extends('layouts.app')

@section('styles')
<style>
    .admin-wrapper {
        display: flex;
        min-height: 100vh;
        background-color: #F8FAFC;
    }

    /* Desktop First Admin Sidebar */
    .admin-sidebar {
        width: 270px;
        background-color: #090E1A;
        color: #94A3B8;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        border-right: 1px solid rgba(255, 255, 255, 0.08);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1040;
    }

    .sidebar-brand {
        padding: 1.5rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.85rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    .sidebar-brand-logo {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: #FFFFFF;
        padding: 3px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        flex-shrink: 0;
    }

    .sidebar-brand-logo img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .sidebar-nav {
        padding: 1.25rem 0.85rem;
        flex: 1;
        overflow-y: auto;
    }

    .sidebar-section-title {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #64748B;
        padding: 0.75rem 1rem 0.35rem;
        margin-top: 0.5rem;
    }

    .sidebar-nav .nav-link {
        color: #94A3B8;
        padding: 0.7rem 1rem;
        border-radius: 0.55rem;
        font-weight: 500;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.85rem;
        margin-bottom: 0.25rem;
        transition: all 0.15s ease-in-out;
    }

    .sidebar-nav .nav-link:hover {
        color: #FFFFFF;
        background-color: rgba(255, 255, 255, 0.08);
    }

    .sidebar-nav .nav-link.active {
        color: #FFFFFF;
        background: linear-gradient(90deg, #1E40AF 0%, #2563EB 100%);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35);
        font-weight: 600;
    }

    .sidebar-user-card {
        padding: 1.25rem 1.25rem;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(0, 0, 0, 0.2);
    }

    .user-avatar-badge {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: linear-gradient(135deg, #1E40AF, #2563EB);
        color: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    /* Admin Content Area */
    .admin-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        background-color: #F8FAFC;
        min-width: 0;
    }

    .admin-header {
        background: #FFFFFF;
        border-bottom: 1px solid #E2E8F0;
        padding: 1rem 2.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        z-index: 1020;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
    }

    .admin-main {
        padding: 2rem 2.25rem;
        flex: 1;
        max-width: 1680px;
        width: 100%;
        margin: 0 auto;
    }

    @media (max-width: 991.98px) {
        .admin-sidebar {
            position: fixed;
            height: 100vh;
            left: -270px;
        }
        .admin-sidebar.show {
            left: 0;
        }
        .admin-header {
            padding: 0.85rem 1.25rem;
        }
        .admin-main {
            padding: 1.25rem 1rem;
        }
    }
</style>
@yield('admin_styles')
@endsection

@section('content')
<div class="admin-wrapper">
    <!-- Admin Desktop Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <!-- Brand Header -->
        <div class="sidebar-brand">
            <div class="sidebar-brand-logo">
                <img src="{{ asset('images/logo.png') }}" alt="Life Solution Connection Logo">
            </div>
            <div>
                <div class="text-white fw-bold lh-sm" style="font-size: 0.95rem; letter-spacing: -0.2px;">Life Solution</div>
                <div class="text-uppercase fw-semibold" style="color: #38BDF8; font-size: 0.68rem; letter-spacing: 0.8px;">Starlink Partner</div>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="sidebar-nav">
            <div class="sidebar-section-title">Navigasi Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i> Dashboard
            </a>
            <a href="{{ route('admin.responses.index') }}" class="nav-link {{ request()->routeIs('admin.responses.*') ? 'active' : '' }}">
                <i class="fa-solid fa-table-list"></i> Respon Inventaris
            </a>
            <a href="{{ route('admin.form-builder.index') }}" class="nav-link {{ request()->routeIs('admin.form-builder.*') ? 'active' : '' }}">
                <i class="fa-solid fa-sliders"></i> Kelola Form
            </a>

            <div class="sidebar-section-title">Laporan & Ekspor</div>
            <a href="{{ route('admin.export.excel') }}" class="nav-link">
                <i class="fa-solid fa-file-excel text-success"></i> Export Excel (.xlsx)
            </a>
            <a href="{{ route('admin.export.csv') }}" class="nav-link">
                <i class="fa-solid fa-file-csv text-info"></i> Export CSV (.csv)
            </a>

            <div class="sidebar-section-title">Akses Publik</div>
            <a href="{{ route('form.index') }}" target="_blank" class="nav-link">
                <i class="fa-solid fa-arrow-up-right-from-square text-warning"></i> Form Inventaris Publik
            </a>
        </nav>

        <!-- Authenticated User Profile -->
        <div class="sidebar-user-card">
            <div class="d-flex align-items-center gap-2.5">
                <div class="user-avatar-badge">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="lh-sm overflow-hidden flex-grow-1">
                    <div class="text-white fw-bold text-truncate" style="font-size: 0.85rem;">{{ Auth::user()->name ?? 'Administrator' }}</div>
                    <small class="text-muted d-block text-truncate" style="font-size: 0.72rem;">{{ Auth::user()->email ?? 'admin@lifesolution.co.id' }}</small>
                    <span class="d-inline-flex align-items-center gap-1 mt-1 text-success" style="font-size: 0.68rem; font-weight: 600;">
                        <span style="width: 6px; height: 6px; border-radius: 50%; background: #10B981; display: inline-block;"></span> Sesi Aktif
                    </span>
                </div>
            </div>
        </div>
    </aside>

    <!-- Admin Content Area -->
    <div class="admin-content">
        <!-- Top Desktop Navbar -->
        <header class="admin-header">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light d-lg-none" type="button" id="sidebarToggle">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div>
                    <h5 class="mb-0 fw-bold text-dark" style="letter-spacing: -0.2px;">@yield('page_title', 'Dashboard Administrator')</h5>
                    <small class="text-muted d-none d-md-block" style="font-size: 0.78rem;">Life Solution Connection — Starlink Regional Kalimantan</small>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <!-- Security TLS Badge -->
                <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 py-1.5 fw-semibold d-none d-md-inline-flex align-items-center gap-1.5" style="font-size: 0.75rem;">
                    <i class="fa-solid fa-shield-halved"></i> TLS 1.3 Terenkripsi
                </span>

                <!-- Quick Public Form Link -->
                <a href="{{ route('form.index') }}" target="_blank" class="btn btn-sm btn-light border rounded-pill px-3 fw-semibold text-secondary d-none d-sm-inline-flex align-items-center gap-1.5">
                    <i class="fa-solid fa-external-link small"></i> Form Publik
                </a>

                <!-- Logout Action -->
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-semibold" title="Keluar dari sesi administrator">
                        <i class="fa-solid fa-arrow-right-from-bracket me-1"></i> Keluar
                    </button>
                </form>
            </div>
        </header>

        <!-- Main Body -->
        <main class="admin-main">
            <!-- Flash Message Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-circle-check fs-5 text-success"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation fs-5 text-danger"></i>
                        <div>{{ session('error') }}</div>
                    </div>
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
