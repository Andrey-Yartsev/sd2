<?php

class SdFontSettingsForm extends SdFontSettingsFormBase {

  protected function getInitFields() {
    return Arr::append(parent::getInitFields(), [[
      'title' => 'Цвет ссылки',
      'name' => 'linkColor',
      'type' => 'color'
    ]]);
  }

}