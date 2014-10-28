window.addEvent('domready', function() {
  $$('.block.type_font').each(function(el) {
    var font = el.get('data-fontFamily');
    Ngn.sd.loadFont(font, function() {
      Cufon.set('fontFamily', font).replace(el.getElement('.cont'));
    });
  });
});
Ngn.sd.initFullBodyHeight();

