import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    cacheDir: '/tmp/.vite-cache',

    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.ts'
            ],
            refresh: true,
            devServerUrl: 'http://localhost:5173',
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        host: 'localhost', // Allows connections from outside the container
        port: 5173,      // Ensures Vite binds to the expected internal port
        strictPort: true, // Forces Vite to fail if port 5173 is busy
        fs: {
            strict: false,         // Disables the restriction that blocks Windows files
            cachedChecks: false,   // Prevents Vite from saving broken Windows file statuses
        },
        hmr: {
            protocol: 'ws', // Forces standard WebSocket protocol
            host: 'localhost', // connect to localhost
            port: 5173, // routes web-sockets through Vite port
        },
        cors: true,
        watch: {
            usePolling: true, // Forces Vite to check files on Windows by polling
            interval: 100, // Checks for updates every 100ms
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
