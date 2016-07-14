Ngn.sd.GlobalSlides = new Class({

  duration: 1500,
  slideSelector: '.cont div',
  blocks: [],

  initialize: function(blocks) {
    this.id = Ngn.String.rand(3);
    this.blocks = [];
    for (var i in blocks) {
      this.add(blocks[i]);
    }
    this.startAnimation.delay(100, this); // Make delay to all blocks will be already added
  },

  add: function(block) {
    if (!block.hasAnimation()) return;
    this.blocks.push(block);
    this.hideSlides(block);
  },

  hideSlides: function(block) {
    var slides = block.el.getElements(this.slideSelector);
    if (slides.length > 1) {
      for (var i = 1; i < slides.length; i++) {
        slides[i].setStyle('display', 'none');
      }
    }
  },

  slides: [],

  cacheSlides: function() {
    var slides = [];
    for (var i = 0; i < this.blocks.length; i++) {
      slides.push(this.blocks[i].el.getElements(this.slideSelector));
    }
    this.slides = slides;
  },

  phantomFrameChange: function() {
    if (typeof window.callPhantom === 'function') {
      window.callPhantom({
        action: 'frameChange'
      });
    }
  },

  currentIndex: 0,
  nextIndex: 0,
  animationStarted: false,
  maxSlidesBlockN: 0,

  initMaxSlidesBlockN: function() {
    for (var i = 0; i < this.slides.length; i++) {
      if (this.slides[i].length > this.maxSlidesBlockN) {
        this.maxSlidesBlockN = i;
      }
    }
  },

  nextSlide: function() {
    if (this.slides[this.maxSlidesBlockN][this.currentIndex + 1]) {
      this.nextIndex = this.currentIndex + 1;
    } else {
      this.nextIndex = 0;
    }
    // hide current
    for (var i = 0; i < this.slides.length; i++) {
      if (this.slides[i].length > 1) {
        if (this.slides[i][this.currentIndex]) this.slides[i][this.currentIndex].setStyle('display', 'none');
        if (this.slides[i][this.nextIndex]) this.slides[i][this.nextIndex].setStyle('display', 'block');
      }
    }
    // show next
    this.currentIndex = this.nextIndex;
    this.phantomFrameChange();
  },

  animationId: null,

  startAnimation: function() {
    if (this.animationStarted) return;
    this.animationStarted = true;
    //this.phantomFrameChange();
    this.cacheSlides();
    this.initMaxSlidesBlockN();
    if (this.slides.length) {
      this.animationId = this.nextSlide.periodical(this.duration, this);
    }
  }

});

Ngn.sd.GlobalSlides.init = function() {
  if (Ngn.sd.GlobalSlides.timeoutId) {
    clearTimeout(Ngn.sd.GlobalSlides.timeoutId);
  }
  Ngn.sd.GlobalSlides.timeoutId = function() {
    if (Ngn.sd.GlobalSlides.instance) {
      clearTimeout(Ngn.sd.GlobalSlides.instance.animationId);
    }
    Ngn.sd.GlobalSlides.instance = new Ngn.sd.GlobalSlides(Ngn.sd.blocks);
  }.delay(1);
};

Ngn.sd.GlobalSlides.lastFrameChangeTime = 0;
