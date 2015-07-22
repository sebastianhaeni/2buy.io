var childProcess = require('child_process');
var fs = require('fs');
var portscanner = require('portscanner')

portscanner.checkPortStatus(3001, 'localhost', function(error, status) {
  // Status is 'open' if currently in use or 'closed' if available
  console.log(status)
})

var out = fs.openSync('./build/api.log', 'a');
var err = fs.openSync('./build/api.log', 'a');

var child = childProcess.spawn('php', [
  '-S',
  'localhost:80',
  'api/api.php'
], {
  detached: true,
  stdio: [ 'ignore', out, err ]
});

child.unref();

console.log('Running API on http://localhost:3001/v1');
console.log('To stop it, open Task Manager and kill the php process.');
