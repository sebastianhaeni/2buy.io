const path = require('path');
const webpack = require('webpack');
const configMerge = require('./config-merge');
const baseConfig = require('./webpack.config.base.js');

module.exports = configMerge(baseConfig, {
  plugins: [
    new webpack.optimize.OccurenceOrderPlugin(),
    new webpack.DefinePlugin({
      'process.env': {
        'NODE_ENV': JSON.stringify('production')
      }
    }),
    new webpack.optimize.UglifyJsPlugin({
      compressor: {
        warnings: false
      }
    })
  ],
  module: {
    loaders: [{
      test: /\.js$/,
      loaders: ['babel?stage=0'],
      include: [path.join(__dirname, '../app'), path.join(__dirname, '../node_modules/_lib')]
    }]
  }
});
