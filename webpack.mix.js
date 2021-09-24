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

mix.js("resources/js/app.js", "public/js")
    .vue({
        globalStyles: "resources/css/sass/variables.scss",
    })
    .sass("resources/css/app.scss", "public/css")
    .sass("resources/css/admin.scss", "public/css")
    .options({
        processCssUrls: false,
    })
    .webpackConfig(require("./webpack.config"));

mix.version();

/*
mix.browserSync({
    proxy: "laramotely.test",
});
*/
