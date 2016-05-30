<?php

class SdBlockSettingsFormFontBase extends SdBlockSettingsFormBase {

  protected $fontFieldType = 'fontFamily';

  protected function getInitFields() {
    return array_merge(Fields::defaults(['fontSize', 'color']), [[
      'title' => 'Font',
      'type'  => $this->fontFieldType,
      'name'  => 'fontFamily'
    ]]);
  }

}