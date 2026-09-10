import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';
// Uncomment the import for your frontend framework:
// import vue from '@vitejs/plugin-vue';
// import react from '@vitejs/plugin-react';
// import { svelte } from '@sveltejs/vite-plugin-svelte';

export default defineConfig({
    build: {
        outDir: '../../public/build-tickets',
        emptyOutDir: true,
        manifest: 'manifest.json',
    },
    plugins: [
        laravel({
            publicDirectory: '../../public',
            buildDirectory: 'build-tickets',
            input: [
                __dirname + '/resources/assets/sass/app.scss',
                __dirname + '/resources/assets/js/app.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/assets/js'),
        },
    },
});
