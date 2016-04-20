window.addEvent('sdPanelComplete', function() {
  new Ngn.Btn(Ngn.sd.fbtn('Add image', 'image'), null, {
    fileUpload: {
      url: '/pageBlock/' + Ngn.sd.bannerId + '/json_createImage',
      onRequest: function() {
        Ngn.Request.Iface.loading(true);
      }.bind(this),
      onComplete: function(v) {
        var block = Ngn.sd.block(Ngn.sd.elBlock().inject(Ngn.sd.eLayoutContent), v);
        block.creationEvent();
        Ngn.Request.Iface.loading(false);
      }.bind(this)
    }
  });
});