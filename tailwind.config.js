/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {
      spacing : {
        '128' : '32rems',
      },
    },
  },
  plugins: [ require('flowbite/plugin')],
}

