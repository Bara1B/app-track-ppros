@props(['workOrder'])

<div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg border border-gray-200 mb-8">
    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between">
        <div class="flex-1">
            {{-- Status dan Work Order Number --}}
            <div class="flex items-center space-x-3 mb-4">
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                    @if ($workOrder->status === 'Completed') bg-green-100 text-green-800
                    @elseif($workOrder->status === 'On Progress') bg-blue-100 text-blue-800
                    @else bg-yellow-100 text-yellow-800 @endif">
                    {{ $workOrder->status }}
                </span>
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    WO: {{ $workOrder->wo_number }}
                </span>
            </div>

            {{-- Nama Produk dan Deskripsi --}}
            <h2 class="text-2xl font-bold text-gray-900 mb-3">{{ $workOrder->output ?? 'Nama Produk' }}</h2>
            <div class="space-y-2 mb-4">
                <p class="text-gray-600">
                    <span class="font-medium">Deskripsi:</span> {{ $workOrder->output ?? 'Tidak ada deskripsi' }}
                </p>
                @if ($workOrder->id_number)
                    <p class="text-gray-600">
                        <span class="font-medium">ID Number:</span> {{ $workOrder->id_number }}
                    </p>
                @endif
            </div>

            {{-- Informasi Detail --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Due Date --}}
                <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span class="font-medium">Due Date:</span>
                    <span
                        class="ml-2">{{ $workOrder->due_date ? $workOrder->due_date->format('d M Y') : 'Not set' }}</span>
                </div>

                {{-- Created Date --}}
                <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-medium">Created:</span>
                    <span class="ml-2">{{ $workOrder->created_at->format('d M Y H:i') }}</span>
                </div>

                {{-- Diterima Date jika ada --}}
                @if ($workOrder->woDiterimaTracking && $workOrder->woDiterimaTracking->completed_at)
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium">Diterima:</span>
                        <span
                            class="ml-2">{{ $workOrder->woDiterimaTracking->completed_at->format('d M Y H:i') }}</span>
                    </div>
                @endif

                {{-- Work Order ID --}}
                <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2zm0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                    <span class="font-medium">Work Order ID:</span>
                    <span class="ml-2 font-mono">#{{ $workOrder->id }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
