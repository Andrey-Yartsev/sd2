<?php

class SdBlockSettingsFormText extends SdBlockSettingsFormFontBase {

  protected $fontFieldType = 'fontFamilyCufon';

  protected function getInitFields() {
    return array_merge(parent::getInitFields(), [
      [
        'type' => 'textarea',
        'name' => 'text'
      ]
    ]);
  }

}