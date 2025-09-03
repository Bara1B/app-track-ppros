@extends('layouts.app')

@push('styles')
    @vite('resources/css/tracking-enhanced.css')
    @vite('resources/css/tracking-icons-fix.css')
    <style>
        /* Ensure notification doesn't overlap header */
        #notification {
            top: 6rem !important;
        }

        /* Enhanced header styling */
        .header-gradient {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 25%, #1d4ed8 75%, #312e81 100%);
        }

        /* Smooth transitions for all elements */
        * {
            transition: all 0.2s ease-in-out;
        }

        /* Fix gap error with flow-root and proper spacing */
        .flow-root {
            overflow: visible !important;
            /* Allow icons to show fully */
        }

        /* Fix tracking icon visibility issues */
        .tracking-item {
            margin-bottom: 2rem;
            position: relative;
            overflow: visible !important;
            /* Ensure icons don't get clipped */
        }

        .tracking-item:last-child {
            margin-bottom: 0;
        }

        /* Icon container - highest z-index to always stay on top */
        .tracking-item .relative.z-30 {
            z-index: 100 !important;
            position: relative !important;
            width: 48px;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        /* Status icon - force to highest layer */
        .tracking-item .status-icon {
            z-index: 101 !important;
            position: relative !important;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15) !important;
        }

        /* Content card - lower z-index to stay behind icon */
        .tracking-item .status-content {
            z-index: 1 !important;
            position: relative;
            margin-left: 0;
            /* Remove negative margin that clips icon */
            padding-left: 0;
            /* Remove compensation padding */
        }

        /* Timeline line - lowest z-index */
        .timeline-line {
            z-index: 0 !important;
            left: 87px !important;
            /* Adjust for new padding (64px + 23px) */
        }

        /* Ensure flex containers don't interfere */
        .tracking-item .relative.flex.items-start {
            position: relative;
        }

        /* Override any conflicting styles */
        .tracking-item .min-w-0.flex-1.relative.z-10 {
            z-index: 1 !important;
        }

        /* Force icon visibility with maximum specificity */
        div[data-status-id] {
            z-index: 2000 !important;
            position: relative !important;
        }

        /* Prevent any elements from covering icons */
        .status-content {
            z-index: 1 !important;
            transform: translateZ(0);
        }

        /* Ensure parent containers don't interfere */
        .tracking-item .relative.flex.items-start>div:first-child {
            z-index: 2001 !important;
        }

        /* Ultra-specific CSS to force icon visibility */
        .tracking-item div[data-status-id="148"],
        .tracking-item div[data-status-id="149"],
        .tracking-item div[data-status-id="150"],
        .tracking-item div[data-status-id="151"],
        .tracking-item div[data-status-id="152"],
        .tracking-item div[data-status-id="153"],
        .tracking-item div[data-status-id="154"] {
            z-index: 99999 !important;
            position: relative !important;
            background: white !important;
        }

        /* Force icon containers to highest layer */
        .tracking-item .relative.z-30.flex-shrink-0 {
            z-index: 99998 !important;
            position: relative !important;
            isolation: isolate;
        }

        /* Ensure content cards are behind */
        .tracking-item .status-content {
            z-index: 1 !important;
            position: relative !important;
            isolation: isolate;
        }

        /* ULTIMATE FIX - Maximum specificity for icon visibility */
        html body .tracking-item .relative.z-30.flex-shrink-0 .status-icon {
            z-index: 2147483647 !important;
            /* Maximum z-index value */
            position: relative !important;
            display: flex !important;
            isolation: isolate !important;
            transform: translateZ(999px) !important;
        }

        /* Force all icon containers to highest layer */
        html body .tracking-item .relative.z-30.flex-shrink-0 {
            z-index: 2147483646 !important;
            position: relative !important;
            isolation: isolate !important;
            transform: translateZ(998px) !important;
        }

        /* All content must be behind */
        html body .tracking-item .min-w-0.flex-1,
        html body .tracking-item .status-content {
            z-index: 1 !important;
            transform: translateZ(0) !important;
        }

        /* Specific targeting by data attributes */
        html body div[data-status-id] {
            z-index: 2147483647 !important;
            position: relative !important;
            transform: translateZ(999px) !important;
        }

        /* Ensure icons are fully visible and not clipped */
        .status-icon {
            width: 48px !important;
            height: 48px !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            position: relative !important;
            z-index: 999999 !important;
            flex-shrink: 0 !important;
            overflow: visible !important;
        }

        /* Force parent containers to not clip */
        .tracking-item,
        .tracking-item>div,
        .tracking-item .relative.flex.items-start {
            overflow: visible !important;
        }
    </style>
@endpush

