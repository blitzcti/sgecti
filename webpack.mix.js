const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js([
    'node_modules/bootstrap/dist/js/bootstrap.js',
    'resources/js/app.js'
], 'public/js')
    .sass([
        'node_modules/bootstrap/scss/bootstrap.scss',
        'resources/sass/app.scss'
    ], 'public/css');
