import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

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
            colors: {
                primary: {
                    DEFAULT: '#1E40AF', // Bleu foncé principal
                    light: '#3B82F6', // Bleu clair pour hover
                    dark: '#1E3A8A', // Bleu très foncé pour hover
                },
                secondary: {
                    DEFAULT: '#9333EA', // Violet principal
                    light: '#A855F7', // Violet clair pour hover
                    dark: '#7E22CE', // Violet foncé pour hover
                },
            },
            container: {
                center: true,
                padding: {
                    DEFAULT: '1rem',
                    sm: '2rem',
                    lg: '4rem',
                    xl: '5rem',
                },
            },
            boxShadow: {
                'property': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
                'property-hover': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
            },
            backgroundImage: {
                'hero-pattern': "linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?ixlib=rb-4.0.3')",
            },
            typography: {
                DEFAULT: {
                    css: {
                        color: '#333',
                        a: {
                            color: '#1E40AF',
                            '&:hover': {
                                color: '#3B82F6',
                            },
                        },
                        h1: {
                            color: '#1E40AF',
                            fontWeight: '700',
                        },
                        h2: {
                            color: '#1E40AF',
                            fontWeight: '600',
                        },
                        h3: {
                            color: '#1E40AF',
                            fontWeight: '600',
                        },
                    },
                },
            },
        },
    },

    plugins: [forms, typography],
};
