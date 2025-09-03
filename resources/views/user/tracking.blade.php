@extends('layouts.app')

@vite('resources/css/tracking.css')
@vite('resources/css/tracking-icons-fix.css')

@push('styles')
    <style>
        /* Force icon visibility for user tracking */
        .timeline-step::before {
            z-index: 1000 !important;
            position: absolute !important;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2) !important;
        }

        .timeline-step.completed::before {
            z-index: 1001 !important;
            box-shadow: 0 6px 12px rgba(25, 135, 84, 0.4) !important;
        }

        /* Ensure content doesn't overflow and cover icons */
        .timeline-step {
            overflow: visible !important;
            position: relative !important;
        }

        .timeline-step>div {
            z-index: 1 !important;
            position: relative !important;
        }
    </style>
@endpush

@section('content')
    <div class="container py-5">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <a href="{{ route('dashboard') }}" class="btn btn-light mb-4">← Kembali ke Dashboard</a>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h2 class="card-title">Tracking Work Order: <strong>{{ $workOrder->wo_number }}</strong></h2>
                <p class="card-text text-muted">
                    Produk: {{ $workOrder->output }} | Due Date: {{ $workOrder->due_date->translatedFormat('l, d F Y') }}
                </p>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">🚀 Progres Pelacakan</h5>
            </div>
            <div class="card-body">
                @php
                    $stepsWithNotes = ['Selesai Timbang', 'Potong Stock', 'Released', 'Kirim BB', 'Kirim CPB/WO'];
                @endphp

                <ol class="timeline-stepper">
                    @foreach ($workOrder->tracking as $status)
                        <li class="timeline-step @if ($status->completed_at) completed @endif">
                            <div class="d-flex justify-content-between align-items-start flex-wrap">
                                <div class="mb-2">
                                    <div class="timeline-step-title">{{ $status->status_name }}</div>
                                    <div class="timeline-step-date">
                                        @if ($status->completed_at)
                                            Selesai pada:
                                            {{ \Carbon\Carbon::parse($status->completed_at)->translatedFormat('l, d M Y') }}
                                        @else
                                            Menunggu proses...
                                        @endif
                                    </div>
                                    @if ($status->notes)
                                        <small class="text-muted fst-italic">Catatan: {{ $status->notes }}</small>
                                    @endif
                                </div>

                                <div class="mb-2">
                                    {{-- User biasa juga bisa verifikasi --}}
                                    @if (!$status->completed_at)
                                        <form method="POST"
                                            action="{{ route('work-orders.tracking.complete', $status->id) }}"
                                            class="d-flex align-items-center gap-2">
                                            @csrf
                                            <input type="date" name="completed_date" class="form-control form-control-sm"
                                                value="{{ date('Y-m-d') }}" required>
                                            @if (in_array($status->status_name, $stepsWithNotes))
                                                <input type="text" name="notes" class="form-control form-control-sm"
                                                    placeholder="Tambah keterangan...">
                                            @endif
                                            <button type="submit"
                                                class="btn btn-sm btn-success flex-shrink-0">Simpan</button>
                                        </form>
                                    @else
                                        <button class="btn btn-sm btn-outline-secondary" disabled>Sudah
                                            diverifikasi</button>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
@endsection
