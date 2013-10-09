<?php

class SdFontSettingsFormBase extends Form {

  protected $items, $id, $fontField = 'fontFamily';

  protected function getInitFields() {
    return Arr::append(Fields::defaults(['fontSize', 'color']), Fields::defaults([$this->fontField]));
  }

  function __construct($id, SdContainerItems $items) {
    $this->items = $items;
    $this->id = $id;
    $item = $this->items->getItemD($this->id);
    if (!empty($item['font'])) $this->defaultData = $item['font'];
    $this->options['title'] = "Настройки шрифта контейнера «{$this->id}»";
    $this->options['filterEmpties'] = true;
    parent::__construct($this->getInitFields());
  }

  protected function _update(array $data) {
    $this->items->update($this->id, ['font' => $data]);
  }

}