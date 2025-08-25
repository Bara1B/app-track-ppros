@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h3 class="text-2xl font-bold mb-6">Selamat Datang, {{ Auth::user()->name }}!</h3>



        {{-- Navigation Cards --}}
        <div class="row g-4 mb-4">
            {{-- Card WO Tracking --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100 nav-card min-h-[260px]"
                    onclick="window.location.href='{{ route('dashboard') }}'">
                    <div class="card-body p-4 md:min-h-[240px]">
                        <div class="flex items-stretch">
                            <div class="w-8/12 flex flex-col h-full">
                                <h5 class="fw-bold text-primary mb-2">Work Order Tracking</h5>
                                <div class="text-muted desc">
                                    Kelola dan pantau semua work order mulai dari pembuatan hingga penyelesaian. Lacak
                                    status progres setiap tahapan produksi.
                                </div>
                                <div class="flex-1"></div>
                                <div class="mt-4 border-t border-gray-100 pt-3">
                                    <span
                                        class="inline-flex items-center px-4 py-2 rounded-md text-white font-semibold shadow bg-gradient-to-r from-blue-600 via-blue-600 to-blue-800 transition-transform hover:translate-x-1 hover:shadow-lg select-none">
                                        <span class="me-2">→</span>Kelola Work Order
                                    </span>
                                </div>
                            </div>
                            <div class="w-4/12 flex items-center justify-end text-end">
                                <div
                                    class="nav-card-icon bg-primary bg-opacity-10 text-primary rounded-3 p-3 d-inline-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Stock Opname --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100 nav-card min-h-[260px]"
                    onclick="window.location.href='{{ route('stock-opname.index') }}'">
                    <div class="card-body p-4 md:min-h-[240px]">
                        <div class="flex items-stretch">
                            <div class="w-8/12 flex flex-col h-full">
                                <h5 class="fw-bold text-success mb-2">Stock Opname</h5>
                                <div class="text-muted desc">
                                    Kelola inventaris dan tentukan status stock produk apakah masuk kategori overmate atau
                                    tidak. Pantau ketersediaan stock secara real-time.
                                </div>
                                <div class="flex-1"></div>
                                <div class="mt-4 border-t border-gray-100 pt-3">
                                    <span
                                        class="inline-flex items-center px-4 py-2 rounded-md text-white font-semibold shadow bg-gradient-to-r from-emerald-600 via-emerald-600 to-emerald-800 transition-transform hover:translate-x-1 hover:shadow-lg select-none">
                                        <span class="me-2">→</span>Kelola Stock Opname
                                    </span>
                                </div>
                            </div>
                            <div class="w-4/12 flex items-center justify-end text-end">
                                <div
                                    class="nav-card-icon bg-success bg-opacity-10 text-success rounded-3 p-3 d-inline-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                        </path>
                                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Additional Cards Row --}}
        <div class="row g-4 mb-4">
            {{-- Card Data Master --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100 nav-card min-h-[260px]"
                    onclick="window.location.href='{{ route('admin.data-master') }}'">
                    <div class="card-body p-4 md:min-h-[240px]">
                        <div class="flex items-stretch">
                            <div class="w-8/12 flex flex-col h-full">
                                <h5 class="fw-bold text-info mb-2">Data Master</h5>
                                <div class="text-muted desc">
                                    Kumpulan data master untuk referensi sistem, termasuk Overmate dan Work Order (Master
                                    Product). Kelola dan telusuri data acuan produksi.
                                </div>
                                <div class="flex-1"></div>
                                <div class="mt-4 border-t border-gray-100 pt-3">
                                    <span
                                        class="inline-flex items-center px-4 py-2 rounded-md text-white font-semibold shadow bg-gradient-to-r from-cyan-500 via-cyan-600 to-cyan-700 transition-transform hover:translate-x-1 hover:shadow-lg select-none">
                                        <span class="me-2">→</span>Kelola Master Data
                                    </span>
                                </div>
                            </div>
                            <div class="w-4/12 flex items-center justify-end text-end">
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

            {{-- Card Settings --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100 nav-card min-h-[260px]"
                    onclick="window.location.href='{{ route('admin.settings.index') }}'">
                    <div class="card-body p-4 md:min-h-[240px]">
                        <div class="flex items-stretch">
                            <div class="w-8/12 flex flex-col h-full">
                                <h5 class="fw-bold text-warning mb-2">Settings & User Management</h5>
                                <div class="text-muted desc">
                                    Konfigurasi sistem, pengaturan user, role management, dan konfigurasi aplikasi lainnya.
                                </div>
                                <div class="flex-1"></div>
                                <div class="mt-4 border-t border-gray-100 pt-3">
                                    <span
                                        class="inline-flex items-center px-4 py-2 rounded-md text-white font-semibold shadow bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 transition-transform hover:translate-x-1 hover:shadow-lg select-none">
                                        <span class="me-2">→</span>Kelola Settings
                                    </span>
                                </div>
                            </div>
                            <div class="w-4/12 flex items-center justify-end text-end">
                                <div
                                    class="nav-card-icon bg-warning bg-opacity-10 text-warning rounded-3 p-3 d-inline-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="3"></circle>
                                        <path
                                            d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grafik Ringkasan (Donut) --}}
        <div class="card shadow-sm dashboard-card mb-5">
            <div class="card-body">
                <div class="mb-4 mt-4">
                    <div class="mx-auto" style="max-width: 900px;">
                        <h5 class="fw-bold text-center mb-3">Ringkasan Data</h5>
                        <div class="p-3 border rounded">
                            <div class="relative w-full h-72">
                                <canvas id="summaryDonutChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Work Order Stats Grouped Card --}}
        <div class="card border-0 shadow-sm mb-5">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="fw-bold mb-0">Work Order</h5>
                </div>
                <div class="row g-5">
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="bg-white border rounded-3 h-100">
                            <div class="p-4 d-flex align-items-center gap-3">
                                <div class="bg-indigo-50 text-indigo-600 p-3 rounded-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="3" width="7" height="7"></rect>
                                        <rect x="14" y="3" width="7" height="7"></rect>
                                        <rect x="14" y="14" width="7" height="7"></rect>
                                        <rect x="3" y="14" width="7" height="7"></rect>
                                    </svg>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">Total Data Master Work Order</h6>
                                    <h4 class="fw-bold mb-0">{{ $stats['total_master_work_order'] ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="bg-white border rounded-3 h-100">
                            <div class="p-4 d-flex align-items-center gap-3">
                                <div class="bg-blue-50 text-blue-600 p-3 rounded-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">Total Work Order</h6>
                                    <h4 class="fw-bold mb-0">{{ $stats['total_wo'] ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="bg-white border rounded-3 h-100">
                            <div class="p-4 d-flex align-items-center gap-3">
                                <div class="bg-green-50 text-green-600 p-3 rounded-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                    </svg>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">Completed</h6>
                                    <h4 class="fw-bold mb-0">{{ $stats['completed_wo'] ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="bg-white border rounded-3 h-100">
                            <div class="p-4 d-flex align-items-center gap-3">
                                <div class="bg-yellow-50 text-yellow-600 p-3 rounded-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z">
                                        </path>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">On Going</h6>
                                    <h4 class="fw-bold mb-0">{{ $stats['on_progress_wo'] ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Stock Opname Grouped Card (Bottom Section) --}}
        <div class="card border-0 shadow-sm mb-5">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="fw-bold mb-0">Stock Opname</h5>
                </div>
                <div class="row g-3 mt-1">
                    {{-- Tile Overmate Master --}}
                    <div class="col-12 col-md-6">
                        <div class="bg-white border rounded-3 h-100">
                            <div class="p-4 d-flex align-items-center gap-3">
                                <div class="bg-purple bg-opacity-10 text-purple p-3 rounded-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 12h18"></path>
                                        <path d="M3 6h18"></path>
                                        <path d="M3 18h18"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">Total Data Overmate Master</h6>
                                    <h4 class="fw-bold mb-0 text-purple">{{ $stats['total_overmate'] ?? 0 }}</h4>
                                    <small class="text-muted">Record data master overmate</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tile Excel Files --}}
                    <div class="col-12 col-md-6">
                        <div class="bg-white border rounded-3 h-100">
                            <div class="p-4 d-flex align-items-center gap-3">
                                <div class="bg-success bg-opacity-10 text-success p-3 rounded-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <path d="M8 13h8"></path>
                                        <path d="M8 17h8"></path>
                                        <path d="M10 9H8v2h2V9z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">File Excel Uploaded</h6>
                                    <h4 class="fw-bold mb-0 text-success">{{ $stats['total_excel_files'] ?? 0 }}</h4>
                                    <small class="text-muted">Total file .xlsx yang diupload</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('styles')
        @vite('resources/css/admin-home.css')
    @endpush

    @push('scripts')
        {{-- Pustaka Chart.js --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Donut chart ringkasan total
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('summaryDonutChart');
                if (!ctx) return;

                const dataValues = [
                    {{ $stats['total_master_work_order'] ?? 0 }},
                    {{ $stats['total_overmate'] ?? 0 }},
                    {{ $stats['total_stock_opname'] ?? 0 }},
                    {{ $stats['total_wo'] ?? 0 }}
                ];

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Master Work Order', 'Master Overmate', 'Stock Opname', 'Work Order'],
                        datasets: [{
                            data: dataValues,
                            backgroundColor: [
                                'rgba(59, 130, 246, 0.8)', // blue-500
                                'rgba(139, 92, 246, 0.8)', // purple-500
                                'rgba(16, 185, 129, 0.8)', // emerald-500
                                'rgba(251, 191, 36, 0.8)' // amber-400
                            ],
                            borderColor: [
                                'rgba(59, 130, 246, 1)',
                                'rgba(139, 92, 246, 1)',
                                'rgba(16, 185, 129, 1)',
                                'rgba(251, 191, 36, 1)'
                            ],
                            borderWidth: 2,
                            hoverOffset: 6,
                            cutout: '60%'
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const value = context.parsed;
                                        return `${context.label}: ${value}`;
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
