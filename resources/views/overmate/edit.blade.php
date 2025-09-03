@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Overmate</h5>
                        <a href="{{ route('overmate.index') }}" class="btn btn-sm btn-outline-secondary">Kembali</a>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('overmate.update', $overmate) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Item Number</label>
                                <input type="text" name="item_number"
                                    class="form-control @error('item_number') is-invalid @enderror"
                                    value="{{ old('item_number', $overmate->item_number) }}" required>
                                @error('item_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Bahan</label>
                                <input type="text" name="nama_bahan"
                                    class="form-control @error('nama_bahan') is-invalid @enderror"
                                    value="{{ old('nama_bahan', $overmate->nama_bahan) }}" required>
                                @error('nama_bahan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Manufacturer</label>
                                <input type="text" name="manufactur"
                                    class="form-control @error('manufactur') is-invalid @enderror"
                                    value="{{ old('manufactur', $overmate->manufactur) }}" required>
                                @error('manufactur')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Overmate Qty</label>
                                <input type="number" step="0.00001" name="overmate_qty"
                                    class="form-control @error('overmate_qty') is-invalid @enderror"
                                    value="{{ old('overmate_qty', $overmate->overmate_qty) }}" required>
                                @error('overmate_qty')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary" data-loading>Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
