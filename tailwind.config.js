/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./storage/framework/views/*.php",
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./resources/css/**/*.css",
        "./resources/sass/**/*.scss",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', 'Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            },
            colors: {
                primary: {
                    50: '#eff6ff',
                    100: '#dbeafe',
                    200: '#bfdbfe',
                    300: '#93c5fd',
                    400: '#60a5fa',
                    500: '#3b82f6',
                    600: '#2563eb',
                    700: '#1d4ed8',
                    800: '#1e3a8a',
                    900: '#1e40af',
                },
                accent: {
                    orange: '#f97316',
                    purple: '#8b5cf6',
                }
            },
            animation: {
                'float': 'float 6s ease-in-out infinite',
                'gradient': 'gradient 3s ease-in-out infinite',
                'background-shift': 'backgroundShift 20s ease-in-out infinite',
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0px) rotate(0deg) scale(1)', opacity: '0.7' },
                    '50%': { transform: 'translateY(-20px) rotate(180deg) scale(1.1)', opacity: '1' },
                },
                gradient: {
                    '0%, 100%': { backgroundPosition: '0% 50%' },
                    '50%': { backgroundPosition: '100% 50%' },
                },
                backgroundShift: {
                    '0%, 100%': { opacity: '0.5', transform: 'scale(1)' },
                    '50%': { opacity: '0.8', transform: 'scale(1.1)' },
                }
            },
            backdropBlur: {
                xs: '2px',
            }
        },
    },
    plugins: [],
}


