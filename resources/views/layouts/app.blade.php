<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('phapros-favicon.ico') }}" type="image/x-icon">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/tracking.css', 'resources/css/custom-table.css'])
    @stack('styles')
    <style>
        /* Style untuk tombol toggle dark mode */
        .theme-switch-wrapper {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .theme-switch {
            display: inline-block;
            height: 24px;
            position: relative;
            width: 48px;
        }

        .theme-switch input {
            display: none;
        }

        .slider {
            background-color: #ccc;
            bottom: 0;
            cursor: pointer;
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            transition: .4s;
        }

        .slider:before {
            background-color: #fff;
            bottom: 4px;
            content: "";
            height: 16px;
            left: 4px;
            position: absolute;
            transition: .4s;
            width: 16px;
        }

        input:checked+.slider {
            background-color: #007bff;
        }

        input:checked+.slider:before {
            transform: translateX(24px);
        }

        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <div id="app">
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

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
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
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle fw-bold" href="#"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false" v-pre>
                                            {{ Auth::user()->name }}
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
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
        })();
    </script>
</body>

</html>
