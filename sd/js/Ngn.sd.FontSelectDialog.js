// @requiresBefore s2/js/common/tpl?name=fontSelect&controller=/font/ajax_browse
Ngn.sd.FontSelectDialog = new Class({
  Extends: Ngn.sd.SelectDialog,
  name: 'font',
  options: {
    width: 600,
    message: Ngn.tpls.fontSelect,
    title: 'Choose Font...',
    value: 'Arial'
  },
  init: function() {
    this.parent();
    //this.message.addClass('hLoader');
    var els = this.message.getElements('div.item');
    var loaded = 0;
    els.each(function(el) {
      Ngn.sd.loadFont(el.get('data-name'), function() {
        loaded++;
        Cufon.set('fontFamily', el.get('data-name')).replace(el.getElement('.font'));
        //if (loaded == els.length) this.message.removeClass('hLoader');
      }.bind(this));
    }.bind(this));
  }
});
