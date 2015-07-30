/**
 * Generates the propel config in php-format to use in silex.
 */

var execPropel = require('./exec-propel');

console.log('Generating propel config...');
execPropel(['config:convert']);
