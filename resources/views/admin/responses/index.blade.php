@extends('layouts.admin')

@section('page_title', 'Data Respon Inventaris')

@section('admin_content')
<!-- Filter & Action Header Card -->
<div class="card card-starkink border-0 shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('admin.responses.index') }}" method="GET" class="row g-3">
            <!-- Search -->
            <div class="col-md-3">
                <label class="form-label small fw-bold">Cari Data</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Kode / Lokasi / PIC..." value="{{ request('search') }}">
                </div>
            </div>

            <!-- Regency Filter -->
            <div class="col-md-2">
                <label class="form-label small fw-bold">Kabupaten / Kota</label>
                <select name="regency" class="form-select">
                    <option value="">Semua Kabupaten</option>
                    @foreach($regencies as $reg)
                        <option value="{{ $reg }}" {{ request('regency') == $reg ? 'selected' : '' }}>{{ $reg }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Province Filter -->
            <div class="col-md-2">
                <label class="form-label small fw-bold">Provinsi</label>
                <select name="province" class="form-select">
                    <option value="">Semua Provinsi</option>
                    @foreach($provinces as $prov)
                        <option value="{{ $prov }}" {{ request('province') == $prov ? 'selected' : '' }}>{{ $prov }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Date From -->
            <div class="col-md-2">
                <label class="form-label small fw-bold">Dari Tanggal</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>

            <!-- Date To -->
            <div class="col-md-2">
                <label class="form-label small fw-bold">Sampai Tanggal</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>

            <!-- Submit Filter Button -->
            <div class="col-md-1 d-flex align-items-end">
                <button type="submit" class="btn btn-starkink-primary w-100 fw-bold" title="Terapkan Filter">
                    <i class="fa-solid fa-filter"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Responses Data Table Card -->
<div class="card card-starkink border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex flex-wrap align-items-center justify-content-between gap-2 border-bottom">
        <h6 class="fw-bold mb-0 text-dark">
            <i class="fa-solid fa-table text-primary me-2"></i> Daftar Respon Inventaris Jaringan ({{ $responses->total() }})
        </h6>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.export.excel', request()->all()) }}" class="btn btn-sm btn-outline-success rounded-pill fw-semibold">
                <i class="fa-solid fa-file-excel me-1"></i> Excel
            </a>
            <a href="{{ route('admin.export.csv', request()->all()) }}" class="btn btn-sm btn-outline-info rounded-pill fw-semibold">
                <i class="fa-solid fa-file-csv me-1"></i> CSV
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 4%;">No</th>
                    <th style="width: 14%;">Kode Respon</th>
                    <th style="width: 22%;">Nama Instansi / Lokasi</th>
                    <th style="width: 14%;">Kabupaten / Kota</th>
                    <th style="width: 14%;">PIC Pengisi</th>
                    <th style="width: 7%;" class="text-center">Perangkat</th>
                    <th style="width: 7%;" class="text-center">Antena</th>
                    <th style="width: 7%;" class="text-center">Client</th>
                    <th style="width: 10%;">Tanggal</th>
                    <th style="width: 10%;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($responses as $index => $res)
                    <tr>
                        <td class="text-muted fw-bold">{{ $responses->firstItem() + $index }}</td>
                        <td>
                            <span class="badge bg-dark-subtle text-dark border px-2 py-1 font-monospace fw-bold">
                                {{ $res->response_code }}
                            </span>
                        </td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $res->location_name }}</div>
                            <small class="text-muted text-truncate d-block" style="max-width: 240px;">{{ $res->location->address ?? '-' }}</small>
                        </td>
                        <td>
                            <span class="badge bg-secondary-subtle text-secondary px-2 py-1">
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
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-sm btn-light border rounded-circle" type="button" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.responses.show', $res->id) }}">
                                            <i class="fa-solid fa-eye me-2 text-primary"></i> Detail Respon
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.responses.pdf', $res->id) }}" target="_blank">
                                            <i class="fa-solid fa-print me-2 text-secondary"></i> Print / PDF
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('admin.responses.destroy', $res->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus respon {{ $res->response_code }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fa-solid fa-trash me-2"></i> Hapus Respon
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-inbox fs-2 d-block mb-2 text-secondary"></i>
                            Tidak ada data respon inventaris yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($responses->hasPages())
        <div class="card-footer bg-white py-3 border-top">
            {{ $responses->links() }}
        </div>
    @endif
</div>
@endsection
