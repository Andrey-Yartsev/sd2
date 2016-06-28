Ngn.sd.SelectDialog = new Class({
  Extends: Ngn.ElSelectDialog,
  options: {
    footer: false,
    width: 580,
    height: 300,
    savePosition: true,
    closeOnSelect: true,
    onChangeFont: function() {
    }
  },
  setOptions: function(opts) {
    this.parent(Object.merge(opts || {}, {id: this.name + 'Select'}));
  },
  eSelected: null,
  init: function() {
    var obj = this;
    this.message.getElements('div.item').each(function(el) {
      if (obj.options.value && el.get('data-name') == obj.options.value) {
        obj._select(el);
      }
      el.addEvent('click', function() {
        obj.select(this);
      });
    });
    if (obj.eSelected) (function() {
      new Fx.Scroll(obj.message).toElement(obj.eSelected)
    }).delay(500);
  },
  _select: function(el) {
    if (this.eSelected) this.eSelected.removeClass('selected');
    this.eSelected = el.addClass('selected');
    this.fireEvent('changeValue', el.get('data-name'));
  },
  select: function(el) {
    this._select(el);
    if (this.options.closeOnSelect) this.close();
  }
});
