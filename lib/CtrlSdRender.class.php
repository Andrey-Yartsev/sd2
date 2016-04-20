<?php

class CtrlSdRender extends CtrlCommon {

  protected $bannerId;

  protected function init() {
    $this->bannerId = $this->req->param(1);
  }

  protected function getParamActionN() {
    return 2;
  }

  static function renderStitic($bannerId) {
    Dir::make(UPLOAD_PATH.'/banner/static');
    system('phantomjs '.SD_PATH.'/phantomjs/genStatic.js '.PROJECT_KEY.' '.SITE_DOMAIN.' '.$bannerId.' '.Config::getVar('sd/renderKey'));
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

  function action_ajax_default() {
    $url = '/'.UPLOAD_DIR.'/'.CtrlSdRender::renderStitic($this->bannerId);
    $this->ajaxOutput = '<img src="'.$url.'?'.Misc::randString().'">';
  }

  function action_ajax_animated() {
    $sdPath = SD_PATH;
    $framesCount = $this->req->param(3);
    $tempFolder = UPLOAD_PATH.'/banner/animated/temp/'.$this->bannerId;
    Dir::make($tempFolder);
//    die2('phantomjs '.$sdPath.'/phantomjs/genAnimated.js '. //
//      PROJECT_KEY.' '.SITE_DOMAIN.' '.$this->bannerId.' '.$framesCount.' '.Config::getVar('sd/renderKey'));
    system('phantomjs '.$sdPath.'/phantomjs/genAnimated.js '. //
      PROJECT_KEY.' '.SITE_DOMAIN.' '.$this->bannerId.' '.$framesCount.' '.Config::getVar('sd/renderKey'));
    $size = BcCore::getSize($this->bannerId);
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
    $path = 'banner/animated/result/'.$this->bannerId.'.gif';
    file_put_contents(UPLOAD_PATH.'/'.$path, $gif->getAnimation());
    $this->ajaxOutput = '<img src="/'.UPLOAD_DIR.'/'.$path.'?'.Misc::randString().'">';
  }

}
