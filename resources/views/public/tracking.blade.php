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

                        <!-- Horizontal Progress Stepper (Design #2) -->
                        <div class="relative mb-12">
                            <!-- Desktop: Horizontal Layout -->
                            <div id="horizontal-tracking" class="horizontal-layout" style="display:flex!important;flex-direction:row!important;align-items:center!important;justify-content:center!important;flex-wrap:nowrap!important;overflow-x:hidden!important;width:100%!important;padding:0 40px!important;">
                                {{-- Styles moved to resources/css/pages/tracking.css --}}

                                <script>
                                    // Force horizontal layout on desktop (run once)
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const container = document.getElementById('horizontal-tracking');
                                        if (container && window.innerWidth >= 768) {
                                            console.log('Horizontal layout applied for', container.querySelectorAll('.step-item').length, 'steps');
                                        }
                                    });
                                </script>

                                @php
                                    $sortedTracking = $workOrder->tracking->sortBy('sequence')->values();
                                    $totalSteps = $sortedTracking->count();
                                    $lastCompletedIndex = -1;
                                    for ($i = 0; $i < $totalSteps; $i++) {
                                        if (!empty($sortedTracking[$i]->completed_at)) {
                                            $lastCompletedIndex = $i;
                                        }
                                    }
                                    $currentIndex = null;
                                    if ($lastCompletedIndex < $totalSteps - 1) {
                                        $currentIndex = $lastCompletedIndex + 1;
                                    }
                                @endphp

                                {{-- Styles moved to resources/css/pages/tracking.css --}}
                                <style>
                                    /* Force horizontal layout immediately (override utilities) */
                                    #horizontal-tracking { display:flex !important; flex-direction:row !important; align-items:center !important; justify-content:center !important; gap:0 !important; flex-wrap:nowrap !important; overflow-x:hidden !important; padding:0 40px !important; }
                                    #horizontal-tracking .icons-row { position:relative !important; display:flex !important; align-items:center !important; justify-content:space-between !important; width:100% !important; max-width:900px !important; padding:0 15px !important; }
                                    #horizontal-tracking .step-item { display:flex !important; flex-direction:column !important; align-items:center !important; flex:1 1 auto !important; min-width:80px !important; margin:0 8px !important; text-align:center !important; flex-shrink:0 !important; }
                                    .hexagon {
                                        width: 48px;
                                        height: 42px;
                                        background: #0ea5e9; /* sky-500 */
                                        clip-path: polygon(25% 6%, 75% 6%, 100% 50%, 75% 94%, 25% 94%, 0% 50%);
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        color: white;
                                        box-shadow: 0 6px 12px rgba(14, 165, 233, 0.45);
                                        position: relative;
                                        animation: pulseHex 2s ease-in-out infinite;
                                    }
                                    @keyframes pulseStep {
                                        0%, 100% { transform: scale(1); box-shadow: 0 4px 12px rgba(59,130,246,0.4); }
                                        50%      { transform: scale(1.05); box-shadow: 0 6px 20px rgba(59,130,246,0.6); }
                                    }
                                </style>

                                <!-- Continuous base and progress lines -->
                                @php
                                    $segments = max(1, $totalSteps - 1);
                                    $progressSegments = max(0, ($currentIndex ?? ($lastCompletedIndex + 1)));
                                    $progressPercent = min(100, max(0, ($progressSegments / $segments) * 100));
                                @endphp

                                <div class="icons-row" style="position:relative;display:flex;align-items:center;justify-content:space-between;padding:0 15px;width:100%;max-width:900px;">
                                    <div class="track-line" style="left:47px;right:47px;"></div>
                                    <div class="track-line-progress" style="left:47px;width: calc((100% - 94px) * {{ number_format($progressPercent, 2, '.', '') }} / 100);"></div>

                                    @for ($i = 0; $i < $totalSteps; $i++)
                                        @php $tracking = $sortedTracking[$i]; @endphp
                                        <div class="step-item">
                                        <!-- Step Icon -->
                                        <div class="relative z-10">
                                            @php
                                                // Map step names to Tailwind/Heroicons SVG classes
                                                $stepConfig = [
                                                    'WO Diterima' => ['icon' => 'clipboard-document-check', 'viewBox' => '0 0 24 24', 'path' => 'M10.125 2.25c-4.56 0-8.25 3.69-8.25 8.25s3.69 8.25 8.25 8.25H18a2.25 2.25 0 002.25-2.25V9.75a8.217 8.217 0 00-2.25-5.5 8.217 8.217 0 00-5.5-2.25H10.125zM12 7.5a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V8.25a.75.75 0 01.75-.75z'],
                                                    'Mulai Timbang' => ['icon' => 'scale', 'viewBox' => '0 0 24 24', 'path' => 'M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75V18a.75.75 0 01-1.5 0v-5.25H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z'],
                                                    'Selesai Timbang' => ['icon' => 'check-badge', 'viewBox' => '0 0 24 24', 'path' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                                                    'Potong Stock' => ['icon' => 'scissors', 'viewBox' => '0 0 24 24', 'path' => 'M7.848 8.25l1.536.887a3.3 3.3 0 003.963-2.842V5.25a2.25 2.25 0 00-4.5 0v1.036c0 .298-.059.593-.171.867l-1.07 2.610-.818-.472a2.25 2.25 0 00-2.25 0l-.818.472 1.07-2.61A3.75 3.75 0 007.848 8.25z'],
                                                    'Released' => ['icon' => 'rocket-launch', 'viewBox' => '0 0 24 24', 'path' => 'M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z'],
                                                    'Kirim BB' => ['icon' => 'truck', 'viewBox' => '0 0 24 24', 'path' => 'M8.25 18.75a1.5 1.5 0 01-3 0 1.5 1.5 0 013 0zM18.75 18.75a1.5 1.5 0 01-3 0 1.5 1.5 0 013 0zM3 4.5h2.25l.75 1.5h11.25c.621 0 1.125.504 1.125 1.125v9c0 .621-.504 1.125-1.125 1.125H6.75l-.75-1.5H3V4.5z'],
                                                    'Kirim CPB/WO' => ['icon' => 'document-arrow-up', 'viewBox' => '0 0 24 24', 'path' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12l-3-3m0 0l-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z']
                                                ];
                                                $config = $stepConfig[$tracking->status_name] ?? ['icon' => 'circle', 'viewBox' => '0 0 24 24', 'path' => 'M21 12a9 9 0 11-18 0 9 9 0 0118 0z'];
                                            @endphp
                                            
                                            @php
                                                $stepIcons = [
                                                    'WO Diterima' => 'fas fa-clipboard-check',
                                                    'Mulai Timbang' => 'fas fa-weight-hanging', 
                                                    'Selesai Timbang' => 'fas fa-balance-scale',
                                                    'Potong Stock' => 'fas fa-cut',
                                                    'Released' => 'fas fa-truck',
                                                    'Kirim BB' => 'fas fa-shipping-fast',
                                                    'Kirim CPB/WO' => 'fas fa-file-export'
                                                ];
                                                $icon = $stepIcons[$tracking->status_name] ?? 'fas fa-circle';
                                            @endphp
                                            
                                            @if ($i <= $lastCompletedIndex)
                                                <div class="w-16 h-16 rounded-full bg-green-500 text-white flex items-center justify-center shadow-lg relative z-10 transition-all duration-300">
                                                    <i class="{{ $icon }} text-xl"></i>
                                                </div>
                                            @elseif($currentIndex !== null && $i === $currentIndex)
                                                <div class="w-16 h-16 rounded-full bg-blue-500 text-white flex items-center justify-center shadow-lg relative z-10 transition-all duration-300 animate-pulse">
                                                    <i class="{{ $icon }} text-xl"></i>
                                                </div>
                                            @else
                                                <div class="w-16 h-16 rounded-full bg-gray-300 text-gray-500 flex items-center justify-center shadow relative z-10 transition-all duration-300">
                                                    <i class="{{ $icon }} text-xl"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Label -->
                                        <div class="mt-3 text-center step-label">
                                            <p class="text-xs font-semibold text-gray-800 leading-tight">{{ $tracking->status_name }}</p>
                                        </div>

                                        <!-- No per-step connector; handled by base/progress lines -->
                                        </div>
                                    @endfor
                                </div>
                            </div>

                            <!-- Step Details List -->
                            <div class="mt-8">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4">Step Details</h4>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <ul class="space-y-3">
                                        @foreach ($sortedTracking as $index => $tracking)
                                            @php
                                                $stepIcons = [
                                                    'WO Diterima' => 'fas fa-clipboard-check',
                                                    'Mulai Timbang' => 'fas fa-weight-hanging', 
                                                    'Selesai Timbang' => 'fas fa-balance-scale',
                                                    'Potong Stock' => 'fas fa-cut',
                                                    'Released' => 'fas fa-truck',
                                                    'Kirim BB' => 'fas fa-shipping-fast',
                                                    'Kirim CPB/WO' => 'fas fa-file-export'
                                                ];
                                                $icon = $stepIcons[$tracking->status_name] ?? 'fas fa-circle';

                                                // Resolve classes per status to avoid multiple alternate Tailwind classes in a single attribute
                                                if ($tracking->completed_at) {
                                                    $dotClasses = 'w-8 h-8 rounded-full flex items-center justify-center text-sm bg-green-100 text-green-600';
                                                    $detailTextClass = 'text-sm text-green-600';
                                                    $badgeClasses = 'inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800';
                                                    $badgeIcon = 'fas fa-check';
                                                    $badgeLabel = 'Complete';
                                                } elseif ($tracking->started_at) {
                                                    $dotClasses = 'w-8 h-8 rounded-full flex items-center justify-center text-sm bg-blue-100 text-blue-600';
                                                    $detailTextClass = 'text-sm text-blue-600';
                                                    $badgeClasses = 'inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800';
                                                    $badgeIcon = 'fas fa-clock';
                                                    $badgeLabel = 'In Progress';
                                                } else {
                                                    $dotClasses = 'w-8 h-8 rounded-full flex items-center justify-center text-sm bg-gray-100 text-gray-400';
                                                    $detailTextClass = 'text-sm text-gray-500';
                                                    $badgeClasses = 'inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600';
                                                    $badgeIcon = 'fas fa-hourglass-start';
                                                    $badgeLabel = 'Pending';
                                                }
                                            @endphp

                                            <li class="flex items-center justify-between py-2 border-b border-gray-200 last:border-b-0">
                                                <div class="flex items-center space-x-3">
                                                    <div class="{{ $dotClasses }}">
                                                        <i class="{{ $icon }}"></i>
                                                    </div>

                                                    <div>
                                                        <p class="font-medium text-gray-900">{{ $tracking->status_name }}</p>
                                                        @if ($tracking->completed_at)
                                                            <p class="{{ $detailTextClass }}">Completed: {{ $tracking->completed_at->format('d M Y H:i') }}</p>
                                                        @elseif($tracking->started_at)
                                                            <p class="{{ $detailTextClass }}">Started: {{ $tracking->started_at->format('d M Y H:i') }}</p>
                                                        @else
                                                            <p class="{{ $detailTextClass }}">Pending</p>
                                                        @endif
                                                        @if ($tracking->notes)
                                                            <p class="text-sm text-gray-600 mt-1 italic">Catatan: "{{ $tracking->notes }}"</p>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="text-right">
                                                    <span class="{{ $badgeClasses }}">
                                                        <i class="{{ $badgeIcon }} mr-1"></i> {{ $badgeLabel }}
                                                    </span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <!-- Mobile: Show list on small screens -->
                            <div class="md:hidden mt-8">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4">Step Details</h4>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <ul class="space-y-3">
                                        @foreach ($sortedTracking as $index => $tracking)
                                            @php
                                                $stepIcons = [
                                                    'WO Diterima' => 'fas fa-clipboard-check',
                                                    'Mulai Timbang' => 'fas fa-weight-hanging', 
                                                    'Selesai Timbang' => 'fas fa-balance-scale',
                                                    'Potong Stock' => 'fas fa-cut',
                                                    'Released' => 'fas fa-truck',
                                                    'Kirim BB' => 'fas fa-shipping-fast',
                                                    'Kirim CPB/WO' => 'fas fa-file-export'
                                                ];
                                                $icon = $stepIcons[$tracking->status_name] ?? 'fas fa-circle';

                                                if ($tracking->completed_at) {
                                                    $dotClasses = 'w-8 h-8 rounded-full flex items-center justify-center text-sm bg-green-100 text-green-600';
                                                    $detailTextClass = 'text-sm text-green-600';
                                                    $badgeClasses = 'inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800';
                                                    $badgeIcon = 'fas fa-check';
                                                    $badgeLabel = 'Complete';
                                                } elseif ($tracking->started_at) {
                                                    $dotClasses = 'w-8 h-8 rounded-full flex items-center justify-center text-sm bg-blue-100 text-blue-600';
                                                    $detailTextClass = 'text-sm text-blue-600';
                                                    $badgeClasses = 'inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800';
                                                    $badgeIcon = 'fas fa-clock';
                                                    $badgeLabel = 'In Progress';
                                                } else {
                                                    $dotClasses = 'w-8 h-8 rounded-full flex items-center justify-center text-sm bg-gray-100 text-gray-400';
                                                    $detailTextClass = 'text-sm text-gray-500';
                                                    $badgeClasses = 'inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600';
                                                    $badgeIcon = 'fas fa-hourglass-start';
                                                    $badgeLabel = 'Pending';
                                                }
                                            @endphp

                                            <li class="flex items-center justify-between py-2 border-b border-gray-200 last:border-b-0">
                                                <div class="flex items-center space-x-3">
                                                    <div class="{{ $dotClasses }}">
                                                        <i class="{{ $icon }}"></i>
                                                    </div>

                                                    <div>
                                                        <p class="font-medium text-gray-900">{{ $tracking->status_name }}</p>
                                                        @if ($tracking->completed_at)
                                                            <p class="{{ $detailTextClass }}">Completed: {{ $tracking->completed_at->format('d M Y H:i') }}</p>
                                                        @elseif($tracking->started_at)
                                                            <p class="{{ $detailTextClass }}">Started: {{ $tracking->started_at->format('d M Y H:i') }}</p>
                                                        @else
                                                            <p class="{{ $detailTextClass }}">Pending</p>
                                                        @endif
                                                        @if ($tracking->notes)
                                                            <p class="text-sm text-gray-600 mt-1 italic">Catatan: "{{ $tracking->notes }}"</p>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="text-right">
                                                    <span class="{{ $badgeClasses }}">
                                                        <i class="{{ $badgeIcon }} mr-1"></i> {{ $badgeLabel }}
                                                    </span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

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
