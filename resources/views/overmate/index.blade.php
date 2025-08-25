@extends('layouts.app')

@push('styles')
    @vite('resources/css/pages/overmate-index.css')
@endpush

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold">Master Data Overmate</h3>
            <div class="d-flex gap-2 align-items-center">
                @if (Auth::user() && Auth::user()->role === 'admin')
                    <a href="{{ route('overmate.create') }}" class="btn btn-sm btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        Tambah
                    </a>
                @endif
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
                                <th style="width: 12%;">Action</th>
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
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('overmate.show', $item->item_number) }}"
                                                class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                            </a>
                                            @if (Auth::user() && Auth::user()->role === 'admin')
                                                <a href="{{ route('overmate.edit', $item->item_number) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"></path></svg>
                                                </a>
                                                <form action="{{ route('overmate.destroy', $item->item_number) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path><path d="M10 11v6"></path><path d="M14 11v6"></path><path d="M9 6V4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"></path></svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
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

 
