Ngn.sd.render = function() {
  var url;
  if (Ngn.sd.animation.exists()) {
    url = '/render/' + Ngn.sd.bannerId + '/ajax_animated/' + Ngn.sd.animation.framesCount();
  } else {
    url = '/render/' + Ngn.sd.bannerId;
  }
  new Ngn.Dialog.HtmlPage({
    url: url,
    title: 'Render',
    width: Ngn.sd.bannerSize.w.toInt() + 30
  });
};

window.addEvent('sdPanelComplete', function() {
  new Ngn.Btn(Ngn.sd.fbtn('Render', 'render'), function() {
    Ngn.sd.render();
  });
});
