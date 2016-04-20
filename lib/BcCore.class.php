<?php

class BcCore {

  static function createBanner($size) {
    return db()->insert('bcBanners', [
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

}