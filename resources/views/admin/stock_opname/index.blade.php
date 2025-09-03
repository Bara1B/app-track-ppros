@extends('layouts.app')

@push('styles')
<style>
        .so-card {
            border: 1px solid #edf2f7;
            border-radius: 12px;
        }

        .so-card .card-body {
            padding: 1.25rem 1.25rem;
        }

        .so-section-title {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: .75rem;
        }

        .so-file {
            border: 1px solid #eef2f6;
            border-radius: 10px;
        }

        .so-file+.so-file {
            margin-top: .5rem;
        }

        .so-file .name {
            font-weight: 600
        }

        .so-file .meta {
            color: #6b7280;
            font-size: .85rem
        }

        .so-badge {
            padding: .25rem .5rem;
            border-radius: .5rem;
            font-size: .75rem;
            font-weight: 600;
        }

        .so-badge-uploaded {
            background: #fff7ed;
            color: #b45309;
            border: 1px solid #fde68a
        }

        .so-badge-imported {
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0
        }

        .so-actions .btn {
            padding: .3rem .6rem;
            font-size: .8rem;
        }

        .so-note {
            background: #f1f9ff;
            border: 1px solid #e1f0ff;
            border-radius: 10px
        }

        .so-heading {
            font-weight: 800;
            font-size: 1.6rem;
        }

        @media (max-width: 991.98px) {
            .so-actions {
                width: 100%;
                justify-content: flex-start !important;
            }
        }
