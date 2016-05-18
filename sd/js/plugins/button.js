Ngn.sd.BlockBButton = new Class({
  Extends: Ngn.sd.BlockBImage
});

Ngn.sd.addBannerButton = function(buttonUrl) {
  new Ngn.Request.JSON({
    url: '/cpanel/' + Ngn.sd.bannerId + '/json_createButtonBlock?buttonUrl=' + buttonUrl,
    onComplete: function() {
      Ngn.sd.reinit();
    }
  }).send();
};

Ngn.sd.ButtonInsertDialog = new Class({
  Extends: Ngn.Dialog,
  options: {
    id: 'button',
    title: 'Insert button',
    okText: 'Insert',
    width: 400,
    height: 300,
    url: '/cpanel/' + Ngn.sd.bannerId + '/ajax_buttonSelect',
    dialogClass: 'dialog-images',
    onRequest: function() {
      this.initImages();
    },
    ok: function() {
      Ngn.sd.addBannerButton(Ngn.sd.selectedButtonUrl);
    }.bind(this)
  },
  removeClass: function() {
    this.images.each(function(el) {
      el.removeClass('selected');
    });
  },
  initImages: function() {
    this.images = this.message.getElements('img');
    this.select(this.images[0]);
    this.images.each(function(el) {
      el.addEvent('click', function() {
        this.select(el);
      }.bind(this));
    }.bind(this));
  },
  select: function(el) {
    this.removeClass();
    Ngn.sd.selectedButtonUrl = el.get('src');
    el.addClass('selected');
  }
});

window.addEvent('sdPanelComplete', function() {
  new Ngn.Btn(Ngn.sd.fbtn('Add button', 'button'), function() {
    new Ngn.sd.ButtonInsertDialog();
  });
});