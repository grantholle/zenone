/** @type {import('tailwindcss').Config} */
export default {
  content: [
    'nuxt/**/*.{vue,js,ts}',
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}

