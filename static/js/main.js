/*
 Ngn.createSystemEvent = function(eventName) {
 var options = $merge(Ngn.createSystemEvent.defaultOptions, arguments[2] || {});
 var event, eventType = null;
 for (var name in eventMatchers) {
 if (eventMatchers[name].test(eventName)) {
 eventType = name;
 break;
 }
 }
 if (!eventType) throw new SyntaxError('Only HTMLEvents and MouseEvents interfaces are supported');
 if (document.createEvent) {
 event = document.createEvent(eventType);
 if (eventType == 'HTMLEvents') {
 event.initEvent(eventName, options.bubbles, options.cancelable);
 } else {
 event.initMouseEvent(eventName, options.bubbles, options.cancelable, document.defaultView, options.button, options.pointerX, options.pointerY, options.pointerX, options.pointerY, options.ctrlKey, options.altKey, options.shiftKey, options.metaKey, options.button);
 }
 } else {
 options.clientX = options.pointerX;
 options.clientY = options.pointerY;
 var evt = document.createEventObject();
 event = extend(evt, options);
 }
 return event;
 };
 var eventMatchers = {
 'HTMLEvents': /^(?:load|unload|abort|error|select|change|submit|reset|focus|blur|resize|scroll)$/,
 'MouseEvents': /^(?:click|dblclick|mouse(?:down|up|over|move|out))$/
 };
 Ngn.createSystemEvent.defaultOptions = {
 pointerX: 0,
 pointerY: 0,
 button: 0,
 ctrlKey: false,
 altKey: false,
 shiftKey: false,
 metaKey: false,
 bubbles: true,
 cancelable: true
 };
 */
var iii = function() {
  var blockTypes = [
    {type: 'text'},
    {type: 'menu'},
    {type: 'image'}
  ];
  blockTypes.each(function(data) {
    var btn = new Element('div', {
      'class': 'btnBlock type_' + data.type
    }).inject($('panel'));
    btn.store('data', data);
    btn.addEvent('mousedown', function(event) {
      //event.stop();
      //new Drag.Move(Ngn.pb2.el().inject(document.body).setPosition(btn.getPosition()));
      //new Ngn.pb2.BlockPreview(Ngn.pb2.el().inject(document.body).setPosition(btn.getPosition()), data, event);
    });
  });

  new Ngn.Btn(Ngn.btn1('Вставить картинку', 'image').inject($('panel')), null, {
    fileUpload: {
      url: '/sdPageBlock/json_createImage',
      onRequest: function() {
        //this.loading(true);
      }.bind(this),
      onComplete: function(v) {
        Ngn.pb2.block(Ngn.pb2.el().inject(Ngn.pb2.blockContainers[v.containerId].el), v);
        //this.loading(false);
      }.bind(this)
    }
  });
  new Ngn.Btn(Ngn.btn1('Предпросмотр', 'btn image').inject($('panel')), function() {
    this.pushed ? $('layout').removeClass('preview') : $('layout').addClass('preview');

  }, {
    usePushed: true
  });

  new Ngn.Request.JSON({
    url: '/sdPageBlock/json_getItems',
    onComplete: function(items) {
      for (var i = 0; i < items.length; i++) {
        var v = items[i];
        Ngn.pb2.block(Ngn.pb2.el().inject(Ngn.pb2.blockContainers[v.containerId].el), v);
      }
    }
  }).send();

  new Ngn.Request.JSON({
    url: '/sdLayout/json_getItems',
    onComplete: function(items) {
      new Ngn.pb2.Layout(items[0]);
    }
  }).send();

  new Ngn.Request.JSON({
    url: '/sdLayoutContent/json_getItems',
    onComplete: function(items) {
      new Ngn.pb2.LayoutContent(items[0]);
    }
  }).send();

};