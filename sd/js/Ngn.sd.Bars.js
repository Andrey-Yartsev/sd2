Ngn.sd.Bars = new Class({
  layersBar: null,
  initialize: function() {
    var pg = window.location.hash.match(/#pg(\d+)/);
    Ngn.sd.ePanel = new Element('div', {'class': 'cont'}).inject($('panel'));
    this.logoElement().inject(Ngn.sd.ePanel);
    Ngn.sd.eFeatureBtns = new Element('div', {
      'class': 'featureBtns'
    }).inject(Ngn.sd.ePanel);
    //new Element('div', {'class': 'clear'}).inject(Ngn.sd.ePanel);
    new Element('div', {
      'class': 'tit'
    }).inject(Ngn.sd.ePanel);
    Ngn.sd.eLayers = new Element('div', {'class': 'cont'}).inject($('layers'));
    Ngn.sd.loadData(pg ? pg[1] : 1, function(data) {
      this.layersBar = this.getLayersBar();
      window.fireEvent('sdDataLoaded');
    }.bind(this));
    window.fireEvent('sdPanelComplete');
  },
  dispose: function() {
    Ngn.sd.eLayers.dispose();
  },
  logoElement: function() {
    return new Element('a', {
      'class': 'logo',
      href: '/', //target: '_blank',
      title: 'Home'
    });
  },
  getLayersBar: function() {
    return new Ngn.sd.LayersBar();
  }
});
