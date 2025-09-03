/**
 * Notification System JavaScript
 * Provides easy-to-use functions for showing notifications
 */

// Global notification functions
window.Notify = {
    /**
     * Show success notification
     */
    success: function (message, duration = 5000) {
        if (typeof showSuccess === 'function') {
            showSuccess(message);
        } else {
            console.log('Success:', message);
        }
    },

    /**
     * Show error notification
     */
    error: function (message, duration = 7000) {
        if (typeof showError === 'function') {
            showError(message);
        } else {
            console.error('Error:', message);
        }
    },

    /**
     * Show warning notification
     */
    warning: function (message, duration = 6000) {
        if (typeof showWarning === 'function') {
            showWarning(message);
        } else {
            console.warn('Warning:', message);
        }
    },

    /**
     * Show info notification
     */
    info: function (message, duration = 5000) {
        if (typeof showInfo === 'function') {
            showInfo(message);
        } else {
            console.info('Info:', message);
        }
    },

    /**
     * Show notification based on operation result
     */
    operation: function (success, successMessage, errorMessage = 'Terjadi kesalahan. Silakan coba lagi.') {
        if (success) {
            this.success(successMessage);
        } else {
            this.error(errorMessage);
        }
    },

    /**
     * Show CRUD operation notifications
     */
    created: function (itemName = 'Data') {
        this.success(`${itemName} berhasil ditambahkan!`);
    },

    updated: function (itemName = 'Data') {
        this.success(`${itemName} berhasil diperbarui!`);
    },

    deleted: function (itemName = 'Data') {
        this.success(`${itemName} berhasil dihapus!`);
    },

    verified: function (itemName = 'Data') {
        this.success(`${itemName} berhasil diverifikasi!`);
    },

    imported: function (itemName = 'Data') {
        this.success(`${itemName} berhasil diimpor!`);
    },

    exported: function (itemName = 'Data') {
        this.success(`${itemName} berhasil diekspor!`);
    }
};

// Auto-show notifications from form submissions
document.addEventListener('DOMContentLoaded', function () {
    // Show notification for form submissions
    const forms = document.querySelectorAll('form[data-notify]');
    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            const notifyType = this.dataset.notify || 'success';
            const notifyMessage = this.dataset.notifyMessage || 'Data berhasil diproses!';

            // Show loading notification
            Notify.info('Memproses data...', 2000);
        });
    });

    // Show notification for AJAX requests
    if (window.axios) {
        // Request interceptor
        window.axios.interceptors.request.use(function (config) {
            if (config.data && config.data._showLoading !== false) {
                Notify.info('Memproses permintaan...', 2000);
            }
            return config;
        });

        // Response interceptor
        window.axios.interceptors.response.use(
            function (response) {
                // Check if response has notification data
                if (response.data && response.data.notification) {
                    const { type, message } = response.data.notification;
                    Notify[type](message);
                }
                return response;
            },
            function (error) {
                if (error.response && error.response.data && error.response.data.message) {
                    Notify.error(error.response.data.message);
                } else {
                    Notify.error('Terjadi kesalahan pada server.');
                }
                return Promise.reject(error);
            }
        );
    }
});

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = window.Notify;
}


