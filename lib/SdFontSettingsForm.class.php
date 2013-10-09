<?php

class SdFontSettingsForm extends SdFontSettingsFormBase {

  protected function getInitFields() {
    return Arr::append(parent::getInitFields(), [
      [
        'type'  => 'headerClose'
      ],
      [
        'title' => 'Цвет ссылки',
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