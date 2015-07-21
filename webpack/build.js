const webpack = require('webpack');
const config = require('./webpack.config.production');
const fs = require('fs');

fs.readFile('./www/index.html', function read(err, data) {
  if (err) {
    throw err;
  }
  data = data.toString().replace('  <script src="http://localhost:3000/webpack-dev-server.js"></script>\r\n', '');
  fs.writeFile('./www/generated/index.html', data);
});

webpack(config).run(function(err, stats) {
  if(err){
    console.error(err);
    return;
  }
  console.log(stats.toString({
    colors: true,
    timings: true
  }));
});
