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
  console.log('User ID (param #4) is not defined');
  phantom.exit();
}
if (!args[5]) {
  console.log('Render key (param #4) is not defined');
  phantom.exit();
}
if (!args[6]) {
  console.log('projectPath (param #5) is not defined');
  phantom.exit();
}

// var projectName = args[1];
var domain = args[2];
var bannerId = args[3];
var userId = args[4];
var adminKey = args[5];
var projectPath = args[6];
var cufonBlocksNumber = args[7];

page.viewportSize = {
  width: 1300,
  height: 900
};

// UNCOMMENT FOR DEBUG
page.onConsoleMessage = function(msg, lineNum, sourceId) {
  //console.log('CONSOLE: ' + msg + ' (from line #' + lineNum + ' in "' + sourceId + '")');
  //phantom.exit();
};

var render = function() {
  page.render(projectPath + '/u/banner/static/' + bannerId + '.png');
  phantom.exit();
};

page.onCallback = function(data) {
  // console.debug(data.action + ' ' + cufonBlocksNumber);
  if (parseInt(cufonBlocksNumber)) {
    if (data.action == 'cufonLoaded') {
      window.setTimeout(function() {
        render();
      }, 500);
    }
  } else if (data.action == 'afterInit') {
    window.setTimeout(function() {
      render();
    }, 500);
  }
};

// UNCOMMENT TO SHOW URL
// console.debug('http://' + domain + '/cpanel/' + bannerId + //
//   '?adminKey=' + adminKey + //
//   '&userId=' + userId + '#preview');

page.open('http://' + domain + '/cpanel/' + bannerId + //
  '?adminKey=' + adminKey + //
  '&userId=' + userId + '#preview', function() {});
