var page = require('webpage').create();
var system = require('system');
var args = system.args;

if (!args[1]) {
  console.log('Banner ID is not defined');
  phantom.exit();
}
if (!args[2]) {
  console.log('Frames count is not defined');
  phantom.exit();
}

var bannerId = args[1];
var framesCount = args[2];

page.viewportSize = {
  width: 1300,
  height: 900
};

console.log('start');
page.open('http://bmaker.majexa.ru/cpanel/' + bannerId + '#preview', function() {
  var n = 1;
  var make = function() {
    console.log('capture ' + n);
    page.render('/home/user/ngn-env/projects/bmaker/u/banner/animated/temp/' + bannerId + '/' + n + '.png');
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
