<?php

class SdPageBlockEditPropForm extends SdPageBlockEditFormAbstract {

  function _update(array $prop) {
    $this->items->update($this->id, ['prop' => $prop]);
  }

  function _getDefaultData() {
    return isset($this->item['data']['prop']) ? $this->item['data']['prop'] : [];
  }


}