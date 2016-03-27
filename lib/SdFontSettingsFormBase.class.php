<?php

class SdFontSettingsFormBase extends Form {

  protected $items, $id, $fontFieldType = 'fontFamily';

  protected function getInitFields() {
    return array_merge(Fields::defaults(['fontSize', 'color']), [[
      'title' => 'Font',
      'type'  => $this->fontFieldType,
      'name'  => 'fontFamily'
    ]]);
  }

  function __construct($id, SdContainerItems $items) {
    $this->items = $items;
    $this->id = $id;
    $item = $this->items->getItemD($this->id);
    if (!empty($item['font'])) $this->defaultData = $item['font'];
    $this->options['title'] = "Font Settings";
    $this->options['filterEmpties'] = true;
    parent::__construct($this->getInitFields());
  }

  protected function _update(array $data) {
    $this->items->update($this->id, ['font' => $data]);
  }

}