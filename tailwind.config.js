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
		 "./vendor/robsontenorio/mary/src/View/Components/**/*.php"
	],
    safelist: [
        'w-screen',
        'w-81',
        'max-w-screen-lg',
        'bg-green-50',
        'border',
        'border-green-800',
        'text-green-800',
        'text-sm',
        'shadow-sm'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    daisyui: {
        themes: ["light", "dark", "forest", "retro",
            {
                hwtheme: {
                    "primary": "#3ebaec",
                    "secondary": "#dcfba9",
                    "accent": "#f962cd",
                    "neutral": "#111827",
                    "base-100": "#dbeafe",
                    "info": "#0000ff",
                    "success": "#10b981",
                    "warning": "#fde047",
                    "error": "#f87171",
                },
            },],
    },

    plugins: [
		forms,
		typography,
		require("daisyui")
	],
};
