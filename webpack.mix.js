const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss'); /* Add this line at the top */

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/css/app.scss', 'public/css')
    .options({
        postCss: [ tailwindcss('./tailwind.config.js') ],
    })
    .version();
