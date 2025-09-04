@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tambah Master Product (Work Order Data)</h5>
                    <a href="{{ route('work-orders.data.index') }}" class="btn btn-sm btn-outline-secondary">Kembali</a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('work-orders.data.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Item Number</label>
                            <input type="text" name="item_number" class="form-control @error('item_number') is-invalid @enderror" value="{{ old('item_number') }}" required>
                            @error('item_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kode</label>
                            <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" value="{{ old('kode') }}" required>
                            @error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Description 2</label>
                                <input type="text" name="uom" class="form-control @error('uom') is-invalid @enderror" value="{{ old('uom') }}">
                                @error('uom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Group</label>
                                <input type="text" name="group" class="form-control @error('group') is-invalid @enderror" value="{{ old('group') }}">
                                @error('group')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="submit" class="btn btn-primary" data-loading>Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
