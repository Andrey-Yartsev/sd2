<?php

class SdBlockSettingsFormFontBase extends SdBlockSettingsFormBase {

  protected $fontFieldType = 'fontFamily';

  protected function getInitFields() {
    return array_merge([[
      'title' => Locale::get('font'),
      'type'  => $this->fontFieldType,
      'name'  => 'fontFamily'
    ]], Fields::defaults(['fontSize', 'color']));
  }

}