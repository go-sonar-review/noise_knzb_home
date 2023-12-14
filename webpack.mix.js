const { version } = require("laravel-mix");
const mix = require("laravel-mix");

const tailwindcss = require("tailwindcss");

mix.js("./src/main.js", "js").vue().setPublicPath("./web/dist");

mix
  .sass("./src/styles/main.scss", "css")
  .options({
    processCssUrls: false,
    postCss: [
      require("postcss-css-variables")(),
      tailwindcss("./tailwind.config.js"),
    ],
  })
  .version()
  .setPublicPath("./web/dist");

mix.webpackConfig({
  module: {
    rules: [
      {
        test: /\.scss/,
        loader: "import-glob-loader",
      },
    ],
  },
});
