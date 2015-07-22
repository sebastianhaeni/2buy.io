const webpack = require('webpack');
const config = require('./webpack.config.production');
const fs = require('fs');

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
