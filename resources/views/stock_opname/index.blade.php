@extends('layouts.app')

@push('styles')
    @vite('resources/css/pages/stock-opname-index.css')
@endpush

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
                    <div class="row g-3">
                        @foreach ($uploadedFiles as $file)
                            <div class="col-12">
                                <div class="card file-card" style="cursor: pointer;"
                                     onclick="window.location.href='{{ route('stock-opname.show-data', $file->id) }}'">
                                    <div class="card-body d-flex align-items-center gap-3 flex-wrap">
                                        <div class="file-icon">
                                            @if ($file->status === 'uploaded')
                                                <i class="fas fa-file-excel fa-lg text-warning"></i>
                                            @elseif ($file->status === 'imported')
                                                <i class="fas fa-check-circle fa-lg text-success"></i>
                                            @else
                                                <i class="fas fa-file fa-lg text-secondary"></i>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1 min-w-0">
                                            <div class="d-flex align-items-center flex-wrap gap-2">
                                                <h6 class="mb-0 text-truncate" style="max-width: 380px;"
                                                    title="{{ $file->original_name }}">{{ $file->original_name }}</h6>
                                                @if ($file->status === 'uploaded')
                                                    <span class="badge bg-warning">Menunggu Import</span>
                                                @elseif ($file->status === 'imported')
                                                    <span class="badge bg-success">Sudah Diimport</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ ucfirst($file->status) }}</span>
                                                @endif
                                            </div>
                                            <div class="text-muted small mt-1">
                                                {{ \Carbon\Carbon::parse($file->created_at)->format('d/m/Y H:i') }}
                                                <span class="mx-2">•</span>
                                                Ukuran {{ number_format($file->file_size / 1024, 1) }} KB
                                            </div>
                                        </div>
                                        <div class="d-flex ms-auto gap-2 flex-wrap">
                                            @if ($file->status === 'uploaded')
                                                <button type="button" class="btn btn-success btn-sm"
                                                    onclick="event.stopPropagation(); importData({{ $file->id }}, '{{ $file->original_name }}')">
                                                    <i class="fas fa-download me-1"></i> Import Data
                                                </button>
                                            @elseif ($file->status === 'imported')
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="event.stopPropagation(); window.location.href='{{ route('stock-opname.show-data', $file->id) }}'">
                                                    <i class="fas fa-eye me-1"></i> Lihat Data
                                                </button>
                                            @endif
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="event.stopPropagation(); deleteFile({{ $file->id }}, '{{ $file->original_name }}')">
                                                <i class="fas fa-trash me-1"></i> Hapus File
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

 
