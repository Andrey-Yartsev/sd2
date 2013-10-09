<?php

class SdFontSettingsFormMenu extends SdFontSettingsForm {

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