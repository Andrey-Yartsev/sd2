<?php

$zukulBaseUrl = 'http://zukul.com/public/uploads';
$db = BcCore::zukulDb();

Dir::make(UPLOAD_PATH.'/bcImagesCache/bannerTemplate');
$r = $db->query("SELECT * FROM bannerTemplate");
$curl = new Curl();

$makeThisShit = function ($r) use ($zukulBaseUrl, $curl, $keyword) {
  foreach ($r as $v) {
    output($zukulBaseUrl."/$keyword/".$v['filename']);
    $curl->copy($zukulBaseUrl."/$keyword/".$v['filename'], UPLOAD_PATH.'/bcImagesCache/$keyword/'.$v['filename']);
  }
};

Dir::make(UPLOAD_PATH.'/bcImagesCache/bannerImage');
$makeThisShit(BcCore::zukulDb()->select("SELECT * FROM bannerTemplate"));
$makeThisShit(BcCore::zukulDb()->select("SELECT * FROM bannerButton"));
$ids = implode(', ', db()->ids('bcBannerButtonBroken'));
$makeThisShit(BcCore::zukulDb()->select("SELECT * FROM bannerImage WHERE id NOT IN ($ids)"));
