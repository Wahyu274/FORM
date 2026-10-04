@extends('layouts.app')

@section('title', 'Admin Login — Life Solution Connection')

@section('styles')
<style>
    .login-container {
        min-height: 100vh;
        background: radial-gradient(ellipse at 50% 15%, #1E3A8A 0%, #0B132B 45%, #030712 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2.5rem 1rem;
    }

    .login-card-desktop {
        width: 100%;
        max-width: 960px;
        background: #FFFFFF;
        border-radius: 1rem;
        box-shadow: 0 20px 45px -10px rgba(0, 0, 0, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.12);
        overflow: hidden;
    }

    .brand-side-panel {
        background: linear-gradient(155deg, #090E1A 0%, #0F172A 50%, #1E3A8A 100%);
        color: #FFFFFF;
        padding: 3rem 2.5rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        border-right: 1px solid rgba(255, 255, 255, 0.08);
    }

    .brand-logo-card {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.25);
        padding: 4px;
        flex-shrink: 0;
    }

    .brand-logo-card img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .security-feature-item {
        display: flex;
        align-items: flex-start;
        gap: 0.85rem;
        margin-bottom: 1.25rem;
    }

    .security-feature-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: rgba(56, 189, 248, 0.12);
        color: #38BDF8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        flex-shrink: 0;
        border: 1px solid rgba(56, 189, 248, 0.2);
    }

    .system-status-indicator {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.4rem 0.85rem;
        border-radius: 9999px;
        background: rgba(16, 185, 129, 0.12);
        border: 1px solid rgba(16, 185, 129, 0.25);
        color: #6EE7B7;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-pulse-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #10B981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.3);
    }

    .form-side-panel {
        padding: 3rem 2.75rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: #FFFFFF;
    }

    @media (max-width: 991.98px) {
        .brand-side-panel {
            padding: 2rem 1.75rem;
        }
        .form-side-panel {
            padding: 2rem 1.75rem;
        }
    }
</style>
@endsection

