@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">📜 Dashboard Work Order</h4>
                        <div class="btn-group">
                            @if (Auth::user()->role == 'admin')
                                <a href="{{ route('work-orders.create') }}" class="btn btn-light btn-sm">➕ Tambah Work
                                    Order</a>
                                <a href="{{ route('work-orders.export') }}" class="btn btn-success btn-sm">📄 Export
                                    Excel</a>
                            @endif
                        </div>
                    </div>

                    <div class="card-body">
                        {{-- ================================================ --}}
                        {{--    PANEL FILTER BARU ADA DI SINI, BRO          --}}
                        {{-- ================================================ --}}
                        <div class="p-3 mb-4 border rounded bg-light">
                            <form action="{{ route('dashboard') }}" method="GET">
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-3">
                                        <label for="search" class="form-label">Pencarian</label>
                                        <input type="text" name="search" id="search" class="form-control"
                                            placeholder="No. WO / Nama Produk..." value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="filter_status" class="form-label">Status</label>
                                        <select name="filter_status" id="filter_status" class="form-select">
                                            <option value="">Semua Status</option>
                                            <option value="On Progress"
                                                {{ request('filter_status') == 'On Progress' ? 'selected' : '' }}>On
                                                Progress</option>
                                            <option value="Completed"
                                                {{ request('filter_status') == 'Completed' ? 'selected' : '' }}>Completed
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="filter_due" class="form-label">Jatuh Tempo</label>
                                        <select name="filter_due" id="filter_due" class="form-select">
                                            <option value="">Semua</option>
                                            <option value="soon" {{ request('filter_due') == 'soon' ? 'selected' : '' }}>
                                                Mendekati Due Date</option>
                                            <option value="today" {{ request('filter_due') == 'today' ? 'selected' : '' }}>
                                                Hari Ini</option>
                                            <option value="overdue"
                                                {{ request('filter_due') == 'overdue' ? 'selected' : '' }}>Lewat Due Date
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="filter_day" class="form-label">Hari Due Date</label>
                                        <select name="filter_day" id="filter_day" class="form-select">
                                            <option value="">Semua Hari</option>
                                            <option value="senin"
                                                {{ request('filter_day') == 'senin' ? 'selected' : '' }}>Senin</option>
                                            <option value="selasa"
                                                {{ request('filter_day') == 'selasa' ? 'selected' : '' }}>Selasa</option>
                                            <option value="rabu" {{ request('filter_day') == 'rabu' ? 'selected' : '' }}>
                                                Rabu</option>
                                            <option value="kamis"
                                                {{ request('filter_day') == 'kamis' ? 'selected' : '' }}>Kamis</option>
                                            <option value="jumat"
                                                {{ request('filter_day') == 'jumat' ? 'selected' : '' }}>Jumat</option>
                                            <option value="sabtu"
                                                {{ request('filter_day') == 'sabtu' ? 'selected' : '' }}>Sabtu</option>
                                            <option value="minggu"
                                                {{ request('filter_day') == 'minggu' ? 'selected' : '' }}>Minggu</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12 text-end">
                                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Reset Filter</a>
                                        <button class="btn btn-primary" type="submit">Terapkan Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>No. Work Order</th>
                                        <th>Nama Produk</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($workOrders as $wo)
                                        <tr>
                                            <td><strong>{{ $wo->wo_number }}</strong></td>
                                            <td><strong>{{ $wo->output ?? '-' }}</strong></td>
                                            <td>{{ \Carbon\Carbon::parse($wo->due_date)->translatedFormat('l, d M Y') }}
                                            </td>
                                            <td>
                                                @if ($wo->status == 'Completed')
                                                    <span class="badge bg-success">{{ $wo->status }}</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">{{ $wo->status }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('work-order.show', $wo) }}"
                                                    class="btn btn-sm btn-info text-white" title="Track">🔍</a>
                                                @if (Auth::user()->role == 'admin')
                                                    <a href="{{ route('work-orders.edit', $wo) }}"
                                                        class="btn btn-sm btn-warning" title="Edit">✏️</a>
                                                    <form action="{{ route('work-orders.destroy', $wo) }}" method="POST"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Yakin mau hapus WO ini, bro?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            title="Hapus">🗑️</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">Work Order tidak
                                                ditemukan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $workOrders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
