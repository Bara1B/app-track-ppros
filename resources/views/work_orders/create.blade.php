@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">➕ Tambah Work Order</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('work-orders.store') }}">
                            @csrf

                            {{-- 1. DROPDOWN KODE PRODUK --}}
                            <div class="mb-3">
                                <label for="product_kode" class="form-label">Kode Produk</label>
                                <select class="form-select" id="product_kode" name="product_kode" required>
                                    <option value="" selected disabled>-- Pilih Kode Produk --</option>

                                    {{-- Pastikan variabelnya $products --}}
                                    @foreach ($products as $product)
                                        <option value="{{ $product->kode }}" data-item-number="{{ $product->item_number }}">
                                            {{ $product->kode }} - {{ $product->description }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- 2. NAMA PRODUK (OTOMATIS) --}}
                            <div class="mb-3">
                                <label for="output" class="form-label">Nama Produk (Output)</label>
                                <input type="text" class="form-control" id="output" name="output" readonly>
                            </div>

                            {{-- 3. NOMOR URUT & DUE DATE --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="sequence" class="form-label">Nomor Urut WO</label>
                                    <input type="text" class="form-control @error('sequence') is-invalid @enderror"
                                        id="sequence" name="sequence" required maxlength="3" placeholder="Contoh: 58">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="due_date" class="form-label">Due Date</label>
                                    <input type="date" class="form-control @error('due_date') is-invalid @enderror"
                                        id="due_date" name="due_date" required>
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Input tersembunyi untuk data yang akan disimpan --}}
                            <input type="hidden" name="wo_number" id="wo_number">
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary me-2">Batal</a>
                                <button type="submit" class="btn btn-primary" id="submit_button" disabled>Simpan Work
                                    Order</button>
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
            // Ambil semua elemen form yang kita butuhin
            const productKodeSelect = document.getElementById('product_kode');
            const outputInput = document.getElementById('output');
            const sequenceInput = document.getElementById('sequence');
            const finalWoDisplay = document.getElementById('final_wo_display');
            const woNumberInput = document.getElementById('wo_number');
            const submitButton = document.getElementById('submit_button');

            // Fungsi buat update Nomor WO final
            function updateFinalWoNumber() {
                const selectedKode = productKodeSelect.value;
                const sequence = sequenceInput.value;
                const selectedOption = productKodeSelect.options[productKodeSelect.selectedIndex];

                // Cuma jalanin kalo kode produk dan nomor urut udah diisi
                if (selectedKode && sequence && selectedOption) {
                    const itemNumber = selectedOption.dataset.itemNumber;
                    const year = '86';
                    const suffix = itemNumber.slice(-1);

                    // Pastiin sequence selalu 3 digit (format penyimpanan), input user tidak wajib 0 di depan
                    const paddedSequence = String(sequence).padStart(3, '0');

                    const finalWoNumber = `${year}${selectedKode}${paddedSequence}${suffix}`;
                    woNumberInput.value = finalWoNumber;
                    submitButton.disabled = false; // Aktifin tombol simpan
                } else {
                    woNumberInput.value = '';
                    submitButton.disabled = true; // Non-aktifin kalo belum lengkap
                }
            }

            // Event listener buat dropdown produk
            productKodeSelect.addEventListener('change', async function() {
                const selectedKode = this.value;
                if (!selectedKode) {
                    outputInput.value = '';
                    updateFinalWoNumber();
                    return;
                }

                outputInput.value = 'Memuat...';

                try {
                    const response = await fetch(`/api/product/${selectedKode}`);
                    if (!response.ok) throw new Error('Produk tidak ditemukan.');

                    const product = await response.json();
                    outputInput.value = product.description;

                    // Panggil fungsi update setelah nama produk terisi
                    updateFinalWoNumber();
                } catch (error) {
                    console.error(error);
                    outputInput.value = 'Error';
                }
            });

            // Event listener buat input nomor urut manual
            sequenceInput.addEventListener('input', function() {
                // Hanya izinkan angka dan batasi 3 digit saat menyimpan, namun input boleh tanpa 0 depan
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3);
                updateFinalWoNumber();
            });
        });
    </script>
@endpush
