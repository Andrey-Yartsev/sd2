var casper = require('casper').create();
//require('./sd-core');

var Sd = {};
Sd.testSite = 'id8.sitedraw.ru';
/*
 Sd.pageError = function(msg, trace) {
 var s = msg + "\n";
 trace.forEach(function(item) {
 s += '  ', item.file, ':', item.line + "\n";
 })
 throw new Error(msg);
 };
 */



casper.start('http://' + Sd.testSite + '/cpanel', function(a) {
  //console.log('loaded ' + a);
});

casper.run();

casper.test.begin('Index test', 2, function suite(test) {
  casper.on('page.error', function(msg, trace) {
    test.error(msg);
  });
  casper.start('http://' + Sd.testSite + '/cpanel', function() {
  });
  casper.then(function() {
    casper.waitForSelector('.type_menu a.edit', function() {
      casper.click('.type_menu a.edit');
    });
  });
  casper.run(function() {
    test.done();
  });
});

/*
 page.open('http://' + Sd.testSite + '/cpanel', function(status) {
 casper.test.assert(status === 'success', 'index not loaded');
 return;
 if (status !== 'success') {
 console.log('Unable to access network');
 } else {
 var a = page.evaluate(function() {
 return document.getElementById('font1_dialog').textContent;
 });
 console.log(a);
 }
 phantom.exit();
 });

 page.onError = function (msg, trace) {
 console.log(msg);
 trace.forEach(function(item) {
 console.log('  ', item.file, ':', item.line);
 })
 }
 */