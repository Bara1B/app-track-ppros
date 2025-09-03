@php
    $isAdmin = Auth::user() && Auth::user()->role === 'admin';
    $currentRoute = request()->route()->getName();
@endphp

<!-- Top Navbar (Fixed at top) -->
<div class="top-navbar" id="topNavbar">
    <div class="navbar-content">
        <div class="navbar-left">
            <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle Sidebar">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <div class="navbar-right">
            <div class="navbar-user">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Unified Sidebar -->
<div class="unified-sidebar" id="unifiedSidebar">
    <!-- Sidebar Header (Logo only) -->
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <img src="{{ asset('images/logoPhapros.png') }}" alt="Phapros Logo" class="sidebar-logo-img">
        </div>
    </div>

    <!-- Sidebar Menu -->
    <div class="sidebar-menu">
        @if ($isAdmin)
            <!-- Main Section -->
            <div class="menu-section">
                <div class="menu-title">Main</div>
                <ul class="menu-list">
                    <li class="menu-item">
                        <a href="{{ route('admin.home') }}"
                            class="menu-link {{ $currentRoute === 'admin.home' ? 'active' : '' }}">
                            <i class="fas fa-home menu-icon"></i>
                            <span class="menu-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('dashboard') }}"
                            class="menu-link {{ $currentRoute === 'dashboard' ? 'active' : '' }}">
                            <i class="fas fa-clipboard-list menu-icon"></i>
                            <span class="menu-text">Work Orders</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.stock-opname.index') }}"
                            class="menu-link {{ str_contains($currentRoute, 'stock-opname') ? 'active' : '' }}">
                            <i class="fas fa-boxes menu-icon"></i>
                            <span class="menu-text">Stock Opname</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Data Management Section -->
            <div class="menu-section">
                <div class="menu-title">Data</div>
                <ul class="menu-list">
                    <li class="menu-item">
                        <a href="{{ route('overmate.index') }}"
                            class="menu-link {{ str_contains($currentRoute, 'overmate') ? 'active' : '' }}">
                            <i class="fas fa-database menu-icon"></i>
                            <span class="menu-text">Overmate Data</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('work-orders.data.index') }}"
                            class="menu-link {{ str_contains($currentRoute, 'work-orders.data') ? 'active' : '' }}">
                            <i class="fas fa-file-alt menu-icon"></i>
                            <span class="menu-text">Work Order Data</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- System Section -->
            <div class="menu-section">
                <div class="menu-title">System</div>
                <ul class="menu-list">
                    <li class="menu-item">
                        <a href="{{ route('settings.edit') }}"
                            class="menu-link {{ str_contains($currentRoute, 'settings.edit') ? 'active' : '' }}">
                            <i class="fas fa-cog menu-icon"></i>
                            <span class="menu-text">Settings</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.settings.users') }}"
                            class="menu-link {{ str_starts_with($currentRoute, 'admin.settings.users') ? 'active' : '' }}">
                            <i class="fas fa-users menu-icon"></i>
                            <span class="menu-text">Users</span>
                        </a>
                    </li>
                </ul>
            </div>
        @else
            <!-- Public User Menu -->
            <div class="menu-section">
                <ul class="menu-list">
                    <li class="menu-item">
                        <a href="{{ route('public.home') }}"
                            class="menu-link {{ str_contains($currentRoute, 'public') ? 'active' : '' }}">
                            <i class="fas fa-arrow-left menu-icon"></i>
                            <span class="menu-text">Back to Public</span>
                        </a>
                    </li>
                </ul>
            </div>
        @endif
    </div>

    <!-- Sidebar Footer (Profile + Logout) -->
    <div class="sidebar-footer">
        <div class="sidebar-profile">
            <div class="profile-icon">
                <span>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
            </div>
            <div class="profile-info">
                <div class="profile-name">{{ Auth::user()->name }}</div>
                <div class="profile-role">{{ ucfirst(Auth::user()->role) }}</div>
            </div>
        </div>

        <a href="#" class="logout-link"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt menu-icon"></i>
            <span class="menu-text">Logout</span>
        </a>

        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
            @csrf
        </form>
    </div>
</div>

<!-- Mobile Overlay -->
<div class="mobile-overlay hidden" id="mobileOverlay"></div>

<!-- Main Content Wrapper -->
<div class="main-content" id="mainContent">
    <!-- Your page content goes here -->
    @yield('content')
</div>

<script>
    // Prevent flash by setting state immediately (inline script)
    (function() {
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        if (isCollapsed) {
            document.documentElement.classList.add('sidebar-collapsed');
        }
        // Add loaded class after a brief delay to ensure styles are applied
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                document.documentElement.classList.add('loaded');
            });
        });
    })();

    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('unifiedSidebar');
        const mainContent = document.getElementById('mainContent');
        const toggleBtn = document.getElementById('sidebarToggle');
        const mobileOverlay = document.getElementById('mobileOverlay');

        // Check if sidebar should be collapsed on load
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        if (isCollapsed) {
            sidebar.classList.add('collapsed');
            mainContent.classList.add('collapsed');
        }

        // Toggle sidebar
        function toggleSidebar() {
            const isCollapsed = sidebar.classList.contains('collapsed');

            if (window.innerWidth <= 768) {
                // Mobile behavior
                sidebar.classList.toggle('open');
                mobileOverlay.classList.toggle('hidden');
                document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
            } else {
                // Desktop behavior - add collapsing class for smooth transition
                document.body.classList.add('sidebar-collapsing');

                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('collapsed');
                document.documentElement.classList.toggle('sidebar-collapsed');
                localStorage.setItem('sidebarCollapsed', !isCollapsed);

                // Remove collapsing class after transition
                setTimeout(() => {
                    document.body.classList.remove('sidebar-collapsing');
                }, 300);
            }
        }

        // Event listeners
        toggleBtn.addEventListener('click', toggleSidebar);
        mobileOverlay.addEventListener('click', toggleSidebar);

        // Close sidebar on window resize if mobile
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('open');
                mobileOverlay.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });
    });
</script>
