@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h3 class="fw-bold mb-4">Tugas Work Order Anda</h3>

        {{-- Panel Filter & Sorting --}}
        <div class="card shadow-sm mb-4 filter-panel">
            <div class="card-body">
                <form action="{{ route('dashboard') }}" method="GET">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-8">
                            <label for="search" class="form-label fw-bold">Cari Work Order</label>
                            <input type="text" name="search" class="form-control" id="search"
                                placeholder="Masukkan No. WO atau Nama Produk..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="sort_by" class="form-label fw-bold">Urutkan Berdasarkan</label>
                            <select name="sort_by" id="sort_by" class="form-select" onchange="this.form.submit()">
                                <option value="created_at-desc" @if (request('sort_by') == 'created_at-desc' || !request('sort_by')) selected @endif>Terbaru
                                    Dibuat</option>
                                <option value="due_date-asc" {{ request('sort_by') == 'due_date-asc' ? 'selected' : '' }}>
                                    Due Date (Terdekat)</option>
                                <option value="due_date-desc" {{ request('sort_by') == 'due_date-desc' ? 'selected' : '' }}>
                                    Due Date (Terlama)</option>
                                <option value="output-asc" {{ request('sort_by') == 'output-asc' ? 'selected' : '' }}>Nama
                                    Produk (A-Z)</option>
                                <option value="output-desc" {{ request('sort_by') == 'output-desc' ? 'selected' : '' }}>Nama
                                    Produk (Z-A)</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row gy-3">
            @forelse($workOrders as $wo)
                <div class="col-12">
                    <x-user-work-order-card :workOrder="$wo" />
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-success text-center">
                        <h4 class="alert-heading">Pekerjaan Selesai!</h4>
                        <p>Tidak ada Work Order yang sedang dalam proses pengerjaan.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $workOrders->links() }}
        </div>
    </div>
@endsection
