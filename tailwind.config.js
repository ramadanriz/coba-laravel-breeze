const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    darkMode: 'class',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },

            colors: {
                dark: {
                    'eval-0': '#151823',
                    'eval-1': '#222738',
                    'eval-2': '#2A2F42',
                    'eval-3': '#2C3142',
                },
                primary: {
                    '50':'#eff6ff',
                    '100':'#dbeafe',
                    '200':'#bfdbfe',
                    '300':'#93c5fd',
                    '400':'#60a5fa',
                    '500':'#3b82f6',
                    '600':'#2563eb',
                    '700':'#1d4ed8',
                    '800':'#1e40af',
                    '900':'#1e3a8a'
                }
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
}
