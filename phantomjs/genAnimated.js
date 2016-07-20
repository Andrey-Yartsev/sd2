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

page.viewportSize = {
  width: 1300,
  height: 900
};

var render = function(n) {
  //console.log("Frame " + n + " rendering");
  page.render(projectPath + '/u/banner/animated/temp/' + bannerId + '/' + n + '.png');
};

var currentFrame = 0;

page.onCallback = function(data) {
  //console.log(data);
  if (parseInt(cufonBlocksNumber)) {
    if (data.action == 'cufonLoaded') {
      currentFrame++;
      //console.log('render on cufonLoaded');
      window.setTimeout(function() {
        render(currentFrame);
      }, 500);
    }
  } else if (data.action == 'afterInit') {
    currentFrame++;
    window.setTimeout(function() {
      //console.log('render on afterInit');
      render(currentFrame);
    }, 500);
  }
  if (data.action == 'frameChange') {
    currentFrame++;
    var timeoutId = setTimeout((function() {
      clearTimeout(timeoutId);
      //console.log('render on frameChange');
      render(currentFrame);
      if (currentFrame == framesCount) {
        phantom.exit();
      }
    }), 100);
  }
};

//console.log('http://' + domain + '/cpanel/' + bannerId + '?renderKey=' + renderKey + '#preview');
page.open('http://' + domain + '/cpanel/' + bannerId + '?renderKey=' + renderKey + '#preview');
//page.open('http://' + domain + '/sd/1.html');
