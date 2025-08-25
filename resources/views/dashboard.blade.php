@extends('layouts.app')

@push('styles')
    @vite('resources/css/pages/dashboard.css')
@endpush

@section('content')

    <div id="dashboard-wo" class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-center">
            <div class="w-full">
                <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                    <div class="bg-gray-900 text-white px-6 py-4 rounded-t-lg flex justify-between items-center">
                        <h4 class="text-xl font-semibold mb-0 flex items-center gap-2">
                            <span>📜</span>
                            <span>Dashboard Work Order</span>
                        </h4>
                    </div>

                    <div class="p-6">
                        {{-- Quick Stats --}}
                        @isset($totalWorkOrders)
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                                <div class="rounded-lg border border-gray-200 p-4 bg-white">
                                    <div class="text-sm text-gray-500">Total WO</div>
                                    <div class="mt-1 text-2xl font-semibold text-gray-900">{{ $totalWorkOrders }}</div>
                                </div>
                                <div class="rounded-lg border border-gray-200 p-4 bg-white">
                                    <div class="text-sm text-gray-500">On Progress</div>
                                    <div class="mt-1 text-2xl font-semibold text-yellow-700">{{ $pendingWorkOrders }}</div>
                                </div>
                                <div class="rounded-lg border border-gray-200 p-4 bg-white">
                                    <div class="text-sm text-gray-500">Completed</div>
                                    <div class="mt-1 text-2xl font-semibold text-green-700">{{ $completedWorkOrders }}</div>
                                </div>
                                <div class="rounded-lg border border-gray-200 p-4 bg-white">
                                    <div class="text-sm text-gray-500">Overdue</div>
                                    <div class="mt-1 text-2xl font-semibold text-red-700">{{ $overdueWorkOrders }}</div>
                                </div>
                            </div>
                        @endisset
                        {{-- Grafik hanya untuk monitoring di Card 1 --}}
                        <div class="mb-6 mt-2">
                            <div class="mx-auto max-w-4xl">
                                <h5 class="font-bold text-center mb-3 text-lg">Total Work Order per Bulan
                                    ({{ now()->year }})</h5>
                                <div class="p-4 border border-gray-300 rounded-lg">
                                    <canvas id="monthlyWoChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Manajemen Work Order (aksi & tabel) --}}
                <div class="bg-white shadow-sm rounded-lg border border-gray-200 mt-6">
                    <div class="bg-gray-50 px-6 py-4 rounded-t-lg flex justify-between items-center">
                        <h5 class="text-lg font-semibold mb-0">Kelola Work Order</h5>
                        @if (Auth::user()->role == 'admin')
                            <div id="actions-toolbar" class="flex space-x-2" role="toolbar" aria-label="Toolbar Actions">
                                <div class="flex space-x-2" role="group" aria-label="Tambah WO Satuan">
                                    <a href="{{ route('work-orders.create') }}"
                                        class="no-underline bg-amber-500 hover:bg-amber-600 text-white px-3 py-2 rounded-full text-sm font-semibold shadow-sm hover:shadow ring-1 ring-black/5 transition-transform transition-colors active:scale-[.98]">➕
                                        Tambah WO
                                        (Satuan)</a>
                                </div>
                                <div class="flex space-x-2" role="group" aria-label="Tambah WO Banyak">
                                    <a href="{{ route('work-orders.bulk-create') }}"
                                        class="no-underline bg-amber-500 hover:bg-amber-600 text-white px-3 py-2 rounded-full text-sm font-semibold shadow-sm hover:shadow ring-1 ring-black/5 transition-transform transition-colors active:scale-[.98]">➕
                                        Tambah
                                        WO (Banyak)</a>
                                </div>
                                <div class="flex space-x-2" role="group" aria-label="Export Laporan">
                                    <button type="button" id="open-export-modal-btn"
                                        class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-2 rounded-full text-sm font-semibold shadow-sm hover:shadow ring-1 ring-black/5 transition-transform transition-colors active:scale-[.98]"
                                        style="border-radius:9999px!important" data-bs-toggle="modal"
                                        data-bs-target="#exportModal">📄 Export Laporan</button>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="p-6">
                        {{-- Notifikasi sukses ditempatkan di Card 2 --}}
                        @if (session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                                role="alert">
                                {{ session('success') }}
                                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3"
                                    data-bs-dismiss="alert" aria-label="Close">
                                    <svg class="fill-current h-6 w-6 text-green-500" role="button"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <title>Close</title>
                                        <path
                                            d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                                    </svg>
                                </button>
                            </div>
                        @endif

                        {{-- Panel Filter --}}
                        <div class="p-4 mb-6 bg-gray-50 rounded-lg border border-gray-200">
                            <form action="{{ route('dashboard') }}" method="GET">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                                    <div>
                                        <label for="search"
                                            class="block text-sm font-bold text-gray-700 mb-2">Pencarian</label>
                                        <input type="text" name="search" id="search"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="No. WO / Nama Produk..." value="{{ request('search') }}">
                                    </div>
                                    <div>
                                        <label for="filter_status"
                                            class="block text-sm font-bold text-gray-700 mb-2">Status</label>
                                        <select name="filter_status" id="filter_status"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Semua Status</option>
                                            <option value="On Progress"
                                                {{ request('filter_status') == 'On Progress' ? 'selected' : '' }}>On
                                                Progress</option>
                                            <option value="Completed"
                                                {{ request('filter_status') == 'Completed' ? 'selected' : '' }}>
                                                Completed
                                            </option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="filter_due" class="block text-sm font-bold text-gray-700 mb-2">Jatuh
                                            Tempo</label>
                                        <select name="filter_due" id="filter_due"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Semua</option>
                                            <option value="soon" {{ request('filter_due') == 'soon' ? 'selected' : '' }}>
                                                Mendekati Due Date</option>
                                            <option value="today"
                                                {{ request('filter_due') == 'today' ? 'selected' : '' }}>
                                                Hari Ini</option>
                                            <option value="overdue"
                                                {{ request('filter_due') == 'overdue' ? 'selected' : '' }}>
                                                Lewat Due
                                                Date
                                            </option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="filter_month" class="block text-sm font-bold text-gray-700 mb-2">Bulan
                                            Due Date</label>
                                        <select name="filter_month" id="filter_month"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Semua Bulan</option>
                                            @for ($m = 1; $m <= 12; $m++)
                                                <option value="{{ $m }}"
                                                    {{ request('filter_month') == $m ? 'selected' : '' }}>
                                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-4 text-right">
                                    <a href="{{ route('dashboard') }}"
                                        class="no-underline bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 px-4 py-2 rounded-full text-sm font-semibold mr-2 shadow-sm ring-1 ring-black/5 transition">Reset</a>
                                    <button
                                        class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-sm hover:shadow ring-1 ring-black/5 transition-transform active:scale-[.98]"
                                        style="border-radius:9999px!important" type="submit">Filter</button>
                                </div>
                            </form>
                        </div>

                        {{-- Form Aksi Massal & Tabel --}}
                        <form id="bulk-actions-form" action="{{ route('work-orders.bulk-destroy') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div id="bulk-actions-toolbar" class="mb-4 hidden">
                                <div class="flex flex-wrap gap-3">
                                    <button type="button"
                                        class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-sm hover:shadow ring-1 ring-black/5 transition-transform active:scale-[.98]"
                                        style="border-radius:9999px!important" data-bs-toggle="modal"
                                        data-bs-target="#editDueDateModal">
                                        ✏️ Edit Due Date yang Dipilih
                                    </button>
                                    <button type="button" id="delete-selected-btn"
                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-sm hover:shadow ring-1 ring-black/5 transition-transform active:scale-[.98]"
                                        style="border-radius:9999px!important">🗑️
                                        Hapus yang
                                        Dipilih</button>
                                    <a href="#" id="export-selected-btn"
                                        class="no-underline bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-sm hover:shadow ring-1 ring-black/5 transition-transform active:scale-[.98]">📄
                                        Export yang
                                        Dipilih</a>
                                </div>
                            </div>
                            <div class="overflow-x-auto" id="work-order-table">
                                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                <input class="form-check-input" type="checkbox" id="select-all">
                                            </th>

                                            @php
                                                // Helper untuk membuat link pengurutan
                                                function sortable_header($label, $column)
                                                {
                                                    $sortBy = request('sort_by', 'created_at');
                                                    $sortDirection = request('sort_direction', 'desc');
                                                    $newDirection =
                                                        $sortBy == $column && $sortDirection == 'asc' ? 'desc' : 'asc';
                                                    $icon = '';
                                                    if ($sortBy == $column) {
                                                        $icon =
                                                            $sortDirection == 'asc'
                                                                ? '<i class="ml-1">↑</i>'
                                                                : '<i class="ml-1">↓</i>';
                                                    }
                                                    // Menggabungkan semua parameter filter yang ada
                                                    $url = request()->fullUrlWithQuery([
                                                        'sort_by' => $column,
                                                        'sort_direction' => $newDirection,
                                                    ]);
                                                    // Menambahkan jangkar ke URL
                                                    return '<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><a href="' .
                                                        $url .
                                                        '" class="text-gray-900 hover:text-gray-700 no-underline" style="text-decoration:none;color:#111827">' .
                                                        $label .
                                                        ' ' .
                                                        $icon .
                                                        '</a></th>';
                                                }
                                            @endphp

                                            {!! sortable_header('No. Work Order', 'wo_number') !!}
                                            {!! sortable_header('Nama Produk', 'output') !!}
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Group</th>
                                            {!! sortable_header('WO Diterima', 'wo_diterima_date') !!}
                                            {!! sortable_header('Due Date', 'due_date') !!}
                                            {!! sortable_header('Status', 'status') !!}

                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse ($workOrders as $wo)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-4 whitespace-nowrap"><input
                                                        class="form-check-input row-checkbox" type="checkbox"
                                                        value="{{ $wo->id }}"></td>
                                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $wo->wo_number }}</td>
                                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $wo->output ?? '-' }}</td>
                                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $wo->masterProduct?->group ?? '-' }}</td>
                                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $wo->woDiterimaTracking?->completed_at?->translatedFormat('d M Y') ?? '-' }}
                                                </td>
                                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ \Carbon\Carbon::parse($wo->due_date)->translatedFormat('d M Y') }}
                                                </td>
                                                <td class="px-4 py-4 whitespace-nowrap">
                                                    @php
                                                        // Tentukan tanggal selesai aktual: pakai completed_on jika ada,
                                                        // fallback ke tanggal terakhir langkah tracking yang selesai.
                                                        $actualCompletedOn =
                                                            $wo->completed_on ?? $wo->tracking?->max('completed_at');
                                                        $isLate = false;
                                                        if ($wo->status === 'Completed' && $actualCompletedOn) {
                                                            $actualCompletedOn = \Carbon\Carbon::parse(
                                                                $actualCompletedOn,
                                                            );
                                                            $isLate = $actualCompletedOn->gt($wo->due_date);
                                                        }
                                                    @endphp
                                                    @if ($wo->status == 'Completed')
                                                        @if ($isLate)
                                                            <span
                                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Completed
                                                                (Late)
                                                            </span>
                                                        @else
                                                            <span
                                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                                                        @endif
                                                    @else
                                                        <span
                                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">{{ $wo->status }}</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                                    <a href="{{ route('work-order.show', $wo) }}"
                                                        class="text-gray-700 hover:text-gray-900 mr-2"
                                                        title="Track">🔍</a>
                                                    @if (Auth::user()->role == 'admin')
                                                        <a href="{{ route('work-orders.edit', $wo) }}"
                                                            class="text-yellow-600 hover:text-yellow-900"
                                                            title="Edit">✏️</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="px-4 py-8 text-center">
                                                    <div class="text-gray-500">
                                                        <div class="text-4xl mb-2">📋</div>
                                                        <div class="font-medium text-lg">Work Order tidak ditemukan</div>
                                                        <div class="text-sm">Tidak ada data yang sesuai dengan
                                                            filter</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        <div class="mt-4">
                            {{ $workOrders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Export Excel -->
    <div class="tw-modal hidden" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 h-full w-full flex items-start justify-center"
            style="z-index:9999;">
            <div class="mt-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="flex justify-between items-center pb-3">
                    <h5 class="text-lg font-bold text-gray-900" id="exportModalLabel">Export Laporan Work Order</h5>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-bs-dismiss="modal" aria-label="Close">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <form id="export-form" action="{{ route('work-orders.export') }}" method="GET">
                    <div class="py-4">
                        <p class="text-gray-600 mb-4">Pilih periode laporan berdasarkan tanggal "WO Diterima".</p>
                        <div class="mb-4">
                            <label for="export_month" class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
                            <select id="export_month" name="month"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ $m == now()->month ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="export_year" class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                            <select id="export_year" name="year"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @for ($y = now()->year; $y >= 2020; $y--)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        <small class="text-gray-500 text-sm">Jika Anda tidak memilih item di tabel, semua WO pada periode
                            terpilih
                            akan
                            diekspor.</small>
                    </div>
                    <div class="flex justify-end space-x-2 pt-4 border-t">
                        <a id="export-cancel-link" href="{{ route('dashboard') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-full text-sm font-medium transition-colors"
                            style="border-radius:9999px!important">Batal</a>

                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-full text-sm font-medium transition-colors"
                            style="border-radius:9999px!important">Download
                            Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Due Date -->
    <div class="tw-modal hidden" id="editDueDateModal" tabindex="-1" aria-labelledby="editDueDateModalLabel"
        aria-hidden="true">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 h-full w-full flex items-start justify-center"
            style="z-index:9999;">
            <div class="mt-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="flex justify-between items-center pb-3">
                    <h5 class="text-lg font-bold text-gray-900" id="editDueDateModalLabel">Update Due Date Borongan</h5>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-bs-dismiss="modal" aria-label="Close">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <form id="bulk-edit-form" action="{{ route('work-orders.bulk-update-due-date') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="py-4">
                        <p class="text-gray-600 mb-4">Anda akan mengubah due date untuk <strong
                                id="selected-count"></strong> item yang dipilih.
                        </p>
                        <div class="mb-4">
                            <label for="new_due_date" class="block text-sm font-medium text-gray-700 mb-2">Pilih Due Date
                                Baru</label>
                            <input type="date"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                id="new_due_date" name="new_due_date" required>
                        </div>
                        <div id="bulk-edit-ids-container"></div>
                    </div>
                    <div class="flex justify-end space-x-2 pt-4 border-t">
                        <button type="button" data-bs-dismiss="modal"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-full text-sm font-medium transition-colors"
                            style="border-radius:9999px!important">Batal</button>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-full text-sm font-medium transition-colors"
                            style="border-radius:9999px!important">Update
                            Due Date</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Form Hapus Borongan (sekarang tersembunyi) --}}
    <form id="bulk-delete-form" action="{{ route('work-orders.bulk-destroy') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
        <div id="bulk-delete-ids-container"></div>
    </form>
