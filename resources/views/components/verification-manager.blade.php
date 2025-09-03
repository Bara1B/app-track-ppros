@props(['workOrderId' => null])

<div id="verification-manager" data-work-order-id="{{ $workOrderId }}">
    <!-- Enhanced Loading Card -->
    <div id="verification-loading-card"
        class="fixed inset-0 z-50 bg-gray-900/50 backdrop-blur-sm flex items-center justify-center"
        style="display: none;">
        <div
            class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full mx-4 transform transition-all duration-300 ease-out">
            <!-- Loading State -->
            <div id="verification-loading-state">
                <div class="text-center">
                    <!-- Loading Spinner -->
                    <div class="flex justify-center mb-6">
                        <div class="relative">
                            <div class="w-16 h-16 border-4 border-blue-200 rounded-full animate-spin border-t-blue-600">
                            </div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Loading Message -->
                    <h3 class="text-lg font-semibold text-gray-900 mb-2" id="verification-loading-message">Memverifikasi
                        Status</h3>
                    <p class="text-sm text-gray-600 mb-6">Mohon tunggu sebentar, proses sedang berjalan...</p>

                    <!-- Progress Bar -->
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full animate-pulse"
                            style="width: 100%;"></div>
                    </div>

                    <!-- Loading Dots -->
                    <div class="flex justify-center space-x-1">
                        <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce"></div>
                        <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 0.1s">
                        </div>
                        <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 0.2s">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success State -->
            <div id="verification-success-state" style="display: none;">
                <div class="text-center">
                    <!-- Success Icon -->
                    <div class="flex justify-center mb-6">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Success Message -->
                    <h3 class="text-lg font-semibold text-gray-900 mb-2" id="verification-success-message">Berhasil!
                    </h3>
                    <p class="text-sm text-gray-600 mb-8">Status berhasil diverifikasi dan diperbarui</p>

                    <!-- OK Button -->
                    <button type="button" id="verification-ok-button"
                        class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:scale-105 shadow-lg"
                        onclick="VerificationManager.handleOkClick()">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        OK
                    </button>
                </div>
            </div>

            <!-- Error State -->
            <div id="verification-error-state" style="display: none;">
                <div class="text-center">
                    <!-- Error Icon -->
                    <div class="flex justify-center mb-6">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Error Message -->
                    <h3 class="text-lg font-semibold text-gray-900 mb-2" id="verification-error-message">Terjadi
                        Kesalahan</h3>
                    <p class="text-sm text-gray-600 mb-8">Gagal memverifikasi status. Silakan coba lagi.</p>

                    <!-- Action Buttons -->
                    <div class="flex space-x-3">
                        <button type="button" id="verification-retry-button"
                            class="flex-1 inline-flex items-center justify-center px-4 py-3 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200"
                            onclick="VerificationManager.retryLastOperation()">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                            Coba Lagi
                        </button>
                        <button type="button" id="verification-cancel-button"
                            class="flex-1 inline-flex items-center justify-center px-4 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200"
                            onclick="VerificationManager.hideCard()">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    class VerificationManager {
        constructor() {
            this.cache = new Map();
            this.loadingStates = new Set();
            this.lastOperation = null;
            this.retryCount = 0;
            this.maxRetries = 3;
            this.debounceTimeout = null;
        }

        // Show loading state
        showLoading(message = 'Memverifikasi Status') {
            const card = document.getElementById('verification-loading-card');
            const loadingState = document.getElementById('verification-loading-state');
            const successState = document.getElementById('verification-success-state');
            const errorState = document.getElementById('verification-error-state');
            const loadingMessage = document.getElementById('verification-loading-message');

            // Debug: Log element existence
            console.log('Elements found:', {
                card: !!card,
                loadingState: !!loadingState,
                successState: !!successState,
                errorState: !!errorState,
                loadingMessage: !!loadingMessage
            });

            if (card && loadingState && successState && errorState && loadingMessage) {
                loadingMessage.textContent = message;
                loadingState.style.display = 'block';
                successState.style.display = 'none';
                errorState.style.display = 'none';
                card.style.display = 'flex';

                // Add animation class
                card.classList.add('animate-in');
                setTimeout(() => {
                    card.classList.remove('animate-in');
                }, 300);

                console.log('Loading card shown successfully');
            } else {
                console.error('Missing elements for loading card');
            }
        }

        // Show success state
        showSuccess(message = 'Berhasil!') {
            const card = document.getElementById('verification-loading-card');
            const loadingState = document.getElementById('verification-loading-state');
            const successState = document.getElementById('verification-success-state');
            const errorState = document.getElementById('verification-error-state');
            const successMessage = document.getElementById('verification-success-message');

            if (card && loadingState && successState && errorState && successMessage) {
                successMessage.textContent = message;
                loadingState.style.display = 'none';
                successState.style.display = 'block';
                errorState.style.display = 'none';
                card.style.display = 'flex';

                // Add success animation
                successState.classList.add('animate-in');
                setTimeout(() => {
                    successState.classList.remove('animate-in');
                }, 300);
            }
        }

        // Show error state
        showError(message = 'Terjadi kesalahan') {
            const card = document.getElementById('verification-loading-card');
            const loadingState = document.getElementById('verification-loading-state');
            const successState = document.getElementById('verification-success-state');
            const errorState = document.getElementById('verification-error-state');
            const errorMessage = document.getElementById('verification-error-message');

            if (card && loadingState && successState && errorState && errorMessage) {
                errorMessage.textContent = message;
                loadingState.style.display = 'none';
                successState.style.display = 'none';
                errorState.style.display = 'block';
                card.style.display = 'flex';
            }
        }

        // Hide card
        hideCard() {
            const card = document.getElementById('verification-loading-card');
            if (card) {
                card.style.display = 'none';
            }
            this.retryCount = 0;
            this.lastOperation = null;
        }

        // Handle form submission with debouncing
        async handleSubmit(event, form) {
            event.preventDefault();

            // Debounce to prevent multiple rapid submissions
            if (this.debounceTimeout) {
                clearTimeout(this.debounceTimeout);
            }

            this.debounceTimeout = setTimeout(async () => {
                await this.submitForm(form);
            }, 100);
        }

        // Submit form with retry mechanism
        async submitForm(form) {
            const formId = form.id || 'form-' + Date.now();

            // Check if already loading
            if (this.loadingStates.has(formId)) {
                return;
            }

            this.loadingStates.add(formId);

            // Debug: Log to console
            console.log('Showing loading card...');
            this.showLoading('Memverifikasi Status');

            try {
                const formData = new FormData(form);
                const cacheKey = this.generateCacheKey(formData);

                // Check cache first
                if (this.cache.has(cacheKey)) {
                    const cachedResult = this.cache.get(cacheKey);
                    this.showSuccess(cachedResult.message);
                    this.loadingStates.delete(formId);
                    return;
                }

                // Store operation for retry
                this.lastOperation = {
                    form,
                    formData,
                    cacheKey
                };

                const response = await fetch(form.action, {
                    method: form.method,
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }

                const data = await response.json();

                if (data.success) {
                    // Cache successful result
                    this.cache.set(cacheKey, data);

                    // Update DOM selectively
                    await this.updateStatusDisplay(data);

                    this.showSuccess(data.message);
                    this.retryCount = 0;
                } else {
                    throw new Error(data.message || 'Verifikasi gagal');
                }

            } catch (error) {
                console.error('Verification error:', error);
                this.showError(error.message || 'Terjadi kesalahan saat memverifikasi status');
            } finally {
                this.loadingStates.delete(formId);
            }
        }

        // Update status display without full page refresh
        async updateStatusDisplay(data) {
            try {
                // Fetch updated status data
                const workOrderId = document.getElementById('verification-manager')?.dataset.workOrderId;
                if (!workOrderId) return;

                const response = await fetch(`/api/work-orders/${workOrderId}/status`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                });

                if (response.ok) {
                    const statusData = await response.json();
                    this.updateStatusElements(statusData);
                }
            } catch (error) {
                console.error('Failed to update status display:', error);
                // Fallback to full refresh if selective update fails
                setTimeout(() => window.location.reload(), 1000);
            }
        }

        // Update specific status elements
        updateStatusElements(statusData) {
            statusData.tracking.forEach(status => {
                const statusElement = document.querySelector(`[data-status-id="${status.id}"]`);
                if (statusElement) {
                    // Update status display
                    this.updateStatusElement(statusElement, status);
                }
            });
        }

        // Update individual status element
        updateStatusElement(element, status) {
            // Update completion status
            const completedAt = status.completed_at;
            const isCompleted = completedAt !== null;

            // Update icon
            const iconElement = element.querySelector('.status-icon');
            if (iconElement) {
                if (isCompleted) {
                    iconElement.className =
                        'status-icon w-12 h-12 rounded-full flex items-center justify-center border-2 bg-green-500 border-green-500 text-white';
                    iconElement.innerHTML =
                        '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                } else {
                    iconElement.className =
                        'status-icon w-12 h-12 rounded-full flex items-center justify-center border-2 bg-gray-100 border-gray-300 text-gray-400';
                    iconElement.innerHTML =
                        '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                }
            }

            // Update date display
            const dateElement = element.querySelector('.status-date');
            if (dateElement && isCompleted) {
                const date = new Date(completedAt).toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                dateElement.textContent = `Selesai pada: ${date}`;
            }

            // Update notes
            if (status.notes) {
                const notesElement = element.querySelector('.status-notes');
                if (notesElement) {
                    notesElement.textContent = status.notes;
                    notesElement.style.display = 'block';
                }
            }
        }

        // Handle OK click
        handleOkClick() {
            this.hideCard();
            // No need for full page refresh - DOM already updated
        }

        // Retry last operation
        async retryLastOperation() {
            if (!this.lastOperation || this.retryCount >= this.maxRetries) {
                this.showError('Maksimal percobaan tercapai');
                return;
            }

            this.retryCount++;
            this.showLoading(`Mencoba lagi... (${this.retryCount}/${this.maxRetries})`);

            try {
                const {
                    formData,
                    cacheKey
                } = this.lastOperation;

                const response = await fetch(this.lastOperation.form.action, {
                    method: this.lastOperation.form.method,
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                });

                if (response.ok) {
                    const data = await response.json();
                    this.cache.set(cacheKey, data);
                    await this.updateStatusDisplay(data);
                    this.showSuccess(data.message);
                    this.retryCount = 0;
                } else {
                    throw new Error('Retry failed');
                }
            } catch (error) {
                if (this.retryCount < this.maxRetries) {
                    this.showError(`Gagal. Mencoba lagi... (${this.retryCount}/${this.maxRetries})`);
                } else {
                    this.showError('Maksimal percobaan tercapai');
                }
            }
        }

        // Generate cache key
        generateCacheKey(formData) {
            const entries = Array.from(formData.entries());
            return entries.map(([key, value]) => `${key}:${value}`).join('|');
        }

        // Clear cache
        clearCache() {
            this.cache.clear();
        }

        // Get cache stats
        getCacheStats() {
            return {
                size: this.cache.size,
                keys: Array.from(this.cache.keys())
            };
        }
    }

    // Initialize global instance
    window.VerificationManager = new VerificationManager();

    // Global function for backward compatibility
    window.handleVerificationSubmit = (event, form) => {
        VerificationManager.handleSubmit(event, form);
    };
</script>

<style>
    /* Enhanced animations for verification manager */
    #verification-loading-card {
        animation: fadeIn 0.3s ease-out;
    }

    #verification-loading-card.animate-in {
        animation: slideInUp 0.3s ease-out;
    }

    #verification-loading-state.animate-in,
    #verification-success-state.animate-in,
    #verification-error-state.animate-in {
        animation: fadeInScale 0.3s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.95);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Enhanced button hover effects */
    #verification-ok-button:hover,
    #verification-retry-button:hover,
    #verification-cancel-button:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    /* Loading spinner enhancement */
    .animate-spin {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    /* Bounce animation for loading dots */
    .animate-bounce {
        animation: bounce 1s infinite;
    }

    @keyframes bounce {

        0%,
        20%,
        53%,
        80%,
        100% {
            transform: translate3d(0, 0, 0);
        }

        40%,
        43% {
            transform: translate3d(0, -8px, 0);
        }

        70% {
            transform: translate3d(0, -4px, 0);
        }

        90% {
            transform: translate3d(0, -2px, 0);
        }
    }
</style>
