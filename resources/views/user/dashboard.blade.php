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
                    <div class="card wo-card-user">
                        <div class="card-body p-3">
                            <div class="row align-items-center">
                                {{-- Info WO, Ikon, dan Tanggal --}}
                                <div class="col-md-5">
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="text-muted opacity-50">
                                                <path d="M10 2v7.31"></path>
                                                <path d="M14 9.31V2"></path>
                                                <path
                                                    d="M17.5 2h-11a1 1 0 0 0-1 1v15a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1z">
                                                </path>
                                                <path d="M8 16h8"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h5 class="card-title fw-bold mb-1">{{ $wo->output }}</h5>
                                            <p class="card-subtitle text-muted mb-2">{{ $wo->wo_number }}</p>
                                            <div>
                                                <span class="badge bg-light text-dark me-2">Diterima:
                                                    {{ $wo->woDiterimaTracking?->completed_at?->translatedFormat('d M Y') ?? '-' }}</span>
                                                <span class="badge bg-danger text-white">Due:
                                                    {{ $wo->due_date->translatedFormat('d M Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Progress Bar & Status Terkini --}}
                                <div class="col-md-4">
                                    @php
                                        $totalSteps = $wo->tracking->count();
                                        $completedSteps = $wo->tracking->whereNotNull('completed_at')->count();
                                        $progress = $totalSteps > 0 ? ($completedSteps / $totalSteps) * 100 : 0;

                                        // Cari status terakhir yang sudah selesai
                                        $lastCompletedStep = $wo->tracking->whereNotNull('completed_at')->last();
                                        $currentStatusText = $lastCompletedStep
                                            ? $lastCompletedStep->status_name
                                            : 'Belum Diterima';

                                        // Tentukan warna statusnya
                                        $statusColorClass = 'text-dark'; // Default: hitam
                                        if ($currentStatusText === 'Kirim CPB/WO') {
                                            $statusColorClass = 'text-success'; // Hijau
                                        } elseif ($lastCompletedStep) {
                                            $statusColorClass = 'text-primary'; // Kuning
                                        }
                                    @endphp
                                    <p class="mb-1"><small>{{ $completedSteps }} dari {{ $totalSteps }} langkah
                                            selesai</small></p>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%;"
                                            aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    <p class="mb-0 mt-2"><small><strong>Status Terkini:</strong> <span
                                                class="{{ $statusColorClass }} fw-bold">{{ $currentStatusText }}</span></small>
                                    </p>
                                </div>

                                {{-- Tombol Aksi --}}
                                <div class="col-md-3 text-md-end mt-3 mt-md-0">
                                    <a href="{{ route('work-order.show', $wo) }}" class="btn btn-primary w-100">Lacak
                                        WO</a>
                                </div>
                            </div>
                        </div>
                    </div>
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
