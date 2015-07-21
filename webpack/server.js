const webpack = require('webpack');
const WebpackDevServer = require('webpack-dev-server');
const config = require('./webpack.config.dev');

const server = new WebpackDevServer(webpack(config), {
  contentBase: './www/',
  path: './www/',
  historyApiFallback: true,
  stats: {
    colors: true
  }
});

server.listen(3000, 'localhost', function(err) {
  if (err) {
    console.log(err);
  }
  console.log('Listening at localhost:3000');
});
