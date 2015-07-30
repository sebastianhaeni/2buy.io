var execPropel = require('./exec-propel');

console.log('Generating database...');
execPropel(['sql:insert']);