@section('content')
    <div class="min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>



            <!-- Work Order Header -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 mb-8 overflow-hidden">
                <!-- Header dengan gradient modern -->
                <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 px-8 py-8">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                        <div class="flex-1">
                            <!-- Badge WO Diterima -->
                            <div
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 mb-3">
                                <div class="w-3 h-3 mr-1 bg-green-600 rounded-full flex items-center justify-center">
                                    <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                WO Diterima
                            </div>

                            <!-- Work Order Number -->
                            <h1 class="text-3xl font-bold text-white mb-2 leading-tight">
                                {{ $workOrder->wo_number ?? 'N/A' }}
                            </h1>

                            <!-- Product Info -->
                            <div class="flex items-center text-blue-100 text-lg">
                                <div class="w-5 h-5 mr-2 bg-blue-500 rounded flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="font-medium">{{ $workOrder->output }}</span>
                            </div>
                        </div>

                        <!-- Due Date Card -->
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                            <div class="text-sm text-blue-100 mb-1 font-medium">Target Selesai</div>
                            <div class="text-xl font-bold text-white flex items-center">
                                <div class="w-5 h-5 mr-2 bg-white/20 rounded flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                {{ $workOrder->due_date->translatedFormat('d M Y') }}
                            </div>
                            <div class="text-xs text-blue-200 mt-1">
                                {{ $workOrder->due_date->translatedFormat('l') }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Info Bar -->
                <div class="px-8 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-t border-blue-100">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-sm text-blue-800">
                            <div class="w-4 h-4 mr-2 bg-blue-600 rounded-full flex items-center justify-center">
                                <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="font-medium">Status tracking diperbarui secara real-time</span>
                        </div>
                        <div class="flex items-center text-xs text-blue-600 bg-blue-100 px-3 py-1 rounded-full">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-2 animate-pulse"></div>
                            Live Update
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Tracking -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 bg-gradient-to-r from-gray-50 to-blue-50 border-b border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center mb-2">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        Progres Pelacakan Work Order
                    </h2>
                    <p class="text-gray-600 font-medium">Lacak setiap tahapan produksi dan update status sesuai progress</p>
                </div>

                <div class="p-8" style="overflow: visible !important; padding-left: 4rem !important;">
                    @php
                        $stepsWithNotes = ['Selesai Timbang', 'Potong Stock', 'Released', 'Kirim BB', 'Kirim CPB/WO'];
                    @endphp

                    <div class="flow-root">
                        @foreach ($workOrder->tracking as $status)
                            <div id="track-{{ $status->id }}" class="relative tracking-item">
                                <!-- Timeline Line -->
                                @if (!$loop->last)
                                    <span
                                        class="timeline-line absolute left-6 top-20 w-0.5 h-16 bg-gradient-to-b from-gray-300 to-gray-200 z-0"
                                        aria-hidden="true" style="left: 87px !important;"></span>
                                @endif

                                <div class="relative flex items-start">
                                    <!-- Status Icon -->
                                    <div class="relative z-30 flex-shrink-0"
                                        style="margin-left: 0; z-index: 1000 !important; position: relative !important;">
                                        <div class="status-icon w-12 h-12 rounded-full flex items-center justify-center shadow-lg transition-all duration-300 
                                        @if ($status->completed_at) bg-gradient-to-br from-green-500 to-green-600 border-2 border-green-400
                                        @else 
                                            bg-gradient-to-br from-gray-200 to-gray-300 border-2 border-gray-400 @endif"
                                            data-status-id="{{ $status->id }}"
                                            style="z-index: 1001 !important; position: relative !important; box-shadow: 0 8px 16px rgba(0,0,0,0.2) !important;">
                                            @if ($status->completed_at)
                                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            @else
                                                <svg class="w-6 h-6 text-gray-500" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Status Content -->
                                    <div class="min-w-0 flex-1 relative z-10"
                                        style="margin-left: 1rem; z-index: 1 !important;">
                                        <div class="status-content bg-gray-50 rounded-lg p-4 border border-gray-200"
                                            style="z-index: 1 !important; position: relative !important;">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                                        {{ $status->status_name }}
                                                    </h3>

                                                    <!-- Date Display & Edit Form -->
                                                    <div class="mb-3">
                                                        @if ($status->completed_at)
                                                            <div id="display-date-{{ $status->id }}"
                                                                class="flex items-center space-x-3">
                                                                <div class="flex items-center text-green-600">
                                                                    <div
                                                                        class="w-4 h-4 mr-2 bg-green-500 rounded-full flex items-center justify-center">
                                                                        <svg class="w-2 h-2 text-white"
                                                                            fill="currentColor" viewBox="0 0 20 20">
                                                                            <path fill-rule="evenodd"
                                                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                                clip-rule="evenodd" />
                                                                        </svg>
                                                                    </div>
                                                                    <span class="font-medium status-date">Selesai pada:
                                                                        {{ \Carbon\Carbon::parse($status->completed_at)->translatedFormat('l, d M Y') }}</span>
                                                                </div>
                                                                @if (Auth::user()->role == 'admin')
                                                                    <button
                                                                        class="edit-date-btn inline-flex items-center px-2 py-1 border border-gray-300 rounded-md text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200"
                                                                        data-id="{{ $status->id }}"
                                                                        title="Edit Tanggal & Keterangan">
                                                                        <svg class="w-3 h-3 mr-1" fill="currentColor"
                                                                            viewBox="0 0 20 20">
                                                                            <path
                                                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                                        </svg>
                                                                        Edit
                                                                    </button>
                                                                @endif
                                                            </div>

                                                            @if (Auth::user()->role == 'admin')
                                                                <form id="edit-form-{{ $status->id }}"
                                                                    action="{{ route('work-orders.tracking.update-date', $status) }}"
                                                                    method="POST"
                                                                    class="hidden mt-3 p-4 bg-white rounded-lg border border-gray-200 shadow-sm"
                                                                    onsubmit="VerificationManager.handleSubmit(event, this)">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                        <div>
                                                                            <label
                                                                                class="block text-sm font-medium text-gray-700 mb-1">Tanggal:</label>
                                                                            <input type="date" name="completed_date"
                                                                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                                                                value="{{ \Carbon\Carbon::parse($status->completed_at)->format('Y-m-d') }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="md:col-span-2">
                                                                            <label
                                                                                class="block text-sm font-medium text-gray-700 mb-1">Keterangan:</label>
                                                                            <input type="text" name="notes"
                                                                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                                                                value="{{ $status->notes }}"
                                                                                placeholder="Tambahkan keterangan...">
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex space-x-2 mt-4">
                                                                        <button type="submit"
                                                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                                                            <svg class="w-4 h-4 mr-2" fill="currentColor"
                                                                                viewBox="0 0 20 20">
                                                                                <path fill-rule="evenodd"
                                                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                                    clip-rule="evenodd" />
                                                                            </svg>
                                                                            Simpan
                                                                        </button>
                                                                        <button type="button"
                                                                            class="cancel-edit-btn inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200"
                                                                            data-id="{{ $status->id }}">
                                                                            Batal
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            @endif
                                                        @else
                                                            <div class="flex items-center text-gray-500">
                                                                <div
                                                                    class="w-4 h-4 mr-2 bg-gray-400 rounded-full flex items-center justify-center">
                                                                    <svg class="w-2 h-2 text-white" fill="currentColor"
                                                                        viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd"
                                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                                            clip-rule="evenodd" />
                                                                    </svg>
                                                                </div>
                                                                <span class="font-medium">Menunggu proses...</span>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    @if ($status->notes)
                                                        <div
                                                            class="bg-blue-50 border border-blue-200 rounded-md p-3 status-notes">
                                                            <div class="flex">
                                                                <div class="flex-shrink-0">
                                                                    <svg class="h-4 w-4 text-blue-400" viewBox="0 0 20 20"
                                                                        fill="currentColor">
                                                                        <path fill-rule="evenodd"
                                                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                                            clip-rule="evenodd" />
                                                                    </svg>
                                                                </div>
                                                                <div class="ml-3">
                                                                    <p class="text-sm text-blue-800">
                                                                        <span class="font-medium">Catatan:</span>
                                                                        {{ $status->notes }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Action Buttons -->
                                                <div class="ml-4 flex-shrink-0">
                                                    @if (!$status->completed_at)
                                                        <form method="POST"
                                                            action="{{ route('work-orders.tracking.complete', $status) }}"
                                                            class="space-y-3"
                                                            onsubmit="VerificationManager.handleSubmit(event, this)">
                                                            @csrf
                                                            <div class="flex flex-col space-y-2">
                                                                <input type="date" name="completed_date"
                                                                    class="px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                                                    value="{{ date('Y-m-d') }}" required>
                                                                @if (in_array($status->status_name, $stepsWithNotes))
                                                                    <input type="text" name="notes"
                                                                        class="px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                                                        placeholder="Tambah keterangan...">
                                                                @endif
                                                                <button type="submit"
                                                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200 shadow-sm">
                                                                    <svg class="w-4 h-4 mr-2" fill="currentColor"
                                                                        viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd"
                                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                            clip-rule="evenodd" />
                                                                    </svg>
                                                                    Selesai
                                                                </button>
                                                            </div>
                                                        </form>
                                                    @else
                                                        <div
                                                            class="inline-flex items-center px-3 py-2 border border-green-200 rounded-md text-sm font-medium text-green-800 bg-green-100">
                                                            <svg class="w-4 h-4 mr-2" fill="currentColor"
                                                                viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd"
                                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            Sudah Selesai
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const editDateButtons = document.querySelectorAll('.edit-date-btn');
                const cancelEditButtons = document.querySelectorAll('.cancel-edit-btn');

                editDateButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.dataset.id;
                        document.getElementById('display-date-' + id).classList.add('hidden');
                        document.getElementById('edit-form-' + id).classList.remove('hidden');
                    });
                });

                cancelEditButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.dataset.id;
                        document.getElementById('display-date-' + id).classList.remove('hidden');
                        document.getElementById('edit-form-' + id).classList.add('hidden');
                    });
                });
            });

            // Verification is now handled by VerificationManager
        </script>
    @endpush
@endsection
