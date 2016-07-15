<?php

class BcCore {

  static function createBanner($size, $title) {
    return db()->insert('bcBanners', [
      'title' => $title,
      'size' => $size,
      'userId' => BcCore::user()['id']
    ]);
  }

  static function user() {
    $id = Misc::checkEmpty(Auth::get('id'));
    return [
      'id' => $id
    ];
  }

  static function zukulDb() {
    return new Db('developer', 'aK211foDyBXwf2', 's0.toasterbridge.com', 'zukul');
  }

  static protected $size;

  static function getSize($bannerId) {
    if (isset(self::$size)) return self::$size;
    list($r['w'], $r['h']) = explode(' x ', db()->selectCell("SELECT size FROM bcBanners WHERE id=?d", $bannerId));
    return self::$size = $r;
  }

  protected static $hasAnimation;

  static function hasAnimation($bannerId) {
    if (isset(self::$hasAnimation)) return self::$hasAnimation;
    return self::$hasAnimation = (new SdPageBlockItems($bannerId))->hasAnimation();
  }

  static function getPath($bannerId) {
    return '/banner/'. //
      (self::hasAnimation($bannerId) ? //
        'animated/result/'.$bannerId.'.gif' : 'static/'.$bannerId.'.png');
  }

  static function copyBanner($bannerId, $userId = null) {
    // copy banner record
    $banner = db()->selectRow("SELECT * FROM bcBanners WHERE id=?d", $bannerId);
    $banner['dateUpdate'] = Date::db();
    unset($banner['id']);
    if ($userId) $banner['userId'] = $userId;
    $newBannerId = db()->insert('bcBanners', $banner);
    // copy block records
    foreach (db()->query("SELECT * FROM bcBlocks WHERE bannerId=?d", $bannerId) as $v) {
      $v['dateCreate'] = $v['dateUpdate'] = Date::db();
      $v['bannerId'] = $newBannerId;
      if ($userId) $v['userId'] = $userId;
      unset($v['id']);
      db()->insert('bcBlocks', $v);
    }
    // copy files
    $path = BcCore::getPath($bannerId);
    $newPath = preg_replace('/\/\d+\./', '/'.$newBannerId.'.', BcCore::getPath(11));
    copy(UPLOAD_PATH.$path, UPLOAD_PATH.$newPath);
    return $newBannerId;
  }

}