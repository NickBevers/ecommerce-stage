const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    "./storage/framework/views/*.php",
    "./resources/views/**/*.blade.php",
    "./resources/js/**/*.vue",
  ],
  plugins: [
    require("@tailwindcss/forms"),
    require("@tailwindcss/aspect-ratio"),
    require("@tailwindcss/typography"),
    require('tailwind-scrollbar'),
  ],
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        primary: {
          50: "#eff6ff",
          100: "#dbeafe",
          200: "#bfdbfe",
          300: "#93c5fd",
          400: "#60a5fa",
          500: "#3b82f6",
          600: "#2563eb",
          700: "#1d4ed8",
          800: "#1e40af",
          900: "#1e3a8a",
        },
        indigo: {
          50: "#e9eefd",
          100: "#d4ddfb",
          200: "#a8baf7",
          300: "#7d98f3",
          400: "#5175ef",
          500: "#3c64ed",
          600: "#2653EB",
          700: "#1e42bc",
          800: "#17328d",
          900: "#0b1946",
        },
      },
    },
    fontFamily: {
      body: ["Golos", "sans-serif"],
      sans: ["Poppins", "sans-serif"],
    },
  },
};
