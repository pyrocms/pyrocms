// You would need to fill 3 fields below
var
  appReference = '',
  vendor = '',
  themeSlug = '',
  resources = `addons/${appReference}/${vendor}/${themeSlug}-theme/resources/`,
  Elixir = require('laravel-elixir');

require('laravel-elixir-webpack-official');
require('laravel-elixir-vue-2');

Elixir.config.sourcemaps = true;

Elixir.webpack.mergeConfig({
  babel: {
    presets: ['es2015', 'stage-2'],
    plugins: ['transform-runtime'],
  },
  resolve: {
    alias: {
      $: 'jquery/src/jquery',
      vue: 'vue/dist/vue.js',
      jquery: 'jquery/src/jquery',
    }
  },
  module: {
    loaders: [
      {
        test: /\.css$/,
        loader: 'style!css',
      },
      {
        test: /\.(s(a|c)ss)$/,
        includePaths: [
          './node_modules/bootstrap-sass/assets/stylesheets'
        ],
        loader: 'style!css!sass',
      },
      {
        test: /\.styl(us)?$/,
        loader: 'style!css!stylus',
      },
      {
        test: /\.(png|jpe?g|gif|ico)$/,
        loader: 'file?name=/img/[name].[ext]',
      },
      {
        test: /\.(ttf|eot|svg|woff2?)(\?v=[0-9]\.[0-9]\.[0-9])?$/,
        loader: 'file?name=/fonts/[name].[ext]',
      },
    ],
  },
});

Elixir(mix => {
  mix
    .copy(`${resources}fonts`, 'public/fonts')
    .copy(`${resources}img`, 'public/img')
    .stylus(`./${resources}stylus/main.styl`, 'public/css', `${resources}stylus`)
    .sass('theme.scss', 'public/css', `${resources}scss/theme`)
    .webpack('main.js', 'public/js', `${resources}js`);
});
