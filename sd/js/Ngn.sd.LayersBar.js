Ngn.sd.LayersBar = new Class({
  initialize: function() {
    this.init();
  },
  init: function() {
    Ngn.sd.eLayers.set('html', '');
    new Element('div', {
      html: 'Layers',
      'class': 'lTitle'
    }).inject(Ngn.sd.eLayers);
    var eLayers = new Element('div', {
      'class': 'layers'
    }).inject(Ngn.sd.eLayers);
    Ngn.sd.sortBySubKey(Ngn.sd.blocks, '_data', 'orderKey').each(function(item) {
      this.getTitle(item);
      var eItem = new Element('div', {
        'class': 'item ' + 'item_' + (item.data.subType || item.data.type),
        'data-id': item._data.id,
        'data-type': item.data.type,
        events: {
          click: function() {
            if (!Ngn.sd.blocks[item._data.id].canEdit()) return;
            Ngn.sd.blocks[item._data.id]._settingsAction(Ngn.sd.blocks[item._data.id]);
          }.bind(this)
        }
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
          Ngn.sd.blocks[item._data.id]._settingsAction.bind(Ngn.sd.blocks[item._data.id]) //
        );
      } else {
        new Element('a', {
          'class': 'smIcons dummy'
        }).inject(eBtns);
      }
      new Ngn.Btn( //
        Ngn.Btn.btn2('Delete', 'delete').inject(eBtns), //
        Ngn.sd.blocks[item._data.id].deleteAction.bind(Ngn.sd.blocks[item._data.id]) //
      );
      eItem.inject(eLayers);
    }.bind(this));
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
      return '<span class="ico 1">' + item._data.html + '</span>' + Ngn.String.ucfirst(item.data.type);
    } else if (item.data.type == 'text') {
      return '<span class="ico 2">' + '<img src="/sd/img/font.png"></span>' + //
      '<span class="text">' + (item._data.html ? item._data.html : 'empty') + '</span>'
    } else {
      return '<span class="ico"></span>unsupported';
    }
  },
  canEdit: function(item) {
    return Ngn.sd.blocks[item._data.id].finalData().data.type == 'text';
  }
});
