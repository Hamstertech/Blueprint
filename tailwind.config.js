import defaultTheme from 'tailwindcss/defaultTheme';

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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            keyframes: {
                'fade-in-down': {
                    'from': {
                        transform: 'translateY(-0.75rem)',
                        opacity: '0',
                    },
                    'to': {
                        transform: 'translate(0rem)',
                        opacity: '1'
                    },
                },
                'fade-in-up': {
                    'from': {
                        transform: 'translateY(0.75rem)',
                        opacity: '0',
                    },
                    'to': {
                        transform: 'translate(0rem)',
                        opacity: '1'
                    },
                },
                'toaster': {
                    '0%': {
                        transform: 'translateY(0.75rem)',
                        opacity: '0',
                    },
                    '5%': {
                        transform: 'translate(0rem)',
                        opacity: '1',
                    },
                    '95%': {
                        transform: 'translate(0rem)',
                        opacity: '1',
                    },
                    '100%': {
                        transform: 'translateY(-0.75rem)',
                        opacity: '0'
                    },
                }
            },
            animation: {
                'fade-in-down': 'fade-in-down 0.2s ease-in-out both',
                'fade-in-up': 'fade-in-up 0.2s ease-in-out both',
                'toaster': 'toaster 5s ease-in-out',
            },
        },
    },
    plugins: [],
};
