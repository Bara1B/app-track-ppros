@props(['workOrder'])

<div class="card wo-card-user">
    <div class="card-body p-3">
        <div class="row align-items-center">
            {{-- Info WO, Ikon, dan Tanggal --}}
            <div class="col-md-5">
                <div class="d-flex align-items-center gap-3">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" class="text-muted opacity-50">
                            <path d="M10 2v7.31"></path>
                            <path d="M14 9.31V2"></path>
                            <path d="M17.5 2h-11a1 1 0 0 0-1 1v15a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1z">
                            </path>
                            <path d="M8 16h8"></path>
                        </svg>
                    </div>
                    <div>
                        {{-- Nama Produk (Output) --}}
                        <h5 class="card-title fw-bold mb-1">{{ $workOrder->output ?? 'Nama Produk' }}</h5>

                        {{-- Work Order Number --}}
                        <p class="card-subtitle text-muted mb-2">WO: {{ $workOrder->wo_number }}</p>

                        {{-- ID Number jika ada --}}
                        @if ($workOrder->id_number)
                            <p class="card-subtitle text-muted mb-2">ID: {{ $workOrder->id_number }}</p>
                        @endif

                        {{-- Deskripsi Produk --}}
                        @if ($workOrder->output)
                            <p class="card-text text-muted mb-2">
                                <small><strong>Deskripsi:</strong> {{ $workOrder->output }}</small>
                            </p>
                        @endif

                        {{-- Badges untuk tanggal --}}
                        <div>
                            <span class="badge bg-light text-dark me-2">Diterima:
                                {{ $workOrder->woDiterimaTracking?->completed_at?->translatedFormat('d M Y') ?? '-' }}</span>
                            <span class="badge bg-danger text-white">Due:
                                {{ $workOrder->due_date->translatedFormat('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Progress Bar & Status Terkini --}}
            <div class="col-md-4">
                @php
                    $totalSteps = $workOrder->tracking->count();
                    $completedSteps = $workOrder->tracking->whereNotNull('completed_at')->count();
                    $progress = $totalSteps > 0 ? ($completedSteps / $totalSteps) * 100 : 0;

                    // Cari status terakhir yang sudah selesai
                    $lastCompletedStep = $workOrder->tracking->whereNotNull('completed_at')->last();
                    $currentStatusText = $lastCompletedStep ? $lastCompletedStep->status_name : 'Belum Diterima';

                    // Tentukan warna statusnya
                    $statusColorClass = 'text-dark'; // Default: hitam
                    if ($currentStatusText === 'Kirim CPB/WO') {
                        $statusColorClass = 'text-success'; // Hijau
                    } elseif ($lastCompletedStep) {
                        $statusColorClass = 'text-primary'; // Biru
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
                <a href="{{ route('work-order.show', $workOrder) }}" class="btn btn-primary w-100">Lacak
                    WO</a>
            </div>
        </div>
    </div>
</div>
