const plugin = require('tailwindcss/plugin');
/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ['./application/views/**/**/*.{html,js,php}'],
    darkMode: 'class',
    daisyui: {
        themes: [
            {
                lofi: {
                    ...require('daisyui/src/theming/themes')['[data-theme=lofi]'],
                    '.modal': {},
                    colors: {
                        'primary-black': '#000000',
                        'primary-white': '#ffffff',
                        'success-600': '#53b483'
                    }
                }
            }
        ]
    },
    variants: {
        extend: {
            backgroundColor: ['label-checked'],
            color: ['label-checked']
        }
    },
    plugins: [
        require('@tailwindcss/typography'),
        require('@tailwindcss/forms'),
        require('@tailwindcss/container-queries'),
        require('daisyui'),
        plugin(({addVariant, e}) => {
            addVariant('label-checked', ({modifySelectors, separator}) => {
                modifySelectors(({className}) => {
                    const eClassName = e(`label-checked${separator}${className}`); // escape class
                    const yourSelector = 'input[type="radio"]'; // your input selector. Could be any
                    return `${yourSelector}:checked ~ .${eClassName}`; // ~ - CSS selector for siblings
                });
            });
        })
    ]
};
