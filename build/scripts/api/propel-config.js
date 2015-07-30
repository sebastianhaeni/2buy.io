var execPropel = require('./exec-propel');

console.log('Regenerating propel config...');
execPropel(['config:convert']);
