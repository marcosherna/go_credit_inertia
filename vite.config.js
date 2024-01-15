import { build, defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'; 
import path from 'path';

console.log(path.resolve(__dirname, 'public/assets'));

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
    resolve : {
        alias : {
            '@assets' : path.resolve(__dirname, 'public/assets'),
            '@Components' : path.resolve(__dirname, 'resources/js/Components'),
            '@Services' : path.resolve(__dirname, 'resources/js/Services/index.js'),
        }
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
