Ngn.sd.BlockBGallery = new Class({
  Extends: Ngn.sd.BlockB,

  init: function() {
    this.parent();
    var carousel = new Ngn.Carousel(this.el.getElement('.cont'));
    $('prev').addEvent('click', function() {
      carousel.toPrevious();
    });
    $('next').addEvent('click', function() {
      carousel.toNext();
    });
  }

});