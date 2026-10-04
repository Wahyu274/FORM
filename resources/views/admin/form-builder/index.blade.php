@extends('layouts.admin')

@section('page_title', 'Kelola Form Inventaris')

@section('admin_content')
<div class="row g-4">
    <!-- Left Column: Form Global Settings Card -->
    <div class="col-lg-4">
        <div class="card card-starkink border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-gear me-2 text-primary"></i> Pengaturan Form</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.form-builder.settings.update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Judul Form Utama</label>
                        <input type="text" name="title" class="form-control" value="{{ $form->title }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Prefix Kode Respon</label>
                        <input type="text" name="code_prefix" class="form-control font-monospace fw-bold" value="{{ $form->code_prefix }}" required>
                        <small class="text-muted">Format: <code>INV-KAL-2026-XXXXX</code></small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Maksimal Client per Antena</label>
                        <div class="input-group">
                            <input type="number" name="max_clients_per_antenna" class="form-control fw-bold" value="{{ $form->max_clients_per_antenna }}" min="1" max="500" required>
                            <span class="input-group-text bg-light">Client</span>
                        </div>
                        <small class="text-muted">Standard default: 25 client per antenna.</small>
                    </div>

                    <button type="submit" class="btn btn-starkink-primary w-100 fw-bold">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Pengaturan
                    </button>
                </form>
            </div>
        </div>

        <div class="card card-starkink border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-circle-info me-2 text-info"></i> Petunjuk Kelola Form</h6>
            </div>
            <div class="card-body small text-muted">
                <p>Admin dapat menambah, mengubah label, mengatur status aktif, dan mengedit pilihan dropdown pertanyaan tanpa perlu mengubah kode program.</p>
                <ul class="ps-3 mb-0">
                    <li>Gunakan <strong>Status Aktif/Nonaktif</strong> untuk menyembunyikan pertanyaan sementara.</li>
                    <li>Ubah <strong>Pilihan Dropdown</strong> dengan menulis 1 baris per pilihan.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Right Column: Fields Table Card -->
    <div class="col-lg-8">
        <div class="card card-starkink border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-bottom">
                <h6 class="fw-bold mb-0 text-dark">
                    <i class="fa-solid fa-list-check text-primary me-2"></i> Daftar Pertanyaan / Field Form
                </h6>
                <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#addFieldModal">
                    <i class="fa-solid fa-plus me-1"></i> Tambah Field
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 25%;">Nama Field / Label</th>
                            <th style="width: 15%;">Bagian Section</th>
                            <th style="width: 15%;">Tipe Input</th>
                            <th style="width: 10%;" class="text-center">Wajib</th>
                            <th style="width: 12%;" class="text-center">Status</th>
                            <th style="width: 18%;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fields as $index => $field)
                            <tr>
                                <td class="fw-bold text-muted">{{ $index + 1 }}</td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $field->label }}</div>
                                    <small class="text-muted font-monospace">key: {{ $field->name }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $field->section->title ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1">
                                        {{ strtoupper($field->type) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($field->is_required)
                                        <span class="badge bg-danger-subtle text-danger fw-bold"><i class="fa-solid fa-check me-1"></i> Ya</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">Tidak</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.form-builder.field.toggle', $field->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @if($field->is_active)
                                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-2.5 py-0.5 fw-bold" style="font-size:0.75rem;">
                                                <i class="fa-solid fa-circle-check me-1"></i> Aktif
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 py-0.5" style="font-size:0.75rem;">
                                                Nonaktif
                                            </button>
                                        @endif
                                    </form>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle me-1" data-bs-toggle="modal" data-bs-target="#editFieldModal{{ $field->id }}" title="Edit Field">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>

                                    <form action="{{ route('admin.form-builder.field.destroy', $field->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus field {{ $field->label }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Hapus Field">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Edit Modal for each Field -->
                            <div class="modal fade" id="editFieldModal{{ $field->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.form-builder.field.update', $field->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold">Edit Field: {{ $field->label }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Nama / Label Pertanyaan <span class="required-star">*</span></label>
                                                    <input type="text" name="label" class="form-control" value="{{ $field->label }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Bagian Section <span class="required-star">*</span></label>
                                                    <select name="section_id" class="form-select" required>
                                                        @foreach($sections as $sec)
                                                            <option value="{{ $sec->id }}" {{ $field->section_id == $sec->id ? 'selected' : '' }}>{{ $sec->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Tipe Input <span class="required-star">*</span></label>
                                                    <select name="type" class="form-select" required>
                                                        <option value="text" {{ $field->type == 'text' ? 'selected' : '' }}>Text (1 Baris)</option>
                                                        <option value="textarea" {{ $field->type == 'textarea' ? 'selected' : '' }}>Textarea (Multi Baris)</option>
                                                        <option value="number" {{ $field->type == 'number' ? 'selected' : '' }}>Number (Angka)</option>
                                                        <option value="dropdown" {{ $field->type == 'dropdown' ? 'selected' : '' }}>Dropdown</option>
                                                        <option value="radio" {{ $field->type == 'radio' ? 'selected' : '' }}>Radio Button</option>
                                                        <option value="checkbox" {{ $field->type == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                                                        <option value="image" {{ $field->type == 'image' ? 'selected' : '' }}>Upload Foto</option>
                                                        <option value="file" {{ $field->type == 'file' ? 'selected' : '' }}>Upload File / PDF</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Pilihan Options (Khusus Dropdown/Radio)</label>
                                                    <textarea name="options" class="form-control font-monospace" rows="4" placeholder="Tulis 1 pilihan per baris...">{{ $field->optionItems->pluck('label')->join("\n") }}</textarea>
                                                    <small class="text-muted">Tuliskan satu pilihan per baris.</small>
                                                </div>

                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="is_required" value="1" id="reqEdit{{ $field->id }}" {{ $field->is_required ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-semibold" for="reqEdit{{ $field->id }}">Field Wajib Diisi (*)</label>
                                                </div>

                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="actEdit{{ $field->id }}" {{ $field->is_active ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-semibold" for="actEdit{{ $field->id }}">Status Aktif</label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary fw-bold">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Belum ada field khusus yang dibuat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add New Field -->
<div class="modal fade" id="addFieldModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.form-builder.field.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="fa-solid fa-plus-circle text-primary me-2"></i> Tambah Field Pertanyaan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama / Label Pertanyaan <span class="required-star">*</span></label>
                        <input type="text" name="label" class="form-control" placeholder="Contoh: Kondisi Sinyal Starlink" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bagian Section <span class="required-star">*</span></label>
                        <select name="section_id" class="form-select" required>
                            @foreach($sections as $sec)
                                <option value="{{ $sec->id }}">{{ $sec->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tipe Input <span class="required-star">*</span></label>
                        <select name="type" class="form-select" required>
                            <option value="text">Text (1 Baris)</option>
                            <option value="textarea">Textarea (Multi Baris)</option>
                            <option value="number">Number (Angka)</option>
                            <option value="dropdown">Dropdown</option>
                            <option value="radio">Radio Button</option>
                            <option value="checkbox">Checkbox</option>
                            <option value="image">Upload Foto</option>
                            <option value="file">Upload File / PDF</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pilihan Options (Jika Dropdown/Radio)</label>
                        <textarea name="options" class="form-control font-monospace" rows="3" placeholder="Pilihan 1&#10;Pilihan 2&#10;Pilihan 3"></textarea>
                        <small class="text-muted">Tulis 1 opsi pilihan per baris baru.</small>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="is_required" value="1" id="addIsRequired">
                        <label class="form-check-label fw-semibold" for="addIsRequired">Wajib Diisi (*)</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-starkink-primary fw-bold">Tambah Pertanyaan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
