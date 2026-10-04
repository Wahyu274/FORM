@extends('layouts.admin')

@section('page_title', 'Dashboard Operasional')

@section('admin_content')
<!-- Desktop Command Center Hero Banner -->
<div class="card card-starkink border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #090E1A 0%, #0F172A 60%, #1E3A8A 100%); border-left: 4px solid #38BDF8 !important;">
    <div class="card-body p-4 text-white">
        <div class="d-flex flex-column flex-xl-row align-items-xl-center justify-content-between gap-3">
            <div>
                <div class="d-inline-flex align-items-center gap-2 px-2.5 py-1 rounded-pill mb-2" style="background: rgba(56, 189, 248, 0.15); border: 1px solid rgba(56, 189, 248, 0.3);">
                    <span style="width: 7px; height: 7px; border-radius: 50%; background: #38BDF8; display: inline-block;"></span>
                    <span style="color: #7DD3FC; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.6px; text-transform: uppercase;">Command Center Inventaris</span>
                </div>
                <h3 class="fw-bold text-white mb-1 fs-4" style="letter-spacing: -0.3px;">Monitoring Infrastruktur Jaringan Starlink Kalimantan</h3>
                <p class="text-white-50 mb-0 small" style="max-width: 700px; line-height: 1.5;">
                    Pusat pemantauan inventarisasi perangkat, antena distribusi, koordinat GPS, dan rekapitulasi client partner regional Kalimantan secara real-time.
                </p>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-2">
                <a href="{{ route('admin.export.excel') }}" class="btn btn-sm btn-light border-0 fw-semibold rounded-pill px-3 shadow-sm">
                    <i class="fa-solid fa-file-excel text-success me-1"></i> Unduh Excel
                </a>
                <a href="{{ route('admin.responses.index') }}" class="btn btn-sm btn-primary fw-semibold rounded-pill px-3 shadow-sm" style="background: #2563EB; border-color: #2563EB;">
                    <i class="fa-solid fa-table-list me-1"></i> Kelola Respon
                </a>
                <a href="{{ route('form.index') }}" target="_blank" class="btn btn-sm btn-outline-light rounded-pill px-3 fw-semibold">
                    <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Form Publik
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Desktop KPI Stats 6-Grid -->
<div class="row g-3 mb-4">
    <!-- Stat 1: Total Form Masuk -->
    <div class="col-12 col-sm-6 col-xl-2">
        <div class="card card-starkink border-0 p-3 h-100 shadow-sm" style="border-top: 3px solid #2563EB !important;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="text-muted fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">TOTAL RESPON</span>
                <span class="badge bg-primary-subtle text-primary rounded-2 px-2 py-1" style="font-size: 0.68rem;">Data Masuk</span>
            </div>
            <div class="fs-2 fw-extrabold text-dark mb-1">{{ number_format($stats['total_forms']) }}</div>
            <div class="text-muted small" style="font-size: 0.76rem;">Formulir tervalidasi</div>
        </div>
    </div>

    <!-- Stat 2: Form Hari Ini -->
    <div class="col-12 col-sm-6 col-xl-2">
        <div class="card card-starkink border-0 p-3 h-100 shadow-sm" style="border-top: 3px solid #10B981 !important;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="text-muted fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">HARI INI</span>
                <span class="badge bg-success-subtle text-success rounded-2 px-2 py-1" style="font-size: 0.68rem;">Real-time</span>
            </div>
            <div class="fs-2 fw-extrabold text-success mb-1">+{{ number_format($stats['forms_today']) }}</div>
            <div class="text-muted small" style="font-size: 0.76rem;">Masuk sejak 00:00 WITA</div>
        </div>
    </div>

    <!-- Stat 3: Total Lokasi / Site -->
    <div class="col-12 col-sm-6 col-xl-2">
        <div class="card card-starkink border-0 p-3 h-100 shadow-sm" style="border-top: 3px solid #8B5CF6 !important;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="text-muted fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">LOKASI / SITE</span>
                <span class="badge rounded-2 px-2 py-1" style="background: rgba(139, 92, 246, 0.12); color: #8B5CF6; font-size: 0.68rem;">Titik GPS</span>
            </div>
            <div class="fs-2 fw-extrabold text-dark mb-1">{{ number_format($stats['total_locations']) }}</div>
            <div class="text-muted small" style="font-size: 0.76rem;">Site partner terdaftar</div>
        </div>
    </div>

    <!-- Stat 4: Total Perangkat -->
    <div class="col-12 col-sm-6 col-xl-2">
        <div class="card card-starkink border-0 p-3 h-100 shadow-sm" style="border-top: 3px solid #F59E0B !important;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="text-muted fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">PERANGKAT</span>
                <span class="badge rounded-2 px-2 py-1" style="background: rgba(245, 158, 11, 0.12); color: #D97706; font-size: 0.68rem;">Hardware</span>
            </div>
            <div class="fs-2 fw-extrabold text-dark mb-1">{{ number_format($stats['total_devices']) }}</div>
            <div class="text-muted small" style="font-size: 0.76rem;">Modem, router, AP, switch</div>
        </div>
    </div>

    <!-- Stat 5: Total Antena -->
    <div class="col-12 col-sm-6 col-xl-2">
        <div class="card card-starkink border-0 p-3 h-100 shadow-sm" style="border-top: 3px solid #0284C7 !important;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="text-muted fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">ANTENA</span>
                <span class="badge rounded-2 px-2 py-1" style="background: rgba(2, 132, 199, 0.12); color: #0284C7; font-size: 0.68rem;">Sektoral</span>
            </div>
            <div class="fs-2 fw-extrabold text-dark mb-1">{{ number_format($stats['total_antennas']) }}</div>
            <div class="text-muted small" style="font-size: 0.76rem;">Antena pemancar aktif</div>
        </div>
    </div>

    <!-- Stat 6: Total Client Terhubung -->
    <div class="col-12 col-sm-6 col-xl-2">
        <div class="card card-starkink border-0 p-3 h-100 shadow-sm" style="border-top: 3px solid #4F46E5 !important;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="text-muted fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">TOTAL CLIENT</span>
                <span class="badge rounded-2 px-2 py-1" style="background: rgba(79, 70, 229, 0.12); color: #4F46E5; font-size: 0.68rem;">Pengguna</span>
            </div>
            <div class="fs-2 fw-extrabold text-primary mb-1">{{ number_format($stats['total_clients']) }}</div>
            <div class="text-muted small" style="font-size: 0.76rem;">Akumulasi user terhubung</div>
        </div>
    </div>
