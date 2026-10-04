@extends('layouts.app')

@section('title', 'Admin Login — STARLINK Inventaris Kalimantan')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100 bg-starkink-navy py-5" style="background: radial-gradient(circle at top right, #1E40AF 0%, #0F172A 70%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card card-starkink border-0 shadow-lg" style="border-radius: 1rem; overflow: hidden;">
                    <!-- Card Header Brand -->
                    <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #090E1A 0%, #0F172A 50%, #1E3A8A 100%); border-bottom: 2px solid rgba(56, 189, 248, 0.2);">
                        <div class="mb-3 d-flex justify-content-center">
                            <div style="width: 56px; height: 56px; border-radius: 12px; background: #FFFFFF; display: flex; align-items: center; justify-content: center; padding: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.2);">
                                <img src="{{ asset('images/logo.png') }}" alt="Life Solution Connection Logo" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                            </div>
                        </div>
                        <h4 class="fw-bold text-white mb-1" style="letter-spacing: -0.3px;">Life Solution Connection</h4>
                        <p class="text-uppercase fw-semibold mb-0" style="color: #7DD3FC; font-size: 0.75rem; letter-spacing: 0.8px;">Starlink Network Partner Kalimantan</p>
                        <small class="text-white-50 d-block mt-1" style="font-size: 0.78rem;">Portal Manajemen & Inventarisasi</small>
                    </div>

                    <!-- Card Body Form -->
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-dark text-center mb-4">Login Admin</h5>

                        @if(session('info'))
                            <div class="alert alert-info py-2 small">{{ session('info') }}</div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger py-2 small mb-3">
                                <ul class="mb-0 ps-3">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('login.post') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Alamat Email Admin</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-envelope"></i></span>
                                    <input type="email" name="email" id="email" class="form-control border-start-0 ps-0" placeholder="admin@starkink.co.id" value="{{ old('email', 'admin@starkink.co.id') }}" required autofocus>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Kata Sandi</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-lock"></i></span>
                                    <input type="password" name="password" id="password" class="form-control border-start-0 ps-0" placeholder="••••••••" value="admin123" required>
                                </div>
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" checked>
                                <label class="form-check-label text-muted small" for="remember">
                                    Ingat saya di perangkat ini
                                </label>
                            </div>

                            <button type="submit" class="btn btn-starkink-primary w-100 py-2.5 fs-6 fw-bold shadow-sm">
                                <i class="fa-solid fa-right-to-bracket me-2"></i> Masuk ke Dashboard
                            </button>
                        </form>
                    </div>

                    <!-- Footer Link -->
                    <div class="card-footer bg-light text-center py-3 border-top-0">
                        <a href="{{ route('form.index') }}" class="text-decoration-none small text-muted">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Form Inventaris Public
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
