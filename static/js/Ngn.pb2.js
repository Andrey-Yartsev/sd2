Ngn.pb2 = {};

Ngn.pb2.Font = new Class({

  updateFont: function() {
    if (this.data.font) for (var i in this.data.font) this.styleEl().setStyle(i.hyphenate(), this.data.font[i]);
  },

  initFont: function() {
    this.updateFont();
    new Ngn.Btn(Ngn.btn2('Настройки шрифта', 'settings').inject(this.eBtns), function() {
      new Ngn.Dialog.RequestForm({
        url: this.ctrl + '/json_fontSettings/' + this.data.id,
        onSubmitSuccess: function() {
          this.reload();
        }.bind(this)
      });
    }.bind(this));
  },
  styleEl: function() {
    return this.el;
  }

});


Ngn.pb2.BlockAbstract = new Class({
  Implements: [Options],
  initialize: function(el, data, event, options) {
    this.el = el;
    this.data = data;
    this.event = event;
    this.setOptions(options);
    this.ctrl = '/sdPageBlock';
    this.init();
  },
  updateElement: function(data) {
    Ngn.setMinHeight(this.container());
  },
  container: function() {
    var eContainer = this.el.getParent();
    if (!eContainer.hasClass('container')) throw new Error('!!!');
    return eContainer;
  },
  inject: function(eContainer) {
    this.el.setPosition(Ngn.positionDiff(this.el.getPosition(), eContainer.getPosition())).inject(eContainer);
    return this;
  },
  save: function(create) {
    var eContainer = this.container();
    var position = Ngn.positionDiff(this.el.getPosition(), eContainer.getPosition());
    this.data = $merge(this.data, {
      ownPageId: 1,
      containerId: eContainer.retrieve('data').id,
      position: position
    });
    this.loading(true);
    new Ngn.Request.JSON({
      url: this.ctrl + '/json_' + (create ? 'create' : 'update'),
      onComplete: function(data) {
        this.updateElement(data);
        this.loading(false);
      }.bind(this)
    }).post({ data: this.data });
  },
  initContent: function() {
    if (!this.data.html) return;
    var eCont = this.el.getElement('.cont');
    if (!eCont) eCont = new Element('div', {'class': 'cont'}).inject(this.el);
    eCont.set('html', this.data.html);
  },
  reload: function() {
    this.loading(true);
    new Ngn.Request.JSON({
      url: this.ctrl + '/json_getItem/' + this.data.id,
      onComplete: function(data) {
        this.data = data;
        this.updateElement(data);
        this.initContent();
        this.loading(false);
      }.bind(this)
    }).send();
  },
  loading: function(flag) {
    Ngn.loading(flag);
  }
});

Ngn.pb2.BlockPreview = new Class({
  Extends: Ngn.pb2.BlockAbstract,
  options: {
    action: 'create'
  },
  init: function() {
    new Ngn.pb2.BlockDragNew(this);
  },
  updateElement: function(data) {
    new Ngn.pb2.Block(Ngn.pb2.el().inject(this.container()), data);
    this.el.destroy();
  }
});

