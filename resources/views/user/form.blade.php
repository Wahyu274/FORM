@extends('layouts.app')

@section('title', 'Form Inventaris Jaringan Partner Kalimantan — Life Solution Connection')

@section('styles')
<style>
    .user-form-header {
        background: linear-gradient(135deg, #090E1A 0%, #0F172A 50%, #1E3A8A 100%);
        color: white;
        padding: 2.25rem 1rem;
        border-bottom: 3px solid #0284C7;
    }

    .brand-logo-box {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        background: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        padding: 4px;
        flex-shrink: 0;
    }

    .brand-logo-box img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .section-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 0.875rem;
        padding: 1.5rem;
        margin-bottom: 1.25rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03), 0 4px 12px -2px rgba(15, 23, 42, 0.04);
    }

    @media (max-width: 575.98px) {
        .user-form-header {
            padding: 1.5rem 0.75rem;
        }
        .section-card {
            padding: 1.15rem 0.85rem;
            border-radius: 0.75rem;
        }
    }

    .section-header {
        border-bottom: 1px solid #F1F5F9;
        padding-bottom: 0.85rem;
        margin-bottom: 1.25rem;
    }

    .section-badge {
        width: 32px;
        height: 32px;
        min-width: 32px;
        background: linear-gradient(135deg, #1E40AF 0%, #2563EB 100%);
        color: #FFFFFF;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.82rem;
        letter-spacing: -0.2px;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
    }

    .dynamic-table {
        min-width: 700px;
        margin-bottom: 0;
    }

    .dynamic-table th {
        background-color: #F8FAFC;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #475569;
        border-bottom: 2px solid #E2E8F0;
        padding: 0.75rem 0.65rem;
    }

    .dynamic-table td {
        padding: 0.65rem 0.5rem;
        vertical-align: middle;
    }

    .summary-badge-card {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 0.75rem;
        padding: 1rem;
    }

    .photo-preview-box {
        width: 100%;
        height: 125px;
        border: 2px dashed #CBD5E1;
        border-radius: 0.65rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        cursor: pointer;
        background-color: #F8FAFC;
        transition: all 0.2s ease;
        overflow: hidden;
        position: relative;
        padding: 0.5rem;
        text-align: center;
    }

    .photo-preview-box:hover {
        border-color: #2563EB;
        background-color: #EFF6FF;
    }

    .photo-preview-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        top: 0;
        left: 0;
    }

    .upload-success-badge {
        position: absolute;
        top: 6px;
        right: 6px;
        background: #10B981;
        color: white;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        z-index: 2;
    }
</style>
@endsection

@section('content')
<!-- Header Banner (Left-Aligned, Logo Top-Left with Life Solution Connection text) -->
<header class="user-form-header">
    <div class="container" style="max-width: 900px;">
        <!-- Brand Row: Logo in Top-Left and Life Solution Connection beside it -->
        <div class="d-flex align-items-center gap-3 mb-3">
            <div class="brand-logo-box">
                <img src="{{ asset('images/logo.png') }}" alt="Life Solution Connection Logo">
            </div>
            <div>
                <div class="text-white fw-bold fs-5 lh-sm" style="letter-spacing: -0.3px;">Life Solution Connection</div>
                <div class="text-uppercase fw-semibold" style="color: #7DD3FC; font-size: 0.75rem; letter-spacing: 0.8px;">Starlink Network Partner Kalimantan</div>
            </div>
        </div>

        <!-- Banner Text: Left-Aligned -->
        <div class="text-start mt-2">
            <div class="d-inline-flex align-items-center gap-2 px-2.5 py-1 rounded-pill mb-2" style="background: rgba(56, 189, 248, 0.12); border: 1px solid rgba(56, 189, 248, 0.25);">
                <span class="badge rounded-circle p-1 bg-info"></span>
                <span style="color: #7DD3FC; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.6px; text-transform: uppercase;">Portal Inventaris Resmi</span>
            </div>
            <h1 class="fw-extrabold text-white mb-2 fs-3 fs-md-2" style="letter-spacing: -0.4px;">Form Inventaris Jaringan Partner Kalimantan</h1>
            <p class="text-white-50 mb-0 small" style="max-width: 680px; line-height: 1.6;">
                Pendataan dan inventarisasi infrastruktur jaringan Starlink partner di seluruh wilayah Kalimantan. Silakan lengkapi formulir di bawah ini dengan data yang valid dan akurat.
            </p>
        </div>
    </div>
</header>

