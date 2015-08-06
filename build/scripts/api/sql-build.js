/**
 * Builds the ddl sql file.
 */

var fs = require('fs');
var path = require('path');
var execPropel = require('./exec-propel');

console.log('Generating sql based on schema.xml...');
execPropel(['sql:build']);
