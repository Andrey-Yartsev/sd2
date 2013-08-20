<?php

class SdBgSettingsForm extends Form {

  protected $items, $id;

  function __construct(SdContainerItems $items, $id) {
    $this->items = $items;
    $this->id = $id;
    $item = $this->items->getItem($this->id);
    if (!empty($item['bgSettings'])) $this->defaultData = $item['bgSettings'];
    $this->options['title'] = "Настройки фона контейнера «{$this->id}»";
    $this->options['filterEmpties'] = true;
    parent::__construct(Arr::append([
      [
        'title' => 'Позиция',
        'name' => 'position',
        'type' => 'select',
        'options' => [
          '' => 'Вручную',
          'top center' => 'Сверху по центру',
          'bottom center' => 'Снизу по центру',
        ]
      ],
      [
        'title' => 'Повторение',
        'name' => 'repeat',
        'type' => 'select',
        'default' => 'no-repeat',
        'options' => [
          'no-repeat' => 'Не повторять',
          'repeat-x' => 'По горизонтали',
          'repeat-y' => 'По вертикали',
          'repeat' => 'По горизонтали и вертикали',
        ]
      ],
    ], Fields::defaults(['color'])));
  }

  public $settingsKey = 'bgSettings';

  protected function _update(array $data) {
    $this->items->update($this->id, [$this->settingsKey => $data]);
  }

}