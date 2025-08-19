@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">Stock Opname System</h3>
            <a href="{{ route('stock-opname.create') }}" class="btn btn-primary">
                <i class="fas fa-upload me-2"></i>Upload Excel (.xlsx)
            </a>
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

        <!-- File Upload Section -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3">
                    <i class="fas fa-cloud-upload-alt me-2 text-primary"></i>
                    Upload File Excel
                </h5>
                <p class="text-muted mb-3">
                    Upload file Excel (.xlsx) untuk memulai proses stock opname.
                    Setelah upload, klik "Import Data" untuk memproses file.
                </p>
                <a href="{{ route('stock-opname.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Upload File Baru
                </a>
            </div>
        </div>

        <!-- Uploaded Files Section -->
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-folder-open me-2 text-success"></i>
                    File yang Sudah Diupload
                </h5>
            </div>
            <div class="card-body">
                @if ($uploadedFiles->count() > 0)
                    <div class="row g-4">
                        @foreach ($uploadedFiles as $file)
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100 file-card" style="cursor: pointer;"
                                    onclick="window.location.href='{{ route('stock-opname.show-data', $file->id) }}'">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="file-icon me-3">
                                                @if ($file->status === 'uploaded')
                                                    <i class="fas fa-file-excel fa-2x text-warning"></i>
                                                @elseif ($file->status === 'imported')
                                                    <i class="fas fa-check-circle fa-2x text-success"></i>
                                                @else
                                                    <i class="fas fa-file fa-2x text-secondary"></i>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="card-title mb-1 text-truncate"
                                                    title="{{ $file->original_name }}">
                                                    {{ $file->original_name }}
                                                </h6>
                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($file->created_at)->format('d/m/Y H:i') }}
                                                </small>
                                            </div>
                                        </div>

                                        <div class="file-info mb-3">
                                            <div class="row text-center">
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Ukuran</small>
                                                    <strong>{{ number_format($file->file_size / 1024, 1) }} KB</strong>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Status</small>
                                                    @if ($file->status === 'uploaded')
                                                        <span class="badge bg-warning">Menunggu Import</span>
                                                    @elseif ($file->status === 'imported')
                                                        <span class="badge bg-success">Sudah Diimport</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ ucfirst($file->status) }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="file-actions">
                                            @if ($file->status === 'uploaded')
                                                <button type="button" class="btn btn-success btn-sm w-100 mb-2"
                                                    onclick="event.stopPropagation(); importData({{ $file->id }}, '{{ $file->original_name }}')">
                                                    <i class="fas fa-download me-1"></i>
                                                    Import Data
                                                </button>
                                            @elseif ($file->status === 'imported')
                                                <button type="button" class="btn btn-primary btn-sm w-100 mb-2"
                                                    onclick="event.stopPropagation(); window.location.href='{{ route('stock-opname.show-data', $file->id) }}'">
                                                    <i class="fas fa-eye me-1"></i>
                                                    Lihat Data
                                                </button>
                                            @endif

                                            <!-- Delete Button -->
                                            <button type="button" class="btn btn-danger btn-sm w-100"
                                                onclick="event.stopPropagation(); deleteFile({{ $file->id }}, '{{ $file->original_name }}')">
                                                <i class="fas fa-trash me-1"></i>
                                                Hapus File
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-folder-open fa-3x text-muted"></i>
                        </div>
                        <h5 class="text-muted">Belum ada file yang diupload</h5>
                        <p class="text-muted">Upload file Excel untuk memulai stock opname</p>
                        <a href="{{ route('stock-opname.create') }}" class="btn btn-primary">
                            <i class="fas fa-upload me-2"></i>Upload File Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Info Panel -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card border-info">
                    <div class="card-body">
                        <h6 class="card-title text-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Cara Kerja Stock Opname
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <ol class="mb-0">
                                    <li><strong>Upload File:</strong> Pilih file Excel (.xlsx) dengan format yang sesuai
                                    </li>
                                    <li><strong>Import Data:</strong> Klik "Import Data" untuk memproses file</li>
                                    <li><strong>Input Stok Fisik:</strong> Masukkan stok fisik aktual via web</li>
                                    <li><strong>Lihat Hasil:</strong> Sistem akan menghitung selisih dan kategori</li>
                                </ol>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-unstyled mb-0">
                                    <li><span class="badge bg-warning me-2">📤</span> File Excel (.xlsx) max 10MB</li>
                                    <li><span class="badge bg-info me-2">📊</span> Data akan di-join dengan overmate</li>
                                    <li><span class="badge bg-success me-2">✅</span> Kalkulasi otomatis selisih & kategori
                                    </li>
                                    <li><span class="badge bg-primary me-2">📱</span> Input stok fisik via web interface
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Data Form -->
    <form id="importDataForm" method="GET" style="display: none;">
        @csrf
    </form>
@endsection

@push('scripts')
    <script>
        function importData(fileId, fileName) {
            if (confirm(`Import data dari file "${fileName}"?`)) {
                window.location.href = `/stock-opname/import-data/${fileId}`;
            }
        }

        function deleteFile(fileId, fileName) {
            if (confirm(
                    `Yakin ingin menghapus file "${fileName}"?\n\n⚠️ PERHATIAN: Semua data stock opname yang terkait dengan file ini akan dihapus permanen!`
                )) {
                // Buat form untuk delete
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/stock-opname/delete-file/${fileId}`;

                // Tambahkan CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';

                // Tambahkan method DELETE
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';

                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endpush

@push('styles')
    <style>
        .file-card {
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }

        .file-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border-color: #007bff;
        }

        .file-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: rgba(0, 123, 255, 0.1);
        }

        .file-info {
            border-top: 1px solid #e9ecef;
            padding-top: 15px;
        }

        .file-actions {
            border-top: 1px solid #e9ecef;
            padding-top: 15px;
        }

        .card-header {
            background: linear-gradient(135deg, #f8f9fc 0%, #e3e6f0 100%);
            border-bottom: 1px solid #e3e6f0;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.5em 0.75em;
        }
    </style>
@endpush
