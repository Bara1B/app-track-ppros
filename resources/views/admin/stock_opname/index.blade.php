@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold">Stock Opname (Overmate)</h3>
            <a href="{{ route('stock-opname.create') }}" class="btn btn-primary">➕ Input Stock Fisik</a>
        </div>

        <div class="card shadow-sm dashboard-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Location System</th>
                                <th>Nama Bahan</th>
                                <th>Overmate (Sistem)</th>
                                <th>Stock Fisik</th>
                                <th>Selisih</th>
                                <th>Masuk?</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stockOpnames as $item)
                                <tr>
                                    <td>{{ $item->location_system }}</td>
                                    <td>
                                        <strong>{{ $item->nama_bahan }}</strong><br>
                                        <small class="text-muted">{{ $item->item_number }}</small>
                                    </td>
                                    <td>{{ rtrim(rtrim(number_format($item->overmate_qty, 5), '0'), '.') }}</td>
                                    <td>{{ rtrim(rtrim(number_format($item->physical_stock, 5), '0'), '.') }}</td>
                                    @php
                                        $selisih = $item->physical_stock - $item->overmate_qty;
                                    @endphp
                                    <td class="{{ $selisih < 0 ? 'text-danger' : 'text-success' }} fw-bold">
                                        {{ rtrim(rtrim(number_format($selisih, 5), '0'), '.') }}
                                    </td>
                                    <td>
                                        {{-- Logika diubah sesuai permintaan --}}
                                        @if ($selisih < 0)
                                            <span class="badge bg-success">Iya</span>
                                        @else
                                            <span class="badge bg-danger">Tidak</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Belum ada data stock opname.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $stockOpnames->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
