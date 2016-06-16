window.addEvent('sdPanelComplete', function() {
  Ngn.sd.CreateFromTemplateDialog = new Class({
    Extends: Ngn.sd.ImageInsertDialog,
    options: {
      id: 'template',
      title: 'Create from template',
      okText: 'Create',
      width: 400,
      height: 300,
      url: '/cpanel/' + Ngn.sd.bannerId + '/ajax_templateSelect'
    },
    insertImage: function(url) {
      new Ngn.Request.JSON({
        url: '/createFromTemplate/' + url.replace(/.*\/(\d+)\..*/, '$1'),
        onComplete: function(bannerId) {
          window.location = '/cpanel/' + bannerId;
        }
      }).send();
    }
  });
  new Ngn.Btn(Ngn.sd.fbtn('Create from template', 'template'), function() {
    new Ngn.sd.CreateFromTemplateDialog();
  });
});