var page = require('webpage').create();
var system = require('system');
var args = system.args;

if (!args[1]) {
  console.log('Banner ID is not defined');
  phantom.exit();
}

var bannerId = args[1];

page.viewportSize = {
  width: 1300,
  height: 900
};

page.open('http://bmaker.majexa.ru/cpanel/' + bannerId + '#preview', function() {
  window.setTimeout(function () {
    page.render('/home/user/ngn-env/projects/bmaker/u/banner/static/' + bannerId + '.png');
    phantom.exit();
  }, 100);
});
