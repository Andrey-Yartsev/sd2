window.addEvent('sdPanelComplete', function() {
  new Ngn.Btn(Ngn.sd.fbtn('New banner', 'add'), function() {
    new Ngn.Dialog.RequestForm({
      url: '/newBanner',
      width: 200,
      onSubmitSuccess: function(r) {
        window.location = '/cpanel/' + r.id;
      }
    });
  });
});