<?php

class SdPbItems extends SdContainerItems {

  function __construct() {
    parent::__construct('pageBlocks');
  }

  function getItems() {
    return array_map(function($v) {
      if (empty($v['content'])) $v['content'] = [];
      $v['content']['id'] = $v['id'];
      $v['html'] = Tt()->getTpl("pb/{$v['type']}", $v['content']);
      return $v;
    }, parent::getItems());
  }

}