@section('content')
<div class="login-container">
    <div class="login-card-desktop">
        <div class="row g-0">

            <!-- Left Column: Enterprise Brand & Security Overview -->
            <div class="col-lg-5 brand-side-panel">
                <div>
                    <!-- Brand Header -->
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="brand-logo-card">
                            <img src="{{ asset('images/logo.png') }}" alt="Life Solution Connection Logo">
                        </div>
                        <div>
                            <div class="fw-bold text-white fs-5 lh-sm" style="letter-spacing: -0.3px;">Life Solution Connection</div>
                            <div class="text-uppercase fw-semibold" style="color: #7DD3FC; font-size: 0.72rem; letter-spacing: 0.8px;">Starlink Network Partner Kalimantan</div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <span class="badge rounded-pill fw-semibold mb-2" style="background: rgba(56, 189, 248, 0.15); color: #7DD3FC; border: 1px solid rgba(56, 189, 248, 0.3); font-size: 0.72rem; letter-spacing: 0.6px; text-transform: uppercase;">
                            Enterprise Command Portal
                        </span>
                        <h3 class="fw-bold text-white mb-2 fs-4" style="letter-spacing: -0.3px;">Sistem Manajemen Inventaris Jaringan</h3>
                        <p class="text-white-50 small mb-0" style="line-height: 1.6;">
                            Pusat kendali dan verifikasi infrastruktur jaringan Starlink partner di seluruh wilayah Kalimantan dengan pengamanan terenkripsi.
                        </p>
                    </div>

                    <!-- Security Highlights -->
                    <div class="pt-2">
                        <div class="security-feature-item">
                            <div class="security-feature-icon">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <div>
                                <div class="text-white fw-semibold small">Autentikasi Terenkripsi & Terlindungi</div>
                                <div class="text-white-50" style="font-size: 0.75rem;">Proteksi brute-force otomatis dan pembatasan frekuensi login.</div>
                            </div>
                        </div>

                        <div class="security-feature-item">
                            <div class="security-feature-icon">
                                <i class="fa-solid fa-database"></i>
                            </div>
                            <div>
                                <div class="text-white fw-semibold small">Integritas Data & Audit Trail</div>
                                <div class="text-white-50" style="font-size: 0.75rem;">Pencatatan riwayat inventaris perangkat, antena, dan koordinat GPS.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Status -->
                <div class="pt-4 border-top border-white border-opacity-10 mt-4 d-flex justify-content-between align-items-center">
                    <div class="system-status-indicator">
                        <span class="status-pulse-dot"></span>
                        Sistem Operasional Aktif
                    </div>
                    <small class="text-white-50" style="font-size: 0.72rem;">WITA Server Time</small>
                </div>
            </div>

            <!-- Right Column: Corporate Login Form -->
            <div class="col-lg-7 form-side-panel">
                <div class="mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-uppercase fw-bold text-primary" style="font-size: 0.75rem; letter-spacing: 0.8px;">Akses Administrator</span>
                        <span class="badge bg-light text-muted border" style="font-size: 0.7rem;"><i class="fa-solid fa-lock me-1"></i> TLS 1.3 Protected</span>
                    </div>
                    <h3 class="fw-bold text-dark mb-1 fs-4" style="letter-spacing: -0.3px;">Masuk ke Dashboard</h3>
                    <p class="text-muted small mb-0">Silakan masukkan kredensial administrator terdaftar Anda.</p>
                </div>

                @if(session('info'))
                    <div class="alert alert-info py-2.5 px-3 small border-0 rounded-3 mb-3 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-circle-info"></i>
                        <div>{{ session('info') }}</div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger py-2.5 px-3 small border-0 rounded-3 mb-3">
                        <div class="fw-bold mb-1"><i class="fa-solid fa-circle-exclamation me-1"></i> Autentikasi Gagal:</div>
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" id="adminLoginForm">
                    @csrf

                    <!-- Email Input -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email Administrator <span class="required-star">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" name="email" id="email" class="form-control border-start-0 ps-1" placeholder="admin@lifesolution.co.id" value="{{ old('email') }}" required autofocus autocomplete="email">
                        </div>
                    </div>

                    <!-- Password Input with Toggle -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="password" class="form-label mb-0">Kata Sandi Akun <span class="required-star">*</span></label>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="password" id="password" class="form-control border-start-0 border-end-0 ps-1" placeholder="Masukkan kata sandi Anda" required autocomplete="current-password">
                            <button class="btn btn-outline-secondary border-start-0 bg-light text-muted" type="button" id="btnTogglePassword" title="Tampilkan / Sembunyikan Kata Sandi">
                                <i class="fa-solid fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember & Security Info -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" checked>
                            <label class="form-check-label text-muted small" for="remember">
                                Ingat sesi saya
                            </label>
                        </div>
                        <small class="text-muted" style="font-size: 0.75rem;"><i class="fa-solid fa-shield me-1 text-primary"></i> Anti-Brute Force</small>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-starkink-primary w-100 py-2.5 fs-6 fw-bold shadow-sm mb-3">
                        <i class="fa-solid fa-arrow-right-to-bracket me-2"></i> Verifikasi & Masuk Dashboard
                    </button>
                </form>

                <!-- Security Notice -->
                <div class="p-2.5 bg-light rounded-2 border text-muted small text-center mb-3" style="font-size: 0.74rem;">
                    <i class="fa-solid fa-shield-halved me-1 text-primary"></i> Akses terbatas hanya untuk personel IT berwenang. Semua aktivitas dicatat demi keamanan.
                </div>

                <!-- Footer Link -->
                <div class="text-center pt-2">
                    <a href="{{ route('form.index') }}" class="text-decoration-none small text-muted">
                        <i class="fa-solid fa-arrow-left me-1"></i> Buka Halaman Formulir Inventaris Publik
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('btnTogglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (toggleBtn && passwordInput && eyeIcon) {
            toggleBtn.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.className = 'fa-solid fa-eye-slash';
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.className = 'fa-solid fa-eye';
                }
            });
        }
    });
</script>
@endsection
