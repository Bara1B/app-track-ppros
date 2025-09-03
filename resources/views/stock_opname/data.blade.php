@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">Data Stock Opname</h3>
                <p class="text-muted mb-0">File: <strong>{{ $stockOpnameFile->original_name }}</strong></p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ (Auth::user() && Auth::user()->role === 'admin') ? route('admin.stock-opname.index') : route('stock-opname.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke List File
                </a>
                <a href="{{ (Auth::user() && Auth::user()->role === 'admin') ? route('admin.stock-opname.export-data', $stockOpnameFile->id) : route('stock-opname.export-data', $stockOpnameFile->id) }}" class="btn btn-success">
                    <i class="fas fa-file-excel me-2"></i>Export Excel
                </a>
            </div>
        </div>

        {{-- Horizontal card info untuk file yang diupload --}}
        <div class="card shadow-sm mb-4 overflow-hidden">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center rounded"
                    style="width:56px;height:56px;">
                    <i class="fas fa-file-excel"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <h5 class="mb-0">{{ $stockOpnameFile->original_name }}</h5>
                        <span class="badge bg-light text-muted fw-normal">ID: {{ $stockOpnameFile->id }}</span>
                    </div>
                    <div class="text-muted small mt-1">
                        Diunggah: {{ optional($stockOpnameFile->created_at)->format('d M Y, H:i') }}
                        @if (isset($stockOpnames))
                            <span class="mx-2">•</span>
                            Total baris:
                            {{ method_exists($stockOpnames, 'total') ? $stockOpnames->total() : $stockOpnames->count() }}
                        @endif
                    </div>
                </div>
                <div class="d-none d-md-block text-end">
                    <a href="{{ route('stock-opname.export-data', $stockOpnameFile->id) }}" class="btn btn-sm btn-success">
                        <i class="fas fa-file-excel me-1"></i> Export
                    </a>
                </div>
            </div>
        </div>

        @if ($stockOpnames && $stockOpnames->count() > 0)
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Tabel Data Stock Opname</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Location System</th>
                                    <th>Item Number</th>
                                    <th>Description</th>
                                    <th>Manufacturer</th>
                                    <th>Quantity on Hand</th>
                                    <th>Stok Fisik</th>
                                    <th>Overmate Qty</th>
                                    <th>Selisih</th>
                                    <th>Masuk Kategori</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stockOpnames as $item)
                                    <tr>
                                        <td>{{ $item->location_system }}</td>
                                        <td><strong>{{ $item->item_number }}</strong></td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ $item->manufacturer ?: '-' }}</td>
                                        <td>{{ number_format($item->quantity_on_hand, 5) }}</td>
                                        <td>
                                            @if (Auth::user() && Auth::user()->role === 'admin')
                                                <form action="{{ route('admin.stock-opname.update-stok-fisik', $item->id) }}" method="POST" class="d-flex align-items-center gap-2">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="number" name="stok_fisik" step="0.00001" min="0" value="{{ $item->stok_fisik !== null ? rtrim(rtrim(number_format($item->stok_fisik, 5), '0'), '.') : '' }}" class="form-control form-control-sm" style="width: 120px;" placeholder="0.00000">
                                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                                </form>
                                            @else
                                                @if ($item->stok_fisik !== null)
                                                    <span class="badge bg-info">{{ number_format($item->stok_fisik, 5) }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>{{ $item->overmate_qty ? number_format($item->overmate_qty, 5) : '-' }}</td>
                                        <td>
                                            @if ($item->stok_fisik !== null)
                                                <span
                                                    class="badge {{ $item->selisih < 0 ? 'bg-danger' : ($item->selisih > 0 ? 'bg-success' : 'bg-warning') }}">
                                                    {{ $item->selisih > 0 ? '+' : '' }}{{ number_format($item->selisih, 5) }}
                                                </span>
                                            @else
                                                <span class="text-muted">Input stok fisik dulu</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->overmate_qty && $item->stok_fisik !== null)
                                                @if ($item->masuk_kategori === 'Iya')
                                                    <span class="badge bg-success">✓ Iya</span>
                                                @else
                                                    <span class="badge bg-danger">✗ Tidak</span>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $stockOpnames->links() }}
                </div>
            </div>
        @else
            <div class="card text-center py-5">
                <h5 class="text-muted">Belum ada data stock opname</h5>
                <p class="text-muted">Data belum tersedia untuk file ini</p>
            </div>
        @endif
    </div>
@endsection
