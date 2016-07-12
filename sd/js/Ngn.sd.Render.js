Ngn.sd.Render = function() {
  new Ngn.Dialog.HtmlPage({
    url: url = '/render/' + Ngn.sd.bannerId,
    title: 'Render',
    width: Ngn.sd.bannerSize.w.toInt() + 30
  });
};
