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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps()
    .styles([
        'public/css/morris.css',
        'public/css/bootstrap.min.css',
        'public/css/dashboard1.css',
        'public/css/style.css',
        'public/css/default.css',
        'public/css/perfect-scrollbar.min.css'
    ], 'public/css/all.css')
    .scripts([
        'public/js/sidebarmenu.js',
        'public/js/perfect-scrollbar.jquery.min.js',
        'public/js/dashboard1.js',
        'public/js/waves.js',
        'public/js/custom.min.js',
        'public/js/d3.min.js',
        'public/js/raphael.min.js',
        'public/js/morris.min.js',
        'public/js/jQuery.style.switcher.js'
    ], 'public/js/all.js');

mix.styles([
        'resources/css/navbar.css',
    ],  'public/css/navbar.css');

mix.styles([
        'resources/css/sidebar.css',
    ],  'public/css/sidebar.css');

mix.styles([
        'resources/css/font.css',
    ],  'public/css/font.css');

mix.styles([
        'resources/css/content.css',
    ],  'public/css/content.css');

mix.styles([
        'resources/css/button.css',
    ],  'public/css/button.css');

mix.styles([
    'resources/css/background.css',
],  'public/css/background.css');

mix.styles([
        'resources/css/datepicker.css',
    ],  'public/css/datepicker.css');

mix.styles([
        'resources/css/card.css',
    ],  'public/css/card.css');

mix.styles([
        'resources/css/form.css',
    ],  'public/css/form.css');

mix.styles([
        'resources/css/search.css',
    ],  'public/css/search.css');

mix.styles([
        'resources/css/tab.css',
    ],  'public/css/tab.css');

mix.styles([
        'resources/css/modal.css',
    ],  'public/css/modal.css');

mix.styles([
        'resources/css/success.css',
    ],  'public/css/success.css');

mix.styles([
        'resources/css/page.css',
    ],  'public/css/page.css');