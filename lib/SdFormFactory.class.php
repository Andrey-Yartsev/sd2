<?php

class SdFormFactory {

  /**
   * @param $id
   * @param SdPageBlockItems $items
   * @return SdPageBlockEditFormAbstract
   */
  static function edit($id, SdPageBlockItems $items) {
    $class = 'SdPageBlockEdit'.($items->getItemE($id)['data']['type'] == 'menu' ? 'Prop' : 'Content').'Form';
    return new $class($id, $items);
  }

  /**
   * @param $id
   * @param SdContainerItems $items
   * @return SdFontSettingsFormBase
   */
  static function fontSettings($id, SdContainerItems $items) {
    $item = $items->getItemD($id);
    if (isset($item['type'])) {
      $type = $item['type'];
      $class = 'SdFontSettingsForm'.ucfirst($type);
      $class = class_exists($class) ? $class : 'SdFontSettingsForm';
    } else {
      $class = 'SdFontSettingsForm';
    }
    return new $class($id, $items);
  }

  static function contentAndFontSettings($id, SdContainerItems $items) {
    $contentForm = self::edit($id, $items);
    $fontSettingsForm = self::fontSettings($id, $items);
    $form = new Form(array_merge($fontSettingsForm->fields, $contentForm->fields));
    return $form;
  }

}