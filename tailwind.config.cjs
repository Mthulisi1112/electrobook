/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./resources/**/*.blade.php", "./resources/**/*.js"],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Rise", "Avenir", "Helvetica", "Arial", "sans-serif"],
            },
        },
    },
    plugins: [],
};
