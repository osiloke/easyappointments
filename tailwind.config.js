/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ['./application/views/**/**/*.{html,js,php}'],
    darkMode: 'class',
    daisyui: {
        themes: [
            {
                lofi: {
                    ...require('daisyui/src/theming/themes')['[data-theme=lofi]'],
                    '.modal': {}
                }
            }
        ]
    },
    plugins: [
        require('@tailwindcss/typography'),
        require('@tailwindcss/forms'),
        require('@tailwindcss/container-queries'),
        require('daisyui')
    ]
};
