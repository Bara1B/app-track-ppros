<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body style="font-family: 'Poppins', sans-serif;">
    <!-- Global Loading Overlay (auth layout) -->
    <div id="global-loading"
        class="hidden fixed inset-0 z-50 bg-gray-900/50 backdrop-blur-sm items-center justify-center">
        <div class="flex flex-col items-center gap-3 p-6 bg-white rounded-lg shadow-lg">
            <svg class="animate-spin h-8 w-8 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            <p class="text-sm text-gray-700 font-medium">Memproses... Mohon tunggu</p>
        </div>
    </div>

    @yield('content')

    <script>
        (function() {
            const loadingEl = document.getElementById('global-loading');
            let pendingShowTimer = null;
            let maxHideTimer = null;

            function reallyShow() {
                if (!loadingEl) return;
                loadingEl.classList.remove('hidden');
                loadingEl.classList.add('flex');
                clearTimeout(maxHideTimer);
                maxHideTimer = setTimeout(() => {
                    hideLoading();
                }, 3000);
            }

            function scheduleShow(delayMs = 200) {
                clearTimeout(pendingShowTimer);
                pendingShowTimer = setTimeout(reallyShow, delayMs);
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
            }

            // Expose for manual trigger/debugging
            window.showGlobalLoading = () => scheduleShow(0);
            window.hideGlobalLoading = hideLoading;

            // Show on any form submit (login/register/forgot password)
            // Tampilkan segera agar terlihat saat terjadi navigasi (redirect)
            document.addEventListener('submit', function() {
                scheduleShow(0);
            }, true);

            // Show on any element with data-loading
            document.addEventListener('click', function(e) {
                const target = e.target.closest('[data-loading]');
                if (target) scheduleShow(300);
            });

            window.addEventListener('DOMContentLoaded', hideLoading);
            window.addEventListener('pageshow', hideLoading);
            window.addEventListener('pagehide', hideLoading);
            document.addEventListener('visibilitychange', function() {
                if (document.visibilityState === 'visible') hideLoading();
            });

            // Jangan batalkan show pada beforeunload agar overlay tetap sempat tampil saat redirect

            if (window.axios && window.axios.interceptors) {
                window.axios.interceptors.request.use(function(config) {
                    scheduleShow(150);
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
        })();
    </script>
</body>

</html>
