@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0">📝 Edit Work Order</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('work-orders.update', $workOrder) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Nomor Work Order</label>
                                <input type="text" class="form-control" value="{{ $workOrder->wo_number }}" disabled>
                            </div>

                            {{-- INPUT TEKS DIGANTI JADI DROPDOWN --}}
                            <div class="mb-3">
                                <label for="product_kode" class="form-label">Nama Produk (Output)</label>
                                <select class="form-select @error('product_kode') is-invalid @enderror" id="product_kode"
                                    name="product_kode" required>
                                    <option value="" disabled>-- Pilih Kode Produk --</option>
                                    @php
                                        // Ambil kode produk dari WO yang ada, contoh: dari '86002058T' ambil '002'
                                        $currentKode = substr($workOrder->wo_number, 2, 3);
                                    @endphp
                                    @foreach ($products as $product)
                                        <option value="{{ $product->kode }}"
                                            @if ($product->kode == $currentKode) selected @endif>
                                            {{ $product->kode }} - {{ $product->description }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="due_date" class="form-label">Due Date</label>
                                <input type="date" class="form-control @error('due_date') is-invalid @enderror"
                                    id="due_date" name="due_date"
                                    value="{{ old('due_date', $workOrder->due_date->format('Y-m-d')) }}" required>
                                @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary me-2">Batal</a>
                                <button type="submit" class="btn btn-primary">Update Work Order</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
