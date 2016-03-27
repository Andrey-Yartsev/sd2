<?php

class BcCore {

  static function createBanner($size) {
    // id calculating
    $max = 0;
    foreach (glob(PROJECT_PATH.'/config/vars/bannerSettings/*') as $file) {
      $id = Misc::removeSuffix('.php', basename($file));
      if ($id > $max) $max = $id;
    }
    $id = $max + 1;
    ProjectConfig::updateVar('bannerSettings/'.$id, [
      'size' => $size
    ], true);
    //
    return $id;
  }

}