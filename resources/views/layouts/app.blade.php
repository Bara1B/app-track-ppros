<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('phapros-favicon.ico') }}" type="image/x-icon">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS v4 via Vite -->

    <!-- Custom CSS -->
    @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js', 'resources/css/tracking.css', 'resources/css/custom-table.css', 'resources/css/sidebar.css', 'resources/css/admin-home.css'])

    @stack('styles')
</head>

<body class="bg-gray-50">
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

        <!-- Notification Component -->
        <x-notification />

        <!-- Enhanced Verification Manager -->
        <x-verification-manager :work-order-id="request()->route('workOrder')" />

        @if (Auth::user() && Auth::user()->role === 'admin')
            <!-- Unified Sidebar & Navbar Layout -->
            @include('layouts.sidebar')
        @else
            <!-- Layout untuk User Biasa -->
            <div class="min-h-screen bg-gray-50">
                <!-- Top Navigation Bar -->
                <nav class="bg-white shadow-lg border-b border-gray-200">
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

                            <!-- Right side - User Menu -->
                            <div class="flex items-center space-x-4">
                                <div class="relative">
                                    <button
                                        class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 transition-colors duration-200">
                                        <div
                                            class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-semibold">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                        <span
                                            class="hidden md:block text-sm font-medium">{{ Auth::user()->name }}</span>
                                    </button>
                                </div>

                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="text-gray-700 hover:text-red-600 transition-colors duration-200">
                                    <i class="fas fa-sign-out-alt"></i>
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Main Content -->
                <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                    @yield('content')
                </main>
            </div>
        @endif
    </div>

    @stack('scripts')
</body>

</html>
