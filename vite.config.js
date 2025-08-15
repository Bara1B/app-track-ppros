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
                'resources/css/custom-table.css',
                'resources/js/app.js',
            ],
            refresh: [
                'resources/views/**',
                'resources/js/**',
                'resources/css/**',
                'resources/sass/**',
                'routes/**',
                'app/**',
            ],
        }),
    ],
    server: {
        // bind ke 127.0.0.1 agar origin cocok dengan http://127.0.0.1:8000
        host: '127.0.0.1',
        port: 5173,
        cors: true,
        https: process.env.APP_URL?.startsWith('https') ? (
            fs.existsSync('/etc/nginx/ssl/localhost+2-key.pem') && fs.existsSync('/etc/nginx/ssl/localhost+2.pem')
                ? {
                    key: fs.readFileSync('/etc/nginx/ssl/localhost+2-key.pem'),
                    cert: fs.readFileSync('/etc/nginx/ssl/localhost+2.pem'),
                }
                : false
        ) : false,
        hmr: {
            protocol: process.env.APP_URL?.startsWith('https') ? 'wss' : 'ws',
            host: '127.0.0.1',
            port: 5173,
        },
        watch: { usePolling: true, interval: 300 },
    },
});