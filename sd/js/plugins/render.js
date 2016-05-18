Ngn.sd.render = function() {
  new Ngn.Dialog.HtmlPage({
    url: url = '/render/' + Ngn.sd.bannerId,
    title: 'Render',
    width: Ngn.sd.bannerSize.w.toInt() + 30
  });
};

window.addEvent('sdPanelComplete', function() {
  new Ngn.Btn(Ngn.sd.fbtn('Render', 'render'), function() {
    Ngn.sd.render();
  });
});
