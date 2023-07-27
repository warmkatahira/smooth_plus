const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/*.js',
    ],

    theme: {
        extend: {
            colors: {
                theme: {
                    'main': "#FEA4A4",
                    'sub': "#FFDEDE",
                    'gray': "#ebe6e6",
                },
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
