const colors = require("tailwindcss/colors");

module.exports = {
  future: {},
  content: ["./templates/**/*.twig", "./src/**/*.vue"],
  purge: ["./templates/**/*.twig"],
  theme: {
    extend: {},
    colors: {
      ...colors,
      sky: colors.sky,
      teal: colors.teal,
      rose: colors.rose,
    },
  },
  variants: {},
  plugins: [require("@tailwindcss/typography")],
};
