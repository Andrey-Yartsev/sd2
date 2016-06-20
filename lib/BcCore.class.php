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

  static function render($bannerId) {
    if ((new SdPageBlockItems($bannerId))->hasAnimation()) {
      return self::renderAnimated($bannerId);
    } else {
      return self::renderStatic($bannerId);
    }
  }

  static function renderStatic($bannerId) {
    $cufonBlocksNumber = (new SdPageBlockItems($bannerId))->cufonBlocksNumber();
    Dir::make(UPLOAD_PATH.'/banner/static');
    system('/usr/local/bin/phantomjs '.SD_PATH.'/phantomjs/genStatic.js '.PROJECT_KEY.' '.SITE_DOMAIN.' '.$bannerId.' '.Config::getVar('sd/renderKey').' '.WEBROOT_PATH.' '.$cufonBlocksNumber);
    $path = 'banner/static/'.$bannerId.'.png';
    $file = UPLOAD_PATH.'/'.$path;
    $src = imagecreatefrompng($file);
    $size = BcCore::getSize($bannerId);
    $src = imagecrop($src, [
      'width'  => $size['w'],
      'height' => $size['h'],
      'x'      => 1300 / 2 - $size['w'] / 2,
      'y'      => 100
    ]);
    imagepng($src, $file, 4);
    db()->update('bcBanners', $bannerId, ['dateRender' => Date::db()]);
    return $path;
  }

  static function renderAnimated($bannerId) {
    $framesCount = (new SdPageBlockItems($bannerId))->maxFramesNumber();
    $sdPath = SD_PATH;
    $tempFolder = UPLOAD_PATH.'/banner/animated/temp/'.$bannerId;
    Dir::make($tempFolder);
    Dir::clear($tempFolder);
    $cmd = '/usr/local/bin/phantomjs '.$sdPath.'/phantomjs/genAnimated.js '. //
      PROJECT_KEY.' '.SITE_DOMAIN.' '.$bannerId.' '.$framesCount.' '.Config::getVar('sd/renderKey').' '.WEBROOT_PATH;
    sys($cmd);
    $size = BcCore::getSize($bannerId);
    $x = 1300 / 2 - $size['w'] / 2;
    foreach (glob($tempFolder.'/*') as $file) {
      $src = imagecreatefrompng($file);
      $src = imagecrop($src, [
        'width'  => $size['w'],
        'height' => $size['h'],
        'x'      => $x,
        'y'      => 100
      ]);
      imagepng($src, $file, 4);
    }
    // for debug
    // $this->ajaxOutput = '<img src="/'.UPLOAD_DIR.'/'.'/banner/animated/temp/'.$this->bannerId.'/1.png?'.Misc::randString().'">';
    // return
    Dir::make(UPLOAD_PATH.'/banner/animated/result');
    $frames = [];
    $framed = [];
    foreach (glob($tempFolder.'/*') as $file) {
      $image = imagecreatefrompng($file);
      ob_start();
      imagegif($image);
      $frames[] = ob_get_contents();
      $framed[] = 150; // delay
      ob_end_clean();
    }
    $gif = new GifEncoder($frames, $framed, 0, 2, 0, 0, 0, 'bin');
    $path = 'banner/animated/result/'.$bannerId.'.gif';
    output('Generating gif "'.UPLOAD_PATH.'/'.$path.'"');
    file_put_contents(UPLOAD_PATH.'/'.$path, $gif->getAnimation());
    db()->update('bcBanners', $bannerId, ['dateRender' => Date::db()]);
    return $path;
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