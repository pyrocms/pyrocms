/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './app/Components/*.php',
    './storage/framework/views/*.php',
    './resources/**/*.blade.php',
    './docs/*.md',
    './vendor/streams/**/docs/*.md',
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
