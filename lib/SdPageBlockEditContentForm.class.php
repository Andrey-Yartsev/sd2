<?php

class SdPageBlockEditContentForm extends SdPageBlockEditFormAbstract {

  function _update(array $d) {
    $this->items->updateContent($this->id, $d);
  }

  function _getDefaultData() {
    return isset($this->item['content']) ? $this->item['content'] : [];
  }

}