@extends('layouts.app')

@push('styles')
    @vite('resources/css/pages/admin-data_master.css')
@endpush

@section('content')
    <div class="container px-3 px-md-4 py-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h4 class="mb-0 fw-bold">Data Master</h4>
            <small class="text-muted">Pusat navigasi data acuan sistem</small>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100 nav-card"
                    onclick="window.location.href='{{ route('overmate.index') }}'">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h5 class="fw-bold text-info mb-2">Overmate Data</h5>
                                <p class="text-muted mb-3">Data master bahan dan overmate quantity untuk referensi stock
                                    opname.</p>
                                <span
                                    class="inline-flex items-center px-4 py-2 rounded-md text-white font-semibold shadow bg-gradient-to-r from-cyan-500 via-cyan-600 to-cyan-700 transition-transform hover:translate-x-1 hover:shadow-lg select-none">
                                    <span class="me-2">→</span>Buka Overmate Data
                                </span>
                            </div>
                            <div class="col-4 text-end">
                                <div class="nav-card-icon bg-info bg-opacity-10 text-info rounded-3 p-3 d-inline-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100 nav-card"
                    onclick="window.location.href='{{ route('work-orders.data.index') }}'">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h5 class="fw-bold text-primary mb-2">Work Order Data</h5>
                                <p class="text-muted mb-3">Data diambil dari Master Product (Seeder). Filter & pagination
                                    tersedia.</p>
                                <span
                                    class="inline-flex items-center px-4 py-2 rounded-md text-white font-semibold shadow bg-gradient-to-r from-blue-600 via-blue-600 to-blue-800 transition-transform hover:translate-x-1 hover:shadow-lg select-none">
                                    <span class="me-2">→</span>Buka Work Order Data
                                </span>
                            </div>
                            <div class="col-4 text-end">
                                <div
                                    class="nav-card-icon bg-primary bg-opacity-10 text-primary rounded-3 p-3 d-inline-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
