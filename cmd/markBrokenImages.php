<?php

$curl = new Curl;
$db = BcCore::zukulDb();
db()->query("DELETE FROM bcBannerButtonBroken");
foreach ($db->select("SELECT * FROM bannerButton") as $v) {
  if ($curl->getCode("http://zukul.com/public/uploads/bannerImage/{$v['filename']}") == 404) {
    db()->insert('bcBannerButtonBroken', ['id' => $v['id']]);
    print '.';
  }
}
