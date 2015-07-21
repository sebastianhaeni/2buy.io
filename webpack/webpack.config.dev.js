const path = require('path');
const webpack = require('webpack');
const configMerge = require('./config-merge');
const baseConfig = require('./webpack.config.base.js');

module.exports = configMerge(baseConfig, {
  entry: {
    app: ['webpack/hot/dev-server']
  },
  cache: true,
  devtool: 'eval-source-map',
  plugins: [
    new webpack.HotModuleReplacementPlugin(),
    new webpack.NoErrorsPlugin()
  ],
  module: {
    loaders: [{
        test: /\.jsx?$/,
        loaders: ['react-hot', 'babel-loader?stage=0'],
        include: path.join(__dirname, '../app/scripts')
      }
    ]
  }
});
