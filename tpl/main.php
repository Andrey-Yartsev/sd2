<? $this->tpl('head', $d) ?>
<body>
<div class="body">
  <div id="panel"></div>
  <div id="layout"><div class="lCont"></div></div>
</div>
<script>
Ngn.pb2.initBlockContainers(<?= Arr::js($d['layoutContainers'], true, [true, false]) ?>);
window.addEvent('domready', function() {
  iii();
});
</script>
</body>
</html>
