<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Inventaris Jaringan — {{ $response->response_code }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #333333;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }

        .header-table {
            width: 100%;
            border-bottom: 3px solid #0F172A;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .company-title {
            font-size: 20px;
            font-weight: bold;
            color: #0F172A;
        }

        .company-subtitle {
            font-size: 11px;
            color: #1E40AF;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .doc-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #0F172A;
        }

        .code-box {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            background-color: #F1F5F9;
            padding: 6px;
            border: 1px solid #CBD5E1;
            margin-bottom: 20px;
        }

        .section-header {
            font-size: 13px;
            font-weight: bold;
            background-color: #0F172A;
            color: #FFFFFF;
            padding: 6px 10px;
            margin-top: 15px;
            margin-bottom: 8px;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        table.data-table th, table.data-table td {
            border: 1px solid #CBD5E1;
            padding: 6px 8px;
            text-align: left;
        }

        table.data-table th {
            background-color: #F8FAFC;
            font-size: 11px;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: bold; }

        .signature-table {
            width: 100%;
            margin-top: 40px;
        }

        .signature-box {
            text-align: center;
            width: 45%;
        }

        .signature-space {
            height: 60px;
        }

        .photo-grid {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            margin-bottom: 15px;
        }

        .photo-card {
            border: 1px solid #CBD5E1;
            padding: 8px;
            text-align: center;
            background-color: #FAFAFA;
            vertical-align: top;
            page-break-inside: avoid;
        }

        .photo-card img {
            max-width: 100%;
            max-height: 180px;
            height: auto;
            object-fit: contain;
            display: block;
            margin: 0 auto 6px auto;
            border: 1px solid #E2E8F0;
            border-radius: 4px;
        }

        .photo-caption {
            font-size: 10px;
            font-weight: bold;
            color: #1E293B;
            margin-top: 4px;
        }

        .photo-filename {
            font-size: 9px;
            color: #64748B;
        }

        @media print {
            body { padding: 0; }
            .no-print { display: none; }
            .section-header { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            table.data-table th { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 15px; text-align: right;">
        <button onclick="window.print()" style="padding: 8px 16px; background-color: #1E40AF; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
            Cetak / Download PDF
        </button>
    </div>

    <!-- Header Letterhead -->
    <table class="header-table">
        <tr>
            <td style="width: 65px; vertical-align: middle;">
                <img src="{{ asset('images/logo.png') }}" style="height: 52px; width: 52px; object-fit: contain; display: block;">
            </td>
            <td style="vertical-align: middle; padding-left: 10px;">
                <div class="company-title">STARLINK</div>
                <div class="company-subtitle">LIFE SOLUTION CONNECTION — WILAYAH KALIMANTAN</div>
            </td>
            <td class="text-right" style="vertical-align: middle;">
                <div style="font-size: 11px; color: #64748B;">DOKUMEN INVENTARIS INFRASTRUKTUR</div>
                <div style="font-size: 11px; font-weight: bold;">TANGGAL: {{ $response->submitted_at ? $response->submitted_at->format('d/m/Y') : date('d/m/Y') }}</div>
            </td>
        </tr>
    </table>

    <div class="doc-title">FORM INVENTARIS JARINGAN PARTNER KALIMANTAN</div>
    <div class="code-box">KODE RESPON: {{ $response->response_code }}</div>

    <!-- 1. INFORMASI LOKASI -->
    <div class="section-header">1. INFORMASI LOKASI & PENANGGUNG JAWAB</div>
    <table class="data-table">
        <tr>
            <th style="width: 25%;">Nama Instansi / Lokasi</th>
            <td>{{ $response->location->instance_name ?? $response->location_name }}</td>
            <th style="width: 20%;">Kabupaten / Kota</th>
            <td>{{ $response->regency }}</td>
        </tr>
        <tr>
            <th>Alamat Lengkap</th>
            <td>{{ $response->location->address ?? '-' }}</td>
            <th>Provinsi</th>
            <td>{{ $response->province }}</td>
        </tr>
        <tr>
            <th>PIC Pengisi</th>
            <td>{{ $response->location->pic_name ?? $response->pic_name }} ({{ $response->location->pic_position ?? '-' }})</td>
            <th>No. HP / WhatsApp</th>
            <td>{{ $response->location->pic_phone ?? $response->pic_phone }}</td>
        </tr>
    </table>

    <!-- 2. JARAK & AKSES -->
    <div class="section-header">2. JARAK DAN AKSES LOKASI</div>
    <table class="data-table">
        <tr>
            <th style="width: 25%;">Jarak Referensi</th>
            <td>{{ $response->location->distance_km ?? 0 }} km</td>
            <th style="width: 20%;">Akses Menuju Lokasi</th>
            <td>{{ $response->location->access_mode ?? '-' }}</td>
        </tr>
        <tr>
            <th>Kondisi Jalan</th>
            <td>{{ $response->location->road_condition ?? '-' }}</td>
            <th>Kendaraan</th>
            <td>{{ $response->location->vehicle_type ?? '-' }}</td>
        </tr>
        <tr>
            <th>Koordinat GPS</th>
            <td colspan="3">Latitude: {{ $response->location->latitude ?? '-' }}, Longitude: {{ $response->location->longitude ?? '-' }}</td>
        </tr>
    </table>

    <!-- 3. TOPOLOGI JARINGAN -->
    <div class="section-header">3. TOPOLOGI JARINGAN</div>
    <table class="data-table">
        <tr>
            <th style="width: 25%;">Jenis Topologi</th>
            <td>{{ $response->topology->topology_type ?? 'Star' }}</td>
        </tr>
        <tr>
            <th>Penjelasan Topologi</th>
            <td>{{ $response->topology->description ?? '-' }}</td>
        </tr>
    </table>

    <!-- 4. PERANGKAT JARINGAN -->
    <div class="section-header">4. DAFTAR PERANGKAT JARINGAN (TOTAL: {{ $response->total_devices }} UNIT)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;" class="text-center">No</th>
                <th style="width: 25%;">Jenis Perangkat</th>
                <th style="width: 20%;">Merk / Brand</th>
                <th style="width: 20%;">Tipe / Model</th>
                <th style="width: 10%;" class="text-center">Jumlah</th>
                <th style="width: 20%;">Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($response->devices as $idx => $dev)
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td class="fw-bold">{{ $dev->device_type }}</td>
                    <td>{{ $dev->brand ?? '-' }}</td>
                    <td>{{ $dev->model ?? '-' }}</td>
                    <td class="text-center fw-bold">{{ $dev->quantity }}</td>
                    <td>{{ $dev->condition ?? 'Baik' }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Tidak ada perangkat.</td></tr>
            @endforelse
        </tbody>
    </table>

    <!-- 5. ANTENA & CLIENT -->
    <div class="section-header">5. DAFTAR ANTENA & CLIENT (TOTAL: {{ $response->total_antennas }} ANTENA, {{ $response->total_clients }} CLIENT)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;" class="text-center">No</th>
                <th style="width: 25%;">ID / Nama Antena</th>
                <th style="width: 25%;">Merk / Tipe</th>
                <th style="width: 25%;">Lokasi Pemasangan</th>
                <th style="width: 20%;" class="text-center">Jumlah Client</th>
            </tr>
        </thead>
        <tbody>
            @forelse($response->antennas as $idx => $ant)
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td class="fw-bold">{{ $ant->antenna_code }}</td>
                    <td>{{ $ant->brand_model ?? '-' }}</td>
                    <td>{{ $ant->install_location ?? '-' }}</td>
                    <td class="text-center fw-bold">{{ $ant->client_count }} Client</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Tidak ada antena.</td></tr>
            @endforelse
        </tbody>
    </table>

    <!-- 6. CATATAN & KEBUTUHAN KHUSUS -->
    <div class="section-header">6. CATATAN TAMBAHAN & KEBUTUHAN LAPANGAN</div>
    <table class="data-table">
        <tr>
            <th style="width: 25%;">Kondisi Sinyal & Internet</th>
            <td>{{ $response->values->where('field_name', 'signal_condition')->first()->value ?? 'Baik' }}</td>
            <th style="width: 20%;">Kondisi Listrik / Power</th>
            <td>{{ $response->values->where('field_name', 'power_condition')->first()->value ?? '-' }}</td>
        </tr>
        <tr>
            <th>Kondisi Tower / Tiang</th>
            <td>{{ $response->values->where('field_name', 'tower_condition')->first()->value ?? '-' }}</td>
            <th>Catatan Teknis Perangkat</th>
            <td>{{ $response->values->where('field_name', 'required_hardware')->first()->value ?? 'Tidak ada catatan khusus.' }}</td>
        </tr>
    </table>

    <!-- 7. DOKUMENTASI FOTO & INSTALASI -->
    <div class="section-header">7. DOKUMENTASI FOTO & INSTALASI (TOTAL: {{ $response->uploads ? $response->uploads->count() : 0 }} BERKAS)</div>
    @if($response->uploads && $response->uploads->count() > 0)
        <table class="photo-grid">
            <tr>
            @php $pCol = 0; @endphp
            @foreach($response->uploads as $upload)
                @if($pCol > 0 && $pCol % 2 == 0)
                    </tr><tr>
                @endif
                <td class="photo-card" style="width: 50%;">
                    @if($upload->isImage())
                        @php
                            $imgSrc = $upload->base64_src ?: $upload->url;
                        @endphp
                        <img src="{{ $imgSrc }}" alt="{{ $upload->original_name }}">
                    @else
                        <div style="padding: 30px 10px; background: #F1F5F9; border: 1px dashed #CBD5E1; color: #475569; font-weight: bold; font-size: 11px;">
                            [FILE DOKUMEN] {{ $upload->original_name }}
                        </div>
                    @endif
                    <div class="photo-caption">{{ ucwords(str_replace('_', ' ', $upload->field_name)) }}</div>
                    <div class="photo-filename">{{ $upload->original_name }} ({{ $upload->formatted_size }})</div>
                </td>
                @php $pCol++; @endphp
            @endforeach
            @if($pCol % 2 != 0)
                <td style="width: 50%; border: none;"></td>
            @endif
            </tr>
        </table>
    @else
        <p style="font-size: 11px; color: #64748B; font-style: italic; padding: 6px 0;">Tidak ada foto dokumentasi yang diunggah.</p>
    @endif

    <!-- TANDA TANGAN -->
    <table class="signature-table">
        <tr>
            <td class="signature-box">
                <div>Pengisi / PIC Partner:</div>
                <div class="signature-space"></div>
                <div class="fw-bold">({{ $response->location->pic_name ?? $response->pic_name }})</div>
                <div style="font-size: 10px; color: #64748B;">Tanggal: {{ date('d/m/Y') }}</div>
            </td>
            <td style="width: 10%;"></td>
            <td class="signature-box">
                <div>Tim verifikasi STARLINK:</div>
                <div class="signature-space"></div>
                <div class="fw-bold">( Network Engineer STARLINK )</div>
                <div style="font-size: 10px; color: #64748B;">Life Solution Connection</div>
            </td>
        </tr>
    </table>

</body>
</html>
