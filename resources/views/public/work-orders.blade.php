@extends('layouts.public')

@section('content')
    <div class="relative min-h-screen bg-gradient-to-br from-blue-50 via-white to-green-50">
        <!-- Header Section -->
        <div class="relative z-10 pt-16 pb-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">Daftar Work Orders</h1>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Monitor progress dan status semua Work Order secara real-time.
                        <span class="font-semibold text-blue-600">Hanya untuk informasi, tidak bisa diedit.</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Work Orders List -->
        <div class="relative z-10 pb-16 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                @if ($workOrders->count() > 0)
                    <!-- Filters & Search -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg border border-gray-200 mb-8">
                        <form method="GET" action="{{ route('public.work-orders') }}" class="space-y-6">
                            <!-- Search Bar -->
                            <div class="flex flex-col md:flex-row gap-4">
                                <div class="flex-1">
                                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari Work
                                        Order</label>
                                    <div class="relative">
                                        <input type="text" name="search" id="search"
                                            value="{{ $filters['search'] ?? '' }}"
                                            placeholder="Cari berdasarkan WO Number, Output, atau ID Number..."
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Filter Options -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <!-- Status Filter -->
                                <div>
                                    <label for="status"
                                        class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                    <select name="status" id="status"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="all"
                                            {{ ($filters['status'] ?? 'all') === 'all' ? 'selected' : '' }}>Semua Status
                                        </option>
                                        @foreach ($statusOptions as $status)
                                            <option value="{{ $status }}"
                                                {{ ($filters['status'] ?? '') === $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Completion Status Filter -->
                                <div>
                                    <label for="completion_status"
                                        class="block text-sm font-medium text-gray-700 mb-2">Status Penyelesaian</label>
                                    <select name="completion_status" id="completion_status"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value=""
                                            {{ ($filters['completion_status'] ?? '') === '' ? 'selected' : '' }}>Semua
                                        </option>
                                        <option value="completed"
                                            {{ ($filters['completion_status'] ?? '') === 'completed' ? 'selected' : '' }}>
                                            Selesai</option>
                                        <option value="pending"
                                            {{ ($filters['completion_status'] ?? '') === 'pending' ? 'selected' : '' }}>
                                            Dalam Proses</option>
                                    </select>
                                </div>

                                <!-- Due Date From -->
                                <div>
                                    <label for="due_date_from" class="block text-sm font-medium text-gray-700 mb-2">Due Date
                                        Dari</label>
                                    <input type="date" name="due_date_from" id="due_date_from"
                                        value="{{ $filters['due_date_from'] ?? '' }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <!-- Due Date To -->
                                <div>
                                    <label for="due_date_to" class="block text-sm font-medium text-gray-700 mb-2">Due Date
                                        Sampai</label>
                                    <input type="date" name="due_date_to" id="due_date_to"
                                        value="{{ $filters['due_date_to'] ?? '' }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>

                            <!-- Additional Filters -->
                            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                                <div class="flex items-center space-x-4">
                                    <!-- Overdue Filter -->
                                    <label class="flex items-center">
                                        <input type="checkbox" name="overdue" id="overdue" value="true"
                                            {{ ($filters['overdue'] ?? '') === 'true' ? 'checked' : '' }}
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-700">Hanya yang Overdue</span>
                                    </label>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex items-center space-x-3">
                                    <button type="submit"
                                        class="appearance-none inline-flex items-center px-4 py-2 text-sm leading-5 font-medium rounded-full text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z">
                                            </path>
                                        </svg>
                                        Terapkan Filter
                                    </button>

                                    <a href="{{ route('public.work-orders') }}"
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Reset
                                    </a>
                                </div>
                            </div>
                        </form>

                        <!-- Results Summary -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                                <div class="flex items-center space-x-4">
                                    <div class="text-sm text-gray-600">
                                        <span class="font-medium">Total:</span> {{ $workOrders->total() }} Work Orders
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        <span class="font-medium">Showing:</span> {{ $workOrders->firstItem() ?? 0 }} -
                                        {{ $workOrders->lastItem() ?? 0 }}
                                    </div>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <span class="font-medium">Note:</span> Halaman ini hanya untuk monitoring
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Work Orders Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach ($workOrders as $workOrder)
                            <x-public-work-order-card :workOrder="$workOrder" />
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if ($workOrders->hasPages())
                        <div class="mt-12 flex justify-center">
                            <div class="bg-white/90 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-gray-200/50">
                                @include('vendor.pagination.modern-pagination', [
                                    'paginator' => $workOrders,
                                ])
                            </div>
                        </div>
                    @endif
                @else
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada Work Orders</h3>
                        <p class="text-gray-600 mb-6">Work orders akan muncul di sini setelah admin membuatnya</p>
                        <a href="{{ route('public.home') }}"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-blue-600 bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke Home
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection
