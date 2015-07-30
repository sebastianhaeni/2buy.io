
// lint js
var CLIEngine = require("eslint").CLIEngine;
var cli = new CLIEngine({useEslintrc: true});
console.log(cli.getFormatter()(cli.executeOnFiles(['app/']).results));

// lint scss
// TODO

// lint php
// TODO
