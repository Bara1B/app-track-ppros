<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy"
        content="default-src 'self' 'unsafe-inline' 'unsafe-eval' data: blob: http: https:; style-src 'self' 'unsafe-inline' http: https:; script-src 'self' 'unsafe-inline' 'unsafe-eval' http: https:; img-src 'self' data: blob: http: https:; font-src 'self' data: http: https:; connect-src 'self' http: https: ws: wss:;">
    <link rel="icon" href="{{ asset('phapros-favicon.ico') }}" type="image/x-icon">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js', 'resources/css/tracking.css', 'resources/css/layouts-app.css', 'resources/css/custom-table.css'])
    @stack('styles')
</head>

<body>
    <div id="app">
        <!-- Global Loading Overlay (hidden by default) -->
        <div id="global-loading"
             class="hidden fixed inset-0 z-50 bg-gray-900/50 backdrop-blur-sm items-center justify-center">
            <div class="flex flex-col items-center gap-3 p-6 bg-white rounded-lg shadow-lg">
                <!-- Spinner -->
                <svg class="animate-spin h-8 w-8 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                <p class="text-sm text-gray-700 font-medium">Memproses... Mohon tunggu</p>
            </div>
        </div>
        <div id="main-wrapper">
            <!-- Sidebar -->
            <aside class="sidebar">
                @include('layouts.sidebar')
            </aside>

            <!-- Content Wrapper -->
            <div class="content-wrapper">
                <!-- Top Navbar -->
                <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                    <div class="container-fluid">
                        <!-- Tombol Toggle Sidebar -->
                        <button class="btn btn-light" id="sidebar-toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <line x1="3" y1="12" x2="21" y2="12"></line>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <line x1="3" y1="18" x2="21" y2="18"></line>
                            </svg>
                        </button>

                        <div class="navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto align-items-center">
                                @guest
                                    @if (Route::has('login'))
                                        <li class="nav-item">
                                            <a class="btn btn-sm btn-nav-login me-2" href="{{ route('login') }}">Login</a>
                                        </li>
                                    @endif
                                    @if (Route::has('register'))
                                        <li class="nav-item">
                                            <a class="btn btn-sm btn-nav-register"
                                                href="{{ route('register') }}">Register</a>
                                        </li>
                                    @endif
                                @else
                                    <li class="nav-item me-3">
                                        <div class="theme-switch-wrapper">
                                            <label class="theme-switch" for="theme-checkbox">
                                                <input type="checkbox" id="theme-checkbox" />
                                                <div class="slider round"></div>
                                            </label>
                                        </div>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle fw-bold d-flex align-items-center gap-2" href="#"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false" v-pre>
                                            <span class="rounded-circle d-inline-flex justify-content-center align-items-center"
                                                style="width:28px;height:28px;background:linear-gradient(135deg,#6b7280,#374151);color:#fff;font-weight:700;font-size:.8rem;">
                                                {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                                            </span>
                                            <span style="color:#374151;">{{ Auth::user()->name }}</span>
                                        </a>
                                        <div id="profile-dropdown-menu" class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <svg class="dropdown-icon" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24" fill="currentColor">
                                                    <path
                                                        d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22ZM13 12V18H11V12H13ZM12 6C12.5523 6 13 6.44772 13 7V10C13 10.5523 12.5523 11 12 11C11.4477 11 11 10.5523 11 10V7C11 6.44772 11.4477 6 12 6Z">
                                                    </path>
                                                </svg>
                                                Logout
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                @endguest
                            </ul>
                        </div>
                    </div>
                </nav>

                <!-- Main Content -->
                <main class="py-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
    @stack('scripts')

    <script>
        // Logika untuk Dark Mode & Sidebar Toggle
        (function() {
            // Loading Overlay helpers (improved)
            const loadingEl = document.getElementById('global-loading');
            let pendingShowTimer = null;
            let maxHideTimer = null;

            function reallyShow() {
                if (!loadingEl) return;
                loadingEl.classList.remove('hidden');
                loadingEl.classList.add('flex');
                // Fallback to inline style in case CSS classes are not present/applied yet
                loadingEl.style.display = 'flex';
                // Auto-hide fallback (3s) agar overlay tidak terasa lama
                clearTimeout(maxHideTimer);
                maxHideTimer = setTimeout(() => {
                    hideLoading();
                }, 3000);
            }

            function scheduleShow(delayMs = 200) {
                clearTimeout(pendingShowTimer);
                pendingShowTimer = setTimeout(() => {
                    reallyShow();
                }, delayMs);
            }

            function cancelScheduledShow() {
                clearTimeout(pendingShowTimer);
                pendingShowTimer = null;
            }

            function hideLoading() {
                cancelScheduledShow();
                clearTimeout(maxHideTimer);
                if (!loadingEl) return;
                loadingEl.classList.add('hidden');
                loadingEl.classList.remove('flex');
                // Hide via inline style as well
                loadingEl.style.display = 'none';
            }

            // Expose for manual trigger/debugging
            window.showGlobalLoading = () => scheduleShow(0);
            window.hideGlobalLoading = hideLoading;

            // Tampilkan loading pada submit form halaman manapun (dengan delayed show agar respons cepat tidak terasa lama)
            document.addEventListener('submit', function() {
                scheduleShow(300);
            }, true);

            // Tampilkan loading saat klik elemen dengan atribut data-loading (sedikit lebih cepat)
            document.addEventListener('click', function(e) {
                const target = e.target.closest('[data-loading]');
                if (target) scheduleShow(200);
            });

            // Sembunyikan loading pada event halaman yang cepat muncul setelah navigasi/restore
            window.addEventListener('DOMContentLoaded', hideLoading);
            window.addEventListener('pageshow', hideLoading);
            window.addEventListener('pagehide', hideLoading);
            document.addEventListener('visibilitychange', function() {
                if (document.visibilityState === 'visible') hideLoading();
            });

            // Batalkan show saat akan berpindah halaman
            window.addEventListener('beforeunload', function() {
                cancelScheduledShow();
            });

            // Axios interceptors (jika tersedia)
            if (window.axios && window.axios.interceptors) {
                window.axios.interceptors.request.use(function(config) {
                    scheduleShow(200);
                    return config;
                }, function(error) {
                    hideLoading();
                    return Promise.reject(error);
                });

                window.axios.interceptors.response.use(function(response) {
                    hideLoading();
                    return response;
                }, function(error) {
                    hideLoading();
                    return Promise.reject(error);
                });
            }

            // Logika Dark Mode
            const themeToggle = document.getElementById('theme-checkbox');
            const currentTheme = localStorage.getItem('theme');

            function setTheme(theme) {
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark-mode');
                    document.body.classList.add('dark-mode');
                    if (themeToggle) themeToggle.checked = true;
                } else {
                    document.documentElement.classList.remove('dark-mode');
                    document.body.classList.remove('dark-mode');
                    if (themeToggle) themeToggle.checked = false;
                }
            }

            if (currentTheme) {
                setTheme(currentTheme);
            } else {
                if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    setTheme('dark');
                }
            }

            if (themeToggle) {
                themeToggle.addEventListener('change', function() {
                    if (this.checked) {
                        localStorage.setItem('theme', 'dark');
                        setTheme('dark');
                    } else {
                        localStorage.setItem('theme', 'light');
                        setTheme('light');
                    }
                });
            }

            // Logika Sidebar
            const sidebar = document.querySelector('.sidebar');
            const toggleBtn = document.getElementById('sidebar-toggle');
            const sidebarState = localStorage.getItem('sidebarState');

            function setSidebarState(state) {
                if (sidebar && state === 'collapsed') {
                    sidebar.classList.add('collapsed');
                } else if (sidebar) {
                    sidebar.classList.remove('collapsed');
                }
            }

            if (sidebarState) {
                setSidebarState(sidebarState);
            }

            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    if (sidebar) {
                        sidebar.classList.toggle('collapsed');
                        const newState = sidebar.classList.contains('collapsed') ? 'collapsed' : 'expanded';
                        localStorage.setItem('sidebarState', newState);
                    }
                });
            }

            // Pastikan dropdown profil bisa terbuka walau data attribute tidak terproses
            const profileToggle = document.getElementById('navbarDropdown');
            const profileDropdown = profileToggle?.nextElementSibling;

            if (profileToggle && profileDropdown) {
                profileToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    // Toggle dropdown manually
                    const isVisible = profileDropdown.style.display === 'block';
                    profileDropdown.style.display = isVisible ? 'none' : 'block';

                    // Close dropdown when clicking outside
                    document.addEventListener('click', function closeDropdown(e) {
                        if (!profileToggle.contains(e.target) && !profileDropdown.contains(e.target)) {
                            profileDropdown.style.display = 'none';
                            document.removeEventListener('click', closeDropdown);
                        }
                    });
                });
            }

            // Toggle for Settings submenu in sidebar
            const settingsSubmenu = document.getElementById('settings-submenu');
            const settingsChevron = document.getElementById('settings-chevron');

            function setChevron(state) {
                if (!settingsChevron) return;
                settingsChevron.style.transform = state === 'open' ? 'rotate(180deg)' : 'rotate(0deg)';
            }

            // Initialize chevron state based on submenu visibility
            if (settingsSubmenu) {
                const isHidden = settingsSubmenu.classList.contains('hidden');
                setChevron(isHidden ? 'closed' : 'open');
            }

            // Expose toggle so it can be called from onclick in sidebar
            window.toggleSettingsDropdown = function() {
                if (!settingsSubmenu) return;
                const isHidden = settingsSubmenu.classList.contains('hidden');
                if (isHidden) {
                    settingsSubmenu.classList.remove('hidden');
                    setChevron('open');
                } else {
                    settingsSubmenu.classList.add('hidden');
                    setChevron('closed');
                }
            }
        })();
    </script>
</body>

</html>
