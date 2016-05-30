Ngn.sd.BlockBBlog = new Class({
  Extends: Ngn.sd.BlockB,

  initBtns: function() {
    this.parent();
    new Ngn.Btn(Ngn.Btn.btn2('Настройки блога', 'settings').inject(this.eBtns, 'top'), function() {
      new Ngn.Dialog.RequestForm({
        url: '/blogSettings',
        dialogClass: 'settingsDialog compactFields dialog',
        width: 400
      });
    });
  },
  _resize: function(size) {
    delete size.h;
    this.parent(size);
  },
  replaceContent: function() {
    this.parent();
    this.el.getElements('.pNums a').each(function(el) {
      el.addEvent('click', function(e) {
        new Event(e).stop();
        new Ngn.Request({
          url: el.get('href').replace(/^\/(\w+)\//g, '/blog/'),
          onComplete: function() {
          }
        }).send();
      });
    });
  },
  editAction: function() {
  }

});
