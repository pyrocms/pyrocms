const mix = require('laravel-mix');

mix
    .sass('resources/scss/theme.scss', 'css')
    .js('resources/js/app.js', 'js')
    .options({
        processCssUrls: false,
        postCss       : [
            require('tailwindcss')('./tailwind.config.js'), // for resources/sass/theme.scss
            require('autoprefixer')
        ]
    })
    .webpackConfig({
        externals: {
            '@streams/core': ['streams', 'core'],
            'axios': ['streams', 'core', 'axios'],
        },
        // output: {
        //     library: ['app'],
        //     libraryTarget: 'window',
        // }
    });
