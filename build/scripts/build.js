/**
 * Builds the propel models and builds the frontend.
 */

const webpack = require('webpack');
const config = require('../webpack.config.production');
const fs = require('fs');
const execPropel = require('./api/exec-propel');

// updating propel config
require('./api/propel-config');
// Generating propel models
execPropel(['model:build']);

// Generate static js resources
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
