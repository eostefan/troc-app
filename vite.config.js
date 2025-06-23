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
            buildDirectory: 'build'
        }),
        tailwindcss(),
    ],
    server: {
        https: true, // Optional for local dev
    },
    build: {
        outDir: 'public/build',
        emptyOutDir: true,
        manifest: true,
    },
    base: '/build/'
});
