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
  console.log('Frames count (param #5) is not defined');
  phantom.exit();
}
if (!args[6]) {
  console.log('Admin key (param #6) is not defined');
  phantom.exit();
}
if (!args[7]) {
  console.log('projectPath (param #7) is not defined');
  phantom.exit();
}

var projectName = args[1];
var domain = args[2];
var bannerId = args[3];
var userId = args[4];
var framesCount = args[5];
var adminKey = args[6];
var projectPath = args[7];
var cufonBlocksNumber = args[8];

var currentFrame = 0;
var timeoutId;

page.viewportSize = {
  width: 1300,
  height: 900
};

function log(s) {
  console.log(s);
}

// UNCOMMENT FOR DEBUG
page.onConsoleMessage = function(msg, lineNum, sourceId) {
  log('CONSOLE: ' + msg + ' (from line #' + lineNum + ' in "' + sourceId + '")');
};

var render = function(descr, callNumber) {
  //log('try ' + descr + " (" + new Date().getSeconds() + ':' + new Date().getMilliseconds() + ") [" + callNumber + "]");
  clearTimeout(timeoutId);
  timeoutId = setTimeout(function() {
    var date = new Date();
    currentFrame++;
    log("Frame " + currentFrame + " rendering on '" + descr + "' (" + //
    date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds() + '.' + date.getMilliseconds() + ") [" + callNumber + "]");
    page.render(projectPath + '/u/banner/animated/temp/' + bannerId + '/' + currentFrame + '.png');
    if (currentFrame == framesCount) {
      phantom.exit();
    }
  }, 500);
};

// setTimeout(function() {
//   phantom.exit();
// }, 2000);

var cufonBlocksExists = parseInt(cufonBlocksNumber) ? true : false;
var callNumber = 0;
page.onCallback = function(data) {
  callNumber++;
  if (cufonBlocksExists) {
    if (data.action == 'cufonLoaded') {
      render(data.action, callNumber);
    }
  } else if (data.action == 'afterInit') {
    render(data.action, callNumber);
  }
  if (data.action == 'frameChange') {
    render(data.action, callNumber);
  }
};

log('http://' + domain + '/cpanel/' + bannerId + //
  '?adminKey=' + adminKey + //
  '&userId=' + userId + //
  '#preview');

page.open('http://' + domain + '/cpanel/' + bannerId + //
  '?adminKey=' + adminKey + //
  '&userId=' + userId + //
  '#preview');

