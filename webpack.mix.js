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

mix.js('resources/js/home.js', 'public/js').vue()
    .js('resources/js/findFeeds.js', 'public/js').vue()
    .js('resources/js/newsBot.js', 'public/js').vue()
    .js('resources/js/related.js', 'public/js').vue()
    .js('resources/js/videoGenerator.js', 'public/js').vue()
    .js('resources/js/bootstrap.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();
