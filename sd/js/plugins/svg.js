Ngn.sd.blockTypes.push({
  title: 'Клипарт',
  data: {
    type: 'svg'
  },
  editDialogOptions: {
    width: 250
  }
});

Ngn.sd.BlockBSvg = new Class({
  Extends: Ngn.sd.BlockB,

  editDialogOptions: function() {
    return {
      onChangeSvg: function(value) {
        this.el.getElement('.cont').set('html', '<img src="/sd/svg/' + value + '.svg">');
      }.bind(this),
      onChangeColor: function(color) {
        this.setColor(color);
      }.bind(this),
      // штука ниже должна генериться сама
      formEvents: [
        {
          fieldName: 'color',
          fieldEvent: 'change',
          formEvent: 'changeColor'
        }
      ]
    }
  },

  resizeContentEl: function(size) {
    this._resizeEl(this.el.getElement('img'), size);
  },

  rotate: function(deg) {
    this._rotate(this.el.getElement('img'), deg);
  },

  _setColor: function(color, n) {
    if (!n) n = 0;
    this.colors[n] = color;
  },

  setColor: function(color, n) {
    this._setColor(color, n);
    this._data.content.color = color;
    this.fillPaths();
  },

  fillPaths: function() {
    if (!this.colors.length) return;
    this.el.getElements('path').each(function(el) {
      el.setStyle('fill', this.colors[0]);
    }.bind(this));
  },

  initColors: function() {
    this.colors = (this._data.content && this._data.content.color) ? [this._data.content.color] : [];
    if (this.colors.length) {
      for (var i; i < this.colors.length; i++) {
        this._setColor(this.colors.colors[i], i);
      }
    }
    this.fillPaths();
  },

  init: function() {
    this.parent();
    this.initColors();
    new Ngn.sd.BlockRotate(this);
  },

  updateElement: function() {
    this.initColors();
  },

  initFont: function() {
  }

});

Ngn.Form.El.SvgSelect = new Class({
  Extends: Ngn.Form.El.DialogSelect.Sd,
  baseName: 'svg',
  getDialogClass: function() {
    return Ngn.sd.SvgSelectDialog;
  },
  setValue: function(value) {
    this.parent(value);
    if (!value) return;
    this.eSelectDialog.set('html', Ngn.sd.itemTpl('svgSelect', value));
  }
});

Ngn.sd.SvgSelectDialog = new Class({
  Extends: Ngn.sd.SelectDialog,
  name: 'svg',
  options: {
    message: /* Ngn.tpls.svgUploadForm + */Ngn.tpls.svgSelect,
    title: 'Выбор векторной картинки'
  },
  init: function() {
    this.parent();
    //new Ngn.Form(this.message.getElement('form'), {
    //  ajaxSubmit: true
    //});
  }
});
