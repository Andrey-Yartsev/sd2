Ngn.sd.CreateFromTemplateDialog = new Class({
  Extends: Ngn.Dialog,
  options: {
    id: 'template',
    title: 'Create from template',
    okText: 'Create',
    width: 400,
    height: 300,
    url: '/cpanel/' + Ngn.sd.bannerId + '/ajax_buttonSelect',
    onRequest: function() {
    },
    ok: function() {
    }.bind(this)
  }
});

window.addEvent('sdPanelComplete', function() {
  new Ngn.Btn(Ngn.sd.fbtn('Create from template', 'template'), function() {
    new Ngn.sd.CreateFromTemplateDialog();
  });
});