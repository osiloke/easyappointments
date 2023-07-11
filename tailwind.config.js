const options = require("./config"); //options from config.js

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./application/views/**/**/*.{html,js,php}"],
    darkMode: "class",
    theme: {
        extend: {},
    },
    plugins: [
        require("@tailwindcss/typography"),
        require("@tailwindcss/forms"),
        require('@tailwindcss/container-queries'),
        require('daisyui')]
};