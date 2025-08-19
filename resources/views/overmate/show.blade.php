@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3 class="fw-bold">Detail Overmate</h3>
                <h5 class="text-muted">Item Number: <span class="text-primary">{{ $itemNumber }}</span></h5>
            </div>
            <a href="{{ route('overmate.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Kembali
            </a>
        </div>

        <!-- Summary Card -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-primary">
                    <div class="card-body text-center">
                        <h5 class="card-title text-primary">
                            <i class="fas fa-cube me-2"></i>
                            Item Number
                        </h5>
                        <h4 class="text-primary">{{ $itemNumber }}</h4>
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
                        <h4 class="text-success">{{ $overmates->unique('manufactur')->count() }}</h4>
                        <small class="text-muted">Different manufacturers</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-info">
                    <div class="card-body text-center">
                        <h5 class="card-title text-info">
                            <i class="fas fa-boxes me-2"></i>
                            Total Overmate
                        </h5>
                        <h4 class="text-info">{{ number_format($overmates->sum('overmate_qty')) }}</h4>
                        <small class="text-muted">Total quantity</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Table -->
        <div class="card shadow-sm dashboard-card">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>
                    Detail per Manufacturer
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th style="width: 40%;">Nama Bahan</th>
                                <th style="width: 30%;">Manufacturer</th>
                                <th style="width: 15%;">Overmate Qty</th>
                                <th style="width: 10%;">Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($overmates as $index => $item)
                                @php
                                    $totalQty = $overmates->sum('overmate_qty');
                                    $percentage = $totalQty > 0 ? ($item->overmate_qty / $totalQty) * 100 : 0;
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div class="fw-bold">{{ $item->nama_bahan }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $item->manufactur }}</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="badge bg-info fs-6">{{ number_format($item->overmate_qty, 5) }}</span>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 me-2" style="height: 20px;">
                                                <div class="progress-bar bg-info" role="progressbar"
                                                    style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}"
                                                    aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                            <small class="fw-bold">{{ number_format($percentage, 1) }}%</small>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr class="fw-bold">
                                <td colspan="3" class="text-end">Total:</td>
                                <td class="text-end">
                                    <span
                                        class="badge bg-primary fs-6">{{ number_format($overmates->sum('overmate_qty'), 5) }}</span>
                                </td>
                                <td class="text-end">100%</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Related Information -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card border-warning">
                    <div class="card-body">
                        <h6 class="card-title text-warning">
                            <i class="fas fa-info-circle me-2"></i>
                            Informasi
                        </h6>
                        <ul class="list-unstyled mb-0">
                            <li><strong>Item Number:</strong> {{ $itemNumber }}</li>
                            <li><strong>Variasi Nama Bahan:</strong> {{ $overmates->unique('nama_bahan')->count() }}
                                variasi</li>
                            <li><strong>Manufacturers:</strong> {{ $overmates->unique('manufactur')->count() }} suppliers
                            </li>
                            <li><strong>Total Overmate Quantity:</strong>
                                {{ number_format($overmates->sum('overmate_qty'), 5) }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
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

        .progress {
            border-radius: 10px;
        }

        .card {
            border-radius: 10px;
        }

        .btn {
            border-radius: 8px;
        }
    </style>
@endpush
