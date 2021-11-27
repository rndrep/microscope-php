const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.sass("resources/sass/app.scss", "public/css/admin.css");

mix.js("resources/js/app.js", "public/js/admin.js");

// mix.copy("resources/assets/admin/bootstrap/fonts", "public/fonts");
// mix.copy("resources/assets/admin/dist/fonts", "public/fonts");
// mix.copy("resources/assets/admin/dist/img", "public/img");
// mix.copy(
//     "resources/assets/admin/plugins/iCheck/minimal/blue.png",
//     "public/css"
// );
