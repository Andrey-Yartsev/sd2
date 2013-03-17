<?php

class SdContainerItems extends ConfigItems {

  function __construct($name) {
    parent::__construct("sd/$name");
  }

  /*
  function getItems() {
    return array_map(function($v) {
      $path = "/{$this->name}/bg/{$v['id']}.jpg";
      if (file_exists(UPLOAD_PATH.$path)) $v['bg'] = '/'.UPLOAD_DIR.$path;
      return $v;
    }, parent::getItems());
  }
  */

}