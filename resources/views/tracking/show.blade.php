@extends('layouts.app')

@vite('resources/css/tracking.css')

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
                <h2 class="card-title">Tracking Work Order: <strong>{{ $workOrder->wo_number }} -
                        <strong>{{ $workOrder->output }}</strong></h2>
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

                                    {{-- Tampilan Tanggal & Form Edit --}}
                                    <div class="timeline-step-date">
                                        @if ($status->completed_at)
                                            <div id="display-date-{{ $status->id }}">
                                                Selesai pada:
                                                {{ \Carbon\Carbon::parse($status->completed_at)->translatedFormat('l, d M Y') }}
                                                @if (Auth::user()->role == 'admin')
                                                    <button class="btn btn-link btn-sm p-0 ms-1 edit-date-btn"
                                                        data-id="{{ $status->id }}" title="Edit Tanggal">✏️</button>
                                                @endif
                                            </div>
                                            @if (Auth::user()->role == 'admin')
                                                <form id="edit-form-{{ $status->id }}"
                                                    action="{{ route('work-orders.tracking.update-date', $status) }}"
                                                    method="POST" class="d-none mt-1">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="input-group input-group-sm" style="max-width: 300px;">
                                                        <input type="date" name="completed_date" class="form-control"
                                                            value="{{ \Carbon\Carbon::parse($status->completed_at)->format('Y-m-d') }}">
                                                        <button type="submit" class="btn btn-success">Simpan</button>
                                                        <button type="button" class="btn btn-secondary cancel-edit-btn"
                                                            data-id="{{ $status->id }}">Batal</button>
                                                    </div>
                                                </form>
                                            @endif
                                        @else
                                            Menunggu proses...
                                        @endif
                                    </div>

                                    @if ($status->notes)
                                        <small class="text-muted fst-italic">Catatan: {{ $status->notes }}</small>
                                    @endif
                                </div>

                                <div class="mb-2">
                                    {{-- Form verifikasi --}}
                                    @if (!$status->completed_at)
                                        <form method="POST" action="{{ route('work-orders.tracking.complete', $status) }}"
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

        {{-- ... (Card Manajemen Komponen tidak berubah) ... --}}
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editDateButtons = document.querySelectorAll('.edit-date-btn');
            const cancelEditButtons = document.querySelectorAll('.cancel-edit-btn');

            editDateButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    document.getElementById('display-date-' + id).classList.add('d-none');
                    document.getElementById('edit-form-' + id).classList.remove('d-none');
                });
            });

            cancelEditButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    document.getElementById('display-date-' + id).classList.remove('d-none');
                    document.getElementById('edit-form-' + id).classList.add('d-none');
                });
            });
        });
    </script>
@endpush
