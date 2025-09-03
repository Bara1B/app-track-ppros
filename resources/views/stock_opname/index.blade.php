@extends('layouts.app')

@push('styles')
    @vite('resources/css/pages/stock-opname-index.css')
@endpush

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0">Stock Opname Data</h3>
            <div class="d-flex align-items-center gap-3">
                @if (Auth::user() && Auth::user()->role === 'admin')
                    <a href="{{ route('admin.stock-opname.index') }}" class="btn btn-primary">
                        <i class="fas fa-upload me-2"></i>Upload/Import Data
                    </a>
                @endif
                <div class="text-muted">
                    <i class="fas fa-info-circle me-2"></i>
                    @if (Auth::user() && Auth::user()->role === 'admin')
                        Admin dapat mengupload, import, dan mengedit stok fisik.
                    @else
                        Hanya untuk melihat data yang sudah diimport
                    @endif
                </div>
            </div>
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

        <!-- Info Section -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3">
                    <i class="fas fa-info-circle me-2 text-info"></i>
                    Informasi Stock Opname
                </h5>
                <p class="text-muted mb-3">
                    Halaman ini menampilkan data stock opname yang sudah diimport oleh admin.
                    Anda dapat melihat dan export data yang tersedia.
                </p>
                <div class="alert alert-info mb-0">
                    <i class="fas fa-lock me-2"></i>
                    <strong>Note:</strong> Fitur upload dan edit hanya tersedia untuk admin.
                </div>
            </div>
        </div>

        <!-- Uploaded Files Section -->
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-folder-open me-2 text-success"></i>
                    Data Stock Opname yang Tersedia
                </h5>
            </div>
            <div class="card-body">
                @if ($uploadedFiles->count() > 0)
                    <div class="row g-3">
                        @foreach ($uploadedFiles as $file)
                            <div class="col-12">
                                <div class="card file-card" style="cursor: pointer;"
                                    onclick="window.location.href='{{ (Auth::user() && Auth::user()->role === 'admin') ? route('admin.stock-opname.show-data', $file->id) : route('stock-opname.show-data', $file->id) }}'">
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
                                                @if ($file->status === 'imported')
                                                    <span class="mx-2">•</span>
                                                    Import:
                                                    {{ \Carbon\Carbon::parse($file->imported_at)->format('d/m/Y H:i') }}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="d-flex ms-auto gap-2 flex-wrap">
                                            @if ($file->status === 'imported')
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="event.stopPropagation(); window.location.href='{{ (Auth::user() && Auth::user()->role === 'admin') ? route('admin.stock-opname.show-data', $file->id) : route('stock-opname.show-data', $file->id) }}'">
                                                    <i class="fas fa-eye me-1"></i> Lihat Data
                                                </button>
                                                <button type="button" class="btn btn-success btn-sm"
                                                    onclick="event.stopPropagation(); window.location.href='{{ (Auth::user() && Auth::user()->role === 'admin') ? route('admin.stock-opname.export-data', $file->id) : route('stock-opname.export-data', $file->id) }}'">
                                                    <i class="fas fa-download me-1"></i> Export Excel
                                                </button>
                                            @else
                                                <span class="text-muted small">File belum siap untuk dilihat</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada data stock opname</h5>
                        <p class="text-muted">Admin belum mengupload file stock opname.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
