@extends('layouts.app')

@push('styles')
    {{-- Mengirim link CSS ke layout utama --}}
    @vite('resources/css/tracking.css')
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
                    Due Date: {{ \Carbon\Carbon::parse($workOrder->due_date)->format('d F Y') }}
                </p>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">🚀 Progres Pelacakan</h5>
            </div>
            <div class="card-body">
                <ol class="timeline-stepper">
                    @foreach ($workOrder->tracking as $status)
                        <li class="timeline-step @if ($status->completed_at) completed @endif">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="timeline-step-title">{{ $status->status_name }}</div>
                                    <div class="timeline-step-date">
                                        @if ($status->completed_at)
                                            Selesai pada:
                                            {{ \Carbon\Carbon::parse($status->completed_at)->format('d M Y, H:i') }}
                                        @else
                                            Menunggu proses...
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    @if (!$status->completed_at)
                                        <form method="POST"
                                            action="{{ route('work-orders.tracking.complete', $status->id) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">✓ Verifikasi</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>

        {{-- Card Manajemen Komponen --}}
    </div>
@endsection
