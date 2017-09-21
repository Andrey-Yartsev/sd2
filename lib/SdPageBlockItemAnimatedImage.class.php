<?php

class SdPageBlockItemAnimatedImage extends SdPageBlockItem {

  function __construct(array $item, $bannerId) {
    parent::__construct($item, $bannerId);
    $this->r['data']['subType'] = 'image';
  }

  function framesNumber() {
    if (empty($this->r['data']['images'])) return 1;
    return count($this->r['data']['images']);
  }

  function _update($id, array $data) {
    $item = $this->getItem($id);
    //die2($item);
    $item['data'] = array_merge($item['data'], $data);
    $item['data']['images'] = array_merge($item['data']['images'], $data['images']);
    parent::update($id, $item->r);
  }

}