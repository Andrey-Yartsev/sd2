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
  console.log('Frames count (param #4) is not defined');
  phantom.exit();
}
if (!args[5]) {
  console.log('Render key (param #5) is not defined');
  phantom.exit();
}
if (!args[6]) {
  console.log('projectPath (param #6) is not defined');
  phantom.exit();
}

var projectName = args[1];
var domain = args[2];
var bannerId = args[3];
var framesCount = args[4];
var renderKey = args[5];
var projectPath = args[6];
var cufonBlocksNumber = args[7];

var currentFrame = 0;
var timeoutId;

page.viewportSize = {
  width: 1300,
  height: 900
};

function log(s) {
  //console.log(s);
}

var render = function(descr, callNumber) {
  log('try ' + descr + " ("+new Date().getSeconds()+':'+ new Date().getMilliseconds()+") [" + callNumber + "]");
  clearTimeout(timeoutId);
  timeoutId = setTimeout(function() {
    currentFrame++;
    log("Frame " + currentFrame + " rendering on '" + descr + "' ("+ //
      new Date().getSeconds()+':'+ new Date().getMilliseconds()+") [" + callNumber + "]");
    page.render(projectPath + '/u/banner/animated/temp/' + bannerId + '/' + currentFrame + '.png');
    if (currentFrame == framesCount) {
      phantom.exit();
    }
  }, 100);
};

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

function a() {
  timeoutId = setTimeout(function() {
    clearTimeout(timeoutId);
    log('a');
  }, 100);
}


log('http://' + domain + '/cpanel/' + bannerId + '?renderKey=' + renderKey + '#preview');
page.open('http://' + domain + '/cpanel/' + bannerId + '?renderKey=' + renderKey + '#preview');
//page.open('http://' + domain + '/sd/1.html');