</style>
@endpush

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="so-heading mb-0">Stock Opname System</h3>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-3 align-items-start">
            <div class="col-lg-5" id="upload-section">
                <div class="card so-card shadow-sm">
                    <div class="card-body">
                        <div class="so-section-title">Upload File Excel</div>
                        <p class="text-muted mb-3">Upload file Excel (.xlsx) untuk memulai proses stock opname. Setelah
                            upload, klik "Import Data" untuk memproses file.</p>
                        @if (Route::has('admin.stock-opname.download-template'))
                            <a href="{{ route('admin.stock-opname.download-template') }}"
                                class="btn btn-sm btn-outline-secondary mb-3 shadow-sm">
                                <i class="fas fa-download me-1"></i> Download Template
                            </a>
                        @endif
                        <form action="{{ route('admin.stock-opname.import') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="file" class="form-label">Pilih File Excel</label>
                                <input type="file" class="form-control @error('file') is-invalid @enderror"
                                    id="file" name="file" accept=".xlsx,.xls" required>
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">File terpilih: <span id="chosen-file-name" class="fw-semibold">Belum
                                        ada</span></div>
                            </div>

                            <div class="mb-3">
                                <div class="small fw-bold mb-1">Format Header Excel yang diharapkan:</div>
                                <div class="small text-muted">No, Location System, Location Actual, Item Number,
                                    Description, UM, Lot/Serial, Reference, Quantity On Hand, Expire Date, Stock Fisik,
                                    Selisih, Overmate, Masuk</div>
                            </div>

                            <div class="so-note py-3 px-3 mb-3">
                                <div class="fw-bold mb-2">Catatan Penting:</div>
                                <ul class="mb-0 small">
                                    <li>Upload file akan mengganti semua data stock opname yang ada.</li>
                                    <li>Pastikan format header sesuai dengan yang diperlukan.</li>
                                    <li>Maksimal ukuran file: 10MB.</li>
                                    <li>Data akan di-join dengan data overmate berdasarkan item_number.</li>
                                    <li>Kolom "Stock Fisik": kosongkan untuk input manual via web.</li>
                                    <li>Kolom "Selisih", "Overmate", "Masuk": akan diisi otomatis oleh sistem.</li>
                                </ul>
                            </div>
                            <button type="submit" class="btn btn-primary shadow-sm">
                                <i class="fas fa-upload me-1"></i> Upload
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card so-card shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold text-primary mb-2">Cara Kerja Stock Opname</h6>
                        <div class="row small g-3 align-items-start">
                            <div class="col-md-6">
                                <ul class="mb-0">
                                    <li><strong>Upload File:</strong> Pilih file Excel (.xlsx) dengan format yang sesuai
                                    </li>
                                    <li><strong>Import Data:</strong> Klik "Import Data" untuk memproses file</li>
                                    <li><strong>Input Stok Fisik:</strong> Masukkan stok fisik aktual via web</li>
                                    <li><strong>Lihat Hasil:</strong> Sistem akan menghitung selisih dan kategori</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                @php
                                    $countUploaded = $uploadedFiles->where('status', 'uploaded')->count();
                                    $countImported = $uploadedFiles->where('status', 'imported')->count();
                                    $lastImportedAt = optional(
                                        $uploadedFiles->where('status', 'imported')->sortByDesc('created_at')->first(),
                                    )->created_at;
                                @endphp
                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="so-note p-2 text-center">
                                            <div class="fw-bold mb-0">Uploaded</div>
                                            <div class="fs-6">{{ $countUploaded }}</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="so-note p-2 text-center">
                                            <div class="fw-bold mb-0">Imported</div>
                                            <div class="fs-6">{{ $countImported }}</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="so-note p-2 d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="fw-bold">Terakhir Import</div>
                                                <div class="text-muted">
                                                    {{ $lastImportedAt ? $lastImportedAt->format('d/m/Y H:i') : '—' }}</div>
                                            </div>
                                            @if (Route::has('admin.stock-opname.download-template'))
                                                <a href="{{ route('admin.stock-opname.download-template') }}"
                                                    class="btn btn-sm btn-outline-secondary shadow-sm">
                                                    <i class="fas fa-download me-1"></i> Template
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card so-card mt-3 shadow-sm">
                    <div class="card-body">
                        <div class="so-section-title d-flex align-items-center mb-3">
                            <i class="fas fa-folder-open me-2 text-success"></i> Daftar File Stock Opname
                        </div>
                        <div>
                            @if ($uploadedFiles->count() > 0)
                                <div class="vstack">
                                    @foreach ($uploadedFiles as $file)
                                        <div class="so-file bg-white px-3 py-2">
                                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                                <div class="file-icon"
                                                    style="width:34px;height:34px;display:flex;align-items:center;justify-content:center;">
                                                    @if ($file->status === 'uploaded')
                                                        <i class="fas fa-file-excel fa-lg text-warning"></i>
                                                    @elseif ($file->status === 'imported')
                                                        <i class="fas fa-check-circle fa-lg text-success"></i>
                                                    @else
                                                        <i class="fas fa-file fa-lg text-secondary"></i>
                                                    @endif
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="name d-flex align-items-center gap-2">
                                                        {{ $file->original_name }}
                                                        @if ($file->status === 'uploaded')
                                                            <span class="so-badge so-badge-uploaded">Diunggah</span>
                                                        @elseif ($file->status === 'imported')
                                                            <span class="so-badge so-badge-imported">Sudah Diimport</span>
                                                        @endif
                                                    </div>
                                                    <div class="meta">
                                                        {{ $file->created_at->format('d/m/Y H:i') }} • Ukuran
                                                        {{ number_format($file->file_size / 1024, 1) }} KB
                                                    </div>
                                                </div>
                                                <div class="ms-auto d-flex align-items-center gap-2 flex-wrap so-actions">
                                                    @if ($file->status === 'uploaded')
                                                        <form
                                                            action="{{ route('admin.stock-opname.import-data', $file->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Import data dari file ini?');">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-warning shadow-sm">
                                                                <i class="fas fa-database me-1"></i> Import Data
                                                            </button>
                                                        </form>
                                                        <form
                                                            action="{{ route('admin.stock-opname.delete-file', $file->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Hapus file ini beserta datanya?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-sm btn-outline-danger shadow-sm">
                                                                <i class="fas fa-trash me-1"></i> Hapus
                                                            </button>
                                                        </form>
                                                    @elseif ($file->status === 'imported')
                                                        <a href="{{ route('admin.stock-opname.show-data', $file->id) }}"
                                                            class="btn btn-sm btn-primary shadow-sm">
                                                            <i class="fas fa-eye me-1"></i> Lihat Data
                                                        </a>
                                                        <a href="{{ route('admin.stock-opname.export-data', $file->id) }}"
                                                            class="btn btn-sm btn-success shadow-sm">
                                                            <i class="fas fa-file-excel me-1"></i> Export Excel
                                                        </a>
                                                        <form
                                                            action="{{ route('admin.stock-opname.delete-file', $file->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Hapus file ini beserta datanya?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-sm btn-outline-danger shadow-sm">
                                                                <i class="fas fa-trash me-1"></i> Hapus
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-muted text-center py-4">Belum ada file yang diupload.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
        (function() {
        const input = document.getElementById('file');
        const chosen = document.getElementById('chosen-file-name');
        if (!input) return;
            input.addEventListener('change', function() {
            const file = this.files && this.files[0];
                if (!file) {
                    if (chosen) chosen.textContent = 'Belum ada';
                    return;
                }
            const name = file.name.toLowerCase();
            const validExt = name.endsWith('.xlsx') || name.endsWith('.xls');
            const maxSize = 10 * 1024 * 1024; // 10MB
            if (!validExt) {
                alert('Hanya file Excel (.xlsx atau .xls) yang diperbolehkan.');
                this.value = '';
                if (chosen) chosen.textContent = 'Belum ada';
                return;
            }
            if (file.size > maxSize) {
                alert('Ukuran file melebihi 10MB.');
                this.value = '';
                if (chosen) chosen.textContent = 'Belum ada';
                return;
            }
            if (chosen) chosen.textContent = file.name;
        });
    })();
</script>
@endpush
