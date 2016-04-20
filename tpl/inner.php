<div class="profileBar">
  <div class="profileBarBg"></div>
  <div class="profileBarBody">
    <div class="login">
      <div class="avatar"></div>
      <div class="name"><?= Auth::get('name') ?></div>
      <div class="email"><?= Misc::cut(Auth::get('email'), 10) ?></div>
    </div>
    <div class="dropdown">
      <a href="/profile" class="profile"><i></i><span>My Profile</span></a>
      <a href="/list" class="list"><i></i><span>My Banners</span></a>
      <a href="?logout=1" class="logout"><i></i><span>Logout</span></a>
    </div>
  </div>
</div>

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