</div>

<!-- Main Split Desktop Workspace -->
<div class="row g-4">
    <!-- Left Section: Recent Responses Widescreen Table -->
    <div class="col-12 col-xl-8">
        <div class="card card-starkink border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-bottom">
                <div>
                    <h6 class="fw-bold mb-0 text-dark" style="letter-spacing: -0.2px;">
                        <i class="fa-solid fa-clock-rotate-left text-primary me-2"></i> Respon Inventaris Terbaru
                    </h6>
                    <small class="text-muted" style="font-size: 0.76rem;">Menampilkan 10 submisi data paling akhir dari partner</small>
                </div>
                <a href="{{ route('admin.responses.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-semibold">
                    Buka Semua Respon <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="min-width: 680px;">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 16%;">Kode Respon</th>
                            <th style="width: 24%;">Lokasi / Instansi</th>
                            <th style="width: 18%;">Wilayah Kab/Kota</th>
                            <th style="width: 18%;">PIC Pengisi</th>
                            <th style="width: 12%;" class="text-center">Rekap Data</th>
                            <th style="width: 12%;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentResponses as $res)
                            <tr>
                                <td>
                                    <span class="badge bg-dark-subtle text-dark border px-2 py-1 font-monospace fw-bold" style="font-size: 0.8rem;">
                                        {{ $res->response_code }}
                                    </span>
                                    <small class="d-block text-muted mt-1" style="font-size: 0.72rem;">
                                        {{ $res->submitted_at ? $res->submitted_at->format('d/m/Y H:i') : '-' }}
                                    </small>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark text-truncate" style="max-width: 220px;">{{ $res->location_name }}</div>
                                    <small class="text-muted text-truncate d-block" style="max-width: 220px; font-size: 0.75rem;">
                                        {{ $res->location->address ?? 'Alamat tercatat' }}
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary px-2.5 py-1 fw-semibold" style="font-size: 0.75rem;">
                                        <i class="fa-solid fa-location-dot me-1 text-primary"></i> {{ $res->regency }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark" style="font-size: 0.85rem;">{{ $res->pic_name }}</div>
                                    <small class="text-muted" style="font-size: 0.75rem;">{{ $res->pic_phone }}</small>
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex gap-1">
                                        <span class="badge bg-light text-dark border" title="Perangkat" style="font-size: 0.72rem;">{{ $res->total_devices }} P</span>
                                        <span class="badge bg-light text-primary border" title="Antena" style="font-size: 0.72rem;">{{ $res->total_antennas }} A</span>
                                        <span class="badge bg-light text-success border" title="Client" style="font-size: 0.72rem;">{{ $res->total_clients }} C</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('admin.responses.show', $res->id) }}" class="btn btn-sm btn-outline-primary rounded-2 px-2 py-1" title="Lihat Detail Respon">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.responses.pdf', $res->id) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-2 px-2 py-1" title="Cetak / Download PDF">
                                            <i class="fa-solid fa-print"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-inbox fs-2 d-block mb-2 text-secondary"></i>
                                    Belum ada data inventaris partner yang tercatat di database.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Section: Regional Statistics & System Security -->
    <div class="col-12 col-xl-4 d-flex flex-column gap-3">

        <!-- Card: Top Regional Distribution -->
        <div class="card card-starkink border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="fw-bold mb-0 text-dark">
                    <i class="fa-solid fa-chart-column text-primary me-2"></i> Distribusi Wilayah Terbanyak
                </h6>
            </div>
            <div class="card-body p-3">
                @if(isset($regencyStats) && count($regencyStats) > 0)
                    @php
                        $maxTotal = $regencyStats->max('total') ?: 1;
                    @endphp
                    @foreach($regencyStats as $reg)
                        @php
                            $percentage = round(($reg->total / $maxTotal) * 100);
                        @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-semibold text-dark small">{{ $reg->regency }}</span>
                                <span class="badge bg-light text-dark border small fw-bold">{{ $reg->total }} Site</span>
                            </div>
                            <div class="progress" style="height: 6px; background-color: #E2E8F0;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted small text-center my-3">Belum ada statistik wilayah terdata.</p>
                @endif
            </div>
        </div>

        <!-- Card: Antenna & Client Capacity Overview -->
        <div class="card card-starkink border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="fw-bold mb-0 text-dark">
                    <i class="fa-solid fa-tower-broadcast text-primary me-2"></i> Kapasitas Jaringan & Aturan Client
                </h6>
            </div>
            <div class="card-body p-3">
                @php
                    $avgClient = $stats['total_antennas'] > 0 ? round($stats['total_clients'] / $stats['total_antennas'], 1) : 0;
                @endphp
                <div class="d-flex align-items-center justify-content-between p-2.5 rounded-3 bg-light border mb-3">
                    <div>
                        <small class="text-muted d-block" style="font-size: 0.74rem;">Rata-rata Client / Antena</small>
                        <span class="fs-4 fw-extrabold text-primary">{{ $avgClient }}</span>
                        <small class="text-muted">User</small>
                    </div>
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1.5 fw-semibold" style="font-size: 0.72rem;">
                        <i class="fa-solid fa-check me-1"></i> Sesuai Standar (Maks 25)
                    </span>
                </div>
                <div class="small text-muted" style="font-size: 0.78rem; line-height: 1.5;">
                    <i class="fa-solid fa-circle-info text-primary me-1"></i> Standar konfigurasi partner: 1 antena sektoral melayani maksimal 25 client demi menjaga stabilitas throughput dan latency Starlink.
                </div>
            </div>
        </div>

        <!-- Card: Security & Server Health -->
        <div class="card card-starkink border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="fw-bold mb-0 text-dark">
                    <i class="fa-solid fa-shield-halved text-success me-2"></i> Integritas & Keamanan Sistem
                </h6>
            </div>
            <div class="card-body p-3 small">
                <div class="d-flex justify-content-between align-items-center py-1.5 border-bottom">
                    <span class="text-muted">Database Engine</span>
                    <span class="fw-bold text-dark">MySQL 8.0 (Hostinger)</span>
                </div>
                <div class="d-flex justify-content-between align-items-center py-1.5 border-bottom">
                    <span class="text-muted">Rate Limiting Protection</span>
                    <span class="badge bg-success-subtle text-success border border-success-subtle">Aktif (5 req/min)</span>
                </div>
                <div class="d-flex justify-content-between align-items-center py-1.5 border-bottom">
                    <span class="text-muted">Session Fixation Guard</span>
                    <span class="badge bg-success-subtle text-success border border-success-subtle">Aktif (Regenerate)</span>
                </div>
                <div class="d-flex justify-content-between align-items-center py-1.5">
                    <span class="text-muted">Enkripsi Pengiriman</span>
                    <span class="fw-bold text-primary">HTTPS / TLS 1.3</span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
