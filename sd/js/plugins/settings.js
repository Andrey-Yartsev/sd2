window.addEvent('sdPanelComplete', function() {
  new Ngn.Btn(Ngn.sd.fbtn('Settings', 'settings'), function() {
    new Ngn.Dialog.RequestForm({
      url: '/cpanel/' + Ngn.sd.bannerId + '/json_settings',
      width: 250,
      onSubmitSuccess: function(r) {
        Ngn.sd.setBannerSize(r);
      }
    });
  });
});