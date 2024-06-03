import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        container: {
            center: true,
            padding: {
                DEFAULT: "1rem",
                lg: "50px",
                xl: "100px",
            },
        },
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                poppins: "Poppins, sans-serif",
            },
            colors:{
                "dark-indigo": "#011A27",
                primary: "#3A405A",
                secondary: "#b3b6c4",
                "butter-yellow": "#F9EFAF",
                "lavender-pink": "#BFA3B0",
                "persian-pink": "#D18E91",
                "iron-grey": "#F9EFAF",
                "pastel-purple": "#A89EBF",
                "bluish-purple": "#6B5B95",
                "smoke-purple": "#847996"
            }            
            ,
        },
    },

    plugins: [forms, typography],
};