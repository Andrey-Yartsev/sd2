var page = require('webpage').create();
var system = require('system');
var args = system.args;

if (!args[1]) {
  console.log('Project name (param #1) is not defined');
  phantom.exit();
}
if (!args[2]) {
  console.log('Domain (param #2) is not defined');
  phantom.exit();
}
if (!args[3]) {
  console.log('Banner ID (param #3) is not defined');
  phantom.exit();
}
if (!args[4]) {
  console.log('Render key (param #4) is not defined');
  phantom.exit();
}
if (!args[5]) {
  console.log('ngnEnvPath (param #5) is not defined');
  phantom.exit();
}

var projectName = args[1];
var domain = args[2];
var bannerId = args[3];
var renderKey = args[4];
var ngnEnvPath = args[5];

page.viewportSize = {
  width: 1300,
  height: 900
};

page.open('http://' + domain + '/cpanel/' + bannerId + '?renderKey=' + renderKey + '#preview', function() {
  window.setTimeout(function () {
    page.render(ngnEnvPath + '/projects/' + projectName + '/u/banner/static/' + bannerId + '.png');
    phantom.exit();
  }, 100);
});
