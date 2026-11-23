import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
                display: ['Baloo 2', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: '#EDFCEF',
                    100: '#D3F8D8',
                    200: '#A9F0B5',
                    300: '#74E28A',
                    400: '#3FCB5F',
                    500: '#1FB047',
                    600: '#148F38',
                    700: '#11722F',
                    800: '#115A29',
                    900: '#0E4B24',
                },
                sunny: {
                    50: '#FFFBE6',
                    100: '#FFF4BF',
                    200: '#FFE980',
                    300: '#FFDB4D',
                    400: '#FFCC1F',
                    500: '#FFB800',
                    600: '#E69500',
                },
                cream: '#FFFDF0',
            },
        },
    },

    plugins: [forms],
};
