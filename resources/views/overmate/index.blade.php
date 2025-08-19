@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold">Master Data Overmate</h3>
            <div class="d-flex gap-2">
                <span class="badge bg-info fs-6">Total: {{ number_format($overmates->total()) }} items</span>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('overmate.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" class="form-control" id="search" name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari item number, nama bahan, atau manufacturer...">
                    </div>
                    <div class="col-md-3">
                        <label for="item_number" class="form-label">Item Number</label>
                        <select class="form-select" id="item_number" name="item_number">
                            <option value="">Semua Item Number</option>
                            @foreach ($itemNumbers as $itemNumber)
                                <option value="{{ $itemNumber }}"
                                    {{ request('item_number') == $itemNumber ? 'selected' : '' }}>
                                    {{ $itemNumber }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="manufactur" class="form-label">Manufacturer</label>
                        <input type="text" class="form-control" id="manufactur" name="manufactur"
                            value="{{ request('manufactur') }}" placeholder="Filter manufacturer...">
                    </div>
                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="fas fa-search me-1"></i>
                            Filter
                        </button>
                        <a href="{{ route('overmate.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Results Section -->
        <div class="card shadow-sm dashboard-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th style="width: 15%;">Item Number</th>
                                <th style="width: 35%;">Nama Bahan</th>
                                <th style="width: 25%;">Manufacturer</th>
                                <th style="width: 10%;">Overmate Qty</th>
                                <th style="width: 10%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($overmates as $index => $item)
                                <tr>
                                    <td>{{ $overmates->firstItem() + $index }}</td>
                                    <td>
                                        <strong class="text-primary">{{ $item->item_number }}</strong>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $item->nama_bahan }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $item->manufactur }}</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="badge bg-info">{{ number_format($item->overmate_qty, 5) }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('overmate.show', $item->item_number) }}"
                                            class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-search fa-3x mb-3 text-muted"></i>
                                            <h5>Tidak ada data ditemukan</h5>
                                            <p>Coba ubah filter pencarian Anda</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($overmates->count() > 0)
                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">
                                Menampilkan {{ $overmates->firstItem() }} - {{ $overmates->lastItem() }}
                                dari {{ number_format($overmates->total()) }} data
                                @if (request()->hasAny(['search', 'item_number', 'manufactur']))
                                    <span class="badge bg-warning text-dark ms-2">Filtered</span>
                                @endif
                            </small>
                        </div>
                        <div>
                            {{ $overmates->withQueryString()->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Statistics Cards -->
        @if (!request()->hasAny(['search', 'item_number', 'manufactur']))
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card border-primary">
                        <div class="card-body text-center">
                            <h5 class="card-title text-primary">
                                <i class="fas fa-boxes me-2"></i>
                                Total Items
                            </h5>
                            <h3 class="text-primary">{{ number_format($itemNumbers->count()) }}</h3>
                            <small class="text-muted">Unique item numbers</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <h5 class="card-title text-success">
                                <i class="fas fa-industry me-2"></i>
                                Manufacturers
                            </h5>
                            <h3 class="text-success">{{ number_format($manufacturers->count()) }}</h3>
                            <small class="text-muted">Unique manufacturers</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-info">
                        <div class="card-body text-center">
                            <h5 class="card-title text-info">
                                <i class="fas fa-database me-2"></i>
                                Total Records
                            </h5>
                            <h3 class="text-info">{{ number_format($overmates->total()) }}</h3>
                            <small class="text-muted">Total overmate records</small>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .dashboard-card {
            border: none;
            border-radius: 10px;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            font-size: 0.875rem;
            white-space: nowrap;
        }

        .badge {
            font-size: 0.75rem;
        }

        .table-responsive {
            border-radius: 10px;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
        }

        .btn {
            border-radius: 8px;
        }

        .card {
            border-radius: 10px;
        }
    </style>
@endpush
