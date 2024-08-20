import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';

export default ({ mode }) => {
    process.env = { ...process.env, ...loadEnv(mode, process.cwd()) };

    return defineConfig({
        plugins: [
            laravel({
                input: [
                    'resources/css/app.css',
                    'resources/js/app.js'
                ],
                refresh: true,
            }),
        ],
        server: {
            host: process.env.VITE_APP_URL
        },
        resolve: {
            alias: {
                '@': '/resources/js',
                '@Component': '/resources/js/Components',
                'vue': 'vue/dist/vue.esm-bundler.js',
            },
            extensions: ['.js', '.vue', '.json']
        }
    });
}
