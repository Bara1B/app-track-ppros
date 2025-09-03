@extends('layouts.public')

@section('content')
    <div class="relative min-h-screen bg-gradient-to-br from-blue-50 via-white to-green-50">
        <!-- Header Section -->
        <div class="relative z-10 pt-16 pb-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">Progress Tracking</h1>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Monitor progress dan status Work Order secara detail.
                        <span class="font-semibold text-blue-600">Hanya untuk informasi, tidak bisa diedit.</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Work Order Details -->
        <div class="relative z-10 pb-16 px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <!-- Work Order Info Card -->
                <x-tracking-progress-card :workOrder="$workOrder" />

                <!-- Progress Overview -->
                @if ($workOrder->tracking && $workOrder->tracking->count() > 0)
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg border border-gray-200 mb-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Progress Overview</h3>

                        @php
                            $totalSteps = $workOrder->tracking->count();
                            $completedSteps = $workOrder->tracking->where('completed_at', '!=', null)->count();
                            $progressPercentage = $totalSteps > 0 ? ($completedSteps / $totalSteps) * 100 : 0;
                        @endphp

                        <div class="mb-4">
                            <div class="flex items-center justify-between text-sm text-gray-600 mb-2">
                                <span>Overall Progress</span>
                                <span>{{ $completedSteps }}/{{ $totalSteps }} steps completed</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r from-blue-500 to-green-500 h-3 rounded-full transition-all duration-500"
                                    style="width: {{ $progressPercentage }}%"></div>
                            </div>
                            <div class="text-center mt-2">
                                <span
                                    class="text-2xl font-bold text-gray-900">{{ number_format($progressPercentage, 1) }}%</span>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Tracking Steps -->
                @if ($workOrder->tracking && $workOrder->tracking->count() > 0)
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 shadow-lg border border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900 mb-8 text-center">Tracking Steps</h3>

                        <!-- Horizontal Progress Line -->
                        <div class="relative mb-12">
                            <div class="flex items-center justify-between relative">
                                @php
                                    $sortedTracking = $workOrder->tracking->sortBy('sequence');
                                    $totalSteps = $sortedTracking->count();
                                @endphp

                                @foreach ($sortedTracking as $index => $tracking)
                                    <div class="relative flex flex-col items-center" style="flex: 1;">
                                        <!-- Step Circle -->
                                        <div
                                            class="relative z-10 w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 shadow-lg
                                            @if ($tracking->completed_at) bg-gradient-to-br from-green-400 to-green-600 text-white transform scale-110
                                            @elseif($tracking->started_at) 
                                                bg-gradient-to-br from-blue-400 to-blue-600 text-white
                                            @else 
                                                bg-gradient-to-br from-gray-300 to-gray-400 text-gray-600 @endif">

                                            @if ($tracking->completed_at)
                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            @elseif($tracking->started_at)
                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            @else
                                                <div class="w-3 h-3 bg-current rounded-full"></div>
                                            @endif
                                        </div>

                                        <!-- Step Label -->
                                        <div class="mt-4 text-center">
                                            <p class="text-sm font-semibold text-gray-900 mb-1">
                                                Level {{ $index + 1 }}
                                            </p>
                                            <p class="text-xs text-gray-600 max-w-20 leading-tight">
                                                {{ $tracking->status_name }}
                                            </p>
                                            @if ($tracking->completed_at)
                                                <div class="mt-2">
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Completed
                                                    </span>
                                                </div>
                                            @elseif($tracking->started_at)
                                                <div class="mt-2">
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        In Progress
                                                    </span>
                                                </div>
                                            @else
                                                <div class="mt-2">
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        Pending
                                                    </span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Connecting Line (except for last item) -->
                                        @if ($index < $totalSteps - 1)
                                            <div class="absolute top-6 left-1/2 w-full h-1 -translate-y-1/2 z-0"
                                                style="margin-left: 24px; width: calc(100% - 48px);">
                                                @php
                                                    $nextStep = $sortedTracking->skip($index + 1)->first();
                                                    $bothCompleted =
                                                        $tracking->completed_at && $nextStep && $nextStep->completed_at;
                                                @endphp
                                                <div
                                                    class="h-full rounded-full transition-all duration-500
                                                    @if ($bothCompleted) bg-gradient-to-r from-green-400 to-green-500
                                                    @elseif($tracking->completed_at)
                                                        bg-gradient-to-r from-green-400 to-gray-300
                                                    @else
                                                        bg-gray-300 @endif">
                                                </div>
                                            </div>
                                        @endif
                                @endforeach
                            </div>
                        </div>

                        <!-- Detailed Step Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($sortedTracking as $tracking)
                                <div
                                    class="bg-gray-50 rounded-xl p-4 border border-gray-200 hover:shadow-md transition-shadow">
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="font-semibold text-gray-900 text-sm">
                                            {{ $tracking->status_name }}
                                        </h4>
                                        <div
                                            class="w-6 h-6 rounded-full flex items-center justify-center
                                            @if ($tracking->completed_at) bg-green-500 text-white
                                            @elseif($tracking->started_at) bg-blue-500 text-white
                                            @else bg-gray-300 text-gray-600 @endif">
                                            @if ($tracking->completed_at)
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            @else
                                                <div class="w-2 h-2 bg-current rounded-full"></div>
                                            @endif
                                        </div>
                                    </div>

                                    @if ($tracking->completed_at)
                                        <p class="text-xs text-gray-600 mb-2">
                                            <span class="font-medium">Completed:</span><br>
                                            {{ \Carbon\Carbon::parse($tracking->completed_at)->format('d M Y H:i') }}
                                        </p>
                                    @endif

                                    @if ($tracking->notes)
                                        <p class="text-xs text-blue-700 bg-blue-50 p-2 rounded">
                                            <span class="font-medium">Notes:</span> {{ $tracking->notes }}
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <!-- No Tracking Data -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-12 shadow-lg border border-gray-200 text-center">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada Tracking Data</h3>
                        <p class="text-gray-600 mb-6">Tracking steps akan muncul di sini setelah admin menambahkannya</p>
                    </div>
                @endif

                <!-- Navigation Buttons -->
                <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('public.work-orders') }}"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-blue-600 bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        Lihat Semua Work Orders
                    </a>
                    <a href="{{ route('public.home') }}"
                        class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7m7 7l7-7m-7 7l-2 2m0 0l-7 7m7-7l-7 7"></path>
                        </svg>
                        Kembali ke Home
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
