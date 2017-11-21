let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js').extract(
    ['vue', 'axios', 'moment', 'jquery', 'sweetalert2', 'vuex', 'vue-flatpickr-component']
    ).version()
   .sass('resources/assets/sass/app.scss', 'css')
   .sass('resources/assets/sass/design.scss', 'css')
   .sass('resources/assets/sass/loading.scss', 'css');
