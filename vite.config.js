import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        hmr: {
            host: 'localhost',
        },
    },
    plugins: [
        laravel([
            'resources/css/app.css',
			'resources/js/app.js',
            'resources/scss/theme.scss',
            'resources/css/welcome.css',
            'resources/scss/navigation.scss',
            'resources/js/loading.js',
            'resources/css/loading.css',
        ]),
    ],
});
