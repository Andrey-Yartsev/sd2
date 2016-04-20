Ngn.sd.ClipartInsertDialog = new Class({
  Extends: Ngn.sd.ButtonInsertDialog,
  options: {
    title: 'Insert clipart',
    url: '/cpanel/' + Ngn.sd.bannerId + '/ajax_clipartSelect',
  }
});

window.addEvent('sdPanelComplete', function() {
  new Ngn.Btn(Ngn.sd.fbtn('Add clipart', 'clipart'), function() {
    new Ngn.sd.ClipartInsertDialog();
  });
});