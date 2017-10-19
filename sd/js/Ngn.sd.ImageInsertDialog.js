Ngn.sd.ImageInsertDialog = new Class({
  Extends: Ngn.Dialog,
  options: {
    id: 'image',
    title: 'Insert image',
    okText: 'Insert',
    width: 400,
    height: 300,
    //url: 'ajax_select',
    //createUrl: 'ajax_select',
    dialogClass: 'dialog dialog-images',
    createImageJsonAction: 'createImageBlock',
    onRequest: function() {
      this.initImages();
    }
  },
  initialize: function(opts) {
    if (!opts) opts = {};
    opts = Object.merge(opts, {
      ok: this.okAction.bind(this)
    });
    this.parent(opts);
  },
  okAction: function() {
    this.insertImage(this.selectedUrl);
  },
  createImageUrl: function(url) {
    return '/cpanel/' + Ngn.sd.bannerId + '/json_' + this.createImageJsonAction + '?url=' + url
  },
  insertImage: function(url) {
    new Ngn.Request.JSON({
      url: this.createImageUrl(url),
      onComplete: function() {
        Ngn.sd.reinit();
      }
    }).send();
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
    this.selectedUrl = el.get('src');
    el.addClass('selected');
  }
});
