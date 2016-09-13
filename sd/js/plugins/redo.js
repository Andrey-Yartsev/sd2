function redo(){
  new Ngn.Request.JSON({
    url: '/pageBlock/' + Ngn.sd.bannerId + '/json_redo',
    onComplete: function(data) {
        //Ngn.sd.interface.bars.layersBar.init();
        var act=data.act;
        delete data.act;
        if (act) {
            var obj = Ngn.sd.blocks[data.id];
            if (act == "delete") {
                obj.delete();
                delete obj;
            }
            else if (act == "update") {
                obj.undo(data, false);
                //Ngn.sd.init(Ngn.sd.bannerId);
            } else {
                //obj.undo(data,true);
                Ngn.sd.init(Ngn.sd.bannerId);
            }
        }
    }.bind(this)
  }).post();
}