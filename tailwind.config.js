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
                sans: ['Plus Jakarta Sans', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                patungans: {
                    bg: '#F4F5F7',
                    dark: '#111111',
                    text: '#1A1A1A',
                    muted: '#6B7280',
                    accentFrom: '#7ED957',
                    accentTo: '#4CAF50',
                    card: '#FFFFFF',
                },
            },
        },
    },

    plugins: [forms],
};
