@props(['type' => 'success', 'message' => '', 'autoClose' => true, 'duration' => 8000])

@php
    $typeClasses = [
        'success' => 'bg-green-50 border-green-200 text-green-800',
        'error' => 'bg-red-50 border-red-200 text-red-800',
        'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
        'info' => 'bg-blue-50 border-blue-200 text-blue-800',
    ];

    $iconClasses = [
        'success' => 'fas fa-check-circle text-green-500',
        'error' => 'fas fa-exclamation-circle text-red-500',
        'warning' => 'fas fa-exclamation-triangle text-yellow-500',
        'info' => 'fas fa-info-circle text-blue-500',
    ];
@endphp

<div id="notification"
    class="fixed right-4 z-50 max-w-sm w-full bg-white border-l-4 shadow-lg rounded-lg p-4 transform translate-x-full transition-all duration-500 ease-out {{ $typeClasses[$type] }}"
    style="display: none; margin-top: 1rem; margin-right: 1rem; opacity: 0; top: 7rem;">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <i class="{{ $iconClasses[$type] }} text-lg"></i>
        </div>
        <div class="ml-3 flex-1">
            <p class="text-sm font-medium" id="notification-message">
                {{ $message }}
            </p>
        </div>
        <div class="ml-4 flex-shrink-0">
            <button type="button"
                class="inline-flex text-gray-400 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition ease-in-out duration-150"
                onclick="hideNotification()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <!-- OK Button for verification notifications -->
    <div id="ok-button-container" class="mt-3 flex justify-end" style="display: none;">
        <button type="button" id="ok-button"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200"
            onclick="handleOkClick()">
            <i class="fas fa-check mr-2"></i>
            OK
        </button>
    </div>
</div>

@if ($autoClose)
    <div class="mt-2 w-full bg-gray-200 rounded-full h-1">
        <div id="progress-bar" class="bg-current h-1 rounded-full transition-all duration-100 ease-linear"
            style="width: 100%;"></div>
    </div>
@endif
</div>

