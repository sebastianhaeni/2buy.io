/**
 * Inserts the sql files defined in the map file into the database.
 */

var execPropel = require('./exec-propel');

console.log('Generating database...');
execPropel(['sql:insert']);
