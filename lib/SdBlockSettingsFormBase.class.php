<?php

abstract class SdBlockSettingsFormBase extends Form {

  protected $items, $id, $block;

  function __construct($id, SdContainerItems $items) {
    $this->items = $items;
    $this->id = $id;
    $this->block = $this->items->getItem($this->id);
    if (!empty($this->block['data']['font'])) {
      $this->defaultData = $this->block['data']['font'];
    }
    $this->options['title'] = "Layer Settings";
    $this->options['filterEmpties'] = true;
    parent::__construct($this->getInitFields());
  }

  abstract protected function getInitFields();

  protected function _update(array $data) {
    $this->items->update($this->id, ['font' => $data]);
  }

}