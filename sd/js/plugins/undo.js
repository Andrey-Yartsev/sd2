function undo(){
  new Ngn.Request.JSON({
    url: '/pageBlock/' + Ngn.sd.bannerId + '/json_undo',
    onComplete: function(data) {
        //Ngn.sd.interface.bars.layersBar.init();
        var act=data.act;
        delete data.act;
        if (act) {
            var obj = Ngn.sd.blocks[data.id];
            if (act == "delete") {
                //obj.undo(data,true);
                Ngn.sd.init(Ngn.sd.bannerId);
            }
            else if (act == "update") {
                obj.undo(data);
                //Ngn.sd.init(Ngn.sd.bannerId);
            } else {
                obj.delete();
                delete obj;
            }
        }
    }.bind(this)
  }).post();
}