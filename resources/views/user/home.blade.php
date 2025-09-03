@extends('layouts.user-app')

@push('styles')
    @vite('resources/css/user-home.css')
@endpush

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-cyan-50 to-teal-50">
        <!-- Hero Section dengan Tema Farmasi -->
        <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-cyan-600 to-teal-600">
            <!-- Background Pattern - Pills & Medical Icons -->
            <div class="absolute inset-0 opacity-10">
                <!-- Floating Pills -->
                <div class="absolute top-20 left-10 w-8 h-4 bg-white rounded-full transform rotate-45 animate-pulse"></div>
                <div class="absolute top-40 right-20 w-6 h-6 bg-white rounded-full animate-bounce"></div>
                <div class="absolute bottom-20 left-1/4 w-4 h-8 bg-white rounded-full transform -rotate-12 animate-pulse">
                </div>
                <div class="absolute top-1/3 right-1/3 w-5 h-5 bg-white rounded-full animate-ping"></div>

                <!-- Medical Crosses -->
                <div class="absolute top-1/4 left-1/3 w-6 h-6 text-white opacity-20">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                    </svg>
                </div>
                <div class="absolute bottom-1/4 right-1/4 w-8 h-8 text-white opacity-20">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                    </svg>
                </div>
            </div>

            <div class="max-w-7xl mx-auto relative z-10">
                <div class="relative z-10 pb-8 sm:pb-16 md:pb-20 lg:pb-28 xl:pb-32">
                    <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                        <div class="sm:text-center lg:text-left">
                            <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                                <span class="block xl:inline">Selamat Datang di</span>
                                <span class="block text-yellow-300 xl:inline">Pharmaceutical Tracker</span>
                            </h1>
                            <p
                                class="mt-3 text-base text-blue-100 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                                Kelola dan pantau progress produksi obat-obatan dengan sistem tracking yang terintegrasi.
                                Pastikan setiap batch obat diproduksi dengan standar kualitas tertinggi.
                            </p>
                            <div
                                class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start space-y-3 sm:space-y-0 sm:space-x-3">
                                <a href="{{ route('dashboard') }}"
                                    class="w-full sm:w-auto flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-blue-600 bg-yellow-300 hover:bg-yellow-400 md:py-4 md:text-lg md:px-10 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    💊 Lihat Work Order
                                </a>
                                <a href="{{ route('work-order.show', $latestWorkOrder ?? 1) }}"
                                    class="w-full sm:w-auto flex items-center justify-center px-8 py-3 border border-yellow-300 text-base font-medium rounded-lg text-yellow-300 hover:bg-yellow-300 hover:text-blue-600 md:py-4 md:text-lg md:px-10 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-1">
                                    🔬 Mulai Tracking
                                </a>
                            </div>
                        </div>
                    </main>
                </div>
            </div>

            <!-- Right Side Visual - Medical Theme -->
            <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
                <div
                    class="h-56 w-full bg-gradient-to-br from-cyan-500 via-blue-600 to-indigo-700 sm:h-72 md:h-96 lg:w-full lg:h-full flex items-center justify-center relative overflow-hidden">
                    <!-- Medical Background Pattern -->
                    <div class="absolute inset-0 opacity-20">
                        <!-- DNA Helix Pattern -->
                        <div class="absolute top-0 left-0 w-full h-full">
                            <div class="absolute top-10 left-1/4 w-1 h-20 bg-white transform rotate-45"></div>
                            <div class="absolute top-20 left-1/3 w-1 h-16 bg-white transform -rotate-45"></div>
                            <div class="absolute top-30 left-1/2 w-1 h-18 bg-white transform rotate-45"></div>
                            <div class="absolute top-40 left-2/3 w-1 h-14 bg-white transform -rotate-45"></div>
                        </div>

                        <!-- Microscope Pattern -->
                        <div class="absolute bottom-10 right-10 w-16 h-16 border-2 border-white rounded-full opacity-30">
                        </div>
                        <div class="absolute bottom-20 right-20 w-8 h-8 border border-white rounded-full opacity-40"></div>
                    </div>

                    <!-- Main Medical Content -->
                    <div class="text-white text-center p-8 relative z-10">
                        <div
                            class="w-24 h-24 mx-auto mb-6 bg-white bg-opacity-20 rounded-full flex items-center justify-center backdrop-blur-sm border border-white border-opacity-30">
                            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Quality Control</h3>
                        <p class="text-base opacity-90">Safe • Effective • Reliable</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats Section dengan Tema Farmasi -->
        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase mb-2">Production Overview</h2>
                    <p class="text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Status Produksi Obat
                    </p>
                    <p class="mt-3 text-lg text-gray-500 max-w-2xl mx-auto">
                        Pantau progress dan status produksi obat secara real-time
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <!-- Total Work Orders -->
                    <div
                        class="bg-gradient-to-br from-blue-50 to-blue-100 overflow-hidden shadow-lg rounded-xl border border-blue-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <dt class="text-sm font-medium text-blue-600 truncate">Total Batch</dt>
                                    <dd class="text-2xl font-bold text-blue-900">{{ $totalWorkOrders ?? 0 }}</dd>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- On Progress -->
                    <div
                        class="bg-gradient-to-br from-yellow-50 to-orange-100 overflow-hidden shadow-lg rounded-xl border border-yellow-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center shadow-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <dt class="text-sm font-medium text-yellow-600 truncate">Dalam Produksi</dt>
                                    <dd class="text-2xl font-bold text-yellow-900">{{ $pendingWorkOrders ?? 0 }}</dd>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Completed -->
                    <div
                        class="bg-gradient-to-br from-green-50 to-emerald-100 overflow-hidden shadow-lg rounded-xl border border-green-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <dt class="text-sm font-medium text-green-600 truncate">Selesai QC</dt>
                                    <dd class="text-2xl font-bold text-green-900">{{ $completedWorkOrders ?? 0 }}</dd>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Overdue -->
                    <div
                        class="bg-gradient-to-br from-red-50 to-pink-100 overflow-hidden shadow-lg rounded-xl border border-red-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-red-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <dt class="text-sm font-medium text-red-600 truncate">Melewati Deadline</dt>
                                    <dd class="text-2xl font-bold text-red-900">{{ $overdueWorkOrders ?? 0 }}</dd>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Work Orders Section dengan Tema Farmasi -->
        <div class="py-16 bg-gradient-to-br from-cyan-50 to-blue-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase mb-2">Recent Activity</h2>
                    <p class="text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Batch Produksi Terbaru
                    </p>
                    <p class="mt-3 text-lg text-gray-500 max-w-2xl mx-auto">
                        Lihat progress produksi obat yang sedang berlangsung
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 xl:grid-cols-3">
                    @forelse($recentWorkOrders ?? [] as $wo)
                        <div
                            class="bg-white overflow-hidden shadow-lg rounded-xl hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-blue-100">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg">
                                                <span
                                                    class="text-white font-bold text-lg">{{ substr($wo->wo_number, 0, 2) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-900">{{ $wo->wo_number }}</p>
                                            <p class="text-sm text-gray-500">{{ $wo->output }}</p>
                                        </div>
                                    </div>
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                        Active
                                    </span>
                                </div>

                                <div class="mb-4 space-y-2">
                                    <div class="flex justify-between text-sm text-gray-600">
                                        <span>Due Date:</span>
                                        <span class="font-medium">{{ $wo->due_date->format('d M Y') }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm text-gray-600">
                                        <span>Progress:</span>
                                        <span class="font-medium">
                                            @php
                                                $totalSteps = $wo->tracking->count();
                                                $completedSteps = $wo->tracking->whereNotNull('completed_at')->count();
                                                $progress = $totalSteps > 0 ? ($completedSteps / $totalSteps) * 100 : 0;
                                            @endphp
                                            {{ $completedSteps }}/{{ $totalSteps }}
                                        </span>
                                    </div>
                                </div>

                                <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
                                    <div class="bg-gradient-to-r from-blue-500 to-cyan-600 h-2 rounded-full transition-all duration-300"
                                        style="width: {{ $progress }}%"></div>
                                </div>

                                <div class="flex space-x-2">
                                    <a href="{{ route('work-order.show', $wo) }}"
                                        class="flex-1 bg-gradient-to-r from-blue-600 to-cyan-600 text-white text-center py-2 px-4 rounded-lg text-sm font-medium hover:from-blue-700 hover:to-cyan-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                        Track Progress
                                    </a>
                                    <a href="{{ route('dashboard') }}"
                                        class="bg-gray-100 text-gray-700 py-2 px-4 rounded-lg text-sm font-medium hover:bg-gray-200 transition-all duration-200 border border-gray-200">
                                        View All
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="text-center py-12">
                                <div
                                    class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-blue-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada batch produksi</h3>
                                <p class="text-gray-500 mb-6">Mulai dengan membuat work order baru</p>
                                <a href="{{ route('dashboard') }}"
                                    class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition-all duration-200">
                                    Lihat Dashboard
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Quick Actions Section dengan Tema Farmasi -->
        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase mb-2">Quick Actions</h2>
                    <p class="text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Mulai Produksi Sekarang
                    </p>
                    <p class="mt-3 text-lg text-gray-500 max-w-2xl mx-auto">
                        Akses cepat ke fitur-fitur utama aplikasi produksi
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Track Production -->
                    <div class="relative group">
                        <div
                            class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-1000 group-hover:duration-200">
                        </div>
                        <div
                            class="relative bg-white p-8 rounded-2xl shadow-lg border border-blue-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-blue-100 to-cyan-100 rounded-2xl flex items-center justify-center mb-6">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Track Production</h3>
                            <p class="text-gray-600 mb-6 leading-relaxed">Pantau kemajuan produksi obat dan update status
                                setiap tahapan dengan mudah.</p>
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold group-hover:text-blue-700 transition-colors duration-200">
                                Mulai Tracking
                                <svg class="ml-2 w-5 h-5 transform group-hover:translate-x-1 transition-transform duration-200"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Quality Reports -->
                    <div class="relative group">
                        <div
                            class="absolute -inset-1 bg-gradient-to-r from-green-600 to-teal-600 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-1000 group-hover:duration-200">
                        </div>
                        <div
                            class="relative bg-white p-8 rounded-2xl shadow-lg border border-green-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-green-100 to-teal-100 rounded-2xl flex items-center justify-center mb-6">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Quality Reports</h3>
                            <p class="text-gray-600 mb-6 leading-relaxed">Lihat laporan quality control dan analisis
                                performa produksi obat dengan visualisasi yang informatif.</p>
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center text-green-600 hover:text-green-700 font-semibold group-hover:text-green-700 transition-colors duration-200">
                                Lihat Laporan
                                <svg class="ml-2 w-5 h-5 transform group-hover:translate-x-1 transition-transform duration-200"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Manage Production -->
                    <div class="relative group">
                        <div
                            class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-1000 group-hover:duration-200">
                        </div>
                        <div
                            class="relative bg-white p-8 rounded-2xl shadow-lg border border-purple-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-purple-100 to-pink-100 rounded-2xl flex items-center justify-center mb-6">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Manage Production</h3>
                            <p class="text-gray-600 mb-6 leading-relaxed">Kelola dan atur prioritas produksi obat dengan
                                sistem yang terorganisir dan terstandar.</p>
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center text-purple-600 hover:text-purple-700 font-semibold group-hover:text-purple-700 transition-colors duration-200">
                                Kelola Produksi
                                <svg class="ml-2 w-5 h-5 transform group-hover:translate-x-1 transition-transform duration-200"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
