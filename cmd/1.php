<?php

$db = new Db('developer', 'K3fo83Gf2a', 's0.toasterbridge.com', 'zukul');
$size = CtrlSdCpanel::getSize(132);
$bannerSizeId = $db->selectCell("SELECT id FROM bannerSize WHERE width=? AND height=?", $size['w'], $size['h']);
$files = $db->selectCol("SELECT filename FROM bannerTemplate WHERE bannerSizeId=?d", $bannerSizeId);
foreach ($files as $file) {
  print "<img src='https://zukul.com/public/uploads/bannerTemplate/$file'>\n";
}
