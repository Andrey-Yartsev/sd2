<?php

class SdCufonSettingsForm extends SdFontSettingsFormBase {

  protected $fontFieldType = 'fontFamilyCufon';

  protected function getInitFields() {
    return array_merge(Arr::injectAfter(parent::getInitFields(), 1, [
      [
        'title' => 'Shadow',
        'type'  => 'boolCheckbox',
        'name'  => 'shadow'
      ],
      [
        'title' => 'Blink',
        'type'  => 'boolCheckbox',
        'name'  => 'blink'
      ],
    ]), [
      [
        'type' => 'textarea',
        'name' => 'text'
      ]
    ]);
  }

}