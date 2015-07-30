/**
 * Builds the ddl sql and map file. Adds the test data sql to the map file.
 */

var fs = require('fs');
var path = require('path');
var execPropel = require('./exec-propel');

console.log('Generating sql based on schema.xml...');
execPropel(['sql:build', '--overwrite']);

var append = '../build/test-data.sql=default';

fs.appendFile(path.join(__dirname, '/../../../generated-sql/sqldb.map'), append, function(err){
  if(err){
    throw err;
  }
});
