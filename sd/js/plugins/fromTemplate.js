window.addEvent('sdPanelComplete', function() {
  Ngn.sd.CreateFromTemplateDialog = new Class({
    Extends: Ngn.sd.ImageInsertDialog,
    options: {
      id: 'template',
      title: 'Create from template<br><font color="red" size="2">Your progress will clear after creation</font>',
      okText: 'Create',
      url: '/cpanel/' + Ngn.sd.bannerId + '/ajax_templateSelect'
    },
    initialize: function(options) {
      var w = Ngn.sd.data.bannerSettings.size.w.toInt();
      if (w < 200) {
        w = w * 3;
      } else if (w < 400) {
        w = w * 2;
      }
      this.options.width = w + 56;
      this.options.height = 400;
      this.parent(options);
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