<?
if (!($pages = Config::getVar('sd/pages', true))) return;
$d['menu'] = $pages['name'];
?>
<style>
.menu<?= $d['id']?> a {
  width: <?= $d['itemWidth'] ?>;
  height: <?= $d['itemHeight'] ?>;
  white-space: nowrap;
  display: inline-block;
}
</style>
<div class="menu menu<?= $d['id']?>">
<? foreach ($d['menu'] as $i => $v) { $curPageId = $i+1; ?>
  <? if ($curPageId != $d['ownPageId']) { ?>
    <a href="/page<?= $i+1 ?>.html"><?= $v ?></a>
  <? } else { ?>
    <a href="/page<?= $i+1 ?>.html"><b><?= $v ?></b></a>
  <? } ?>
<? } ?>
</div>