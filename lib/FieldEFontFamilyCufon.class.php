<?php

class FieldEFontFamilyCufon extends FieldEDialogSelect {

  static $title = 'Шрифт';

  protected $useTypeJs = true;

  protected function defineOptions() {
    $options['options'] = Html::defaultOption();
    foreach (glob(Sflm::$absBasePaths['sd'].'/js/fonts/*') as $v) {
      $v = basename(Misc::removeSuffix('.js', $v));
      $options['options'][$v] = $v;
    }
    return array_merge(parent::defineOptions(), $options);
  }

}