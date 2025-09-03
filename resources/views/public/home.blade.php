@extends('layouts.public')

@section('content')
    <div class="relative min-h-screen">
        <!-- Scroll Progress Bar -->
        <div class="fixed top-0 left-0 w-full h-1 bg-gray-200 z-50">
            <div class="scroll-progress h-full bg-gradient-to-r from-blue-600 to-orange-500 transition-all duration-500">
            </div>
        </div>

        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-white to-orange-50">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60"
                xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23e0f2fe"
                fill-opacity="0.4"%3E%3Ccircle cx="30" cy="30" r="2" /%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]
                opacity-30">
            </div>
        </div>

        <!-- Hero Section -->
        <div
            class="relative z-10 pt-16 pb-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-blue-600 via-orange-500 to-blue-800 shadow-2xl fade-in-scale hero-bg-zoom">
            <div class="max-w-7xl mx-auto text-center">
                <!-- Logo Phapros -->
                <div class="mb-8 flex justify-center initial-fade-in-scale initial-stagger-1 fade-in-up">
                    <img src="{{ asset('images/logoPhapros.png') }}" alt="Phapros Logo" class="h-24 md:h-32 lg:h-36">
                </div>

                <div class="mb-8 initial-fade-in initial-stagger-2 fade-in">
                    <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                        <span class="px-6 py-3">
                            Work Order Tracker
                        </span>
                    </h1>
                    <p class="text-xl md:text-2xl text-blue-100 max-w-3xl mx-auto">
                        Sistem tracking work order yang efisien dan real-time untuk monitoring progress produksi
                    </p>
                </div>

                <!-- CTA Buttons -->
                <div
                    class="flex flex-col sm:flex-row gap-4 justify-center items-center initial-fade-in initial-stagger-3 fade-in-up">
                    <a href="{{ route('public.work-orders') }}"
                        class="inline-flex items-center px-8 py-4 border-2 border-white text-lg font-medium rounded-xl text-blue-800 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        Lihat Work Orders
                    </a>
                    <a href="{{ route('public.tracking', $latestWorkOrder) }}"
                        class="inline-flex items-center px-8 py-4 border-2 border-transparent text-lg font-medium rounded-xl text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Mulai Tracking
                    </a>
                </div>

            </div>
        </div>

        <!-- Statistics Section -->
        <div class="relative z-10 py-16 px-4 sm:px-6 lg:px-8 fade-in">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12 initial-fade-in initial-stagger-1 fade-in-up">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Statistik Work Order</h2>
                    <p class="text-lg text-gray-600">Overview progress dan status terkini</p>
                </div>

                <!-- Charts: Radar + Monthly side-by-side -->
                <div class="mb-10">
                    <div class="mx-auto max-w-7xl fade-in-up">
                        <div class="flex items-center gap-2 mb-4">
                            <span
                                class="inline-flex w-9 h-9 rounded-xl bg-blue-600/10 text-blue-700 items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2" />
                                </svg>
                            </span>
                            <h3 class="text-xl md:text-2xl font-semibold text-gray-900">Visualisasi Statistik</h3>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Card: Donut Chart -->
                            <div
                                class="rounded-3xl p-6 md:p-8 shadow-xl hover:shadow-2xl transition-shadow duration-300 ring-1 ring-blue-100/70 bg-gradient-to-br from-white/90 via-blue-50/60 to-orange-50/60 backdrop-blur-xl">
                                <h4 class="text-base font-medium text-gray-700 mb-3">Status Work Order</h4>
                                <div class="relative h-80 flex items-center justify-center">
                                    <canvas id="woDonutChart" aria-label="Work Order Status Donut Chart"
                                        role="img"></canvas>
                                </div>
                            </div>

                            <!-- Card: Monthly Chart -->
                            <div
                                class="rounded-3xl p-6 md:p-8 shadow-xl hover:shadow-2xl transition-shadow duration-300 ring-1 ring-blue-100/70 bg-gradient-to-br from-white/90 via-blue-50/60 to-orange-50/60 backdrop-blur-xl">
                                <h4 class="text-base font-semibold text-gray-800 text-center mb-3">Total Work Order per
                                    Bulan (<span id="woYear"></span>)</h4>
                                <div class="relative h-80">
                                    <canvas id="woMonthlyChart" aria-label="Work Order Monthly Chart"
                                        role="img"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" id="statistics-section">
                    <!-- Total Work Orders -->
                    <div
                        class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 initial-fade-in-left initial-stagger-2 fade-in-left">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Work Orders</p>
                                <p class="text-2xl font-bold text-gray-900">{{ number_format($totalWorkOrders) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Work Orders -->
                    <div
                        class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 initial-fade-in initial-stagger-3 fade-in">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-12 h-12 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Pending</p>
                                <p class="text-2xl font-bold text-gray-900">{{ number_format($pendingWorkOrders) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Completed Work Orders -->
                    <div
                        class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 initial-fade-in initial-stagger-4 fade-in">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Completed</p>
                                <p class="text-2xl font-bold text-gray-900">{{ number_format($completedWorkOrders) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Overdue Work Orders -->
                    <div
                        class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 initial-fade-in-right initial-stagger-5 fade-in-right">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-12 h-12 bg-gradient-to-r from-red-500 to-red-600 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Overdue</p>
                                <p class="text-2xl font-bold text-gray-900">{{ number_format($overdueWorkOrders) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Work Orders Section -->
        <div class="relative z-10 py-16 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12 initial-fade-in initial-stagger-1">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Work Order Terbaru</h2>
                    <p class="text-lg text-gray-600">Monitor progress work order terkini</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($recentWorkOrders as $index => $workOrder)
                        <div class="fade-in-up fade-stagger-{{ ($index % 3) + 1 }}">
                            <x-public-work-order-card :workOrder="$workOrder" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="relative z-10 py-16 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12 initial-fade-in initial-stagger-1">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Fitur Unggulan</h2>
                    <p class="text-lg text-gray-600">Mengapa memilih Work Order Tracker kami?</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center initial-fade-in-left initial-stagger-2">
                        <div
                            class="w-16 h-16 bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Real-time Tracking</h3>
                        <p class="text-gray-600">Monitor progress work order secara real-time dengan update status yang
                            akurat</p>
                    </div>

                    <div class="text-center initial-fade-in initial-stagger-3">
                        <div
                            class="w-16 h-16 bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Efisien & Produktif</h3>
                        <p class="text-gray-600">Optimalkan workflow produksi dengan sistem yang mudah digunakan</p>
                    </div>

                    <div class="text-center initial-fade-in-right initial-stagger-4">
                        <div
                            class="w-16 h-16 bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Keamanan Data</h3>
                        <p class="text-gray-600">Data work order tersimpan aman dengan sistem backup dan enkripsi</p>
                    </div>
                </div>
            </div>
        </div>

        <script>
            window.woMonthlyData = @json($monthlyWoAccepted ?? []);
        </script>
        <script>
            function initPublicCharts() {
                console.log('[Chart Debug] Public charts init called');
                // Wait for Chart.js to be available
                if (!window.Chart) {
                    console.log('[Chart Debug] Chart not available, retrying in 100ms');
                    setTimeout(initPublicCharts, 100);
                    return;
                }
                console.log('[Chart Debug] Chart available, registering components');

                // Register required components for donut and line charts
                if (window.Chart.register) {
                    try {
                        window.Chart.register(
                            window.Chart.CategoryScale,
                            window.Chart.LinearScale,
                            window.Chart.LineElement,
                            window.Chart.PointElement,
                            window.Chart.Filler,
                            window.Chart.LineController,
                            window.Chart.BarController,
                            window.Chart.DoughnutController
                        );
                        console.log('[Chart Debug] Chart components registered successfully');
                    } catch (e) {
                        console.log('[Chart Debug] Component registration error:', e);
                    }
                }
                // DONUT CHART
                const ctx = document.getElementById('woDonutChart');
                if (!ctx) {
                    console.log('[Chart Debug] Donut chart canvas not found');
                    return;
                }
                console.log('[Chart Debug] Donut chart canvas found, creating chart');

                const dataValues = [
                    {{ (int) ($pendingWorkOrders ?? 0) }},
                    {{ (int) ($completedWorkOrders ?? 0) }},
                    {{ (int) ($overdueWorkOrders ?? 0) }},
                    {{ (int) ($totalWorkOrders ?? 0) }}
                ];

                // Avoid zero-all chart (no data) by short-circuit
                const hasData = dataValues.some(v => v > 0);

                // Segment value labels removed as requested

                // eslint-disable-next-line no-new
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Pending', 'Completed', 'Overdue', 'Total'],
                        datasets: [{
                            data: hasData ? dataValues : [1, 1, 1, 1],
                            backgroundColor: [
                                'rgba(251, 191, 36, 0.9)', // yellow-500 for Pending
                                'rgba(34, 197, 94, 0.9)', // green-500 for Completed
                                'rgba(239, 68, 68, 0.9)', // red-500 for Overdue
                                'rgba(59, 130, 246, 0.9)' // blue-500 for Total
                            ],
                            borderWidth: 0,
                            hoverBorderWidth: 3,
                            hoverBorderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true,
                                    font: {
                                        size: 12,
                                        weight: '500'
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.parsed || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                        return label + ': ' + value + ' (' + percentage + '%)';
                                    }
                                }
                            }
                        },
                        animation: {
                            duration: 900,
                            easing: 'easeOutQuart'
                        }
                    }
                });

                // MONTHLY LINE AREA CHART (WO diterima pada progress tracking)
                const monthlyEl = document.getElementById('woMonthlyChart');
                if (monthlyEl) {
                    const now = new Date();
                    const currentYear = now.getFullYear();
                    const monthNamesID = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
                        'September', 'Oktober', 'November', 'Desember'
                    ];
                    const labels = monthNamesID; // full-year
                    const yearSpan = document.getElementById('woYear');
                    if (yearSpan) yearSpan.textContent = currentYear;

                    // Prefer injected data: array of 12 angka untuk tahun berjalan
                    let injected = (window.woMonthlyData && Array.isArray(window.woMonthlyData)) ? window.woMonthlyData : null;
                    if (injected && injected.length !== 12) {
                        // pad/trim to 12
                        injected = [...injected, ...new Array(12).fill(0)].slice(0, 12);
                    }
                    const monthlyData = injected || [0, 0, 0, 0, 0, 0, 7, 6, 1, 0, 0, 0];

                    const mCtx = monthlyEl.getContext('2d');
                    const gradient = mCtx.createLinearGradient(0, 0, 0, monthlyEl.height);
                    gradient.addColorStop(0, 'rgba(37, 99, 235, 0.20)'); // blue-600 top
                    gradient.addColorStop(1, 'rgba(255, 255, 255, 0.0)'); // fade to transparent

                    // eslint-disable-next-line no-new
                    new Chart(monthlyEl, {
                        type: 'line',
                        data: {
                            labels,
                            datasets: [{
                                label: 'Total WO',
                                data: monthlyData,
                                borderColor: 'rgba(37, 99, 235, 0.9)', // blue line
                                backgroundColor: gradient,
                                tension: 0.35,
                                pointRadius: 3,
                                pointHoverRadius: 5,
                                pointBackgroundColor: '#ffffff',
                                pointBorderColor: 'rgba(37, 99, 235, 1)',
                                fill: true,
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                x: {
                                    grid: {
                                        color: 'rgba(0,0,0,0.04)'
                                    },
                                    ticks: {
                                        color: '#4b5563',
                                        font: {
                                            size: 12
                                        }
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(0,0,0,0.06)'
                                    },
                                    ticks: {
                                        color: '#6b7280',
                                        stepSize: 1
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return context.formattedValue + ' WO';
                                        }
                                    }
                                }
                            },
                            animation: {
                                duration: 900,
                                easing: 'easeOutQuart'
                            }
                        }
                    });
                }
            }

            // Initialize charts when DOM is ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initPublicCharts);
            } else {
                initPublicCharts();
            }
        </script>
    </div>
@endsection
