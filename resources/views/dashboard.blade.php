@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-sm dashboard-card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">📜 Dashboard Work Order</h4>
                        <div class="btn-group">
                            @if (Auth::user()->role == 'admin')
                                <a href="{{ route('work-orders.create') }}" class="btn btn-light btn-sm">➕ Tambah WO
                                    (Satuan)</a>
                                <a href="{{ route('work-orders.bulk-create') }}" class="btn btn-light btn-sm">➕ Tambah WO
                                    (Banyak)</a>
                                <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#exportModal">
                                    📄 Export Laporan
                                </button>
                            @endif
                        </div>
                    </div>

                    <div class="card-body">
                        {{-- Notifikasi sukses dipindahkan ke sini --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Grafik --}}
                        <div class="mb-4 mt-4">
                            <div class="mx-auto" style="max-width: 900px;">
                                <h5 class="fw-bold text-center mb-3">Total Work Order per Bulan ({{ now()->year }})</h5>
                                <div class="p-3 border rounded">
                                    <canvas id="monthlyWoChart"></canvas>
                                </div>
                            </div>
                        </div>

                        {{-- Panel Filter --}}
                        <div class="p-3 mb-4 filter-panel">
                            <form action="{{ route('dashboard') }}" method="GET">
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-3">
                                        <label for="search" class="form-label fw-bold">Pencarian</label>
                                        <input type="text" name="search" id="search" class="form-control"
                                            placeholder="No. WO / Nama Produk..." value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="filter_status" class="form-label fw-bold">Status</label>
                                        <select name="filter_status" id="filter_status" class="form-select">
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
                                    <div class="col-md-3">
                                        <label for="filter_due" class="form-label fw-bold">Jatuh Tempo</label>
                                        <select name="filter_due" id="filter_due" class="form-select">
                                            <option value="">Semua</option>
                                            <option value="soon" {{ request('filter_due') == 'soon' ? 'selected' : '' }}>
                                                Mendekati Due Date</option>
                                            <option value="today" {{ request('filter_due') == 'today' ? 'selected' : '' }}>
                                                Hari Ini</option>
                                            <option value="overdue"
                                                {{ request('filter_due') == 'overdue' ? 'selected' : '' }}>
                                                Lewat Due
                                                Date
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="filter_month" class="form-label fw-bold">Bulan Due Date</label>
                                        <select name="filter_month" id="filter_month" class="form-select">
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
                                <div class="row mt-3">
                                    <div class="col-12 text-end">
                                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Reset</a>
                                        <button class="btn btn-primary" type="submit">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        {{-- Form Aksi Massal & Tabel --}}
                        <form id="bulk-actions-form" action="{{ route('work-orders.bulk-destroy') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div id="bulk-actions-toolbar" class="mb-3" style="display: none;">
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#editDueDateModal">
                                    ✏️ Edit Due Date yang Dipilih
                                </button>
                                <button type="button" id="delete-selected-btn" class="btn btn-danger">🗑️ Hapus yang
                                    Dipilih</button>
                                <a href="#" id="export-selected-btn" class="btn btn-success">📄 Export yang
                                    Dipilih</a>
                            </div>
                            <div class="table-responsive" id="work-order-table">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="width: 1%;"><input class="form-check-input" type="checkbox"
                                                    id="select-all"></th>

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
                                                        $icon = $sortDirection == 'asc' ? '▲' : '▼';
                                                    }
                                                    // Menggabungkan semua parameter filter yang ada
                                                    $url = request()->fullUrlWithQuery([
                                                        'sort_by' => $column,
                                                        'sort_direction' => $newDirection,
                                                    ]);
                                                    // Menambahkan jangkar ke URL
                                                    return '<th><a href="' .
                                                        $url .
                                                        '#work-order-table" class="text-decoration-none text-dark">' .
                                                        $label .
                                                        ' ' .
                                                        $icon .
                                                        '</a></th>';
                                                }
                                            @endphp

                                            {!! sortable_header('No. Work Order', 'wo_number') !!}
                                            {!! sortable_header('Nama Produk', 'output') !!}
                                            <th>Group</th>
                                            {!! sortable_header('WO Diterima', 'wo_diterima_date') !!}
                                            {!! sortable_header('Due Date', 'due_date') !!}
                                            {!! sortable_header('Status', 'status') !!}

                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($workOrders as $wo)
                                            <tr>
                                                <td><input class="form-check-input row-checkbox" type="checkbox"
                                                        value="{{ $wo->id }}"></td>
                                                <td><strong>{{ $wo->wo_number }}</strong></td>
                                                <td>{{ $wo->output ?? '-' }}</td>
                                                <td>{{ $wo->masterProduct?->group ?? '-' }}</td>
                                                <td>{{ $wo->woDiterimaTracking?->completed_at?->translatedFormat('l, d M Y') ?? '-' }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($wo->due_date)->translatedFormat('l, d M Y') }}
                                                </td>
                                                <td>
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
                                                            <span class="badge bg-danger">Completed (Late)</span>
                                                        @else
                                                            <span class="badge bg-success">Completed</span>
                                                        @endif
                                                    @else
                                                        <span
                                                            class="badge bg-warning text-dark">{{ $wo->status }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('work-order.show', $wo) }}"
                                                        class="btn btn-sm btn-outline-info" title="Track">🔍</a>
                                                    @if (Auth::user()->role == 'admin')
                                                        <a href="{{ route('work-orders.edit', $wo) }}"
                                                            class="btn btn-sm btn-outline-warning" title="Edit">✏️</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted py-4">Work Order
                                                    tidak
                                                    ditemukan.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        <div class="mt-3">
                            {{ $workOrders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Export Excel -->
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">Export Laporan Work Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Pilih periode laporan berdasarkan tanggal "WO Diterima".</p>
                    <div class="mb-3">
                        <label for="export_month" class="form-label">Bulan</label>
                        <select id="export_month" class="form-select">
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ $m == now()->month ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="export_year" class="form-label">Tahun</label>
                        <select id="export_year" class="form-select">
                            @for ($y = now()->year; $y >= 2020; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <small class="text-muted">Jika Anda tidak memilih item di tabel, semua WO pada periode terpilih akan
                        diekspor.</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="download-report-btn" class="btn btn-success">Download Laporan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Due Date -->
    <div class="modal fade" id="editDueDateModal" tabindex="-1" aria-labelledby="editDueDateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDueDateModalLabel">Update Due Date Borongan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="bulk-edit-form" action="{{ route('work-orders.bulk-update-due-date') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <p>Anda akan mengubah due date untuk <strong id="selected-count"></strong> item yang dipilih.
                        </p>
                        <div class="mb-3">
                            <label for="new_due_date" class="form-label">Pilih Due Date Baru</label>
                            <input type="date" class="form-control" id="new_due_date" name="new_due_date" required>
                        </div>
                        <div id="bulk-edit-ids-container"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update Due Date</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Form Hapus Borongan (sekarang tersembunyi) --}}
    <form id="bulk-delete-form" action="{{ route('work-orders.bulk-destroy') }}" method="POST" class="d-none">
        @csrf
        @method('DELETE')
        <div id="bulk-delete-ids-container"></div>
    </form>
@endsection

@push('scripts')
    {{-- Pustaka Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            function getSelectedIds() {
                return Array.from(rowCheckboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);
            }

            function toggleBulkActionsToolbar() {
                const selectedIds = getSelectedIds();
                const anyChecked = selectedIds.length > 0;

                if (bulkActionsToolbar) {
                    bulkActionsToolbar.style.display = anyChecked ? 'flex' : 'none';
                }
                if (mainBtnGroup) {
                    mainBtnGroup.style.display = anyChecked ? 'none' : 'inline-flex';
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

            if (downloadReportBtn) {
                downloadReportBtn.addEventListener('click', function() {
                    const month = document.getElementById('export_month').value;
                    const year = document.getElementById('export_year').value;

                    const baseUrl = "{{ route('work-orders.export') }}";
                    const queryString = `?month=${month}&year=${year}`;

                    window.location.href = baseUrl + queryString;
                });
            }
        });
    </script>
@endpush
