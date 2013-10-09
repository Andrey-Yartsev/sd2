<?php

class FieldESvgSelect extends FieldEDialogSelect {

  protected $useTypeJs = true;

  protected function defineOptions() {
    $options['options'] = Html::defaultOption();
    foreach (CtrlSdSvg::getFiles() as $v) {
      $name = basename(Misc::removeSuffix('.svg', $v));
      $options['options'][$name] = $name;
    }
    return array_merge(parent::defineOptions(), $options);
  }

}