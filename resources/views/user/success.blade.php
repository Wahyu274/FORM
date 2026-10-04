@extends('layouts.app')

@section('title', 'Data Berhasil Dikirim — Life Solution Connection')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100 py-4 py-md-5" style="background: radial-gradient(circle at top right, #1E3A8A 0%, #0F172A 85%);">
    <div class="container px-3" style="max-width: 640px;">
        <div class="card card-starkink border-0 shadow-lg" style="border-radius: 1.15rem; overflow: hidden;">
            <!-- Brand Header -->
            <div class="p-4 text-white" style="background: linear-gradient(135deg, #0B1329 0%, #1E3A8A 100%); border-bottom: 3px solid #10B981;">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div style="width: 44px; height: 44px; border-radius: 10px; background: #FFFFFF; display: flex; align-items: center; justify-content: center; padding: 4px; box-shadow: 0 4px 10px rgba(0,0,0,0.15); flex-shrink: 0;">
                        <img src="{{ asset('images/logo.png') }}" alt="Life Solution Connection Logo" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                    </div>
                    <div>
                        <div class="text-white fw-bold fs-5 lh-sm" style="letter-spacing: -0.3px;">Life Solution Connection</div>
                        <div class="text-uppercase fw-semibold" style="color: #7DD3FC; font-size: 0.72rem; letter-spacing: 0.8px;">Starlink Network Partner Kalimantan</div>
                    </div>
                </div>

                <div class="text-start mt-2">
                    <div class="d-inline-flex align-items-center gap-1.5 px-2.5 py-1 rounded-pill mb-2" style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3);">
                        <i class="fa-solid fa-circle-check text-success small me-1"></i>
                        <span style="color: #6EE7B7; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase;">Pengiriman Berhasil</span>
                    </div>
                    <h2 class="fw-bold text-white mb-1 fs-4">Data Inventaris Telah Tersimpan</h2>
                    <p class="text-white-50 mb-0 small" style="line-height: 1.5;">
                        Terima kasih. Laporan inventarisasi jaringan partner Starlink telah berhasil dicatat ke dalam database operasional.
                    </p>
                </div>
            </div>

            <div class="card-body p-3 p-md-4">
                <!-- Response Code Receipt Box -->
                <div class="text-center mb-4 p-3 rounded-3 bg-light border">
                    <small class="text-uppercase text-muted fw-bold d-block mb-1" style="font-size: 0.72rem; letter-spacing: 0.8px;">KODE RESPON INVENTARIS</small>
                    <div class="fs-2 fw-extrabold text-primary my-1" id="responseCodeText" style="letter-spacing: 1px;">{{ $response->response_code }}</div>
                    <button class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-semibold mt-1" onclick="copyResponseCode()">
                        <i class="fa-solid fa-copy me-1"></i> Salin Kode Respon
                    </button>
                </div>

                <h6 class="fw-bold text-dark mb-3 border-bottom pb-2">
                    <i class="fa-solid fa-file-lines me-2 text-primary"></i> Rincian Singkat Data
                </h6>

                <div class="row g-3 small mb-4">
                    <div class="col-12 col-sm-6">
                        <span class="text-muted d-block" style="font-size: 0.8rem;">Nama Instansi / Lokasi</span>
                        <strong class="text-dark">{{ $response->location_name }}</strong>
                    </div>
                    <div class="col-12 col-sm-6">
                        <span class="text-muted d-block" style="font-size: 0.8rem;">Kabupaten / Kota</span>
                        <strong class="text-dark">{{ $response->regency }}, {{ $response->province }}</strong>
                    </div>
                    <div class="col-12 col-sm-6">
                        <span class="text-muted d-block" style="font-size: 0.8rem;">PIC Pengisi</span>
                        <strong class="text-dark">{{ $response->pic_name }} ({{ $response->pic_phone }})</strong>
                    </div>
                    <div class="col-12 col-sm-6">
                        <span class="text-muted d-block" style="font-size: 0.8rem;">Waktu Pengisian</span>
                        <strong class="text-dark">{{ $response->submitted_at ? $response->submitted_at->format('d M Y, H:i') : now()->format('d M Y, H:i') }} WITA</strong>
                    </div>

                    <div class="col-4">
                        <div class="p-2 bg-light rounded-3 text-center border">
                            <small class="d-block text-muted" style="font-size: 0.75rem;">Perangkat</small>
                            <span class="fs-5 fw-bold text-dark">{{ $response->total_devices }}</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 bg-light rounded-3 text-center border">
                            <small class="d-block text-muted" style="font-size: 0.75rem;">Antena</small>
                            <span class="fs-5 fw-bold text-primary">{{ $response->total_antennas }}</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 bg-light rounded-3 text-center border">
                            <small class="d-block text-muted" style="font-size: 0.75rem;">Client</small>
                            <span class="fs-5 fw-bold text-success">{{ $response->total_clients }}</span>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <a href="{{ route('form.index') }}" class="btn btn-starkink-primary py-2.5 fw-bold rounded-pill shadow-sm">
                        <i class="fa-solid fa-plus me-1"></i> Isi Formulir Inventaris Baru
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function copyResponseCode() {
        const code = document.getElementById('responseCodeText').innerText;
        navigator.clipboard.writeText(code).then(() => {
            alert('Kode Respon ' + code + ' berhasil disalin ke clipboard!');
        });
    }
</script>
@endsection
