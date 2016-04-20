window.addEvent('sdPanelComplete', function() {
  new Ngn.Btn(Ngn.sd.fbtn('Add text', 'text'), function() {
    var data = Ngn.sd.getBlockType('font');
    data.data.position = {
      x: 0,
      y: 0
    };
    Ngn.sd.block(Ngn.sd.elBlock().inject(Ngn.sd.eLayoutContent), {
      data: data.data,
      html: ''
    }).setToTheTop().save(true);
  });
});