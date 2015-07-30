var execPropel = require('./exec-propel');

console.log('Generating propel config...');
execPropel(['config:convert']);
