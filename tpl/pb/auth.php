<style>
  <?= CssCore::btnColors($d['bgColor'], ".id_{$d['id']} .cont") ?>
  .id_<?= $d['id'] ?> .cont .btn span {
    color: <?= $d['color'] ?>;
  }
  .id_<?= $d['id'] ?> .cont .btn {
    height: auto;
  }
  .id_<?= $d['id'] ?> .cont .btn span {
    padding: 5px 20px 8px 20px;
  }
  .id_<?= $d['id'] ?> .cont .login {
  margin-left: 10px;
  }
</style>

<? if (Auth::get('id')) { ?>
  <a href="<?= $d['presonalUrl'] ?>" class="btn"><span><?= $d['presonalBtnText'] ?> <small>(<?= UsersCore::getTitle(Auth::get('id')) ?>)</small></span></a>
  <a href="?logout=1" class="login">Выйти</a>
<? } else { ?>
  <a href="" class="btn try"><span><?= $d['regBtnText'] ?></span></a>
  <a href="" class="login auth pseudoLink">Войти</a>
  <script>
  Ngn.addBtnsAction('a.try', function(eBtn) {
    new Ngn.Dialog.Auth({
      selectedTab: 1,
      completeUrl: '<?= $d['presonalUrl'] ?>'
    });
  });
  Ngn.addBtnsAction('a.auth', function(eBtn) {
    new Ngn.Dialog.Auth({
      selectedTab: 0,
      completeUrl: '<?= $d['presonalUrl'] ?>'
    });
  });
  </script>
<? } ?>