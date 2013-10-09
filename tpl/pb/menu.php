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
  <? if ($curPageId != $d['ownPageId']) { $pageName = $i ? 'page'.($i+1) : 'index' ?>
    <a href="/<?= $pageName ?>.html?<?= time() ?>"><?= $v ?></a>
  <? } else { ?>
    <a href="/<?= $pageName ?>.html?<?= time() ?>" class="sel"><?= $v ?></a>
  <? } ?>
<? } ?>
</div>