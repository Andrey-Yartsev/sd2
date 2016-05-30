<?php

class SdFontSettingsFormMenu extends SdBlockSettingsFormFont {

  protected function getInitFields() {
    return Arr::append(parent::getInitFields(), [
      [
        'title' => 'Цвет ссылки',
        'name'  => 'linkSelectedColor',
        'help' => 'активная',
        'type'  => 'color'
      ]
    ]);
  }

}