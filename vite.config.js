import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        hmr: {
            host: 'localhost',
        },
    },
    plugins: [
        laravel(
            // 共通
            [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/scss/theme.scss',
                'resources/scss/navigation.scss',
                'resources/js/loading.js',
                'resources/css/loading.css',
                'resources/js/file_select.js',
                'resources/js/checkbox.js',
            ],
            // ウェルカム
            [
                'resources/css/welcome.css',
            ],
            // 受注インポート
            [
                'resources/js/order_import/order_import.js',
            ],
        ),
    ],
});
