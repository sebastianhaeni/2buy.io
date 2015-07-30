/**
 * Should be executed post `npm install`.
 * Creates new config files and executes `composer install`.
 */

var fs = require('fs');
var path = require('path');
var childProcess = require('child_process');

var apiSrc  = path.join(__dirname, '../../config/sample/api.yml');
var apiDist = path.join(__dirname, '../../config/api.yml');

var propelSrc  = path.join(__dirname, '../../config/sample/propel.yml');
var propelDist = path.join(__dirname, '../../config/propel.yml');

// copy api.yml from samples
if(!fs.existsSync(apiDist)){
  fs.createReadStream(apiSrc).pipe(fs.createWriteStream(apiDist));
}

// copy propel.yml from samples
if(!fs.existsSync(propelDist)){
  fs.createReadStream(propelSrc).pipe(fs.createWriteStream(propelDist));
}

var extension = process.env.OS === 'Windows_NT'
  ? '.bat'
  : '';

childProcess.execFileSync('composer' + extension, ['install']);
