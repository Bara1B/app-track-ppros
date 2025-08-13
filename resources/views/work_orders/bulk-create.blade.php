@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">➕ Tambah Work Order (Borongan)</h4>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Gunakan form ini untuk membuat beberapa Work Order sekaligus untuk produk dan
                            due date yang sama.</p>
                        <form action="{{ route('work-orders.bulk-store') }}" method="POST">
                            @csrf
                            {{-- Pilih Produk --}}
                            <div class="mb-3">
                                <label for="product_kode" class="form-label">Kode Produk</label>
                                <select class="form-select @error('product_kode') is-invalid @enderror" id="product_kode"
                                    name="product_kode" required>
                                    <option value="" selected disabled>-- Pilih Kode Produk --</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->kode }}"
                                            {{ old('product_kode') == $product->kode ? 'selected' : '' }}>
                                            {{ $product->kode }} - {{ $product->description }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Due Date --}}
                            <div class="mb-3">
                                <label for="due_date" class="form-label">Due Date</label>
                                <input type="date" class="form-control @error('due_date') is-invalid @enderror"
                                    id="due_date" name="due_date" value="{{ old('due_date') }}" required>
                                @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- ================================================ --}}
                            {{--    PERUBAHANNYA ADA DI SINI, BRO               --}}
                            {{-- ================================================ --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="start_sequence" class="form-label">Mulai dari Nomor Urut</label>
                                    <input type="number" class="form-control @error('start_sequence') is-invalid @enderror"
                                        id="start_sequence" name="start_sequence" value="{{ old('start_sequence') }}"
                                        placeholder="Contoh: 58" min="1" required>
                                    @error('start_sequence')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="quantity" class="form-label">Jumlah WO yang Dibuat</label>
                                    <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                        id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="1"
                                        max="50" required>
                                    @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="d-flex justify-content-end">
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary me-2">Batal</a>
                                <button type="submit" class="btn btn-primary">Generate Work Orders</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
