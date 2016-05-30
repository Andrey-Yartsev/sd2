Ngn.sd.BlockBButton = new Class({
  Extends: Ngn.sd.BlockBImage
});

Ngn.sd.ButtonInsertDialog = new Class({
  Extends: Ngn.sd.ImageInsertDialog,
  options: {
    title: 'Insert button',
    url: '/cpanel/' + Ngn.sd.bannerId + '/ajax_buttonSelect'
  },
  createImageUrl: function(url) {
    return '/cpanel/' + Ngn.sd.bannerId + '/json_createButtonBlock?url=' + url
  }
});

window.addEvent('sdPanelComplete', function() {
  new Ngn.Btn(Ngn.sd.fbtn('Add button', 'button'), function() {
    new Ngn.sd.ButtonInsertDialog();
  });
});