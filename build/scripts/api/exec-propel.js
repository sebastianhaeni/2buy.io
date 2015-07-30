/**
 * Executes the propel cli with the give arguments.
 */

var childProcess = require('child_process');

var extension = process.env.OS === 'Windows_NT'
  ? '.bat'
  : '';

var propelScript = __dirname + '/../../../vendor/bin/propel' + extension;

module.exports = function(args) {
  childProcess.execFileSync(propelScript, args);
}