Ngn.pb2.Block = new Class({
  Extends: Ngn.pb2.BlockAbstract,
  Implements: [Ngn.pb2.Font],
  options: {
    action: 'update'
  },
  /*
  styleEl: function() {
    return this.el.getElement('.cont');
  },
  */
  init: function() {
    var eContainer = this.container();
    var cls = eContainer.retrieve('absolute') ? ' absolute' : '';
    this.el.addClass(cls).setPosition(this.data.position);
    this.initControls();
    this.initContent();
    if (this.data.size) this._resize(this.data.size);
    Ngn.setMinHeight(eContainer);
    this.eResize = '<div class="btnResize"></div>'.toDOM()[0].inject(this.el, 'top');
    var startPos = {};
    var startBlockSize = {};
    new Drag(new Element('div'), {
      handle: this.eResize,
      snap: 0,
      stopPropagation: true,
      onStart: function(el, e) {
        offset = this.el.getPosition();
        layoutOffset = $('layout').getPosition();
        var l = this.el.getStyle('left');
        startPos.x = this.el.getPosition().x + startBlockSize.x;
        startPos.y = this.el.getPosition().y + startBlockSize.y;
        startBlockSize = this.el.getSize();
      }.bind(this),
      onDrag: function(el, e) {
        this.resize({
          y: e.event.pageY - offset.y,
          x: e.event.pageX - offset.x
        });
      }.bind(this),
      onComplete: function() {
        this.save();
      }.bind(this)
    });
  },
  initControls: function() {
    this.eBtns = new Element('div', {'class': 'btnSet'}).inject(this.el, 'top');
    new Ngn.Btn(Ngn.btn2('Удалить', 'delete').inject(this.eBtns, 'top'), function() {
      if (!Ngn.confirm()) return;
      this.loading(true);
      new Ngn.Request.JSON({
        url: this.ctrl + '/json_delete/' + this.data.id,
        onComplete: function() {
          this.loading(false);
          this.el.dispose();
        }.bind(this)
      }).send();
    }.bind(this));
    new Ngn.Btn(Ngn.btn2('Редактировать', 'edit').inject(this.eBtns, 'top'), function() {
      new Ngn.Dialog.RequestForm($merge({
        url: this.ctrl + '/json_edit/' + this.data.id,
        title: false,
        width: 400,
        onSubmitSuccess: function() {
          this.reload();
        }.bind(this)
      }, this.getDialogOptions()))
    }.bind(this));
    new Ngn.Btn(Ngn.btn2('Клонировать', 'copy').inject(this.eBtns, 'top'), function() {
      var data = Object.clone(this.data);
      data.position.x += 50;
      data.position.y += 50;
      delete data.id;
      new Ngn.pb2.Block(this.el.clone().inject(this.container()), data).save(true);
    }.bind(this));
    this.initFont();
    this.eDrag = '<div class="dragBox"></div>'.toDOM()[0].inject(this.eBtns, 'bottom');
    new Ngn.pb2.BlockDrag(this);
  },
  _resize: function(size) {
    this.el.setStyles({
      width: size.x + 'px',
      height: size.y + 'px'
    });
  },
  resize: function(size) {
    this._resize(size);
    this.data = $merge(this.data, {size: size});
  },
  getDialogOptions: function() {
    if (Ngn.pb2.dialogOptions[this.data.type]) return Ngn.pb2.dialogOptions[this.data.type];
    return {};
  }
});

Ngn.pb2.Block.Font = new Class({
  Extends: Ngn.pb2.Block,
  init: function() {
    this.parent();
    Cufon.replace(this.styleEl());
  },
  initContent: function() {
    this.parent();
    this.updateFont();
    Cufon.refresh(this.styleEl());
  },
  _initControls: function() {
    this.parent();
    var eSlider = '<div class="slider"><div class="knob"></div></div>'.toDOM()[0].inject(this.eBtns);
    new Slider(eSlider, eSlider.getElement('.knob'), {
      dragOptions: {
        stopPropagation: true
      },
      range: [9, 250],
      initialStep: this.data.font && this.data.font.fontSize ? this.data.font.fontSize.toInt() : 14,
      onChange: function(size) {
        this.data.font.fontSize = size+'px';
        this.updateFont();
        Cufon.refresh(this.styleEl());
      }.bind(this),
      onComplete: function() {
        this.save();
      }.bind(this)
    });
  }
});

Ngn.pb2.block = function(el, data) {
  var cls = 'Ngn.pb2.Block.' + ucfirst(data.type);
  var o = eval(cls);
  cls = o || Ngn.pb2.Block;
  return new cls(el, data);
};

Ngn.pb2.dialogOptions = {};

Ngn.pb2.dialogOptions.text = {
  //resizeble: Ngn.Dialog.Resizeble.Wisiwig,
  width: 450
};

Ngn.pb2.BlockDragAbstract = new Class({
  initialize: function(block) {
    this.block = block;
    this.drag = new Drag.Move(this.block.el, this.getDragOptions());
    this.init();
  },
  init: function() {
  },
  create: false,
  getDragOptions: function() {
    return {
      droppables: '#layout .container',
      onDrop: function(eBlock, eContainer) {
        this.block.inject(eContainer).save(this.create);
      }.bind(this),
      onEnter: function(eBlock, eContainer) {
        eContainer.setStyle('border-color', '#000');
      },
      onLeave: function(eBlock, eContainer) {
        eContainer.setStyle('border-color', '#F00');
      }
    };
  }
});

Ngn.pb2.BlockDragNew = new Class({
  Extends: Ngn.pb2.BlockDragAbstract,
  create: true,
  init: function() {
    this.drag.start(this.block.event);
  }
});

