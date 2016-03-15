<?php

class SdCufonSettingsForm extends SdFontSettingsFormBase {

  protected $fontFieldType = 'fontFamilyCufon';

  protected function getInitFields() {
    return Arr::injectAfter(parent::getInitFields(), 1, [
      [
        'title' => 'Тень',
        'type'  => 'boolCheckbox',
        'name'  => 'shadow'
      ],
      [
        'title' => 'Blink',
        'type'  => 'boolCheckbox',
        'name'  => 'blink'
      ],
    ]);
  }

}