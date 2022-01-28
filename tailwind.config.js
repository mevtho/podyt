const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                'primary': {
                    '50': '#f2f5f6',
                    '100': '#e6eaee',
                    '200': '#bfccd4',
                    '300': '#99adba',
                    '400': '#4d6f87',
                    '500': '#003153',
                    '600': '#002c4b',
                    '700': '#00253e',
                    '800': '#001d32',
                    '900': '#001829'
                },
                'secondary': {
                    '50': '#fdf9f5',
                    '100': '#faf2eb',
                    '200': '#f3dfcc',
                    '300': '#ebccad',
                    '400': '#dca570',
                    '500': '#CD7F32',
                    '600': '#b9722d',
                    '700': '#9a5f26',
                    '800': '#7b4c1e',
                    '900': '#643e19'
                },
                'red': {
                    '50': '#fff2f2',
                    '100': '#ffe6e6',
                    '200': '#ffbfbf',
                    '300': '#ff9999',
                    '400': '#fe4d4d',
                    '500': '#fe0000',
                    '600': '#e50000',
                    '700': '#bf0000',
                    '800': '#980000',
                    '900': '#7c0000'
                },
            },
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
