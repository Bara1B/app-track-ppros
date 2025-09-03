@props(['message' => 'Memproses...', 'show' => false])

<div id="loading-card" class="fixed inset-0 z-50 bg-gray-900/50 backdrop-blur-sm items-center justify-center"
    style="display: {{ $show ? 'flex' : 'none' }};">
    <div class="bg-white rounded-lg shadow-xl p-6 max-w-sm w-full mx-4">
        <!-- Loading State -->
        <div id="loading-state">
            <div class="flex items-center space-x-3">
                <!-- Loading Spinner -->
                <div class="flex-shrink-0">
                    <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </div>

                <!-- Loading Message -->
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900" id="loading-message">{{ $message }}</p>
                    <p class="text-xs text-gray-500 mt-1">Mohon tunggu sebentar...</p>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="mt-4 w-full bg-gray-200 rounded-full h-1">
                <div class="bg-blue-600 h-1 rounded-full animate-pulse" style="width: 100%;"></div>
            </div>
        </div>

        <!-- Success State -->
        <div id="success-state" style="display: none;">
            <div class="flex items-center space-x-3">
                <!-- Success Icon -->
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <!-- Success Message -->
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900" id="success-message">Berhasil!</p>
                    <p class="text-xs text-gray-500 mt-1">Proses telah selesai</p>
                </div>
            </div>

            <!-- OK Button -->
            <div class="mt-4 flex justify-end">
                <button type="button" id="ok-button"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200"
                    onclick="handleOkClick()">
                    <i class="fas fa-check mr-2"></i>
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function showLoadingCard(message = 'Memproses...') {
        const loadingCard = document.getElementById('loading-card');
        const loadingState = document.getElementById('loading-state');
        const successState = document.getElementById('success-state');
        const loadingMessage = document.getElementById('loading-message');

        if (loadingCard && loadingState && successState && loadingMessage) {
            loadingMessage.textContent = message;
            loadingState.style.display = 'block';
            successState.style.display = 'none';
            loadingCard.style.display = 'flex';
        }
    }

    function showSuccessCard(message = 'Berhasil!') {
        const loadingCard = document.getElementById('loading-card');
        const loadingState = document.getElementById('loading-state');
        const successState = document.getElementById('success-state');
        const successMessage = document.getElementById('success-message');

        if (loadingCard && loadingState && successState && successMessage) {
            successMessage.textContent = message;
            loadingState.style.display = 'none';
            successState.style.display = 'block';
            loadingCard.style.display = 'flex';
        }
    }

    function hideLoadingCard() {
        const loadingCard = document.getElementById('loading-card');
        if (loadingCard) {
            loadingCard.style.display = 'none';
        }
    }

    function handleOkClick() {
        // Hide loading card first
        hideLoadingCard();

        // Then refresh the page after a short delay
        setTimeout(() => {
            window.location.reload();
        }, 300);
    }

    // Global functions
    window.showLoadingCard = showLoadingCard;
    window.showSuccessCard = showSuccessCard;
    window.hideLoadingCard = hideLoadingCard;
    window.handleOkClick = handleOkClick;
</script>
