import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import fs from 'fs';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: [
                'resources/css/app.css',
                'resources/sass/app.scss',
                'resources/css/tracking.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    // Konfigurasi dev server agar cocok dengan HTTPS lokal
    server: {
        host: '0.0.0.0',
        port: 5173,
        origin: 'https://localhost:5173',
        https: {
            key: fs.readFileSync('/etc/nginx/ssl/localhost+2-key.pem'),
            cert: fs.readFileSync('/etc/nginx/ssl/localhost+2.pem'),
        },
        hmr: {
            protocol: 'wss',
            host: 'localhost',
            port: 5173,
        },
    },
});