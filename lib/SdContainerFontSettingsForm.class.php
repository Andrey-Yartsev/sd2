<?php

class SdContainerFontSettingsForm extends Form {

  protected $items, $id;

  function __construct(SdContainerItems $items, $id) {
    $this->items = $items;
    $this->id = $id;
    $item = $this->items->getItem($this->id);
    if (!empty($item['font'])) $this->defaultData = $item['font'];
    $this->options['title'] = "Настройки шрифта контейнера «{$this->id}»";
    $this->options['filterEmpties'] = true;
    parent::__construct(Fields::defaults(['fontSize', 'fontFamily', 'color']));
  }

  protected function _update(array $data) {
    $this->items->update($this->id, ['font' => $data]);
  }

}