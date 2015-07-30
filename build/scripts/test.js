/**
 * Unit tests.
 */

var path = require('path');
var Server = require('karma').Server;

var server = new Server({ configFile: path.join(__dirname, '../karma.js') });
server.start();
