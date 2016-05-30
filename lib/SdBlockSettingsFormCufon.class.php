<?php

class SdBlockSettingsFormCufon extends SdBlockSettingsFormFont {

  protected $fontFieldType = 'fontFamilyCufon';

  protected function getInitFields() {
    return [
      [
        'type' => 'textarea',
        'name' => 'text'
      ]
    ];
  }

}