import { build, defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'; 

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }), 
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    },
    server: {
        host: 'localhost',
        port: 5000, 
    },
    build: {
        manifest: true,
        rollupOptions: {
            input: 'resources/js/app.js',
        },
        outDir: 'public/build',
    },
});
