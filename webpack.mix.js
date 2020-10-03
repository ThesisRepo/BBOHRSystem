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

mix.webpackConfig({
    resolve: {
        extensions: ['.js', '.vue'],
        alias:{
            "src":path.resolve(__dirname,'src'),
            "assets":path.resolve(__dirname,'src/assets'),
            "components":path.resolve(__dirname,'src/components'),
            "module":path.resolve(__dirname,'src/modules'),
            "router":path.resolve(__dirname,'src/router'),
        }
    }
})
