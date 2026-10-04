@extends('layouts.admin')

@section('page_title', 'Detail Respon — ' . $response->response_code)

@section('admin_content')
<!-- Header Bar Actions -->
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin.responses.index') }}" class="btn btn-outline-secondary rounded-circle">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h4 class="fw-extrabold text-dark mb-0">Respon: {{ $response->response_code }}</h4>
            <small class="text-muted">Dikirim pada {{ $response->submitted_at ? $response->submitted_at->format('d F Y, H:i') : '-' }} WITA</small>
        </div>
    </div>

    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('admin.responses.pdf', $response->id) }}" target="_blank" class="btn btn-starkink-primary fw-bold shadow-sm">
            <i class="fa-solid fa-print me-1"></i> Download / Print PDF
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Location, Access, Topology, Devices, Antenna -->
    <div class="col-lg-8">

        <!-- Bagian 1 & 2: Informasi Lokasi & Akses -->
        <div class="card card-starkink border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0 text-dark">
                    <i class="fa-solid fa-location-dot text-primary me-2"></i> Informasi Lokasi & Akses
                </h6>
                <span class="badge bg-primary-subtle text-primary px-3 py-1 fw-bold">
                    {{ $response->regency }}, {{ $response->province }}
                </span>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <span class="text-muted small d-block">Nama Instansi / Lokasi</span>
                        <strong class="fs-6 text-dark">{{ $response->location->instance_name ?? $response->location_name }}</strong>
                    </div>

                    <div class="col-md-6">
                        <span class="text-muted small d-block">Alamat Lengkap</span>
                        <span class="fw-medium text-dark">{{ $response->location->address ?? '-' }}</span>
                    </div>

                    <div class="col-md-4">
                        <span class="text-muted small d-block">PIC Pengisi</span>
                        <strong class="text-dark">{{ $response->location->pic_name ?? $response->pic_name }}</strong>
                        <small class="text-muted d-block">{{ $response->location->pic_position ?? '-' }}</small>
                    </div>

                    <div class="col-md-4">
                        <span class="text-muted small d-block">Kontak PIC</span>
                        <span class="fw-semibold text-dark">{{ $response->location->pic_phone ?? $response->pic_phone }}</span>
                        <small class="text-muted d-block">{{ $response->location->pic_email ?? '-' }}</small>
                    </div>

                    <div class="col-md-4">
                        <span class="text-muted small d-block">Jarak Referensi</span>
                        <span class="fw-bold text-dark">{{ $response->location->distance_km ?? 0 }} km</span>
                    </div>

                    <div class="col-md-4">
                        <span class="text-muted small d-block">Akses Menuju Lokasi</span>
                        <span class="badge bg-light text-dark border">{{ $response->location->access_mode ?? '-' }}</span>
                    </div>

                    <div class="col-md-4">
                        <span class="text-muted small d-block">Kondisi Jalan</span>
                        <span class="badge bg-light text-dark border">{{ $response->location->road_condition ?? '-' }}</span>
                    </div>

                    <div class="col-md-4">
                        <span class="text-muted small d-block">Kendaraan</span>
                        <span class="fw-medium text-dark">{{ $response->location->vehicle_type ?? '-' }}</span>
                    </div>
                </div>

                <!-- Leaflet Interactive Map Card -->
                @if($response->location && $response->location->latitude && $response->location->longitude)
                    <div class="mt-4">
                        <label class="form-label fw-bold small text-muted"><i class="fa-solid fa-map me-1 text-danger"></i> Peta Lokasi GPS ({{ $response->location->latitude }}, {{ $response->location->longitude }})</label>
                        <div id="locationMap" style="height: 250px; border-radius: 0.75rem; border: 1px solid #CBD5E1;"></div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Bagian 3: Topologi Jaringan -->
        <div class="card card-starkink border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="fw-bold mb-0 text-dark">
                    <i class="fa-solid fa-diagram-project text-primary me-2"></i> Topologi Jaringan
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <span class="text-muted small d-block">Jenis Topologi</span>
                        <span class="badge bg-info-subtle text-info border border-info-subtle fs-6 px-3 py-1">
                            {{ $response->topology->topology_type ?? 'Star' }}
                        </span>
                    </div>

                    <div class="col-md-12">
                        <span class="text-muted small d-block">Penjelasan Skema Topologi</span>
                        <p class="mb-0 text-dark bg-light p-3 rounded border">{{ $response->topology->description ?? 'Tidak ada penjelasan khusus.' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bagian 4: Perangkat Jaringan (Tabel) -->
        <div class="card card-starkink border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0 text-dark">
                    <i class="fa-solid fa-network-wired text-primary me-2"></i> Perangkat Jaringan (Total: {{ $response->total_devices }} Perangkat)
                </h6>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Jenis Perangkat</th>
                            <th>Merk / Brand</th>
                            <th>Tipe / Model</th>
                            <th class="text-center">Jumlah</th>
                            <th>Spesifikasi</th>
                            <th>Kondisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($response->devices as $dev)
                            <tr>
                                <td class="fw-bold text-dark">{{ $dev->device_type }}</td>
                                <td>{{ $dev->brand ?? '-' }}</td>
                                <td>{{ $dev->model ?? '-' }}</td>
                                <td class="text-center fw-bold">{{ $dev->quantity }}</td>
                                <td class="small text-muted">{{ $dev->specs ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">
                                        {{ $dev->condition ?? 'Baik' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-3">Tidak ada data perangkat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Bagian 5: Antena & Client (Tabel) -->
        <div class="card card-starkink border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0 text-dark">
                    <i class="fa-solid fa-satellite text-primary me-2"></i> Antena dan Client
                </h6>
                <div class="badge bg-success-subtle text-success fs-6 px-3 py-1 fw-bold">
                    Total: {{ $response->total_antennas }} Antena | {{ $response->total_clients }} Client
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID Antena</th>
                            <th>Merk / Tipe</th>
                            <th>Frekuensi</th>
                            <th>Lokasi Pemasangan</th>
                            <th class="text-center">Jumlah Client</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($response->antennas as $ant)
                            <tr>
                                <td class="fw-bold text-primary">{{ $ant->antenna_code }}</td>
                                <td>{{ $ant->brand_model ?? '-' }}</td>
                                <td>{{ $ant->frequency ?? '-' }}</td>
                                <td>{{ $ant->install_location ?? '-' }}</td>
                                <td class="text-center">
                                    <span class="badge bg-primary px-3 py-1 fs-6">
                                        {{ $ant->client_count }} / {{ $ant->max_clients }} Client
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">Tidak ada data antena.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Right Column: Additional Info & Documentation Photos -->
    <div class="col-lg-4">

        <!-- Summary Badge Card -->
        <div class="card card-starkink border-0 shadow-sm mb-4 bg-starkink-navy text-white p-3">
            <div class="small text-starkink-sky fw-bold text-uppercase" style="letter-spacing:1px;">Ringkasan Respon</div>
            <div class="display-6 fw-extrabold my-2">{{ $response->response_code }}</div>
            <div class="d-flex justify-content-between small text-white-50 border-top border-secondary border-opacity-50 pt-2 mt-2">
                <span>Status:</span>
                <span class="badge bg-success text-white fw-bold">{{ strtoupper($response->status) }}</span>
            </div>
        </div>

        <!-- Bagian 6: Informasi Tambahan -->
        <div class="card card-starkink border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="fw-bold mb-0 text-dark">
                    <i class="fa-solid fa-clipboard-list text-primary me-2"></i> Informasi Tambahan & Teknis
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <span class="text-muted small d-block">Kondisi Sinyal Starlink</span>
                    <span class="fw-semibold text-dark">{{ $response->values->where('field_name', 'signal_condition')->first()->value ?? 'Baik' }}</span>
                </div>

                <div class="mb-3">
                    <span class="text-muted small d-block">Kondisi Listrik & Power</span>
                    <span class="fw-semibold text-dark">{{ $response->values->where('field_name', 'power_condition')->first()->value ?? '-' }}</span>
                </div>

                <div class="mb-3">
                    <span class="text-muted small d-block">Kondisi Tower / Tiang</span>
                    <span class="fw-semibold text-dark">{{ $response->values->where('field_name', 'tower_condition')->first()->value ?? '-' }}</span>
                </div>

                <div class="mb-0">
                    <span class="text-muted small d-block">Catatan Teknis / Kebutuhan Perangkat</span>
                    <p class="mb-0 small bg-light p-2 rounded border">{{ $response->values->where('field_name', 'required_hardware')->first()->value ?? 'Tidak ada catatan khusus.' }}</p>
                </div>
            </div>
        </div>

        <!-- Bagian 7: Dokumentasi Upload Gallery -->
        <div class="card card-starkink border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-dark">
                    <i class="fa-solid fa-images text-primary me-2"></i> Dokumentasi Foto & Berkas
                </h6>
                <span class="badge bg-primary rounded-pill px-2.5 py-1">{{ $response->uploads->count() }} Berkas</span>
            </div>
            <div class="card-body">
                @if($response->uploads->count() > 0)
                    <div class="row g-3">
                        @foreach($response->uploads as $upload)
                            @php
                                $imgSrc = $upload->base64_src ?: $upload->url;
                                $label = ucwords(str_replace('_', ' ', $upload->field_name));
                            @endphp
                            <div class="col-6">
                                <div class="card h-100 border shadow-sm overflow-hidden position-relative">
                                    <div class="position-relative bg-light text-center" style="height: 130px; overflow: hidden;">
                                        @if($upload->isImage())
                                            <img src="{{ $imgSrc }}" 
                                                 alt="{{ $upload->original_name }}"
                                                 class="w-100 h-100 object-fit-cover previewable-img"
                                                 style="cursor: pointer; transition: transform 0.2s;"
                                                 data-bs-toggle="modal" 
                                                 data-bs-target="#imagePreviewModal"
                                                 data-img-src="{{ $imgSrc }}"
                                                 data-img-title="{{ $label }}"
                                                 data-img-name="{{ $upload->original_name }}"
                                                 data-img-size="{{ $upload->formatted_size }}"
                                                 data-img-url="{{ $upload->url }}"
                                                 onerror="this.onerror=null; this.src='{{ $upload->url }}';"
                                                 title="Klik untuk memperbesar">
                                            
                                            <!-- Overlay Quick Action -->
                                            <div class="position-absolute top-0 end-0 p-1">
                                                <button type="button" 
                                                        class="btn btn-sm btn-dark bg-opacity-75 text-white p-1 rounded-circle shadow-sm"
                                                        style="width: 28px; height: 28px;"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#imagePreviewModal"
                                                        data-img-src="{{ $imgSrc }}"
                                                        data-img-title="{{ $label }}"
                                                        data-img-name="{{ $upload->original_name }}"
                                                        data-img-size="{{ $upload->formatted_size }}"
                                                        data-img-url="{{ $upload->url }}"
                                                        title="Pratinjau Foto">
                                                    <i class="fa-solid fa-magnifying-glass-plus" style="font-size: 11px;"></i>
                                                </button>
                                            </div>
                                        @else
                                            <div class="d-flex flex-column align-items-center justify-content-center h-100 p-2 text-center">
                                                <i class="fa-solid fa-file-pdf fs-1 text-danger mb-1"></i>
                                                <span class="small fw-semibold text-truncate w-100 text-dark">{{ $upload->original_name }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-2 bg-white">
                                        <div class="fw-bold text-dark text-truncate" style="font-size: 0.8rem;" title="{{ $label }}">
                                            {{ $label }}
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-1">
                                            <span class="text-muted" style="font-size: 0.7rem;">{{ $upload->formatted_size }}</span>
                                            <a href="{{ $upload->url }}" 
                                               download="{{ $upload->original_name }}" 
                                               class="btn btn-xs btn-outline-primary py-0 px-2"
                                               style="font-size: 0.7rem;"
                                               title="Download file">
                                                <i class="fa-solid fa-download me-1"></i> Unduh
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted small mb-0 text-center py-4">
                        <i class="fa-regular fa-image fs-3 d-block text-secondary opacity-50 mb-2"></i>
                        Tidak ada foto dokumentasi yang diunggah.
                    </p>
                @endif
            </div>
        </div>

    </div>
</div>

<!-- Modal Lightbox Pratinjau Foto -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1rem; overflow: hidden;">
            <div class="modal-header bg-dark text-white border-0 py-2.5 px-3">
                <div>
                    <h6 class="modal-title fw-bold mb-0" id="imagePreviewModalLabel">Pratinjau Foto</h6>
                    <small class="text-white-50" id="modalImageFilename" style="font-size: 0.75rem;"></small>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="#" id="modalDownloadBtn" download class="btn btn-sm btn-primary py-1 px-2.5" style="font-size: 0.8rem;">
                        <i class="fa-solid fa-download me-1"></i> Unduh Asli
                    </a>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
            </div>
            <div class="modal-body p-0 bg-black text-center position-relative d-flex align-items-center justify-content-center" style="min-height: 350px; max-height: 80vh;">
                <img src="" id="modalPreviewImg" class="img-fluid" style="max-height: 78vh; object-fit: contain;" alt="Pratinjau Foto">
            </div>
        </div>
    </div>
</div>
@endsection

@section('admin_scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal Image Preview Handler
        const previewModal = document.getElementById('imagePreviewModal');
        if (previewModal) {
            previewModal.addEventListener('show.bs.modal', function(event) {
                const trigger = event.relatedTarget;
                if (!trigger) return;
                
                const src = trigger.getAttribute('data-img-src');
                const title = trigger.getAttribute('data-img-title');
                const name = trigger.getAttribute('data-img-name');
                const size = trigger.getAttribute('data-img-size');
                const url = trigger.getAttribute('data-img-url');

                document.getElementById('imagePreviewModalLabel').textContent = title || 'Pratinjau Foto';
                document.getElementById('modalImageFilename').textContent = (name ? name : '') + (size ? ' • ' + size : '');
                document.getElementById('modalPreviewImg').src = src || url;
                document.getElementById('modalDownloadBtn').href = url || src;
                document.getElementById('modalDownloadBtn').setAttribute('download', name || 'image.jpg');
            });
        }

        @if($response->location && $response->location->latitude && $response->location->longitude)
        const lat = {{ $response->location->latitude }};
        const lng = {{ $response->location->longitude }};
        const map = L.map('locationMap').setView([lat, lng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        L.marker([lat, lng]).addTo(map)
            .bindPopup("<b>{{ $response->location->instance_name }}</b><br>Lat: " + lat + ", Lng: " + lng)
            .openPopup();
        @endif
    });
</script>
@endsection
