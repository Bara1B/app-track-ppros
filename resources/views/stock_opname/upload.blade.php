@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold">Upload Stock Opname Excel</h3>
            <a href="{{ route('stock-opname.index') }}" class="btn btn-outline-secondary">↩ Kembali</a>
        </div>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <i class="fas fa-file-excel fa-4x text-success mb-3"></i>
                            <h4>Upload File Excel Stock Opname</h4>
                            <p class="text-muted">Format file harus .xlsx atau .xls dengan header yang sesuai</p>
                        </div>

                        <form action="{{ route('stock-opname.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <label for="file" class="form-label fw-bold">Pilih File Excel</label>
                                <input type="file" class="form-control @error('file') is-invalid @enderror"
                                    id="file" name="file" accept=".xlsx,.xls" required>
                                @error('file')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-text">
                                    <strong>Format Header Excel yang diharapkan:</strong><br>
                                    <small class="text-muted">
                                        No, Location System, Location Actual, Item Number, Description, UM,
                                        Lot/Serial, Reference, Quantity On Hand, Expire Date, Stock Fisik, Selisih,
                                        Overmate, Masuk
                                    </small>
                                </div>
                            </div>

                            <div class="alert alert-info">
                                <div class="d-flex">
                                    <i class="fas fa-info-circle me-2 mt-1"></i>
                                    <div>
                                        <strong>Catatan Penting:</strong>
                                        <ul class="mb-0 mt-2">
                                            <li>Upload file akan mengganti semua data stock opname yang ada</li>
                                            <li>Pastikan format header sesuai dengan yang diperlukan</li>
                                            <li>Maksimal ukuran file: 10MB</li>
                                            <li>Data akan di-join dengan data overmate berdasarkan item_number</li>
                                            <li><strong>Kolom "Stock Fisik":</strong> Kosongkan untuk input manual via web
                                            </li>
                                            <li><strong>Kolom "Selisih", "Overmate", "Masuk":</strong> Akan diisi otomatis
                                                oleh sistem</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-upload me-2"></i>
                                    Upload & Import Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Template Excel Download -->
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div class="card border-light">
                    <div class="card-body text-center">
                        <h6 class="card-title">Template Excel</h6>
                        <p class="card-text text-muted">
                            Unduh template Excel untuk memudahkan input data
                        </p>
                        <a href="{{ route('stock-opname.download-template') }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-download me-1"></i>
                            Download Template Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Template download now handled by server-side route

        // File input validation
        document.getElementById('file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const fileSize = file.size / 1024 / 1024; // MB
                const maxSize = 10; // 10MB

                if (fileSize > maxSize) {
                    alert('Ukuran file terlalu besar. Maksimal 10MB.');
                    e.target.value = '';
                    return;
                }

                const allowedTypes = [
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/vnd.ms-excel'
                ];

                if (!allowedTypes.includes(file.type)) {
                    alert('Format file tidak didukung. Gunakan .xlsx atau .xls');
                    e.target.value = '';
                    return;
                }
            }
        });
    </script>
@endpush

@push('styles')
    <style>
        .card {
            border: none;
            border-radius: 10px;
        }

        .form-control {
            border-radius: 8px;
        }

        .btn {
            border-radius: 8px;
        }

        .alert {
            border-radius: 8px;
        }
    </style>
@endpush
