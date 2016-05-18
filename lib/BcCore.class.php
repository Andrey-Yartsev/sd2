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

  static function render($bannerId) {
    if ((new SdPageBlockItems($bannerId))->hasAnimation()) {
      return self::renderAnimated($bannerId);
    } else {
      return self::renderStatic($bannerId);
    }
  }

  static function renderStatic($bannerId) {
    Dir::make(UPLOAD_PATH.'/banner/static');
    system('/usr/local/bin/phantomjs '.SD_PATH.'/phantomjs/genStatic.js '.PROJECT_KEY.' '.SITE_DOMAIN.' '.$bannerId.' '.Config::getVar('sd/renderKey').' '.WEBROOT_PATH);
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
    return $path;
  }

  static function renderAnimated($bannerId, $framesCount = 2) {
    $sdPath = SD_PATH;
    $tempFolder = UPLOAD_PATH.'/banner/animated/temp/'.$bannerId;
    Dir::make($tempFolder);
    system('/usr/local/bin/phantomjs '.$sdPath.'/phantomjs/genAnimated.js '. //
      PROJECT_KEY.' '.SITE_DOMAIN.' '.$bannerId.' '.$framesCount.' '.Config::getVar('sd/renderKey').' '.WEBROOT_PATH);
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
      $framed[] = 50; // delay
      ob_end_clean();
    }
    $gif = new GifEncoder($frames, $framed, 0, 2, 0, 0, 0, 'bin');
    $path = 'banner/animated/result/'.$bannerId.'.gif';
    file_put_contents(UPLOAD_PATH.'/'.$path, $gif->getAnimation());
    return $path;
  }


}