Ngn.sd.LayersBar = new Class({
  initialize: function() {
    this.init();
  },
  init: function() {
    Ngn.sd.eLayers.set('html', '');
    var title;
    var item;
    var sortedBlocks = Ngn.sd.sortBySubKey(Ngn.sd.blocks, '_data', 'orderKey');
    new Element('div', {
      html: 'Layers',
      'class': 'lTitle'
    }).inject(Ngn.sd.eLayers);
    var eLayers = new Element('div', {
      'class': 'layers'
    }).inject(Ngn.sd.eLayers);
    for (var i = 0; i < sortedBlocks.length; i++) {
      item = sortedBlocks[i]._data;
      this.getTitle(item);
      var eItem = new Element('div', {
        'class': 'item ' + 'item_' + (item.data.subType || item.data.type),
        'data-id': item.id,
        'data-type': item.data.type
      });
      new Element('div', {
        'class': 'title',
        html: this.getTitle(item)
      }).inject(eItem);
      var eBtns = new Element('div', {
        'class': 'btns'
      }).inject(eItem);
      if (this.canEdit(item)) {
        new Ngn.Btn( //
          Ngn.Btn.btn2('Edit', 'edit').inject(eBtns), //
          Ngn.sd.blocks[item.id]._settingsAction.bind(Ngn.sd.blocks[item.id]) //
        );
      } else {
        new Element('a', {
          'class': 'smIcons dummy'
        }).inject(eBtns);
      }
      new Ngn.Btn( //
        Ngn.Btn.btn2('Delete', 'delete').inject(eBtns), //
        Ngn.sd.blocks[item.id].deleteAction.bind(Ngn.sd.blocks[item.id]) //
      );
      eItem.inject(eLayers);
    }
    new Sortables(eLayers, {
      onStart: function(eMovingLayer) {
        eMovingLayer.addClass('drag');
      },
      onComplete: function(eMovingLayer) {
        eMovingLayer.removeClass('drag');
        var ePrevLayer;
        var id = eMovingLayer.get('data-id');
        ePrevLayer = eMovingLayer.getPrevious();
        if (ePrevLayer) {
          Ngn.sd.blocks[id].el.inject( //
            Ngn.sd.blocks[ePrevLayer.get('data-id')].el, 'before');
        } else {
          ePrevLayer = eMovingLayer.getNext();
          if (ePrevLayer) {
            Ngn.sd.blocks[id].el.inject( //
              Ngn.sd.blocks[ePrevLayer.get('data-id')].el, 'after');
          }
        }
        // request
        var ids = this.serialize(0, function(element) {
          return element.get('data-id');
        });
        for (var i = 0; i < ids.length; i++) {
          Ngn.sd.blocks[ids[i]].updateOrder(i);
        }
        new Ngn.Request({
          url: '/pageBlock/' + Ngn.sd.bannerId + '/json_updateOrder'
        }).post({
            ids: ids
          });
      }
    });
  },
  getTitle: function(item) {
    if (item.data.subType == 'image') {
      return '<span class="ico">' + item.html + '</span>' + Ngn.String.ucfirst(item.data.type);
    } else if (item.data.type == 'font') {
      return '<span class="ico">' + '<img src="/sd/img/font.png"></span>' + //
      '<span class="text">' + (item.html ? item.html : 'empty') + '</span>'
    } else {
      return '<span class="ico"></span>unsupported';
    }
  },
  canEdit: function(item) {
    return Ngn.sd.blocks[item.id].finalData().data.type == 'font';
  }
});
