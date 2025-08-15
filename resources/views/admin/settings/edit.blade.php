@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Pengaturan Nomor WO</h5>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <form method="POST" action="{{ route('settings.update') }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Prefix Tahun (contoh: 86)</label>
                                <input type="text" name="wo_year_prefix"
                                    class="form-control @error('wo_year_prefix') is-invalid @enderror"
                                    value="{{ old('wo_year_prefix', $prefix->value) }}" maxlength="4" required>
                                @error('wo_year_prefix')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-end">
                                <button class="btn btn-primary" type="submit">Simpan</button>
                            </div>
                        </form>

                        <hr class="my-4">
                        <h6 class="text-danger mb-3">Reset Semua Tabel (Danger Zone)</h6>
                        <form method="POST" action="{{ route('settings.reset') }}"
                            onsubmit="return confirm('Tindakan ini akan menghapus semua data dan mengembalikan ke kondisi awal. Lanjutkan?')">
                            @csrf
                            @method('DELETE')
                            <div class="mb-3">
                                <label class="form-label">Ketik <strong>HAPUS</strong> untuk konfirmasi</label>
                                <input type="text" name="confirm"
                                    class="form-control @error('confirm') is-invalid @enderror" placeholder="HAPUS"
                                    required>
                                @error('confirm')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-danger">Reset Database</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
