<?php

class SdCore {

  const defaultOwnPageId = 1;

  static function getLayout($ownPageId) {
    return $ownPageId == SdCore::defaultOwnPageId ? 'home' : 'inner';
  }

  static function getProject() {
    return (new SdProjectItems)->getItemByField('name', PROJECT_KEY);
  }

  static function cacheZukulImage($url) {
    $path = str_replace('http://zukul.com/public/uploads', '', $url);
    $file = UPLOAD_PATH.$path;
    if (!file_exists($file)) {
      Dir::make(dirname($file));
      copy($url, $file);
    }
    return '/'.UPLOAD_DIR.$path;
  }

}