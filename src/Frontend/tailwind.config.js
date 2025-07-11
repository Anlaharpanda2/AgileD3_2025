/** @type {import('tailwindcss').Config} */
export default {
  // Gunakan pola ini agar Tailwind otomatis memindai semua file di folder src
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      // Tambahkan keyframes untuk animasi 'float'
      keyframes: {
        float: {
          '0%, 100%': { transform: 'translateY(0px)' },
          '50%': { transform: 'translateY(-15px)' },
        }
      }
    },
  },
  plugins: [],
}