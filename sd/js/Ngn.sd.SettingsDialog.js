Ngn.sd.SettingsDialog = new Class({
  Extends: Ngn.Dialog.RequestForm,

  options: {
    useFx: false
  },

  formInit: function() {
    var obj = this;
    var el = this.message.getElement('[name=fontFamily]');
    if (el) {
      el.addEvent('change', function() {
        obj.fireEvent('changeFont', this.get('value'));
      });
      this.message.getElement('[name=fontSize]').addEvent('change', function() {
        obj.fireEvent('changeSize', this.get('value'));
      });
      this.message.getElement('[name=shadow]').addEvent('change', function() {
        obj.fireEvent('changeShadow', this.get('checked'));
      });
      this.message.getElement('[name=color]').addEvent('change', function() {
        obj.fireEvent('changeColor', this.get('value'));
      });
    }
  }

});
