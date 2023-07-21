import { defineConfig } from 'vite';
import tailwindcss from 'tailwindcss';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: ['resources/js/app.js'],
            refresh: true,
        }),
    ],
});
