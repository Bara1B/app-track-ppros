import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            // TAMBAHKAN 'resources/css/tracking.css' DI SINI
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/css/tracking.css',
            ],
            refresh: true,
        }),
    ],
});