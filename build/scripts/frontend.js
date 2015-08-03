/**
 * Starts a webpack dev server with hot reloading that hosts the frontend.
 * Specifying the option --open will open the site in the browser.
 */

const webpack = require('webpack');
const WebpackDevServer = require('webpack-dev-server');
const config = require('../webpack.config.dev');

const server = new WebpackDevServer(webpack(config), {
  contentBase: './www',
  publicPath: config.output.publicPath,
  hot: true,
  historyApiFallback: true,
  stats: {
    colors: true
  }
});

server.listen(3000, 'localhost', function(err) {
  if (err) {
    console.log(err);
  }
  console.log('Running Frontend at http://localhost:3000');
});

if(process.env.npm_config_argv.indexOf('--open') >= 0){
  require('open')('http://localhost:3000');
}