<script>
    let notificationTimeout;
    let progressInterval;

    function showNotification(message, type = 'success', autoClose = true, duration = 8000, showOkButton = false) {
        const notification = document.getElementById('notification');
        const messageEl = document.getElementById('notification-message');
        const progressBar = document.getElementById('progress-bar');
        const okButtonContainer = document.getElementById('ok-button-container');

        if (!notification) return;

        // Hide any existing notification first
        hideNotification();

        // Clear existing timeouts
        clearTimeout(notificationTimeout);
        clearInterval(progressInterval);

        // Update message and type
        messageEl.textContent = message;

        // Update classes based on type
        notification.className = notification.className.replace(/bg-\w+-\d+|border-\w+-\d+|text-\w+-\d+/g, '');
        notification.className += ` {{ $typeClasses[$type] }}`;

        // Update icon
        const icon = notification.querySelector('.flex-shrink-0 i');
        icon.className = `{{ $iconClasses[$type] }} text-lg`;

        // Show notification with smooth transition
        notification.style.display = 'block';
        // Force reflow to ensure display change is applied
        notification.offsetHeight;
        // Remove translate class and set opacity for smooth slide-in
        notification.classList.remove('translate-x-full');
        notification.style.opacity = '1';

        // Ensure notification stays fixed during scroll
        notification.style.position = 'fixed';
        notification.style.top = '7rem';
        notification.style.right = '1rem';
        notification.style.zIndex = '9999';

        // Show/hide OK button
        if (okButtonContainer) {
            okButtonContainer.style.display = showOkButton ? 'flex' : 'none';
        }

        if (autoClose && !showOkButton) {
            // Progress bar animation
            if (progressBar) {
                progressBar.style.width = '100%';
                progressBar.style.transition = `width ${duration}ms linear`;
                progressBar.style.display = 'block';
                // Start progress bar animation after notification is fully visible
                setTimeout(() => {
                    progressBar.style.width = '0%';
                }, 100);
            }

            // Auto hide
            notificationTimeout = setTimeout(() => {
                hideNotification();
            }, duration);
        } else {
            // Hide progress bar for manual close notifications
            if (progressBar) {
                progressBar.style.display = 'none';
            }
        }
    }

    function hideNotification() {
        const notification = document.getElementById('notification');
        const okButtonContainer = document.getElementById('ok-button-container');
        const progressBar = document.getElementById('progress-bar');

        if (!notification) return;

        clearTimeout(notificationTimeout);
        clearInterval(progressInterval);

        // Smooth fade out and slide out
        notification.style.opacity = '0';
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            notification.style.display = 'none';
            // Reset for next use
            notification.style.opacity = '0';
            // Hide OK button
            if (okButtonContainer) {
                okButtonContainer.style.display = 'none';
            }
            // Show progress bar for next use
            if (progressBar) {
                progressBar.style.display = 'block';
            }
        }, 500);
    }

    function handleOkClick() {
        // Hide notification first
        hideNotification();

        // Then refresh the page after a short delay
        setTimeout(() => {
            window.location.reload();
        }, 300);
    }

    // Global function for easy access
    window.showSuccess = (message) => showNotification(message, 'success', true, 10000); // 10 detik untuk success
    window.showError = (message) => showNotification(message, 'error', true, 12000); // 12 detik untuk error
    window.showWarning = (message) => showNotification(message, 'warning', true, 8000); // 8 detik untuk warning
    window.showInfo = (message) => showNotification(message, 'info', true, 6000); // 6 detik untuk info

    // Special function for verification notifications (with OK button)
    window.showVerificationSuccess = (message) => showNotification(message, 'success', false, 0,
        true); // Manual close dengan OK button

    // Auto show notification if message exists in session
    @if (session('success'))
        @if (session('verification'))
            showSuccessCard('{{ session('success') }}'); // Use loading card success state
        @else
            showNotification('{{ session('success') }}', 'success', true, 10000);
        @endif
    @endif

    @if (session('error'))
        showNotification('{{ session('error') }}', 'error', true, 12000);
    @endif

    @if (session('warning'))
        showNotification('{{ session('warning') }}', 'warning', true, 8000);
    @endif

    @if (session('info'))
        showNotification('{{ session('info') }}', 'info', true, 6000);
    @endif

    // Handle auto scroll after notification is shown (only for non-verification)
    @if (session('scroll_to') && !session('verification'))
        // Wait for notification to be fully visible, then scroll
        setTimeout(() => {
            const element = document.getElementById('{{ session('scroll_to') }}');
            if (element) {
                element.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        }, 1000); // 1 second delay to let notification show first
    @endif
</script>

<style>
    /* Ensure notification doesn't overlap with content */
    #notification {
        max-width: calc(100vw - 2rem);
        word-wrap: break-word;
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
        #notification {
            top: 5rem !important;
            right: 1rem !important;
            left: 1rem !important;
            max-width: none;
            width: auto;
        }
    }

    /* Ensure notification is above all other elements */
    #notification {
        z-index: 9999 !important;
    }

    /* Smooth transitions to prevent blinking */
    #notification {
        transition: all 0.5s ease-out !important;
        will-change: transform, opacity;
    }

    /* Prevent layout shift during animation */
    #notification * {
        transition: none !important;
    }

    /* Smooth progress bar animation */
    #progress-bar {
        transition: width linear !important;
    }

    /* Ensure notification stays visible during scroll */
    #notification {
        position: fixed !important;
        top: 7rem !important;
        right: 1rem !important;
        transform: translateX(0) !important;
        z-index: 9999 !important;
    }

    /* Prevent notification from being affected by page scroll */
    body {
        scroll-behavior: smooth;
    }

    /* Ensure notification is always visible above navbar */
    .top-navbar {
        z-index: 60 !important;
    }

    #notification {
        z-index: 9999 !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
    }
</style>
