window.addEvent('sdPanelComplete', function() {
  new Ngn.Btn(Ngn.sd.fbtn(Ngn.Locale.get('Sd.newDocument'), 'add'), function() {
    new Ngn.Dialog.RequestForm({
      url: '/newDocument',
      width: 300,
      onSubmitSuccess: function(r) {
        window.location = '/cpanel/' + r.id;
      }
    });
  });
});