@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">Data Stock Opname</h3>
                <p class="text-muted mb-0">File: <strong>{{ $stockOpnameFile->original_name }}</strong></p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('stock-opname.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke List File
                </a>
                <button type="button" class="btn btn-danger"
                    onclick="deleteFile({{ $stockOpnameFile->id }}, '{{ $stockOpnameFile->original_name }}')">
                    <i class="fas fa-trash me-2"></i>Hapus File
                </button>
            </div>
        </div>

        @if ($stockOpnames && $stockOpnames->count() > 0)
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Tabel Data Stock Opname</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Location System</th>
                                    <th>Item Number</th>
                                    <th>Description</th>
                                    <th>Manufacturer</th>
                                    <th>Quantity on Hand</th>
                                    <th>Stok Fisik</th>
                                    <th>Overmate Qty</th>
                                    <th>Selisih</th>
                                    <th>Masuk Kategori</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stockOpnames as $item)
                                    <tr>
                                        <td>{{ $item->location_system }}</td>
                                        <td><strong>{{ $item->item_number }}</strong></td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ $item->manufacturer ?: '-' }}</td>
                                        <td>{{ number_format($item->quantity_on_hand, 5) }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('stock-opname.update-stok', $item->id) }}"
                                                class="d-flex gap-2">
                                                @csrf
                                                @method('PUT')
                                                <input type="number" name="stok_fisik"
                                                    value="{{ $item->stok_fisik ?? '' }}"
                                                    class="form-control form-control-sm" style="width: 80px;"
                                                    step="0.00001">
                                                <button type="submit" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-save"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td>{{ $item->overmate_qty ? number_format($item->overmate_qty, 5) : '-' }}</td>
                                        <td>
                                            @if ($item->stok_fisik !== null)
                                                <span
                                                    class="badge {{ $item->selisih < 0 ? 'bg-danger' : ($item->selisih > 0 ? 'bg-success' : 'bg-warning') }}">
                                                    {{ $item->selisih > 0 ? '+' : '' }}{{ number_format($item->selisih, 5) }}
                                                </span>
                                            @else
                                                <span class="text-muted">Input stok fisik dulu</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->overmate_qty && $item->stok_fisik !== null)
                                                @if ($item->masuk_kategori === 'Iya')
                                                    <span class="badge bg-success">✓ Iya</span>
                                                @else
                                                    <span class="badge bg-danger">✗ Tidak</span>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $stockOpnames->links() }}
                </div>
            </div>
        @else
            <div class="card text-center py-5">
                <h5 class="text-muted">Belum ada data stock opname</h5>
                <p class="text-muted">Data belum tersedia untuk file ini</p>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        function deleteFile(fileId, fileName) {
            if (confirm(
                    `Yakin ingin menghapus file "${fileName}"?\n\n⚠️ PERHATIAN: Semua data stock opname yang terkait dengan file ini akan dihapus permanen!`
                )) {
                // Buat form untuk delete
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/stock-opname/delete-file/${fileId}`;

                // Tambahkan CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';

                // Tambahkan method DELETE
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';

                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endpush
