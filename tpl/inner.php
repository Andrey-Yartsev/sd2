<div id="panel"></div>
<div id="layers"></div>
<div id="layout" class="layout">
  <div id="layout1" class="layout sdEl">
  </div>
</div>
<div id="orderBar"></div>
<script>
  window.addEvent('domready', function() {
    Ngn.sd.init(<?= $d['bannerId'] ?>);
  });
</script>
