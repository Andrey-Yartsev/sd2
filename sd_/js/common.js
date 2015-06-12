Ngn.positionDiff = function(pos1, pos2, offset) {
  if (!offset) offset = 0;
  return {
    x: pos1.x - pos2.x + offset,
    y: pos1.y - pos2.y + offset
  }
};

if (!Ngn.sd) Ngn.sd = {};

Ngn.sd.loadedFonts = {};
Ngn.sd.loadFont = function(font, onLoad) {
  if (!font) return;
  if (Ngn.sd.loadedFonts[font]) {
    onLoad();
    return;
  }
  Asset.javascript((Ngn.sd.baseUrl || '') + '/sd/js/fonts/' + font + '.js', { onLoad: function() {
    Ngn.sd.loadedFonts[font] = true;
    onLoad();
  }});
};

Ngn.sd.initFullBodyHeight = function() {
  return;
  var isFullHeight = null;
  var fullBodyHeight = function() {
    if (window.getScrollSize().y > window.getSize().y) {
      if (isFullHeight === true || isFullHeight === null) document.getElement('body').setStyle('height', '');
    } else {
      if (isFullHeight === false || isFullHeight === null) document.getElement('body').setStyle('height', '100%');
    }
  };
  window.addEvent('domready', fullBodyHeight);
  window.addEvent('resize', fullBodyHeight);
};