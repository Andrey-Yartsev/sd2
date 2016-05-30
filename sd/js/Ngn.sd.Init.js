Ngn.sd.Init = new Class({
  initialize: function(bannerId) {
    Ngn.sd.bannerId = bannerId;
    new this.barsClass();
    if (window.location.hash == '#preview') {
      Ngn.sd.previewSwitch();
    }
  },
  barsClass: function() {
    return Ngn.sd.Bars;
  }
});
