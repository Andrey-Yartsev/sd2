<a href="#" id="create">Create banner</a>
<script>
  $('create').addEvent('click', function() {
    new Ngn.Dialog.RequestForm({
      url: '/newBanner',
      width: 200,
      onSubmitSuccess: function(r) {
        window.location = '/cpanel/' + r.id;
      }
    });
    return false;
  });
</script>
<ul>
<? foreach (db()->select('SELECT * FROM bcBanners WHERE userId=?d', Auth::get('id')) as $v) { ?>
  <li><a href="/cpanel/<?= $v['id'] ?>">Banner ID=<?= $v['id'] ?></a></li>
<? } ?>
</ul>
