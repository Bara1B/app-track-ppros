@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <h5 class="mb-0">Work Order Data</h5>
                        <div class="d-flex align-items-center gap-2">
                            @if (Auth::user() && Auth::user()->role === 'admin')
                                <a href="{{ route('work-orders.data.create') }}" class="btn btn-sm btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="me-1">
                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                    Tambah
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('work-orders.data.index') }}" class="row g-2 mb-3">
                            <div class="col-sm-3">
                                <input type="text" name="item_number" value="{{ request('item_number') }}"
                                    class="form-control" placeholder="Item Number">
                            </div>
                            <div class="col-sm-3">
                                <input type="text" name="kode" value="{{ request('kode') }}" class="form-control"
                                    placeholder="Kode">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" name="description" value="{{ request('description') }}"
                                    class="form-control" placeholder="Description">
                            </div>
                            <div class="col-sm-2 d-flex gap-2">
                                <button type="submit" class="btn btn-primary w-100" data-loading>Filter</button>
                                <a href="{{ route('work-orders.data.index') }}" class="btn btn-outline-secondary">Reset</a>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-sm table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th class="w-16rem">Item Number</th>
                                        <th class="w-8rem">Kode</th>
                                        <th>Description</th>
                                        <th class="w-6rem">Description 2</th>
                                        <th class="w-10rem">Group</th>
                                        @if (Auth::user() && Auth::user()->role === 'admin')
                                            <th class="w-10rem">Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products as $p)
                                        <tr>
                                            <td><code>{{ $p->item_number }}</code></td>
                                            <td>{{ $p->kode }}</td>
                                            <td>{{ $p->description }}</td>
                                            <td>{{ $p->uom }}</td>
                                            <td>{{ $p->group }}</td>
                                            @if (Auth::user() && Auth::user()->role === 'admin')
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('work-orders.data.edit', $p) }}"
                                                            class="btn btn-sm btn-outline-secondary" title="Edit">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="M12 20h9"></path>
                                                                <path
                                                                    d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z">
                                                                </path>
                                                            </svg>
                                                        </a>
                                                        <form action="{{ route('work-orders.data.destroy', $p) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Hapus data ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                title="Hapus">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6">
                                                                    </path>
                                                                    <path d="M10 11v6"></path>
                                                                    <path d="M14 11v6"></path>
                                                                    <path d="M9 6V4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"></path>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted small">Menampilkan {{ $products->firstItem() ?? 0 }} -
                                {{ $products->lastItem() ?? 0 }} dari {{ $products->total() }} data</div>
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
