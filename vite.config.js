import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

import { viteStaticCopy } from 'vite-plugin-static-copy'
export default defineConfig({
    build: {
        manifest: 'manifest.json',
        rtl: true,
        outDir: 'public/build/',
        cssCodeSplit: true,
        rollupOptions: {
            output: {
                assetFileNames: (css) => {
                    if (css.name.split('.').pop() == 'css') {
                        return 'css/' + `[name]` + '.min.' + 'css';
                    } else {
                        return 'icons/' + css.name;
                    }
                },
                entryFileNames: 'js/' + `[name]` + `.js`,
            },
        },
    },
    plugins: [
        laravel({
            input: [
            'resources/css/style.css',
            'resources/css/app.css',
            'Modules/Tickets/resources/assets/css/create.css',
            'Modules/Tickets/resources/assets/css/show.css',
            'Modules/Tickets/resources/assets/css/archive.css',
            'Modules/Tickets/resources/assets/css/my_daily_job.css',
            'Modules/Tickets/resources/assets/css/my_team.css',
            'Modules/Reports/resources/assets/css/reports_category.css',
            'resources/js/script.js',
            'resources/js/helpers/helper.js',
            'Modules/Tickets/resources/assets/js/index.js',
            'Modules/Tickets/resources/assets/js/create.js',
            'Modules/Tickets/resources/assets/js/show.js',
            'Modules/Tickets/resources/assets/js/assing.js',
            'Modules/Tickets/resources/assets/js/reassing.js',
            'Modules/Tickets/resources/assets/js/archive.js',
            'Modules/Tickets/resources/assets/js/my_daily_job.js',
            'Modules/Tickets/resources/assets/js/my_team.js',
            'Modules/Reports/resources/assets/js/reports_category.js'
            ],
            refresh: true,
        }),

        viteStaticCopy({
            targets: [
                {
                    src: 'resources/css',
                    dest: ''
                },
                {
                    src: 'resources/scss',
                    dest: ''
                },
                {
                    src: 'resources/fonts',
                    dest: ''
                },
                {
                    src: 'resources/img',
                    dest: ''
                },
                {
                    src: 'resources/js',
                    dest: ''
                },
               
                {
                    src: 'resources/plugins',
                    dest: ''
                },
               
            ]
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/js'),
        },
    }
});
