@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h3 class="fw-bold mb-4">Selamat Datang, {{ Auth::user()->name }}!</h3>

        {{-- Kartu Statistik --}}
        <div class="row g-4 mb-4">
            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
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
            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="bg-success bg-opacity-10 text-success p-3 rounded-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
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
            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">On Going</h6>
                            <h4 class="fw-bold mb-0">{{ $stats['ongoing_wo'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="bg-info bg-opacity-10 text-info p-3 rounded-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Pengguna</h6>
                            <h4 class="fw-bold mb-0">{{ $stats['total_users'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Navigation Cards --}}
        <div class="row g-4 mb-4">
            {{-- Card WO Tracking --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100 nav-card"
                    onclick="window.location.href='{{ route('dashboard') }}'">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h5 class="fw-bold text-primary mb-2">Work Order Tracking</h5>
                                <p class="text-muted mb-3">Kelola dan pantau semua work order mulai dari pembuatan hingga
                                    penyelesaian. Lacak status progres setiap tahapan produksi.</p>
                                <span class="btn btn-gradient-primary">
                                    <span class="me-2">→</span>Kelola Work Order
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
                <div class="card border-0 shadow-sm h-100 nav-card"
                    onclick="window.location.href='{{ route('stock-opname.index') }}'">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h5 class="fw-bold text-success mb-2">Stock Opname</h5>
                                <p class="text-muted mb-3">Kelola inventaris dan tentukan status stock produk apakah masuk
                                    kategori overmate atau tidak. Pantau ketersediaan stock secara real-time.</p>
                                <span class="btn btn-gradient-success">
                                    <span class="me-2">→</span>Kelola Stock Opname
                                </span>
                            </div>
                            <div class="col-4 text-end">
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
            {{-- Card Master Overmate --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100 nav-card"
                    onclick="window.location.href='{{ route('overmate.index') }}'">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h5 class="fw-bold text-info mb-2">Master Overmate</h5>
                                <p class="text-muted mb-3">Data master bahan dan overmate quantity untuk referensi sistem
                                    stock opname. Kelola 346+ records data.</p>
                                <span class="btn btn-gradient-info">
                                    <span class="me-2">→</span>Kelola Master Data
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

            {{-- Card Settings --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100 nav-card"
                    onclick="window.location.href='{{ route('admin.settings.index') }}'">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h5 class="fw-bold text-warning mb-2">Settings & User Management</h5>
                                <p class="text-muted mb-3">Konfigurasi sistem, pengaturan user, role management, dan
                                    konfigurasi aplikasi lainnya.</p>
                                <span class="btn btn-gradient-warning">
                                    <span class="me-2">→</span>Kelola Settings
                                </span>
                            </div>
                            <div class="col-4 text-end">
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

        {{-- Grafik --}}
        <div class="card shadow-sm dashboard-card">
            <div class="card-body">
                <div class="mb-4 mt-4">
                    <div class="mx-auto" style="max-width: 900px;">
                        <h5 class="fw-bold text-center mb-3">Total Work Order per Bulan ({{ now()->year }})</h5>
                        <div class="p-3 border rounded">
                            <canvas id="monthlyWoChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card Tambahan --}}
        <div class="row g-4 mt-4">
            {{-- Card Overmate Master --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="bg-purple bg-opacity-10 text-purple p-3 rounded-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M20 7L10 17l-5-5"></path>
                                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7"></path>
                                <path d="M16 5h6v6"></path>
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

            {{-- Card Excel Files --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="bg-success bg-opacity-10 text-success p-3 rounded-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
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
@endsection

@push('styles')
    <style>
        .nav-card {
            transition: all 0.3s ease;
            cursor: pointer;
            overflow: hidden;
        }

        .nav-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
        }

        .nav-card-icon {
            transition: all 0.3s ease;
        }

        .nav-card:hover .nav-card-icon {
            transform: scale(1.1);
        }

        .nav-card .btn {
            transition: all 0.3s ease;
        }

        .nav-card:hover .btn {
            transform: translateX(5px);
        }

        .nav-card .btn span:first-child {
            transition: transform 0.3s ease;
            display: inline-block;
        }

        .nav-card:hover .btn span:first-child {
            transform: translateX(3px);
        }

        /* Gradient Button Styles */
        .btn-gradient-primary {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 50%, #084298 100%);
            border: none;
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-gradient-primary:hover {
            background: linear-gradient(135deg, #0b5ed7 0%, #0a58ca 50%, #052c65 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(13, 110, 253, 0.4);
            color: white;
        }

        .btn-gradient-success {
            background: linear-gradient(135deg, #198754 0%, #146c43 50%, #0f5132 100%);
            border: none;
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(25, 135, 84, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-gradient-success:hover {
            background: linear-gradient(135deg, #157347 0%, #146c43 50%, #0d5b3e 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(25, 135, 84, 0.4);
            color: white;
        }

        .btn-gradient-info {
            background: linear-gradient(135deg, #0dcaf0 0%, #0aa2c0 50%, #087990 100%);
            border: none;
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(13, 202, 240, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-gradient-info:hover {
            background: linear-gradient(135deg, #0bb5d4 0%, #0aa2c0 50%, #087990 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(13, 202, 240, 0.4);
            color: white;
        }

        .btn-gradient-warning {
            background: linear-gradient(135deg, #ffc107 0%, #e0a800 50%, #b8860b 100%);
            border: none;
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-gradient-warning:hover {
            background: linear-gradient(135deg, #e0a800 0%, #d39e00 50%, #b8860b 100%);
            transform: translateY(-2px);
        }

        /* Custom Colors */
        .bg-purple {
            background-color: #6f42c1 !important;
        }

        .text-purple {
            color: #6f42c1 !important;
        }

        box-shadow: 0 8px 25px rgba(255, 193, 7, 0.4);
        color: white;
        }

        /* Gradient Button Shine Effect */
        .btn-gradient-primary::before,
        .btn-gradient-success::before,
        .btn-gradient-info::before,
        .btn-gradient-warning::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-gradient-primary:hover::before,
        .btn-gradient-success:hover::before,
        .btn-gradient-info:hover::before,
        .btn-gradient-warning:hover::before {
            left: 100%;
        }

        .nav-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s;
        }

        .nav-card:hover::before {
            left: 100%;
        }
    </style>
@endpush

@push('scripts')
    {{-- Pustaka Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Skrip untuk Grafik (tidak berubah)
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('monthlyWoChart');
            if (ctx) {
                fetch("{{ route('charts.monthly-wo') }}")
                    .then(response => response.json())
                    .then(data => {
                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: data.labels,
                                datasets: [{
                                    label: 'Total WO',
                                    data: data.data,
                                    tension: 0.4,
                                    fill: true,
                                    backgroundColor: function(context) {
                                        const chart = context.chart;
                                        const {
                                            ctx,
                                            chartArea
                                        } = chart;
                                        if (!chartArea) return null;
                                        const gradient = ctx.createLinearGradient(0,
                                            chartArea.bottom, 0, chartArea.top);
                                        gradient.addColorStop(0, 'rgba(0, 86, 160, 0)');
                                        gradient.addColorStop(1, 'rgba(0, 86, 160, 0.6)');
                                        return gradient;
                                    },
                                    borderColor: 'rgba(0, 86, 160, 1)',
                                    borderWidth: 2,
                                    pointBackgroundColor: 'rgba(0, 86, 160, 1)',
                                    pointBorderColor: '#fff',
                                    pointHoverBackgroundColor: '#fff',
                                    pointHoverBorderColor: 'rgba(0, 86, 160, 1)'
                                }]
                            },
                            options: {
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            precision: 0
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                }
                            }
                        });
                    });
            }
        });
    </script>
@endpush
