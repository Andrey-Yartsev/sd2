<a href="#" id="create">Create banner</a>
<script>
  var create = function() {
    new Ngn.Dialog.RequestForm({
      url: '/newBanner',
      width: 200,
      onSubmitSuccess: function(r) {
        window.location = '/cpanel/' + r.id;
      }
    });
    return false;
  };
  $('create').addEvent('click', create);
  <? if ($d['params'][1] == 'create') { ?>
  create();
  <? } ?>
</script>
<ul>
  <? foreach (db()->select('SELECT * FROM bcBanners WHERE userId=?d', Auth::get('id')) as $v) { ?>
    <li><a href="/cpanel/<?= $v['id'] ?>">Banner ID=<?= $v['id'] ?></a></li>
  <? } ?>
</ul>
