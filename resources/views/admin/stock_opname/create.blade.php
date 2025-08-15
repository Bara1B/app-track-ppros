@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Input Stock Fisik</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('stock-opname.store') }}" method="POST">
                            @csrf
                            {{-- Input Location System --}}
                            <div class="mb-3">
                                <label for="location_system" class="form-label">Location System</label>
                                <input type="text" class="form-control @error('location_system') is-invalid @enderror"
                                    id="location_system" name="location_system" value="{{ old('location_system') }}"
                                    required>
                                @error('location_system')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Dropdown Cerdas --}}
                            <div class="mb-3">
                                <label for="overmate_master_id" class="form-label">Pilih Item</label>
                                <select class="form-select @error('overmate_master_id') is-invalid @enderror"
                                    id="overmate_master_id" name="overmate_master_id" required>
                                    <option value="" selected disabled>-- Pilih Item Number - Manufacturer - Lot
                                        Serial --</option>
                                    @foreach ($overmateMasters as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->item_number }} - {{ $item->manufacturer }} - {{ $item->lot_serial }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('overmate_master_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <hr>
                            {{-- Field Otomatis --}}
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label class="form-label">Nama Bahan (Otomatis)</label>
                                    <input type="text" class="form-control" id="nama_bahan" name="nama_bahan" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Overmate (Otomatis)</label>
                                    <input type="text" class="form-control" id="overmate" name="overmate" readonly>
                                </div>
                            </div>
                            <hr>
                            {{-- Input Stock Fisik --}}
                            <div class="mb-3">
                                <label for="physical_stock" class="form-label">Stock Fisik (Input)</label>
                                <input type="number" step="0.00001"
                                    class="form-control @error('physical_stock') is-invalid @enderror" id="physical_stock"
                                    name="physical_stock" value="{{ old('physical_stock') }}" required>
                                @error('physical_stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('stock-opname.index') }}" class="btn btn-secondary me-2">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const itemSelect = document.getElementById('overmate_master_id');
            const namaBahanInput = document.getElementById('nama_bahan');
            const overmateInput = document.getElementById('overmate');

            itemSelect.addEventListener('change', async function() {
                const selectedId = this.value;
                if (!selectedId) {
                    namaBahanInput.value = '';
                    overmateInput.value = '';
                    return;
                }

                namaBahanInput.value = 'Memuat...';
                overmateInput.value = 'Memuat...';

                try {
                    // Bangun URL secara aman tanpa karakter yang di-encode
                    const url = "{{ route('api.overmate.details', ['master' => 'PLACEHOLDER']) }}"
                        .replace(
                            'PLACEHOLDER', selectedId);
                    const response = await fetch(url);

                    if (!response.ok) {
                        throw new Error('Data tidak ditemukan.');
                    }

                    const data = await response.json();
                    namaBahanInput.value = data.nama_bahan;
                    overmateInput.value = data.overmate;

                } catch (error) {
                    console.error(error);
                    namaBahanInput.value = 'Error';
                    overmateInput.value = 'Error';
                }
            });
        });
    </script>
@endpush
