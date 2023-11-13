const defaultTheme = require('tailwindcss/defaultTheme');


/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue', 
        'node_modules/flowbite-vue/**/*.{js,jsx,ts,tsx}',
        "./node_modules/flowbite/**/*.js", //
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            }, 
        },
    },

    plugins: [
        require('@tailwindcss/forms'), 
        require('@tailwindcss/typography'), 
        require('flowbite/plugin'),
        require('flowbite/plugin'),
    ],
};
