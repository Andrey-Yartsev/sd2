<style>
  .carousel {
    overflow: hidden;
    width: 300px;
    height: 200px;
  }
  .carousel .inner {
    width: 900px;
  }
  .carousel .inner img {
    display: inline-block;
    margin: 0px;
  }
</style>
<input type="button" id="prev">
<input type="button" id="next">
<div class="carousel">
  <div class="inner">
    <? for ($i=0; $i<$d['data']['n']; $i++) { ?>
      <img src="/u/sd/pageBlocks/images/<?= $d['id'].'/'.$i.'.jpg' ?>" style="width:300px;height:200px;"/>
    <? } ?>
  </div>
</div>
