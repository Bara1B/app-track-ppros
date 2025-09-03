@extends('layouts.app')

@section('title', 'Pengaturan Admin')

@section('content')
    <div class="settings-container">
        <div class="container mx-auto px-4">
            <!-- Settings Header -->
            <div class="settings-header text-center">
                <h1 class="settings-title">Pengaturan Admin</h1>
                <p class="settings-subtitle">Kelola sistem dan konfigurasi aplikasi</p>
            </div>

            <div class="max-w-6xl mx-auto">
                <div class="settings-card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="card-title">Dashboard Pengaturan</h2>
                            <a href="{{ route('admin.home') }}" class="back-link">
                                <i class="fas fa-arrow-left"></i>Kembali
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Statistics Cards -->
                        <div class="stats-grid">
                            <div class="stat-card stat-users">
                                <div class="stat-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="stat-number">{{ $stats['total_users'] ?? 0 }}</div>
                                <div class="stat-label">Total Users</div>
                            </div>

                            <div class="stat-card stat-admin">
                                <div class="stat-icon">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                                <div class="stat-number">{{ $stats['admin_users'] ?? 0 }}</div>
                                <div class="stat-label">Admin Users</div>
                            </div>

                            <div class="stat-card stat-regular">
                                <div class="stat-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="stat-number">{{ $stats['regular_users'] ?? 0 }}</div>
                                <div class="stat-label">Regular Users</div>
                            </div>
                        </div>

                        <!-- Settings Sections -->
                        <div class="settings-grid">
                            <!-- Work Order Settings -->
                            <div class="setting-item">
                                <div class="setting-header">
                                    <h3 class="setting-title">Settings Sistem</h3>
                                    <div class="setting-icon">
                                        <i class="fas fa-cogs"></i>
                                    </div>
                                </div>
                                <div class="setting-description">
                                    Konfigurasi pengaturan untuk Work Order tracking dan Stock Opname
                                </div>
                                <div class="setting-control">
                                    <a href="{{ route('settings.edit') }}" class="btn-save">
                                        <i class="fas fa-edit me-2"></i>Edit Settings
                                    </a>
                                </div>
                            </div>

                            <!-- User Management -->
                            <div class="setting-item">
                                <div class="setting-header">
                                    <h3 class="setting-title">User Management</h3>
                                    <div class="setting-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                                <div class="setting-description">
                                    Kelola user accounts, roles, dan permissions
                                </div>
                                <div class="setting-control">
                                    <a href="{{ route('admin.settings.users') }}" class="btn-save">
                                        <i class="fas fa-users me-2"></i>Manage Users
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Users -->
                        <div class="setting-item">
                            <div class="setting-header">
                                <h3 class="setting-title">Recent Users</h3>
                                <div class="setting-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                            <div class="setting-description">
                                Daftar user yang baru-baru ini ditambahkan ke sistem
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Created</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($users as $user)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm me-2">
                                                            <i class="fas fa-user-circle fa-2x text-primary"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-bold">{{ $user->name }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    <span
                                                        class="badge {{ $user->role === 'admin' ? 'bg-danger' : 'bg-success' }}">
                                                        {{ ucfirst($user->role) }}
                                                    </span>
                                                </td>
                                                <td>{{ $user->created_at->format('d M Y') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">
                                                    <i class="fas fa-info-circle me-2"></i>No users found
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if ($users->hasPages())
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $users->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
