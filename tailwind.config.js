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
            colors: {
                // Outdoor Adventure Color Palette
                outdoor: {
                    // Primary Colors
                    olive: {
                        50: '#f7f8f3',
                        100: '#eef0e6',
                        200: '#dde2cd',
                        300: '#c6cfaa',
                        400: '#a8b884',
                        500: '#606c38', // Primary buttons, navigation
                        600: '#535f32',
                        700: '#464f2b',
                        800: '#3a4125',
                        900: '#323620',
                    },
                    forest: {
                        50: '#f4f5f2',
                        100: '#e8eae4',
                        200: '#d1d6ca',
                        300: '#b4bca5',
                        400: '#93a080',
                        500: '#283618', // Text, headers, structure
                        600: '#232f15',
                        700: '#1e2812',
                        800: '#1a210f',
                        900: '#161c0d',
                    },
                    cream: {
                        50: '#fefae0', // Backgrounds, cards
                        100: '#fdf6c8',
                        200: '#fbeea3',
                        300: '#f8e271',
                        400: '#f4d24a',
                        500: '#efc027',
                        600: '#d4a61c',
                        700: '#b08318',
                        800: '#8f6619',
                        900: '#775419',
                    },
                    ochre: {
                        50: '#fdf8f3',
                        100: '#faeee6',
                        200: '#f4dcc7',
                        300: '#ecc29e',
                        400: '#dda15e', // Links, accents, highlights
                        500: '#d18b47',
                        600: '#c2753b',
                        700: '#a15f32',
                        800: '#824d2d',
                        900: '#6b4026',
                    },
                    earth: {
                        50: '#fdf6f0',
                        100: '#faebe0',
                        200: '#f4d5bf',
                        300: '#ecb894',
                        400: '#e19460',
                        500: '#bc6c25', // Secondary buttons, borders
                        600: '#a85d20',
                        700: '#8b4e1c',
                        800: '#71401a',
                        900: '#5d3518',
                    },
                },
                // Nature-inspired Neutrals
                nature: {
                    stone: '#8d8680',
                    bark: '#5d4e47',
                    moss: '#7a8471',
                    sky: '#b8c5d6',
                    mist: '#e8edf2',
                },
            },
            fontFamily: {
                // Outdoor-friendly typography
                sans: ['Inter', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'sans-serif'],
                display: ['Bricolage Grotesque', 'Montserrat', 'system-ui', 'sans-serif'],
                title: ['Bricolage Grotesque', 'system-ui', 'sans-serif'],
                heading: ['Bricolage Grotesque', 'system-ui', 'sans-serif'],
                body: ['Inter', ...defaultTheme.fontFamily.sans],
                mono: ['JetBrains Mono', 'Menlo', 'Monaco', 'Consolas', 'Liberation Mono', 'Courier New', 'monospace'],
            },
            spacing: {
                // Custom spacing for outdoor layouts
                '18': '4.5rem',
                '88': '22rem',
                '100': '25rem',
                '112': '28rem',
                '128': '32rem',
            },
            borderRadius: {
                // Organic, nature-inspired border radius
                'xl2': '1.125rem',
                '2xl': '1.25rem',
                '3xl': '1.75rem',
                '4xl': '2rem',
            },
            boxShadow: {
                // Earth-toned shadows
                'outdoor-sm': '0 1px 2px 0 rgba(40, 54, 24, 0.05)',
                'outdoor': '0 1px 3px 0 rgba(40, 54, 24, 0.1), 0 1px 2px 0 rgba(40, 54, 24, 0.06)',
                'outdoor-md': '0 4px 6px -1px rgba(40, 54, 24, 0.1), 0 2px 4px -1px rgba(40, 54, 24, 0.06)',
                'outdoor-lg': '0 10px 15px -3px rgba(40, 54, 24, 0.1), 0 4px 6px -2px rgba(40, 54, 24, 0.05)',
                'outdoor-xl': '0 20px 25px -5px rgba(40, 54, 24, 0.1), 0 10px 10px -5px rgba(40, 54, 24, 0.04)',
                'outdoor-2xl': '0 25px 50px -12px rgba(40, 54, 24, 0.25)',
                'outdoor-inner': 'inset 0 2px 4px 0 rgba(40, 54, 24, 0.06)',
            },
            backgroundImage: {
                // Nature-inspired gradients
                'outdoor-sunset': 'linear-gradient(135deg, #dda15e 0%, #bc6c25 100%)',
                'outdoor-forest': 'linear-gradient(135deg, #606c38 0%, #283618 100%)',
                'outdoor-earth': 'linear-gradient(135deg, #bc6c25 0%, #8b4e1c 100%)',
                'outdoor-mist': 'linear-gradient(135deg, #fefae0 0%, #e8edf2 100%)',
            },
            animation: {
                // Subtle, organic animations
                'gentle-bounce': 'gentle-bounce 2s ease-in-out infinite',
                'sway': 'sway 3s ease-in-out infinite',
                'fade-in-up': 'fade-in-up 0.6s ease-out',
            },
            keyframes: {
                'gentle-bounce': {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-2px)' },
                },
                'sway': {
                    '0%, 100%': { transform: 'rotate(-1deg)' },
                    '50%': { transform: 'rotate(1deg)' },
                },
                'fade-in-up': {
                    '0%': { opacity: '0', transform: 'translateY(10px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
            },
        },
    },

    plugins: [forms],
};
