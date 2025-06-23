import { defineConfig } from 'vite';
import vue from "@vitejs/plugin-vue";
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        https: true, // Optional for local dev
    },
    build: {
        manifest: true,
        outDir: 'public/build',
    },
    base: process.env.APP_URL ? `${process.env.APP_URL}/build/` : '/build/',
});
