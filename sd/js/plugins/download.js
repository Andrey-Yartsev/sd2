window.addEvent('sdPanelComplete', function() {
  new Ngn.Btn(Ngn.sd.fbtn('Download', 'download'), function() {
    var dialog = new Ngn.Dialog.Loader({
      title: 'Rendering...',
      width: 200
    });
    new Ngn.Request({
      url: '/download/' + Ngn.sd.bannerId,
      onComplete: function(bannerUrl) {
        dialog.close();
        window.location = bannerUrl;
      }
    }).send();
  });
});