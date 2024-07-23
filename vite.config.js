import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import svgr from 'vite-plugin-svgr';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.jsx',
            refresh: true,
        }),
        react(),
        svgr(),
        
    ],
    base: '/OptiConnect/',
    build: {
        outDir: 'dist', // This is the default, ensure it is set correctly
      },
});
