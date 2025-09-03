@props(['workOrder'])

<div
    class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
    <div class="flex items-start justify-between mb-4">
        <div class="flex-1">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $workOrder->output ?? 'N/A' }}</h3>
            <p class="text-sm text-gray-600 mb-2">WO: {{ $workOrder->wo_number ?? 'N/A' }}</p>
            <p class="text-sm text-gray-600 mb-2">Due Date:
                {{ $workOrder->due_date ? \Carbon\Carbon::parse($workOrder->due_date)->format('d M Y') : 'N/A' }}</p>
        </div>
        <div class="ml-4">
            @if ($workOrder->tracking && $workOrder->tracking->whereNotNull('completed_at')->count() > 0)
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    Completed
                </span>
            @elseif($workOrder->tracking && $workOrder->tracking->whereNotNull('started_at')->count() > 0)
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    In Progress
                </span>
            @else
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                    Pending
                </span>
            @endif
        </div>
    </div>

    <div class="flex items-center justify-between">
        <div class="text-sm text-gray-500">
            ID: {{ $workOrder->id ?? 'N/A' }}
        </div>
        <a href="{{ route('public.tracking', $workOrder) }}"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                </path>
            </svg>
            Lihat Progress
        </a>
    </div>
</div>
