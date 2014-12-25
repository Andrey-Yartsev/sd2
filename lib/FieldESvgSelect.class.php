<?php

class FieldESvgSelect extends FieldEDialogSelect {

  protected function defineOptions() {
    $options['options'] = Html::defaultOption();
    foreach (CtrlSdSvg::getFiles() as $v) {
      $name = basename(Misc::removeSuffix('.svg', $v));
      $options['options'][$name] = $name;
    }
    $options['useTypeJs'] = true;
    return array_merge(parent::defineOptions(), $options);
  }

}