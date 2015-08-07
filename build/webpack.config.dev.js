
const path = require('path');
const webpack = require('webpack');
const configMerge = require('./config-merge');
const baseConfig = require('./webpack.config.base.js');

module.exports = configMerge(baseConfig, {
  entry: {
    app: [
      'webpack-dev-server/client?http://localhost:3000',
      'webpack/hot/only-dev-server'
    ]
  },
  cache: true,
  devtool: 'eval-source-map',
  plugins: [
    new webpack.HotModuleReplacementPlugin(),
    new webpack.NoErrorsPlugin()
  ],
  module: {
    loaders: [{
      test: /\.js$/,
      loaders: ['react-hot', 'babel?stage=0'],
      include: [path.join(__dirname, '../app'), path.join(__dirname, '../node_modules/_lib')]
    }]
  }
});
