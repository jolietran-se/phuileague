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
    .sass('resources/sass/app.scss', 'public/css');

mix.styles(['resources/sass/magnific-popup.css'], 'public/css/magnific-popup.css')
   .styles(['resources/sass/owl.carousel.css'], 'public/css/owl.carousel.css')
   .styles(['resources/sass/responsive.css'], 'public/css/responsive.css')
   .styles(['resources/sass/rsmenu-main.css'], 'public/css/rsmenu-main.css')
   .styles(['resources/sass/rsmenu-transitions.css'], 'public/css/rsmenu-transitions.css')
   .styles(['resources/sass/slick.css'], 'public/css/slick.css')
   .styles(['resources/sass/style.css'], 'public/css/style.css')
   .styles(['resources/sass/time-circles.css'], 'public/css/time-circles.css')
   .styles(['resources/sass/home.css'], 'public/css/home.css')
   .styles(['resources/sass/user.css'], 'public/css/user.css')
   .styles(['resources/sass/tournament.css'], 'public/css/tournament.css')
   .styles(['resources/sass/club.css'], 'public/css/club.css');

mix.js('resources/js/main.js', 'public/js/main.js')
   .js('resources/js/owl.carousel.min.js', 'public/js/owl.carousel.min.js')
   .js('resources/js/rsmenu-main.js', 'public/js/rsmenu-main.js')
   .js('resources/js/jquery.meanmenu.js', 'public/js/jquery.meanmenu.js')
   .js('resources/js/time-circle.js', 'public/js/time-circle.js');



