<?php

class FieldEFontFamilyCufon extends FieldEDialogSelect {

  static $title = 'Font';

  protected function defineOptions() {
    $options['value'] = 'arial';
    $options['options'] = Html::defaultOption();
    foreach (glob(Sflm::$absBasePaths['sd'].'/js/fonts/*') as $v) {
      $v = basename(Misc::removeSuffix('.js', $v));
      $options['options'][$v] = $v;
    }
    $options['useTypeJs'] = true;
    return array_merge(parent::defineOptions(), $options);
  }

}