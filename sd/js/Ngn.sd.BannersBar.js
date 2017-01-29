Ngn.sd.BannersBar = new Class({

  initialize: function() {
    this.opened = Ngn.Storage.get('sd.BannersBar.opened');
    this.eWrapper = new Element('div', {
      'class': 'bannerBarWrapper'
    }).inject(document.getElement('.body'));
    this.eBar = new Element('div', {
      'class': 'bannerBar'
    }).inject(this.eWrapper);
    this.eCont = new Element('div', {
      'class': 'bannerBarCont'
    }).inject(this.eBar);
    this.eContInner = new Element('div', {
      'class': 'bannerBarContInner'
    }).inject(this.eCont);
    var eHandler = new Element('div', {
      'class': 'handler'
    }).inject(this.eBar);
    if (this.opened) {
      this.show();
    } else {
      this.hide();
    }
    eHandler.addEvent('click', this.toggle.bind(this));
    this.eCont.addEvent('mousewheel', function(e) {
      this.eCont.scrollLeft += -(e.wheel * 35 );
    }.bind(this));
    this.load();
  },

  load: function() {
    this.eContInner.set('html', '');
    new Ngn.Request.JSON({
      url: '/allBanners',
      onComplete: function(r) {
        var eSelected = null;
        for (var i = 0; i < r.banners.length; i++) {
          var el = new Element('a', {
            'class': 'item',
            href: r.banners[i].editLink,
            html: r.banners[i].downloadLink ? '<img src="' + r.banners[i].directLink + '">' : '<div>need to render</div>'
          }).inject(this.eContInner);
          if (Ngn.sd.bannerId == r.banners[i].id) {
            el.addClass('selected');
            eSelected = el;
          }
        }
        this.eContInner.setStyle('width', (el.getSizeWithMargin().x * r.banners.length) + 'px');

        if (eSelected && eSelected.getPosition().x > this.eCont.getSize().x) {
          new Fx.Scroll(this.eCont).toElement(eSelected);
        }
      }.bind(this)
    }).send();
  },

  show: function() {
    this.eCont.setStyle('display', 'block');
    this.eWrapper.removeClass('hiddn');
    this.opened = true;
    Ngn.Storage.set('sd.BannersBar.opened', true);
  },

  hide: function() {
    this.eCont.setStyle('display', 'none');
    //this.eWrapper.setStyle('bottom', '-10px');
    this.eWrapper.addClass('hiddn');
    this.opened = false;
    Ngn.Storage.set('sd.BannersBar.opened', false);
  },

  toggle: function() {
    if (this.opened) {
      this.hide();
    } else {
      this.show();
    }
  }

});