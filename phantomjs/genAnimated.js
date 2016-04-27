var page = require('webpage').create();
var system = require('system');
var args = system.args;
var config = require('config');

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
  console.log('Frames count (param #4) is not defined');
  phantom.exit();
}
if (!args[5]) {
  console.log('Render key (param #5) is not defined');
  phantom.exit();
}
if (!args[6]) {
  console.log('ngnEnvPath (param #6) is not defined');
  phantom.exit();
}

var projectName = args[1];
var domain = args[2];
var bannerId = args[3];
var framesCount = args[4];
var renderKey = args[5];
var ngnEnvPath = args[6];

page.viewportSize = {
  width: 1300,
  height: 900
};

page.open('http://' + domain + '/cpanel/' + bannerId + '?renderKey=' + renderKey + '#preview', function() {
  var n = 1;
  var make = function() {
    page.render(config.ngnEnvPath + '/projects/' + projectName + '/u/banner/animated/temp/' + bannerId + '/' + n + '.png');
    n++;
    window.setTimeout(function() {
      if (n - 1 == framesCount) {
        phantom.exit();
        return;
      }
      make();
    }, 500);
  };
  make();
});
