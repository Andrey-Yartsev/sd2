<div class="selectItems">
  <? foreach ($d['items'] as $v) { ?>
  <div class="item" data-name="<?= $v['name'] ?>">
    <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="30px" height="30px" viewBox="0 0 200 200"
    xmlns:xlink="http://www.w3.org/1999/xlink">
    <?= $v->html() ?>
    <div class="tit"><?= $v['name'] ?></div>
  </svg>
  </div>
  <? } ?>
</div>
