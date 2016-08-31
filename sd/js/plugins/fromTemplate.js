window.addEvent('sdPanelComplete', function() {
  Ngn.sd.CreateFromTemplateDialog = new Class({
    Extends: Ngn.sd.ImageInsertDialog,
    options: {
      id: 'template',
      title: 'Create from template<br><font color="red" size="2">Your progress will clear after creation</font>',
      okText: 'Create',
      width: 400,
      height: 300,
      url: '/cpanel/' + Ngn.sd.bannerId + '/ajax_templateSelect'
    },
    insertImage: function(url) {
      new Ngn.Request.JSON({
        url: '/createFromTemplate/' + url.replace(/.*\/(\d+)\..*/, '$1')+'/'+ Ngn.sd.bannerId,
        onComplete: function(bannerId) {
          window.location = '/cpanel/' + bannerId;
        }
      }).send();
    }
  });
  new Ngn.Btn(Ngn.sd.fbtn('Use Template', 'template'), function() {
    new Ngn.sd.CreateFromTemplateDialog();
  });
});