const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.jsx',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            backgroundImage: {
                'back-burger': "url('https://podacha-blud.com/uploads/posts/2022-10/1665577376_75-podacha-blud-com-p-fud-foto-dlya-saita-burgeri-79.jpg')"
            }
        },
    },

    plugins: [
        require('@tailwindcss/forms')
    ],
};
