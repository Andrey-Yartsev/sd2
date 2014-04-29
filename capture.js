var casper = require('casper').create();
casper.on('page.error', function(msg, trace) {
  console.trace('^^^: ' + msg);
});
var domain = casper.start('http://design-1-1.june.majexa.ru/cpanel', function() {
});
casper.evaluate(function() {
});
casper.then(function() {
  casper.waitForSelector('.id_1 a.edit', function() {
    casper.click('.id_1 a.edit');
    casper.wait(1000, function() {
      console.log('capture');
      casper.capture('/home/user/ngn-env/sd/static/watch/' + domain + '.png', {
        top: 0,
        left: 0,
        width: 950,
        height: 600
      });
    });
  });
});
casper.run();
