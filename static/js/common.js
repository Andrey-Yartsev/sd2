Ngn.positionDiff = function (pos1, pos2) {
  return {
    x: pos1.x - pos2.x,
    y: pos1.y - pos2.y
  }
};

Ngn.setMinHeight = function(parent) {
  var max = 0;
  parent.getChildren().each(function(el) {
    var y = el.getSize().y + parseInt(el.getStyle('top'));
    if (y > max) max = y;
  });
  if (max) parent.setStyle('min-height', max);
};
