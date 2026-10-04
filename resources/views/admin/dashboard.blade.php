@extends('layouts.admin')

@section('page_title', 'Dashboard Admin Inventaris')

@section('admin_content')
<!-- Metric Stats Overview Grid -->
<div class="row g-3 mb-4">
    <!-- Stat 1: Total Form Masuk -->
    <div class="col-6 col-md-4 col-xl-2">
        <div class="card card-starkink border-0 p-3 h-100 shadow-sm" style="border-left: 4px solid #2563EB !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Total Form</div>
                    <h3 class="fw-extrabold text-dark mb-0 mt-1">{{ number_format($stats['total_forms']) }}</h3>
                </div>
                <div class="bg-primary-subtle text-primary rounded-circle p-3 fs-4">
                    <i class="fa-solid fa-file-invoice"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 2: Form Hari Ini -->
    <div class="col-6 col-md-4 col-xl-2">
        <div class="card card-starkink border-0 p-3 h-100 shadow-sm" style="border-left: 4px solid #10B981 !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Form Hari Ini</div>
                    <h3 class="fw-extrabold text-success mb-0 mt-1">{{ number_format($stats['forms_today']) }}</h3>
                </div>
                <div class="bg-success-subtle text-success rounded-circle p-3 fs-4">
                    <i class="fa-solid fa-calendar-day"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 3: Total Lokasi -->
    <div class="col-6 col-md-4 col-xl-2">
        <div class="card card-starkink border-0 p-3 h-100 shadow-sm" style="border-left: 4px solid #8B5CF6 !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Total Lokasi</div>
                    <h3 class="fw-extrabold text-dark mb-0 mt-1">{{ number_format($stats['total_locations']) }}</h3>
                </div>
                <div class="bg-purple-subtle text-purple rounded-circle p-3 fs-4" style="color:#8B5CF6;">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 4: Total Perangkat -->
    <div class="col-6 col-md-4 col-xl-2">
        <div class="card card-starkink border-0 p-3 h-100 shadow-sm" style="border-left: 4px solid #F59E0B !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Total Perangkat</div>
                    <h3 class="fw-extrabold text-dark mb-0 mt-1">{{ number_format($stats['total_devices']) }}</h3>
                </div>
                <div class="bg-warning-subtle text-warning rounded-circle p-3 fs-4">
                    <i class="fa-solid fa-network-wired"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 5: Total Antena -->
    <div class="col-6 col-md-4 col-xl-2">
        <div class="card card-starkink border-0 p-3 h-100 shadow-sm" style="border-left: 4px solid #06B6D4 !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Total Antena</div>
                    <h3 class="fw-extrabold text-dark mb-0 mt-1">{{ number_format($stats['total_antennas']) }}</h3>
                </div>
                <div class="bg-info-subtle text-info rounded-circle p-3 fs-4">
                    <i class="fa-solid fa-satellite"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 6: Total Client -->
    <div class="col-6 col-md-4 col-xl-2">
        <div class="card card-starkink border-0 p-3 h-100 shadow-sm" style="border-left: 4px solid #EC4899 !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Total Client</div>
                    <h3 class="fw-extrabold text-dark mb-0 mt-1">{{ number_format($stats['total_clients']) }}</h3>
                </div>
                <div class="bg-danger-subtle text-danger rounded-circle p-3 fs-4">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Respon Terbaru Table Card -->
<div class="card card-starkink border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-bottom">
        <h6 class="fw-bold mb-0 text-dark">
            <i class="fa-solid fa-clock-rotate-left text-primary me-2"></i> Respon Inventaris Terbaru
        </h6>
        <a href="{{ route('admin.responses.index') }}" class="btn btn-sm btn-primary rounded-pill px-3 fw-semibold">
            Lihat Semua Respon <i class="fa-solid fa-arrow-right ms-1"></i>
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode Respon</th>
                    <th>Nama Instansi / Lokasi</th>
                    <th>Kabupaten / Kota</th>
                    <th>PIC</th>
                    <th class="text-center">Perangkat</th>
                    <th class="text-center">Antena</th>
                    <th class="text-center">Client</th>
                    <th>Tanggal Pengisian</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentResponses as $res)
                    <tr>
                        <td>
                            <span class="badge bg-dark-subtle text-dark border px-2 py-1 font-monospace fw-bold">
                                {{ $res->response_code }}
                            </span>
                        </td>
                        <td class="fw-semibold text-dark">{{ $res->location_name }}</td>
                        <td>
                            <span class="badge bg-secondary-subtle text-secondary px-2.5 py-1">
                                <i class="fa-solid fa-location-dot me-1"></i> {{ $res->regency }}
                            </span>
                        </td>
                        <td>
                            <div class="fw-medium text-dark">{{ $res->pic_name }}</div>
                            <small class="text-muted">{{ $res->pic_phone }}</small>
                        </td>
                        <td class="text-center fw-bold">{{ $res->total_devices }}</td>
                        <td class="text-center fw-bold text-primary">{{ $res->total_antennas }}</td>
                        <td class="text-center fw-bold text-success">{{ $res->total_clients }}</td>
                        <td class="small text-muted">
                            {{ $res->submitted_at ? $res->submitted_at->format('d/m/Y H:i') : '-' }}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.responses.show', $res->id) }}" class="btn btn-sm btn-outline-primary rounded-circle" title="Detail Respon">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">
                            <i class="fa-solid fa-inbox fs-3 d-block mb-2"></i>
                            Belum ada respon inventaris yang masuk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
