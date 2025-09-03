<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Work Order Tracking</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/css/user-home.css', 'resources/js/app.js'])

    <style>
        /* Initial load animations */
        .initial-fade-in {
            opacity: 0;
            transform: translateY(30px);
            animation: initialFadeIn 1.5s ease-out forwards;
        }

        .initial-fade-in-left {
            opacity: 0;
            transform: translateX(-30px);
            animation: initialFadeInLeft 1.5s ease-out forwards;
        }

        .initial-fade-in-right {
            opacity: 0;
            transform: translateX(30px);
            animation: initialFadeInRight 1.5s ease-out forwards;
        }

        .initial-fade-in-scale {
            opacity: 0;
            transform: scale(0.9);
            animation: initialFadeInScale 1.5s ease-out forwards;
        }

        .initial-fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            animation: initialFadeInUp 1.5s ease-out forwards;
        }

        /* Initial stagger delays */
        .initial-stagger-1 {
            animation-delay: 0.2s;
        }

        .initial-stagger-2 {
            animation-delay: 0.4s;
        }

        .initial-stagger-3 {
            animation-delay: 0.6s;
        }

        .initial-stagger-4 {
            animation-delay: 0.8s;
        }

        .initial-stagger-5 {
            animation-delay: 1.0s;
        }

        /* Keyframes for initial animations */
        @keyframes initialFadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes initialFadeInLeft {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes initialFadeInRight {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes initialFadeInScale {
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes initialFadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Scroll-triggered fade animations */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 1.2s ease-out;
        }

        .fade-in-left {
            opacity: 0;
            transform: translateX(-30px);
            transition: all 1.2s ease-out;
        }

        .fade-in-right {
            opacity: 0;
            transform: translateX(30px);
            transition: all 1.2s ease-out;
        }

        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            transition: all 1.2s ease-out;
        }

        .fade-in-scale {
            opacity: 0;
            transform: scale(0.9);
            transition: all 1.2s ease-out;
        }

        /* Stagger delays for multiple elements */
        .fade-stagger-1 {
            transition-delay: 0.2s;
        }

        .fade-stagger-2 {
            transition-delay: 0.4s;
        }

        .fade-stagger-3 {
            transition-delay: 0.6s;
        }

        .fade-stagger-4 {
            transition-delay: 0.8s;
        }

        .fade-stagger-5 {
            transition-delay: 1.0s;
        }

        /* Active states when element is visible */
        .fade-in.fade-in-active,
        .fade-in-left.fade-in-active,
        .fade-in-right.fade-in-active,
        .fade-in-up.fade-in-active,
        .fade-in-scale.fade-in-active {
            opacity: 1;
            transform: translate(0, 0) scale(1);
        }

        /* Fade out effect - elemen kembali ke kondisi awal */
        .fade-in:not(.fade-in-active),
        .fade-in-left:not(.fade-in-active),
        .fade-in-right:not(.fade-in-active),
        .fade-in-up:not(.fade-in-active),
        .fade-in-scale:not(.fade-in-active) {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease-in-out;
        }

        .fade-in-left:not(.fade-in-active) {
            transform: translateX(-30px);
        }

        .fade-in-right:not(.fade-in-active) {
            transform: translateX(30px);
        }

        .fade-in-scale:not(.fade-in-active) {
            transform: scale(0.9);
        }

        /* Scroll progress bar */
        .scroll-progress {
            width: 0%;
            transition: width 0.5s ease-out;
        }

        /* Directional fade-out states for scroll direction UX */
        .fade-out-up {
            opacity: 0 !important;
            transform: translateY(-20px) !important;
            transition: opacity 0.5s ease-in, transform 0.5s ease-in;
        }

        .fade-out-down {
            opacity: 0 !important;
            transform: translateY(20px) !important;
            transition: opacity 0.5s ease-in, transform 0.5s ease-in;
        }

        /* Hero background zoom-in on first load */
        .hero-bg-zoom {
            transform: scale(1.08);
            filter: saturate(1.05) contrast(1.02);
            will-change: transform, filter;
            animation: heroBgZoomIn 1.2s ease-out forwards;
            transform-origin: center top;
        }

        @keyframes heroBgZoomIn {
            to {
                transform: scale(1);
                filter: none;
            }
        }
    </style>
</head>

<body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-white to-orange-50">
    <div id="app">
        <!-- Navigation Bar -->
        <nav class="bg-white/80 backdrop-blur-md border-b border-gray-200 shadow-lg sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo & Brand -->
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img src="{{ asset('images/logoPhapros.png') }}" alt="Phapros Logo" class="h-10 w-auto">
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">Work Order Tracker</h1>
                            <p class="text-sm text-gray-600">Monitor Progress & Status</p>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="{{ route('public.home') }}"
                            class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                            Home
                        </a>
                        <a href="{{ route('public.work-orders') }}"
                            class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                            Work Orders
                        </a>
                        @if ($latestWorkOrder ?? false)
                            <a href="{{ route('public.tracking', $latestWorkOrder) }}"
                                class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                Latest Tracking
                            </a>
                        @endif
                    </div>

                    <!-- Login Button -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-orange-600 hover:from-blue-700 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                </path>
                            </svg>
                            Login
                        </a>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button type="button" id="mobile-menu-button"
                            class="text-gray-700 hover:text-blue-600 focus:outline-none focus:text-blue-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile menu -->
                <div class="md:hidden hidden" id="mobile-menu">
                    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 border-t border-gray-200">
                        <!-- Logo Phapros di mobile menu -->
                        <div class="flex items-center justify-center py-4 border-b border-gray-200">
                            <img src="{{ asset('images/logoPhapros.png') }}" alt="Phapros Logo" class="h-12 w-auto">
                        </div>

                        <a href="{{ route('public.home') }}"
                            class="text-gray-700 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">
                            Home
                        </a>
                        <a href="{{ route('public.work-orders') }}"
                            class="text-gray-700 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">
                            Work Orders
                        </a>
                        @if ($latestWorkOrder ?? false)
                            <a href="{{ route('public.tracking', $latestWorkOrder) }}"
                                class="text-gray-700 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">
                                Latest Tracking
                            </a>
                        @endif

                        <div class="pt-4">
                            <a href="{{ route('login') }}"
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-orange-600 hover:from-blue-700 hover:to-orange-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Login
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="min-h-screen">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-8 mt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <p class="text-gray-400">&copy; {{ date('Y') }} Work Order Tracker. All rights reserved.</p>
                    <p class="text-sm text-gray-500 mt-2">Monitor your work orders progress in real-time</p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuButton = document.getElementById('mobile-menu-button');

            if (!mobileMenu.contains(event.target) && !mobileMenuButton.contains(event.target)) {
                mobileMenu.classList.add('hidden');
            }
        });

        // Track scroll direction (down/up)
        let __lastScrollY = window.pageYOffset;
        let __scrollingDown = true;
        window.addEventListener('scroll', () => {
            const y = window.pageYOffset;
            __scrollingDown = y > __lastScrollY;
            __lastScrollY = y;
        }, { passive: true });

        // Intersection Observer untuk animasi scroll dengan fade out
        const observerOptions = {
            threshold: [0, 0.1, 0.5, 1.0], // Multiple thresholds untuk animasi yang lebih smooth
            rootMargin: '50px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Fade in berdasarkan intersection ratio
                    const ratio = entry.intersectionRatio;
                    if (ratio > 0.5) {
                        entry.target.classList.add('fade-in-active');
                        entry.target.classList.remove('fade-out-up', 'fade-out-down');
                    }
                } else {
                    // Fade out ketika elemen tidak terlihat
                    entry.target.classList.remove('fade-in-active');

                    // Tambahkan arah fade-out berdasarkan arah scroll & posisi elemen
                    const rect = entry.boundingClientRect;
                    // Jika scroll ke bawah dan elemen keluar lewat atas viewport -> fade-out-up
                    if (__scrollingDown && rect.top < 0) {
                        entry.target.classList.add('fade-out-up');
                        entry.target.classList.remove('fade-out-down');
                    }
                    // Jika scroll ke atas dan elemen keluar lewat bawah viewport -> fade-out-down
                    else if (!__scrollingDown && rect.bottom > window.innerHeight) {
                        entry.target.classList.add('fade-out-down');
                        entry.target.classList.remove('fade-out-up');
                    } else {
                        // Default fallback: kecilkan opacity saja
                        entry.target.classList.add('fade-out-down');
                    }
                }
            });
        }, observerOptions);

        // Observe elements with fade-in classes
        const fadeElements = document.querySelectorAll(
            '.fade-in, .fade-in-left, .fade-in-right, .fade-in-up, .fade-in-scale');
        fadeElements.forEach(element => {
            observer.observe(element);
        });

        // Scroll progress bar
        const scrollProgressBar = document.querySelector('.scroll-progress');
        if (scrollProgressBar) {
            window.addEventListener('scroll', () => {
                const scrollTop = window.pageYOffset;
                const docHeight = document.body.offsetHeight - window.innerHeight;
                const scrollPercent = (scrollTop / docHeight) * 100;
                scrollProgressBar.style.width = scrollPercent + '%';
            });
        }
    </script>
</body>

</html>
