const path = require('path');
const webpack = require('webpack');

module.exports = {
  entry: {
    app: [path.resolve(__dirname, '../app/scripts/main.js')]
  },
  output: {
    path: path.resolve(__dirname, '../www/static/'),
    filename: '[name].js',
    chunkFilename: '[id].chunk.js',
    publicPath: '/static/'
  },
  resolve: {
    extensions: ['', '.js']
  },
  eslint: {
    configFile: '.eslintrc'
  },
  plugins: [
    new webpack.ProvidePlugin({
      $: 'jquery',
      jQuery: 'jquery',
      'window.jQuery': 'jquery'
    }),
    new webpack.optimize.CommonsChunkPlugin('shared.js')
  ],
  module: {
    loaders: [{
      test: /\.scss$/,
      loader: 'style!css!sass?outputStyle=expanded'
    }, {
      test: /\.css$/,
      loader: 'style!css'
    }]
  }
};