Ngn.pb2.BlockDrag = new Class({
  Extends: Ngn.pb2.BlockDragAbstract,
  getDragOptions: function() {
    return $merge(this.parent(), {
      //handle: this.block.eDrag
    });
  }
});

Ngn.pb2.el = function() {
  return new Element('div', {'class': 'block dummy'});
};

// data: id
Ngn.pb2.ContainerAbstract = new Class({
  Implements: [Ngn.pb2.Font],
  ctrl: '/sdContainer',
  initialize: function(data) {
    this.data = data;
    this.el = this.getEl();
    this.el.store('data', data);
    if (this.data.bg) this.setBg(this.data.bg);
    if (!this.data.position) this.data.position = {x: 0, y: 0};
    this.setPosition(this.data.position);
    this.initControls();
    this.initFont();
  },
  initControls: function() {
    this.eBtns = new Element('div', {'class': 'btnSet'}).inject(this.el);
    new Ngn.Btn(Ngn.btn2('Задать фон', 'image').inject(this.eBtns), null, {
      fileUpload: {
        url: this.ctrl + '/json_uploadBg/' + this.data.id,
        onRequest: function() {
          this.loading(true);
        }.bind(this),
        onComplete: function(r) {
          this.loading(false);
          this.setBg(r.url);
        }.bind(this)
      }
    });
    if (this.data.bg) {
      var btnDelete = new Ngn.Btn(Ngn.btn2('Удалить фон', 'delete').inject(this.eBtns), function() {
        if (!Ngn.confirm()) return;
        this.loading(true);
        new Ngn.Request.JSON({
          url: this.ctrl + '/json_removeBg/' + this.data.id,
          onComplete: function() {
            this.loading(false);
            this.setBg('');
            btnDelete.el.dispose();
          }.bind(this)
        }).send();
      }.bind(this));
    }
    this.initDrag();
  },
  initDrag: function() {
    var eDrag = '<div class="dragBox"></div>'.toDOM()[0].inject(this.eBtns, 'top');
    var startCursorPos;
    var position;
    new Drag(eDrag, {
      snap: 0,
      onStart: function(el, e) {
        startCursorPos = [e.event.clientX, e.event.clientY];
      },
      onDrag: function(el, e) {
        position = {
          x: this.data.position.x + startCursorPos[0] - e.event.clientX,
          y: this.data.position.y + startCursorPos[1] - e.event.clientY
        };
        this.setPosition(position);
      }.bind(this),
      onComplete: function(el) {
        this.data.position = position;
        this.save();
      }.bind(this)
    });
  },
  setBg: function (url) {
    this.el.setStyle('background-image', 'url(' + url + '?' + Math.random(1000) + ')');
  },
  save: function(create) {
    var data = this.data;
    if (data.bg) delete data.bg;
    this.loading(true);
    new Ngn.Request.JSON({
      url: this.ctrl + '/json_' + (create ? 'create' : 'update'),
      onComplete: function() {
        this.loading(false);
      }.bind(this)
    }).post({ data: data });
  },
  setPosition: function(position) {
    this.el.setStyle('background-position', (-position.x) + 'px ' + (-position.y) + 'px');
  },
  loading: function(flag) {
    Ngn.loading(flag);
  }
});

Ngn.pb2.BlockContainer = new Class({
  Extends: Ngn.pb2.ContainerAbstract,
  getEl: function() {
    return ('<div class="container" id="container' + this.data.id + '"></div>').toDOM()[0].inject($('layout').getElement('.lCont'));
  }
});

Ngn.pb2.Layout = new Class({
  Extends: Ngn.pb2.ContainerAbstract,
  ctrl: '/sdLayout',
  getEl: function() {
    return $('layout');
  }
});

Ngn.pb2.LayoutContent = new Class({
  Extends: Ngn.pb2.ContainerAbstract,
  ctrl: '/sdLayoutContent',
  getEl: function() {
    return $('layout').getElement('.lCont');
  }
});

Ngn.pb2.blockContainers = {};
Ngn.pb2.initBlockContainers = function(items) {
  for (var i = 0; i < items.length; i++) {
    var v = items[i];
    Ngn.pb2.blockContainers[v.id] = new Ngn.pb2.BlockContainer(v);
  }
};