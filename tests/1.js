var casper = require('casper').create();
casper.on('page.error', function(msg, trace) {
  console.trace('^^^: ' + msg);
});
casper.start('http://design-1-1.june.majexa.ru/cpanel', function() {
});
casper.evaluate(function() {
});
console.log('22222');
casper.then(function() {
  console.log('33333');
  casper.waitForSelector('.id_1 a.edit', function() {
    casper.click('.id_1 a.edit');
    // casper.waitForSelector('#text_dialog', function() {
      console.log('55555');
      casper.capture('../static/capture/text_edit.png', {
        top: 0,
        left: 0,
        width: 950,
        height: 600
      });
    //});
  });
});
casper.run();
