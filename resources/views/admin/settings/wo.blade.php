@extends('layouts.app')

@section('title', 'Pengaturan Work Order')

@section('content')
    <div class="settings-container">
        <div class="container mx-auto px-4">
            <!-- Settings Header -->
            <div class="settings-header text-center">
                <h1 class="settings-title">Pengaturan Work Order</h1>
                <p class="settings-subtitle">Konfigurasi sistem dan fitur Work Order</p>
            </div>

            <div class="max-w-6xl mx-auto">
                <div class="settings-card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="card-title">Pengaturan Work Order</h2>
                            <a href="{{ route('admin.home') }}" class="back-link">
                                <i class="fas fa-arrow-left"></i>Kembali
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-error">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('settings.update') }}" class="settings-form">
                            @csrf
                            @method('PUT')

                            <div class="settings-grid">
                                <!-- Work Order Prefix -->
                                <div class="setting-item wo-prefix-setting">
                                    <div class="setting-header">
                                        <h3 class="setting-title">Prefix Nomor Work Order</h3>
                                        <div class="setting-icon">
                                            <i class="fas fa-hashtag"></i>
                                        </div>
                                    </div>
                                    <div class="setting-description">
                                        Prefix untuk nomor Work Order yang akan digunakan sistem
                                    </div>
                                    <div class="setting-control">
                                        <input type="text" id="wo_prefix" name="wo_prefix"
                                            value="{{ $settings['wo_prefix'] ?? '86' }}" required maxlength="10"
                                            class="prefix-input" placeholder="86">
                                        <div class="prefix-example">
                                            Contoh: {{ $settings['wo_prefix'] ?? '86' }}002001T
                                        </div>
                                    </div>
                                </div>

                                <!-- Work Order Tracking -->
                                <div class="setting-item">
                                    <div class="setting-header">
                                        <h3 class="setting-title">Work Order Tracking</h3>
                                        <div class="setting-icon">
                                            <i class="fas fa-route"></i>
                                        </div>
                                    </div>
                                    <div class="setting-description">
                                        Mengaktifkan fitur tracking progress work order
                                    </div>
                                    <div class="setting-control">
                                        <div class="form-check">
                                            <input type="checkbox" id="wo_tracking_enabled" name="wo_tracking_enabled"
                                                value="1" {{ $settings['wo_tracking_enabled'] ? 'checked' : '' }}
                                                class="form-check-input">
                                            <label for="wo_tracking_enabled" class="form-check-label">
                                                Aktifkan Work Order Tracking
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Stock Opname -->
                                <div class="setting-item">
                                    <div class="setting-header">
                                        <h3 class="setting-title">Stock Opname</h3>
                                        <div class="setting-icon">
                                            <i class="fas fa-boxes"></i>
                                        </div>
                                    </div>
                                    <div class="setting-description">
                                        Mengaktifkan fitur stock opname dan inventory
                                    </div>
                                    <div class="setting-control">
                                        <div class="form-check">
                                            <input type="checkbox" id="stock_opname_enabled" name="stock_opname_enabled"
                                                value="1" {{ $settings['stock_opname_enabled'] ? 'checked' : '' }}
                                                class="form-check-input">
                                            <label for="stock_opname_enabled" class="form-check-label">
                                                Aktifkan Stock Opname
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Overmate -->
                                <div class="setting-item">
                                    <div class="setting-header">
                                        <h3 class="setting-title">Overmate</h3>
                                        <div class="setting-icon">
                                            <i class="fas fa-cogs"></i>
                                        </div>
                                    </div>
                                    <div class="setting-description">
                                        Mengaktifkan fitur overmate dan material management
                                    </div>
                                    <div class="setting-control">
                                        <div class="form-check">
                                            <input type="checkbox" id="overmate_enabled" name="overmate_enabled"
                                                value="1" {{ $settings['overmate_enabled'] ? 'checked' : '' }}
                                                class="form-check-input">
                                            <label for="overmate_enabled" class="form-check-label">
                                                Aktifkan Overmate
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="settings-actions">
                                <button type="button" onclick="resetSettings()" class="btn-reset">
                                    <i class="fas fa-undo me-2"></i>Reset ke Default
                                </button>

                                <div class="btn-group">
                                    <a href="{{ route('admin.home') }}" class="btn-cancel">
                                        Batal
                                    </a>
                                    <button type="submit" class="btn-save">
                                        <i class="fas fa-save"></i>Simpan Pengaturan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function resetSettings() {
            if (confirm('Apakah Anda yakin ingin mereset semua pengaturan ke default?')) {
                window.location.href = '{{ route('settings.reset') }}';
            }
        }

        // Update prefix example in real-time
        document.getElementById('wo_prefix').addEventListener('input', function() {
            const prefix = this.value || '86';
            const example = document.querySelector('.prefix-example');
            example.textContent = `Contoh: ${prefix}002001T`;
        });
    </script>
@endsection
