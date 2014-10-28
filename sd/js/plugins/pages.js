Ngn.sd.blockTypes.push({
  title: 'Меню',
  data: {
    type: 'menu'
  }
});

Ngn.sd.PagesPanel = new Class({

  initialize: function() {
    new Ngn.Request.JSON({
      url: '/pages/json_getItems',
      onComplete: function(r) {
        this.loaded(r);
      }.bind(this)
    }).send();
  },

  loaded: function(r) {
    var data = [];
    for (var i = 0; i < r.name.length; i++) {
      data.push({ name: r.name[i] });
      Ngn.sd.pages[i + 1] = r.name[i];
    }
    var ePages = new Element('div', { id: 'pages', 'class': 'dropRightMenu'}).inject(Ngn.sd.ePanel, 'after');
    new Element('div', {
      'class': 'tit',
      id: 'pageTitle',
      html: '...'
    }).inject(ePages);
    new Element('div', {
      'class': 'tit',
      html: 'Разделы'
    }).inject(ePages);
    var fieldSet = new Ngn.sd.PagesSet(ePages, {
      fields: [
        { name: 'name' }
      ],
      data: data
    });
    new Ngn.Btn(Ngn.btn1('Сохранить', 'btn ok').inject(fieldSet.eContainer.getElement('.bottomBtns'), 'bottom'), function() {
      Ngn.loading(true);
      new Ngn.Request.JSON({
        url: '/pages/json_update',
        onComplete: function() {
          Ngn.loading(false);
        }
      }).post({data: Ngn.Frm.toObj(Ngn.sd.pagesSet.eContainer)});
    });
    var hidebleBar = new Ngn.HidebleBar.V(ePages);
    hidebleBar.eHandlerShow.set('title', 'Показать');
    // Ngn.addTips(hidebleBar.eHandlerShow);
    // new Tips(hidebleBar.eHandlerShow)
    // c(Ngn.tips);
    // Ngn.tips.attache(hidebleBar.eHandlerShow);
  }

});

new Ngn.sd.PagesPanel();