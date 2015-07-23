var childProcess = require('child_process');
var fs = require('fs');
var http = require('http');

var PORT = 3001;

function startApi() {
  console.log('Starting API...');

  var child = childProcess.spawn('php', [
    '-S',
    '127.0.0.1:' + PORT,
    'api/api.php'
  ]);

  console.log('Running API on http://localhost:' + PORT + '/v1/');
}

http.get({
  host: '127.0.0.1',
  port: PORT,
  path: '/v1/'
}, function(response) {
  var json = '';

  response.on('data', function(data) {
    json += data;
  });

  response.on('end', function() {
    var result = JSON.parse(json);
    if(result.author === '2buy.io'){
      console.log('API already started');
    } else {
      startApi();
    }
  });
}).on('error', function(e){
  startApi();
});