<!-- Main Container -->
<div class="container py-3 py-md-4" style="max-width: 900px;">

    <!-- Progress Indicator Bar -->
    <div class="card card-starkink mb-3 p-3 border-0 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="fw-bold text-dark small"><i class="fa-solid fa-list-check me-1 text-primary"></i> Progress Pengisian Form</span>
            <span class="badge bg-primary rounded-pill px-3" id="stepCounterBadge">Langkah 1 dari 7</span>
        </div>
        <div class="step-progress-bar">
            <div class="step-progress-fill" id="progressBar" style="width: 15%;"></div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger shadow-sm border-0 mb-3 rounded-3" role="alert">
            <div class="fw-bold mb-1"><i class="fa-solid fa-circle-exclamation me-1"></i> Mohon periksa kembali inputan Anda:</div>
            <ul class="mb-0 ps-3 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('form.submit') }}" method="POST" enctype="multipart/form-data" id="inventoryForm">
        @csrf

        <!-- BAGIAN 1 — INFORMASI LOKASI -->
        <div class="section-card">
            <div class="section-header d-flex align-items-center gap-2">
                <div class="section-badge">01</div>
                <div>
                    <h5 class="fw-bold mb-0 text-dark">Informasi Lokasi</h5>
                    <small class="text-muted">Data instansi, alamat, dan penanggung jawab lokasi</small>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-12">
                    <label for="instance_name" class="form-label">Nama Instansi / Lokasi <span class="required-star">*</span></label>
                    <input type="text" name="instance_name" id="instance_name" class="form-control" placeholder="Contoh: Site Tambang KCR Samboja / Basecamp Berau" value="{{ old('instance_name') }}" required>
                </div>

                <div class="col-12">
                    <label for="address" class="form-label">Alamat Lengkap <span class="required-star">*</span></label>
                    <textarea name="address" id="address" class="form-control" rows="2" placeholder="Alamat jalan, RT/RW, desa/kelurahan, kecamatan..." required>{{ old('address') }}</textarea>
                </div>

                <div class="col-12 col-md-6">
                    <label for="province" class="form-label">Provinsi <span class="required-star">*</span></label>
                    <select name="province" id="province" class="form-select" required>
                        <option value="">-- Pilih Provinsi --</option>
                        @foreach(array_keys($regenciesKalimantan) as $prov)
                            <option value="{{ $prov }}" {{ old('province', 'Kalimantan Timur') == $prov ? 'selected' : '' }}>{{ $prov }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-6">
                    <label for="regency" class="form-label">Kabupaten / Kota <span class="required-star">*</span></label>
                    <select name="regency" id="regency" class="form-select" required>
                        <option value="">-- Pilih Kabupaten / Kota --</option>
                        @foreach($regenciesKalimantan['Kalimantan Timur'] as $reg)
                            <option value="{{ $reg }}" {{ old('regency') == $reg ? 'selected' : '' }}>{{ $reg }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-6">
                    <label for="pic_name" class="form-label">Nama PIC / Pengisi <span class="required-star">*</span></label>
                    <input type="text" name="pic_name" id="pic_name" class="form-control" placeholder="Nama lengkap pengisi" value="{{ old('pic_name') }}" required>
                </div>

                <div class="col-12 col-md-6">
                    <label for="pic_position" class="form-label">Jabatan PIC</label>
                    <input type="text" name="pic_position" id="pic_position" class="form-control" placeholder="Contoh: IT Support / Site Engineer" value="{{ old('pic_position') }}">
                </div>

                <div class="col-12 col-md-6">
                    <label for="pic_phone" class="form-label">Nomor HP / WhatsApp <span class="required-star">*</span></label>
                    <input type="tel" name="pic_phone" id="pic_phone" class="form-control" placeholder="081234567890" value="{{ old('pic_phone') }}" required>
                </div>

                <div class="col-12 col-md-6">
                    <label for="pic_email" class="form-label">Email (Jika Ada)</label>
                    <input type="email" name="pic_email" id="pic_email" class="form-control" placeholder="pic@perusahaan.com" value="{{ old('pic_email') }}">
                </div>
            </div>
        </div>

        <!-- BAGIAN 2 — JARAK DAN AKSES LOKASI -->
        <div class="section-card">
            <div class="section-header d-flex align-items-center gap-2">
                <div class="section-badge">02</div>
                <div>
                    <h5 class="fw-bold mb-0 text-dark">Jarak dan Akses Lokasi</h5>
                    <small class="text-muted">Akses jalan, estimasi waktu, dan koordinat GPS</small>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <label for="distance_km" class="form-label">Jarak dari Titik Referensi (km) <span class="required-star">*</span></label>
                    <div class="input-group">
                        <input type="number" step="0.1" name="distance_km" id="distance_km" class="form-control" placeholder="Contoh: 15.5" value="{{ old('distance_km') }}" required>
                        <span class="input-group-text bg-light text-muted fw-semibold">km</span>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <label for="access_mode" class="form-label">Akses Menuju Lokasi <span class="required-star">*</span></label>
                    <select name="access_mode" id="access_mode" class="form-select" required>
                        <option value="">-- Pilih Akses --</option>
                        <option value="Darat (Jalan Aspal)">Darat (Jalan Aspal)</option>
                        <option value="Darat (Jalan Tanah / Offroad)">Darat (Jalan Tanah / Offroad)</option>
                        <option value="Sungai / Perahu">Sungai / Perahu Klotok / Speedboat</option>
                        <option value="Kombinasi Darat & Sungai">Kombinasi Darat & Sungai</option>
                        <option value="Udara / Helikopter">Udara / Helikopter</option>
                    </select>
                </div>

                <div class="col-12 col-md-4">
                    <label for="road_condition" class="form-label">Kondisi Jalan <span class="required-star">*</span></label>
                    <select name="road_condition" id="road_condition" class="form-select" required>
                        <option value="">-- Pilih Kondisi --</option>
                        <option value="Bagus / Aspal Mulus">Bagus / Aspal Mulus</option>
                        <option value="Cukup Baik / Berlubang Sedang">Cukup Baik / Berlubang Sedang</option>
                        <option value="Rusak / Tanah Berlumpur">Rusak / Tanah Berlumpur</option>
                        <option value="Ekstrem / Memerlukan 4WD">Ekstrem / Memerlukan 4WD</option>
                    </select>
                </div>

                <div class="col-12 col-md-4">
                    <label for="vehicle_type" class="form-label">Kendaraan yang Dapat Digunakan <span class="required-star">*</span></label>
                    <input type="text" name="vehicle_type" id="vehicle_type" class="form-control" placeholder="Contoh: Double Cabin 4WD / Trail" value="{{ old('vehicle_type') }}" required>
                </div>

                <div class="col-12 col-md-4">
                    <label for="travel_time" class="form-label">Estimasi Waktu Perjalanan</label>
                    <input type="text" name="travel_time" id="travel_time" class="form-control" placeholder="Contoh: 2 Jam 30 Menit" value="{{ old('travel_time') }}">
                </div>

                <!-- GPS Coordinates Box (Mobile-optimized) -->
                <div class="col-12">
                    <div class="p-3 bg-light rounded-3 border">
                        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-2 mb-2">
                            <label class="form-label mb-0 fw-bold text-dark">
                                <i class="fa-solid fa-location-dot text-primary me-1"></i> Koordinat Lokasi GPS
                            </label>
                            <button type="button" class="btn btn-sm btn-outline-primary fw-semibold rounded-pill px-3 w-100 w-sm-auto" id="btnGetGps">
                                <i class="fa-solid fa-location-arrow me-1"></i> Ambil Lokasi Saya
                            </button>
                        </div>
                        <p class="text-muted small mb-2">Tekan tombol di atas untuk mengisi koordinat GPS secara otomatis dari perangkat Anda.</p>
                        <div class="row g-2">
                            <div class="col-12 col-sm-6">
                                <label for="latitude" class="form-label small text-muted mb-1">Latitude</label>
                                <input type="number" step="any" name="latitude" id="latitude" class="form-control" placeholder="Contoh: -1.234567" value="{{ old('latitude') }}">
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="longitude" class="form-label small text-muted mb-1">Longitude</label>
                                <input type="number" step="any" name="longitude" id="longitude" class="form-control" placeholder="Contoh: 116.890123" value="{{ old('longitude') }}">
                            </div>
                        </div>
                        <div id="gpsStatusText" class="form-text mt-2 text-primary fw-medium" style="display:none;"></div>
                    </div>
                </div>

                <div class="col-12">
                    <label for="access_notes" class="form-label">Catatan Akses Lokasi</label>
                    <textarea name="access_notes" id="access_notes" class="form-control" rows="2" placeholder="Catatan khusus mengenai rute perjalanan, penyeberangan sungai, cuaca, atau perizinan..."></textarea>
                </div>
            </div>
        </div>

        <!-- BAGIAN 3 — TOPOLOGI JARINGAN -->
        <div class="section-card">
            <div class="section-header d-flex align-items-center gap-2">
                <div class="section-badge">03</div>
                <div>
                    <h5 class="fw-bold mb-0 text-dark">Topologi Jaringan</h5>
                    <small class="text-muted">Skema dan skenario arsitektur distribusi koneksi</small>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <label for="topology_type" class="form-label">Jenis Topologi <span class="required-star">*</span></label>
                    <select name="topology_type" id="topology_type" class="form-select" required>
                        <option value="">-- Pilih Jenis Topologi --</option>
                        @foreach($topologyOptions as $key => $val)
                            <option value="{{ $key }}" {{ old('topology_type') == $key ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-6">
                    <label for="topology_file" class="form-label">Upload File Topologi (Opsional)</label>
                    <input type="file" name="topology_file" id="topology_file" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                    <div class="form-text text-muted" style="font-size: 0.78rem;">Format didukung: JPG, PNG, atau PDF (Maksimal 10 MB).</div>
                </div>

                <div class="col-12">
                    <label for="topology_description" class="form-label">Penjelasan Topologi</label>
                    <textarea name="topology_description" id="topology_description" class="form-control" rows="2" placeholder="Jelaskan alur distribusi: Starlink Dish -> Router Utama -> Switch -> Access Point..."></textarea>
                </div>
            </div>
        </div>

        <!-- BAGIAN 4 — PERANGKAT JARINGAN (Tabel Dinamis) -->
        <div class="section-card">
            <div class="section-header d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                <div class="d-flex align-items-center gap-2">
                    <div class="section-badge">04</div>
                    <div>
                        <h5 class="fw-bold mb-0 text-dark">Perangkat Jaringan</h5>
                        <small class="text-muted">Daftar modem, router, switch, AP, UPS, dan perangkat lainnya</small>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary fw-semibold rounded-pill px-3 w-100 w-sm-auto mt-2 mt-sm-0" id="btnAddDevice">
                    <i class="fa-solid fa-plus me-1"></i> Tambah Perangkat
                </button>
            </div>

            <!-- Mobile Table Hint -->
            <div class="d-block d-md-none text-muted small mb-2">
                <i class="fa-solid fa-arrows-left-right me-1 text-primary"></i> <span style="font-size:0.78rem;">Geser tabel ke samping untuk melihat & mengisi semua kolom</span>
            </div>

            <div class="table-responsive rounded-3 border">
                <table class="table table-bordered align-middle dynamic-table" id="devicesTable">
                    <thead>
                        <tr>
                            <th style="width: 22%;">Jenis Perangkat</th>
                            <th style="width: 15%;">Merk</th>
                            <th style="width: 15%;">Tipe / Model</th>
                            <th style="width: 10%;">Jumlah</th>
                            <th style="width: 18%;">Spesifikasi</th>
                            <th style="width: 13%;">Kondisi</th>
                            <th style="width: 7%;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="devicesTableBody">
                        <tr class="device-row">
                            <td>
                                <select name="devices[0][device_type]" class="form-select form-select-sm" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach($deviceTypeOptions as $dType)
                                        <option value="{{ $dType }}" {{ $dType == 'Modem / ONT' ? 'selected' : '' }}>{{ $dType }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="text" name="devices[0][brand]" class="form-control form-control-sm" placeholder="Starlink"></td>
                            <td><input type="text" name="devices[0][model]" class="form-control form-control-sm" placeholder="Standard Actuated"></td>
                            <td><input type="number" name="devices[0][quantity]" class="form-control form-control-sm text-center" value="1" min="1"></td>
                            <td><input type="text" name="devices[0][specs]" class="form-control form-control-sm" placeholder="Gen 2 Motorized"></td>
                            <td>
                                <select name="devices[0][condition]" class="form-select form-select-sm">
                                    <option value="Baik" selected>Baik</option>
                                    <option value="Rusak Ringan">Rusak Ringan</option>
                                    <option value="Rusak Berat">Rusak Berat</option>
                                    <option value="Perlu Peremajaan">Perlu Peremajaan</option>
                                </select>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-danger btn-sm btn-remove-row rounded-2" title="Hapus Baris"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>

                        <tr class="device-row">
                            <td>
                                <select name="devices[1][device_type]" class="form-select form-select-sm">
                                    <option value="">-- Pilih --</option>
                                    @foreach($deviceTypeOptions as $dType)
                                        <option value="{{ $dType }}" {{ $dType == 'Router' ? 'selected' : '' }}>{{ $dType }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="text" name="devices[1][brand]" class="form-control form-control-sm" placeholder="MikroTik"></td>
                            <td><input type="text" name="devices[1][model]" class="form-control form-control-sm" placeholder="RB5009"></td>
                            <td><input type="number" name="devices[1][quantity]" class="form-control form-control-sm text-center" value="1" min="1"></td>
                            <td><input type="text" name="devices[1][specs]" class="form-control form-control-sm" placeholder="RouterOS v7"></td>
                            <td>
                                <select name="devices[1][condition]" class="form-select form-select-sm">
                                    <option value="Baik" selected>Baik</option>
                                    <option value="Rusak Ringan">Rusak Ringan</option>
                                    <option value="Rusak Berat">Rusak Berat</option>
                                </select>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-danger btn-sm btn-remove-row rounded-2" title="Hapus Baris"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- BAGIAN 5 — ANTENA DAN CLIENT -->
        <div class="section-card">
            <div class="section-header d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                <div class="d-flex align-items-center gap-2">
                    <div class="section-badge">05</div>
                    <div>
                        <h5 class="fw-bold mb-0 text-dark">Antena dan Client</h5>
                        <small class="text-muted">Standar kapasitas: 1 Antena maksimal melayani 25 Client</small>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary fw-semibold rounded-pill px-3 w-100 w-sm-auto mt-2 mt-sm-0" id="btnAddAntenna">
                    <i class="fa-solid fa-plus me-1"></i> Tambah Antena
                </button>
            </div>

            <!-- Summary Auto Calculation Card -->
            <div class="summary-badge-card mb-3">
                <div class="row text-center align-items-center g-2">
                    <div class="col-6 border-end">
                        <div class="text-muted small fw-semibold text-uppercase" style="font-size:0.75rem; letter-spacing: 0.5px;">TOTAL ANTENA</div>
                        <div class="fs-3 fw-bold text-dark mt-1" id="totalAntennaDisplay">1</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small fw-semibold text-uppercase" style="font-size:0.75rem; letter-spacing: 0.5px;">TOTAL CLIENT TERHUBUNG</div>
                        <div class="fs-3 fw-bold text-primary mt-1" id="totalClientDisplay">15</div>
                    </div>
                </div>
            </div>

            <!-- Mobile Table Hint -->
            <div class="d-block d-md-none text-muted small mb-2">
                <i class="fa-solid fa-arrows-left-right me-1 text-primary"></i> <span style="font-size:0.78rem;">Geser tabel ke samping untuk melihat & mengisi semua kolom</span>
            </div>

            <div class="table-responsive rounded-3 border">
                <table class="table table-bordered align-middle dynamic-table" id="antennaTable">
                    <thead>
                        <tr>
                            <th style="width: 20%;">ID / Nama Antena</th>
                            <th style="width: 20%;">Merk / Tipe</th>
                            <th style="width: 15%;">Frekuensi</th>
                            <th style="width: 20%;">Lokasi Pemasangan</th>
                            <th style="width: 17%;">Jumlah Client</th>
                            <th style="width: 8%;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="antennaTableBody">
                        <tr class="antenna-row">
                            <td><input type="text" name="antennas[0][antenna_code]" class="form-control form-control-sm fw-bold" value="Antena 1"></td>
                            <td><input type="text" name="antennas[0][brand_model]" class="form-control form-control-sm" placeholder="Ruijie / Ubiquiti"></td>
                            <td><input type="text" name="antennas[0][frequency]" class="form-control form-control-sm" placeholder="5 GHz"></td>
                            <td><input type="text" name="antennas[0][install_location]" class="form-control form-control-sm" placeholder="Tower Monopole 15m"></td>
                            <td>
                                <input type="number" name="antennas[0][client_count]" class="form-control form-control-sm antenna-client-input text-center fw-bold" value="15" min="0" max="200">
                                <small class="text-muted d-block text-center client-warning mt-1" style="font-size:0.72rem;">Maks 25/antena</small>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-danger btn-sm btn-remove-antenna rounded-2" title="Hapus Baris"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- BAGIAN 6 — INFORMASI TAMBAHAN -->
        <div class="section-card">
            <div class="section-header d-flex align-items-center gap-2">
                <div class="section-badge">06</div>
                <div>
                    <h5 class="fw-bold mb-0 text-dark">Informasi Tambahan</h5>
                    <small class="text-muted">Kondisi teknis lapangan, suplai listrik, tiang, dan kendala</small>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <label for="signal_condition" class="form-label">Kondisi Sinyal Starlink</label>
                    <input type="text" name="signal_condition" id="signal_condition" class="form-control" placeholder="Contoh: Sangat Baik / Obstruction 0%" value="{{ old('signal_condition') }}">
                </div>

                <div class="col-12 col-md-6">
                    <label for="power_condition" class="form-label">Kondisi Listrik & Power Backup</label>
                    <input type="text" name="power_condition" id="power_condition" class="form-control" placeholder="Contoh: PLN 2200W + UPS 1200VA / Genset" value="{{ old('power_condition') }}">
                </div>

                <div class="col-12 col-md-6">
                    <label for="tower_condition" class="form-label">Kondisi Tower / Tiang</label>
                    <input type="text" name="tower_condition" id="tower_condition" class="form-control" placeholder="Contoh: Tower Monopole 15 meter" value="{{ old('tower_condition') }}">
                </div>

                <div class="col-12 col-md-6">
                    <label for="network_issues" class="form-label">Kendala Jaringan Jika Ada</label>
                    <input type="text" name="network_issues" id="network_issues" class="form-control" placeholder="Contoh: Listrik sering padam saat cuaca hujan" value="{{ old('network_issues') }}">
                </div>

                <div class="col-12">
                    <label for="required_hardware" class="form-label">Kebutuhan Perangkat Tambahan / Catatan Teknis</label>
                    <textarea name="required_hardware" id="required_hardware" class="form-control" rows="2" placeholder="Catat jika memerlukan penambahan Access Point, Switch tambahan, atau perbaikan tiang..."></textarea>
                </div>
            </div>
        </div>

        <!-- BAGIAN 7 — DOKUMENTASI FOTO -->
        <div class="section-card">
            <div class="section-header d-flex align-items-center gap-2">
                <div class="section-badge">07</div>
                <div>
                    <h5 class="fw-bold mb-0 text-dark">Dokumentasi Foto</h5>
                    <small class="text-muted">Upload foto lokasi, perangkat, antena, dan instalasi (Format: JPG, PNG. Maks: 5MB)</small>
                </div>
            </div>

            <div class="row g-2 g-md-3">
                <div class="col-6 col-md-3">
                    <label class="form-label small fw-bold text-dark">Foto Lokasi / Gedung</label>
                    <label class="photo-preview-box" for="foto_lokasi">
                        <span class="upload-success-badge" id="badge_foto_lokasi"><i class="fa-solid fa-check"></i></span>
                        <i class="fa-solid fa-camera fs-4 text-secondary mb-1"></i>
                        <span class="small text-muted text-center px-1" style="font-size: 0.78rem;">Pilih Foto</span>
                        <img id="preview_foto_lokasi" style="display:none;" alt="Preview Foto Lokasi">
                    </label>
                    <input type="file" name="foto_lokasi" id="foto_lokasi" class="d-none photo-input-file" accept="image/*">
                </div>

                <div class="col-6 col-md-3">
                    <label class="form-label small fw-bold text-dark">Foto Perangkat Server</label>
                    <label class="photo-preview-box" for="foto_perangkat">
                        <span class="upload-success-badge" id="badge_foto_perangkat"><i class="fa-solid fa-check"></i></span>
                        <i class="fa-solid fa-server fs-4 text-secondary mb-1"></i>
                        <span class="small text-muted text-center px-1" style="font-size: 0.78rem;">Pilih Foto</span>
                        <img id="preview_foto_perangkat" style="display:none;" alt="Preview Foto Perangkat">
                    </label>
                    <input type="file" name="foto_perangkat" id="foto_perangkat" class="d-none photo-input-file" accept="image/*">
                </div>

                <div class="col-6 col-md-3">
                    <label class="form-label small fw-bold text-dark">Foto Antena & Dish</label>
                    <label class="photo-preview-box" for="foto_antena">
                        <span class="upload-success-badge" id="badge_foto_antena"><i class="fa-solid fa-check"></i></span>
                        <i class="fa-solid fa-satellite-dish fs-4 text-secondary mb-1"></i>
                        <span class="small text-muted text-center px-1" style="font-size: 0.78rem;">Pilih Foto</span>
                        <img id="preview_foto_antena" style="display:none;" alt="Preview Foto Antena">
                    </label>
                    <input type="file" name="foto_antena" id="foto_antena" class="d-none photo-input-file" accept="image/*">
                </div>

                <div class="col-6 col-md-3">
                    <label class="form-label small fw-bold text-dark">Foto Instalasi Kabel</label>
                    <label class="photo-preview-box" for="foto_instalasi">
                        <span class="upload-success-badge" id="badge_foto_instalasi"><i class="fa-solid fa-check"></i></span>
                        <i class="fa-solid fa-network-wired fs-4 text-secondary mb-1"></i>
                        <span class="small text-muted text-center px-1" style="font-size: 0.78rem;">Pilih Foto</span>
                        <img id="preview_foto_instalasi" style="display:none;" alt="Preview Foto Instalasi">
                    </label>
                    <input type="file" name="foto_instalasi" id="foto_instalasi" class="d-none photo-input-file" accept="image/*">
                </div>
            </div>
        </div>

        <!-- SUBMIT BUTTON CARD -->
        <div class="card card-starkink p-4 border-0 shadow text-center mb-4" style="background: linear-gradient(135deg, #F8FAFC 0%, #EFF6FF 100%); border: 1px solid #DBEAFE !important;">
            <h5 class="fw-bold text-dark mb-1">Verifikasi & Pengiriman Data</h5>
            <p class="text-muted small mb-3" style="max-width: 520px; margin: 0 auto;">Pastikan seluruh data inventaris lokasi, perangkat, dan antena telah terisi dengan benar sebelum mengirimkan formulir.</p>

            <div class="d-flex flex-column flex-sm-row justify-content-center gap-2">
                <button type="submit" class="btn btn-starkink-primary btn-lg px-5 py-3 fw-bold rounded-pill shadow-sm w-100 w-sm-auto" style="min-width: 280px;">
                    <i class="fa-solid fa-paper-plane me-2"></i> Kirim Formulir Inventaris
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Footer -->
<footer class="bg-starkink-navy text-white-50 py-4 mt-auto border-top border-secondary border-opacity-25">
    <div class="container text-center">
        <div class="fw-bold text-white mb-1">Life Solution Connection — Starlink Network Partner Kalimantan</div>
        <small class="d-block mb-1 text-white-50">Sistem Inventarisasi Infrastruktur & Jaringan Partner Regional Kalimantan</small>
        <small class="text-xs text-white-50">&copy; {{ date('Y') }} Life Solution Connection. All rights reserved.</small>
    </div>
</footer>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // 1. Regency Dropdown Dynamic Updating based on Province
        const provinceSelect = document.getElementById('province');
        const regencySelect = document.getElementById('regency');
        const regenciesMap = @json($regenciesKalimantan);

        provinceSelect.addEventListener('change', function() {
            const selectedProv = this.value;
            regencySelect.innerHTML = '<option value="">-- Pilih Kabupaten / Kota --</option>';

            if (selectedProv && regenciesMap[selectedProv]) {
                regenciesMap[selectedProv].forEach(reg => {
                    const opt = document.createElement('option');
                    opt.value = reg;
                    opt.textContent = reg;
                    regencySelect.appendChild(opt);
                });
            }
        });

        // 2. GPS Geolocation Button
        const btnGetGps = document.getElementById('btnGetGps');
        const latInput = document.getElementById('latitude');
        const longInput = document.getElementById('longitude');
        const gpsStatusText = document.getElementById('gpsStatusText');

        btnGetGps.addEventListener('click', function() {
            if (!navigator.geolocation) {
                alert('Browser Anda tidak mendukung fitur Geolocation GPS.');
                return;
            }

            gpsStatusText.style.display = 'block';
            gpsStatusText.className = 'form-text mt-2 text-primary fw-medium';
            gpsStatusText.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Mengambil titik koordinat GPS...';

            navigator.geolocation.getCurrentPosition(
                function(position) {
                    latInput.value = position.coords.latitude.toFixed(8);
                    longInput.value = position.coords.longitude.toFixed(8);
                    gpsStatusText.className = 'form-text mt-2 text-success fw-bold';
                    gpsStatusText.innerHTML = '<i class="fa-solid fa-check-circle me-1"></i> Koordinat GPS berhasil diambil!';
                },
                function(error) {
                    gpsStatusText.className = 'form-text mt-2 text-danger fw-bold';
                    gpsStatusText.innerHTML = '<i class="fa-solid fa-circle-exclamation me-1"></i> Gagal mengambil GPS: ' + error.message;
                },
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
            );
        });

        // 3. Dynamic Devices Table Rows (+ Tambah Perangkat)
        const devicesTableBody = document.getElementById('devicesTableBody');
        const btnAddDevice = document.getElementById('btnAddDevice');
        let deviceIndex = 2;

        const deviceTypes = @json($deviceTypeOptions);

        btnAddDevice.addEventListener('click', function() {
            const tr = document.createElement('tr');
            tr.className = 'device-row';

            let typeOptionsHtml = '<option value="">-- Pilih --</option>';
            deviceTypes.forEach(t => {
                typeOptionsHtml += `<option value="${t}">${t}</option>`;
            });

            tr.innerHTML = `
                <td>
                    <select name="devices[${deviceIndex}][device_type]" class="form-select form-select-sm" required>
                        ${typeOptionsHtml}
                    </select>
                </td>
                <td><input type="text" name="devices[${deviceIndex}][brand]" class="form-control form-control-sm" placeholder="Merk"></td>
                <td><input type="text" name="devices[${deviceIndex}][model]" class="form-control form-control-sm" placeholder="Tipe"></td>
                <td><input type="number" name="devices[${deviceIndex}][quantity]" class="form-control form-control-sm text-center" value="1" min="1"></td>
                <td><input type="text" name="devices[${deviceIndex}][specs]" class="form-control form-control-sm" placeholder="Spesifikasi"></td>
                <td>
                    <select name="devices[${deviceIndex}][condition]" class="form-select form-select-sm">
                        <option value="Baik" selected>Baik</option>
                        <option value="Rusak Ringan">Rusak Ringan</option>
                        <option value="Rusak Berat">Rusak Berat</option>
                        <option value="Perlu Peremajaan">Perlu Peremajaan</option>
                    </select>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-outline-danger btn-sm btn-remove-row rounded-2" title="Hapus Baris"><i class="fa-solid fa-trash"></i></button>
                </td>
            `;

            devicesTableBody.appendChild(tr);
            deviceIndex++;
        });

        devicesTableBody.addEventListener('click', function(e) {
            if (e.target.closest('.btn-remove-row')) {
                const row = e.target.closest('tr');
                if (devicesTableBody.querySelectorAll('tr').length > 1) {
                    row.remove();
                } else {
                    alert('Minimal 1 baris perangkat harus terisi.');
                }
            }
        });

        // 4. Dynamic Antenna Rows & Auto Calculation
        const antennaTableBody = document.getElementById('antennaTableBody');
        const btnAddAntenna = document.getElementById('btnAddAntenna');
        const totalAntennaDisplay = document.getElementById('totalAntennaDisplay');
        const totalClientDisplay = document.getElementById('totalClientDisplay');
        let antennaIndex = 1;

        function updateAntennaCalculations() {
            const rows = antennaTableBody.querySelectorAll('.antenna-row');
            totalAntennaDisplay.textContent = rows.length;

            let totalClients = 0;
            rows.forEach(r => {
                const clientInput = r.querySelector('.antenna-client-input');
                if (clientInput) {
                    const count = parseInt(clientInput.value) || 0;
                    totalClients += count;

                    // Check >25 clients warning rule
                    const warning = r.querySelector('.client-warning');
                    if (count > 25) {
                        warning.className = 'text-danger d-block text-center client-warning fw-bold mt-1';
                        warning.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> Melebihi 25 client!';
                    } else {
                        warning.className = 'text-muted d-block text-center client-warning mt-1';
                        warning.textContent = 'Maks 25/antena';
                    }
                }
            });

            totalClientDisplay.textContent = totalClients;
        }

        btnAddAntenna.addEventListener('click', function() {
            const num = antennaTableBody.querySelectorAll('tr').length + 1;
            const tr = document.createElement('tr');
            tr.className = 'antenna-row';

            tr.innerHTML = `
                <td><input type="text" name="antennas[${antennaIndex}][antenna_code]" class="form-control form-control-sm fw-bold" value="Antena ${num}"></td>
                <td><input type="text" name="antennas[${antennaIndex}][brand_model]" class="form-control form-control-sm" placeholder="Merk / Tipe"></td>
                <td><input type="text" name="antennas[${antennaIndex}][frequency]" class="form-control form-control-sm" placeholder="5 GHz"></td>
                <td><input type="text" name="antennas[${antennaIndex}][install_location]" class="form-control form-control-sm" placeholder="Lokasi Pasang"></td>
                <td>
                    <input type="number" name="antennas[${antennaIndex}][client_count]" class="form-control form-control-sm antenna-client-input text-center fw-bold" value="10" min="0">
                    <small class="text-muted d-block text-center client-warning mt-1" style="font-size:0.72rem;">Maks 25/antena</small>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-outline-danger btn-sm btn-remove-antenna rounded-2" title="Hapus Baris"><i class="fa-solid fa-trash"></i></button>
                </td>
            `;

            antennaTableBody.appendChild(tr);
            antennaIndex++;
            updateAntennaCalculations();
        });

        antennaTableBody.addEventListener('click', function(e) {
            if (e.target.closest('.btn-remove-antenna')) {
                const row = e.target.closest('tr');
                if (antennaTableBody.querySelectorAll('tr').length > 1) {
                    row.remove();
                    updateAntennaCalculations();
                } else {
                    alert('Minimal 1 antena harus terisi.');
                }
            }
        });

        antennaTableBody.addEventListener('input', function(e) {
            if (e.target.classList.contains('antenna-client-input')) {
                updateAntennaCalculations();
            }
        });

        updateAntennaCalculations();

        // 5. Photo Live Preview with clean check badge
        document.querySelectorAll('.photo-input-file').forEach(input => {
            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                const previewImg = document.getElementById('preview_' + input.id);
                const badge = document.getElementById('badge_' + input.id);
                const box = input.previousElementSibling;

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(evt) {
                        previewImg.src = evt.target.result;
                        previewImg.style.display = 'block';
                        if (badge) badge.style.display = 'flex';
                        box.querySelector('i')?.style.setProperty('display', 'none');
                        box.querySelector('span')?.style.setProperty('display', 'none');
                    };
                    reader.readAsDataURL(file);
                }
            });
        });

    });
</script>
@endsection
