const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                dawn: {
                    header: '#3E4865',   // ヘッダー背景 / 主要ボタン
                    accent: '#D05E45',   // アクセント（オレンジ）
                    glass: '#6C6C6C',    // 透過グレー基準
                    text: '#6C6C6C',     // 文字色
                    register: '#5A659E', // REGISTERボタン
                    update: '#81987C',   // 更新ボタン
                    danger: '#AD5B59',   // フォロー外す等
                    white: '#FFFFFF',
                },
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