@endsection

@push('scripts')
    {{-- Pustaka Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        (function() {
            function initDashboardScripts() {
                // Enhanced scroll position memory
                try {
                    const scrollStorageKey = 'dashboard:lastScrollY';

                    // Function to save current scroll position
                    function saveScrollPosition() {
                        sessionStorage.setItem(scrollStorageKey, String(window.scrollY || 0));
                    }

                    // Restore last scroll position
                    if (!location.hash) {
                        const savedY = sessionStorage.getItem(scrollStorageKey);
                        if (savedY) {
                            // Delay scroll restoration to ensure page is fully loaded
                            setTimeout(() => {
                                window.scrollTo(0, parseInt(savedY, 10) || 0);
                            }, 100);
                        }
                    }

                    // Save scroll position on various events
                    window.addEventListener('beforeunload', saveScrollPosition);

                    // Save scroll position when forms are submitted
                    document.addEventListener('submit', function(e) {
                        // Only save if it's not a modal form
                        if (!e.target.closest('.modal')) {
                            saveScrollPosition();
                        }
                    });

                    // Fallback: open export modal by ID (in case data attributes aren't processed)
                    const openExportBtn = document.getElementById('open-export-modal-btn');
                    if (openExportBtn) {
                        openExportBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            const m = document.getElementById('exportModal');
                            if (m) {
                                console.debug('Opening modal via fallback #open-export-modal-btn');
                                m.classList.remove('hidden');
                                m.setAttribute('aria-hidden', 'false');
                            }
                        });
                    }

                    // Save scroll position when action buttons are clicked
                    document.addEventListener('click', function(e) {
                        // Save on delete, edit, or bulk action buttons
                        if (e.target.matches('[onclick*="delete"]') ||
                            e.target.matches('button[type="submit"]') ||
                            e.target.closest('form[method="POST"]')) {
                            saveScrollPosition();
                        }
                    });

                } catch (e) {
                    // no-op if storage is unavailable
                }
                // Skrip untuk Grafik
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
                                            if (!chartArea) {
                                                return null;
                                            }
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

                // Skrip untuk Aksi Massal (Bulk Actions)
                // Modal handlers (open/close) without Bootstrap JS
                const modalTriggers = document.querySelectorAll('[data-bs-toggle="modal"]');
                modalTriggers.forEach(btn => {
                    const targetSel = btn.getAttribute('data-bs-target');
                    const modalEl = targetSel ? document.querySelector(targetSel) : null;
                    if (!modalEl) {
                        console.warn('Modal target not found for trigger:', btn);
                        return;
                    }
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        console.debug('Opening modal', targetSel);
                        modalEl.classList.remove('hidden');
                        modalEl.setAttribute('aria-hidden', 'false');
                    });
                });

                const modalDismissers = document.querySelectorAll('[data-bs-dismiss="modal"]');
                modalDismissers.forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const modal = btn.closest('.tw-modal');
                        if (modal) modal.classList.add('hidden');
                    });
                });

                // Force navigate when clicking Export modal Cancel link
                const exportCancelLink = document.getElementById('export-cancel-link');
                if (exportCancelLink) {
                    exportCancelLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        const url = this.getAttribute('href');
                        if (url) {
                            window.location.href = url;
                        }
                    });
                }

                // Close when clicking backdrop area
                document.querySelectorAll('.tw-modal').forEach(modal => {
                    const backdrop = modal.querySelector('.fixed.inset-0');
                    if (backdrop) {
                        backdrop.addEventListener('click', function(e) {
                            if (e.target === backdrop) {
                                modal.classList.add('hidden');
                            }
                        });
                    }
                });

                // Escape to close any open modal
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        document.querySelectorAll('.tw-modal').forEach(m => {
                            if (!m.classList.contains('hidden')) m.classList.add('hidden');
                        });
                    }
                });

                // Skrip untuk Aksi Massal (Bulk Actions)
                const selectAllCheckbox = document.getElementById('select-all');
                const rowCheckboxes = document.querySelectorAll('.row-checkbox');
                const bulkActionsToolbar = document.getElementById('bulk-actions-toolbar');
                const mainBtnGroup = document.querySelector('.card-header .btn-group');
                const deleteBtn = document.getElementById('delete-selected-btn');
                const exportSelectedBtn = document.getElementById('export-selected-btn');
                const editForm = document.getElementById('bulk-edit-form');
                const editIdsContainer = document.getElementById('bulk-edit-ids-container');
                const selectedCountSpan = document.getElementById('selected-count');
                const deleteForm = document.getElementById('bulk-delete-form');
                const deleteIdsContainer = document.getElementById('bulk-delete-ids-container');
                const downloadReportBtn = document.getElementById('download-report-btn');
                const exportForm = document.getElementById('export-form');
                const exportMonthSelect = document.getElementById('export_month');
                const exportYearSelect = document.getElementById('export_year');

                function getSelectedIds() {
                    return Array.from(rowCheckboxes)
                        .filter(cb => cb.checked)
                        .map(cb => cb.value);
                }

                function toggleBulkActionsToolbar() {
                    const selectedIds = getSelectedIds();
                    const anyChecked = selectedIds.length > 0;

                    if (bulkActionsToolbar) {
                        bulkActionsToolbar.classList.toggle('hidden', !anyChecked);
                    }
                    if (mainBtnGroup) {
                        mainBtnGroup.style.display = anyChecked ? 'none' : 'flex';
                    }
                    if (selectedCountSpan) {
                        selectedCountSpan.textContent = selectedIds.length;
                    }
                }

                if (selectAllCheckbox) {
                    selectAllCheckbox.addEventListener('change', function() {
                        rowCheckboxes.forEach(checkbox => {
                            checkbox.checked = this.checked;
                        });
                        toggleBulkActionsToolbar();
                    });
                }

                rowCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        if (!this.checked && selectAllCheckbox) {
                            selectAllCheckbox.checked = false;
                        }
                        toggleBulkActionsToolbar();
                    });
                });

                if (deleteBtn) {
                    deleteBtn.addEventListener('click', function() {
                        const selectedIds = getSelectedIds();
                        if (selectedIds.length === 0) {
                            alert('Pilih minimal satu item untuk dihapus.');
                            return;
                        }
                        if (confirm('Yakin mau hapus ' + selectedIds.length + ' item yang dipilih?')) {
                            deleteIdsContainer.innerHTML = '';
                            selectedIds.forEach(id => {
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = 'ids[]';
                                input.value = id;
                                deleteIdsContainer.appendChild(input);
                            });
                            deleteForm.submit();
                        }
                    });
                }

                if (exportSelectedBtn) {
                    exportSelectedBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const checkedIds = getSelectedIds();

                        if (checkedIds.length === 0) {
                            alert('Silakan pilih minimal satu item untuk diekspor.');
                            return;
                        }

                        const baseUrl = "{{ route('work-orders.export') }}";
                        const queryString = checkedIds.map(id => 'ids[]=' + id).join('&');
                        window.location.href = baseUrl + '?' + queryString;
                    });
                }

                // Pastikan tombol Download Laporan di modal selalu melakukan navigasi langsung (seperti exportSelected)
                if (exportForm) {
                    exportForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const baseUrl = "{{ route('work-orders.export') }}";
                        const params = new URLSearchParams();

                        const month = exportMonthSelect ? exportMonthSelect.value : '';
                        const year = exportYearSelect ? exportYearSelect.value : '';
                        if (month) params.set('month', month);
                        if (year) params.set('year', year);

                        // Jika ada item yang dipilih di tabel, ikutkan juga
                        const checkedIds = getSelectedIds();
                        if (checkedIds.length > 0) {
                            checkedIds.forEach(id => params.append('ids[]', id));
                        }

                        window.location.href = baseUrl + (params.toString() ? ('?' + params.toString()) : '');
                    });
                }

                if (editForm) {
                    editForm.addEventListener('submit', function(e) {
                        const selectedIds = getSelectedIds();
                        editIdsContainer.innerHTML = '';
                        selectedIds.forEach(id => {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'ids[]';
                            input.value = id;
                            editIdsContainer.appendChild(input);
                        });
                    });
                }

                // Jika form ada, biarkan submit default GET tanpa JS extra
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initDashboardScripts);
            } else {
                initDashboardScripts();
            }
        })();
    </script>
@endpush
