<?php

class SdBlockSettingsFormFont extends SdBlockSettingsFormFontBase {

  protected function getInitFields() {
    return Arr::append(parent::getInitFields(), [
      [
        'type'  => 'headerClose'
      ],
      [
        'title' => 'Цвет ссылки1',
        'name'  => 'linkColor',
        'type'  => 'color'
      ],
      [
        'title' => 'Цвет ссылки',
        'name'  => 'linkOverColor',
        'help' => 'при наведении',
        'type'  => 'color'
      ]
    ]);
  }

}