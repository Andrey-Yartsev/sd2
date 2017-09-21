<?php

class SdPageBlockItemAnimatedText extends SdPageBlockItem {

  function __construct(array $item, $bannerId) {
    parent::__construct($item, $bannerId);

    if (!empty($this->r['data']['font'])) {
      if (!empty($this->r['data']['font']['text'])) {
        $this->r['data']['font']['text'] = array_values($this->r['data']['font']['text']);
      }
    }
  }

  function framesNumber() {
    if (empty($this->r['data']['font']) or empty($this->r['data']['font']['text'])) return 1;
    return count($this->r['data']['font']['text']);
  }

}