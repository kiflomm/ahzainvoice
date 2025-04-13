import vue from '@vitejs/plugin-vue';
import autoprefixer from 'autoprefixer';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import tailwindcss from 'tailwindcss';
import { resolve } from 'node:path';
import { defineConfig, loadEnv } from 'vite';

export default defineConfig(({ mode }) => {
    // Load env file based on mode
    const env = loadEnv(mode, process.cwd(), '');
    
    // Determine base URL for assets
    const baseUrl = mode === 'production' 
        ? env.VITE_ASSET_URL || env.APP_URL || '/' 
        : '/';
    
    return {
        plugins: [
            laravel({
                input: ['resources/js/app.ts'],
                ssr: 'resources/js/ssr.ts',
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
        base: baseUrl,
        resolve: {
            alias: {
                '@': path.resolve(__dirname, './resources/js'),
                'ziggy-js': resolve(__dirname, 'vendor/tightenco/ziggy'),
            },
        },
        css: {
            postcss: {
                plugins: [tailwindcss, autoprefixer],
            },
        },
        build: {
            // Improve asset handling
            assetsInlineLimit: 0,
            manifest: true,
            rollupOptions: {
                output: {
                    manualChunks: undefined
                }
            }
        }
    };
});
