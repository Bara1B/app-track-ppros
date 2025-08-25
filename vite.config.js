import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import fs from 'fs';
import tailwindcss from '@tailwindcss/vite';
import { config as loadEnv } from 'dotenv';
loadEnv();

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
                'database/migrations/**',
            ],
        }),
    ],
    server: {
        // gunakan localhost agar cocok dengan https://localhost dan sertifikat dev
        host: 'localhost',
        port: 5174,
        cors: true,
        https: process.env.APP_URL?.startsWith('https') ? (
            (() => {
                try {
                    // Prefer project certs first when running Vite on host
                    if (
                        fs.existsSync('./docker/nginx/ssl/localhost+2-key.pem') &&
                        fs.existsSync('./docker/nginx/ssl/localhost+2.pem')
                    ) {
                        return {
                            key: fs.readFileSync('./docker/nginx/ssl/localhost+2-key.pem'),
                            cert: fs.readFileSync('./docker/nginx/ssl/localhost+2.pem'),
                        };
                    }
                    // Fallback to container path if accessible
                    if (
                        fs.existsSync('/etc/nginx/ssl/localhost+2-key.pem') &&
                        fs.existsSync('/etc/nginx/ssl/localhost+2.pem')
                    ) {
                        return {
                            key: fs.readFileSync('/etc/nginx/ssl/localhost+2-key.pem'),
                            cert: fs.readFileSync('/etc/nginx/ssl/localhost+2.pem'),
                        };
                    }
                } catch (e) {
                    // ignore and fallback below
                }
                // Let Vite generate a self-signed cert if none available
                return true;
            })()
        ) : false,
        hmr: {
            protocol: process.env.APP_URL?.startsWith('https') ? 'wss' : 'ws',
            host: 'localhost',
            port: 5174,
        },
        watch: { usePolling: true, interval: 300 },
    },
});