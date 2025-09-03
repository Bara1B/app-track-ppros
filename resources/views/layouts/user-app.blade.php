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
    @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js', 'resources/css/tracking.css', 'resources/css/layouts-app.css', 'resources/css/custom-table.css', 'resources/css/user-navbar.css'])
    @stack('styles')
</head>

<body>
    <div id="app">
        <!-- Global Loading Overlay -->
        <div id="global-loading"
            class="hidden fixed inset-0 z-50 bg-gray-900/50 backdrop-blur-sm items-center justify-center">
            <div class="flex flex-col items-center gap-3 p-6 bg-white rounded-lg shadow-lg">
                <svg class="animate-spin h-8 w-8 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                <p class="text-sm text-gray-700 font-medium">Memproses... Mohon tunggu</p>
            </div>
        </div>

        <!-- Layout untuk User dengan Navbar -->
        <div class="min-h-screen bg-gray-50">
            <!-- Top Navigation Bar -->
            <nav class="bg-white shadow-lg border-b border-gray-200 sticky top-0 z-40">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <!-- Left side - Logo & Brand -->
                        <div class="flex items-center">
                            <div class="flex-shrink-0 flex items-center">
                                <div
                                    class="w-8 h-8 bg-gradient-to-br from-blue-600 to-cyan-600 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
                                    </svg>
                                </div>
                                <span class="text-xl font-bold text-gray-900">Pharmaceutical Tracker</span>
                            </div>
                        </div>

                        <!-- Center - Navigation Links -->
                        <div class="hidden md:flex items-center space-x-8">
                            <a href="{{ route('home') }}"
                                class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('home') ? 'text-blue-600 bg-blue-50' : '' }}">
                                <i class="fas fa-home mr-2"></i>Home
                            </a>
                            <a href="{{ route('dashboard') }}"
                                class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('dashboard*') ? 'text-blue-600 bg-blue-50' : '' }}">
                                <i class="fas fa-clipboard-list mr-2"></i>Work Orders
                            </a>
                            <a href="{{ route('stock-opname.index') }}"
                                class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('stock-opname.*') ? 'text-blue-600 bg-blue-50' : '' }}">
                                <i class="fas fa-boxes mr-2"></i>Stock Opname
                            </a>
                        </div>

                        <!-- Right side - User Menu & Theme Toggle -->
                        <div class="flex items-center space-x-4">
                            <!-- Theme Toggle -->
                            <div class="theme-switch-wrapper">
                                <label class="theme-switch" for="theme-checkbox">
                                    <input type="checkbox" id="theme-checkbox" />
                                    <div class="slider round"></div>
                                </label>
                            </div>

                            <!-- User Dropdown -->
                            <div class="relative">
                                <button id="user-menu-button"
                                    class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                    aria-expanded="false" aria-haspopup="true">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-br from-blue-600 to-cyan-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                    <span
                                        class="ml-2 text-gray-700 font-medium hidden md:block">{{ Auth::user()->name }}</span>
                                    <svg class="ml-2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <!-- Dropdown menu -->
                                <div id="user-dropdown-menu"
                                    class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200">
                                    <div class="px-4 py-2 text-sm text-gray-700 border-b border-gray-100">
                                        <div class="font-medium">{{ Auth::user()->name }}</div>
                                        <div class="text-gray-500">{{ Auth::user()->email }}</div>
                                    </div>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Navigation -->
                <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-200">
                    <div class="px-2 pt-2 pb-3 space-y-1">
                        <a href="{{ route('home') }}"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-colors duration-200 {{ request()->routeIs('home') ? 'text-blue-600 bg-blue-50' : '' }}">
                            <i class="fas fa-home mr-2"></i>Home
                        </a>
                        <a href="{{ route('dashboard') }}"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-colors duration-200 {{ request()->routeIs('dashboard*') ? 'text-blue-600 bg-blue-50' : '' }}">
                            <i class="fas fa-clipboard-list mr-2"></i>Work Orders
                        </a>
                        <a href="{{ route('stock-opname.index') }}"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-colors duration-200 {{ request()->routeIs('stock-opname.*') ? 'text-blue-600 bg-blue-50' : '' }}">
                            <i class="fas fa-boxes mr-2"></i>Stock Opname
                        </a>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="py-6">
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')

    <script>
        // Loading Overlay helpers
        const loadingEl = document.getElementById('global-loading');
        let pendingShowTimer = null;
        let maxHideTimer = null;

        function reallyShow() {
            if (!loadingEl) return;
            loadingEl.classList.remove('hidden');
            loadingEl.classList.add('flex');
            loadingEl.style.display = 'flex';
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

        function hideLoading() {
            clearTimeout(pendingShowTimer);
            clearTimeout(maxHideTimer);
            if (!loadingEl) return;
            loadingEl.classList.add('hidden');
            loadingEl.classList.remove('flex');
            loadingEl.style.display = 'none';
        }

        window.showGlobalLoading = () => scheduleShow(0);
        window.hideGlobalLoading = hideLoading;

        // Form submit loading
        document.addEventListener('submit', function() {
            scheduleShow(300);
        }, true);

        // User Dropdown Logic
        const userMenuButton = document.getElementById('user-menu-button');
        const userDropdownMenu = document.getElementById('user-dropdown-menu');

        if (userMenuButton && userDropdownMenu) {
            userMenuButton.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const isVisible = userDropdownMenu.classList.contains('hidden');
                if (isVisible) {
                    userDropdownMenu.classList.remove('hidden');
                    userMenuButton.setAttribute('aria-expanded', 'true');
                } else {
                    userDropdownMenu.classList.add('hidden');
                    userMenuButton.setAttribute('aria-expanded', 'false');
                }
            });

            document.addEventListener('click', function(e) {
                if (!userMenuButton.contains(e.target) && !userDropdownMenu.contains(e.target)) {
                    userDropdownMenu.classList.add('hidden');
                    userMenuButton.setAttribute('aria-expanded', 'false');
                }
            });
        }

        // Theme Toggle Logic
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
    </script>
</body>

</html>
